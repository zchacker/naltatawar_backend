<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property\PropertyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    public function list(Request $request)
    {
        // check if the user allowed to add a new item
        $query  = PropertyModel::query();

         // Check if the "query" input exists
        if ($request->filled('query')) {
            $searchTerm = $request->input('query');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('property_number', 'LIKE', "%{$searchTerm}%")
                ->orWhere('title', 'LIKE', "%{$searchTerm}%");
            });
        }

        $sum        = $query->count();
        $propreties = $query->paginate(50);

        return view('admin.propreties.list', compact('propreties' , 'sum'));
    }

    public function my_list(Request $request)
    {
        // check if the user allowed to add a new item
        $query  = PropertyModel::where('parent_id', $request->user()->id);        

        // Check if the "query" input exists
        if ($request->filled('query')) {
            $searchTerm = $request->input('query');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('property_number', 'LIKE', "%{$searchTerm}%")
                ->orWhere('title', 'LIKE', "%{$searchTerm}%");
            });
        }

        $sum        = $query->count();
        $propreties = $query->paginate(50);

        return view('admin.propreties.list', compact('propreties' , 'sum'));
    }

    public function publish_properity(Request $request) 
    {
        // check if the proprety found
        $properity = PropertyModel::find($request->properity_id);

        if( $properity )
        {
            // update it in database
            $properity->update(['status' => $request->item_status]);   

            $properity_id = $request->properity_id;
            $status       = $request->item_status;

            // to record
            //Log::info('item status : ' , ['status' => $status]);

            // create queue job 
            dispatch(function () use ( $properity_id , $status ) { 

                //save some data in wp to update it later       
                $response = Http::withHeaders([
                    'Authorization' => 'Basic ' . base64_encode(env('WORDPRESS_USER') . ":" . env('WORDPRESS_KEY')),
                ])->post(env('WORDPRESS_API') . 'real_estate/'. $properity_id, [  
                    'id' => $properity_id,               
                    'status' => $status
                ]);

            })->onQueue('save_proprety');

            return [
                'done' => "تم بنجاح",
                'status' => true
            ];

        }else {

            return [
                'done' => "المنشأة غير موجودة",
                'status' => false
            ];

        }
            
    }

}
