<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Property\PropertyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PropertyController extends Controller
{

    public function list(Request $request)
    {
        $query      = PropertyModel::where('user_id', $request->user()->id);
        $sum        = $query->count('id');
        $propreties = $query->paginate(50);

        return view('client.propreties.list', compact('propreties'));
    }


    public function create(Request $request)
    {
        return view('client.propreties.create');
    }

    public function create_action(Request $request)
    {

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' .base64_encode(env('WORDPRESS_USER').":".env('WORDPRESS_KEY')),
        ])->post(env('WORDPRESS_API'). 'real_estate/', [
            'title' =>  $request->title,
            'real_estate_title' =>  $request->title,
            'real_estate_short__description' =>  $request->description,
            'real_estate_space' =>  $request->space,
            'real_estate_neighborhood' =>  $request->title,
            'real_estate_rooms' =>  $request->rooms,
            'real_estate_price' =>  $request->price,
            'status' => 'pending'
        ]);

        if ($response->successful()) 
        {
            $data = $response->json();
            dd( $data['id'] );
            return back()->with(['success' => __('added_successfuly')]);

        }else{

            return back()
            ->withErrors(['error' => __('faild_to_save').' '. $response->status()])
            ->withInput($request->all());

        }

    }
}
