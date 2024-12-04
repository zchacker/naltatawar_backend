<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Property\PropertyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PropertyController extends Controller
{

    public function list(Request $request)
    {
        $query      = PropertyModel::where('user_id', $request->user()->id);

         // Check if the "query" input exists
        if ($request->filled('query')) {
            $searchTerm = $request->input('query');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('property_number', 'LIKE', "%{$searchTerm}%")
                ->orWhere('title', 'LIKE', "%{$searchTerm}%");
            });
        }

        $sum        = $query->count('id');
        $propreties = $query->paginate(50);

        return view('client.propreties.list', compact('propreties'));
    }

    // to check langaue 
    // https://polylang.pro/doc/rest-api/
    public function create(Request $request)
    {

        return view('client.propreties.create');
    }

    public function create_action(Request $request)
    {


        // Validate and store the uploaded image
        /*
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,gif|max:5120', // Limit size to 5MB
        ]);

        // upload image
        // Get the uploaded file
        $image = $request->file('image');

        $response_img = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('WORDPRESS_USER') . ":" . env('WORDPRESS_KEY')),
            //'Content-Disposition' => 'attachment; filename=' . $image->getClientOriginalName(),
            //'Content-Type' => "multipart/form-data;".$image->getMimeType(),
        ])->attach(

            'file', // The file key as expected by WordPress
            file_get_contents($image->getPathname()),
            $image->getClientOriginalName()

        )->post(env('WORDPRESS_API') . "media");

        // dd($image->getClientOriginalName());
        dd($response_img->json());*/

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('WORDPRESS_USER') . ":" . env('WORDPRESS_KEY')),
        ])->post(env('WORDPRESS_API') . 'real_estate/', [
            
            "real_estate_purpose" => $request->purpose,
            "real_estate_type" => $request->type,

            'title' =>  $request->title,
            'real_estate_title' =>  $request->title,
            'real_estate_short__description' =>  $request->description,
            'real_estate_space' =>  $request->space,
            'real_estate_neighborhood' =>  $request->title,
            'real_estate_rooms' =>  $request->rooms,
            'real_estate_price' =>  $request->price,
            'real_estate_location' => $request->location,
            'real_estate_city' => $request->city,

            'real_estate_kitchen' => $request->kitchen,
            'real_estate_toilets' => $request->bathrooms,
            'real_estate_living_room' => $request->has('living_room') ? 'نعم' : 'لا',
            'real_estate_halls' => $request->has('hall') ? 'نعم' : 'لا',
            'real_estate_elevator' => $request->has('elevator') ? 'نعم' : 'لا',
            'real_estate_fiber' => $request->has('fiber') ? 'نعم' : 'لا',
            'real_estate_school' => $request->has('school') ? 'نعم' : 'لا',
            'real_estate__musque' => $request->has('mosque') ? 'نعم' : 'لا',
            'real_estate_garden' => $request->has('garden') ? 'نعم' : 'لا',
            'real_estate_swim_pool' => $request->has('pool') ? 'نعم' : 'لا',
            
            'status' => 'pending'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $proprety = PropertyModel::create([
                "user_id" => $request->user()->id,
                "property_number" => $data["id"],
                "title" => $request->title,                
                "description" => $request->description,                
                "type" => $request->type,                
                "purpose" => $request->purpose,                
                "license_no" => $request->license_no,                
                "space" => $request->space,                
                "neighborhood" => $request->neighborhood,                
                "price" => $request->price,                
                "city" => $request->city,                
                "location" => $request->location,                
                "rooms" => $request->rooms,                
                "bathrooms" => $request->bathrooms,                
                "kitchen" => $request->kitchen,                
                "hall" => $request->has('hall') ? 1 : 0,                
                "living_room" => $request->has('living_room') ? 1 : 0,                
                "elevator" => $request->has('elevator') ? 1 : 0,                
                "fiber" => $request->has('fiber') ? 1 : 0,                
                "school" => $request->has('school') ? 1 : 0,                
                "mosque" => $request->has('mosque') ? 1 : 0,                
                "pool" => $request->has('pool') ? 1 : 0,                
                "garden" => $request->has('garden') ? 1 : 0,                
            ]);

            
            return back()->with(['success' => __('added_successfuly')]);
        } else {

            dd($response->json());
            return back()
                ->withErrors(['error' => __('faild_to_save') . ' ' . $response->status()])
                ->withInput($request->all());
        }
    }
}
