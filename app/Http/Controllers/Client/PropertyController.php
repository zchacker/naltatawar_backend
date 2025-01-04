<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Auth\UsersModel;
use App\Models\Property\FilesModel;
use App\Models\Property\PropertyModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class PropertyController extends Controller
{

    public function list(Request $request)
    {
        // check if the user allowed to add a new item
        $type       = $request->user()->account_type;
        $max_items  = $request->user()->subscription->plan->items;
        $items_used = 0;

        if($type == 3) // this is agent sub user
        {
            // find who is parent account, to check and update data to it
            $parent        = $request->user()->parent;
            $manager_data  = UsersModel::where('id', $parent)->first();

            if($manager_data)
            {
                $items_used = $manager_data->items_added;
            }

        }else{ // find account manager max items
            
            $items_used = $request->user()->items_added ;

        }

        $query  = PropertyModel::where('parent_id', $request->user()->id);

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

        return view('client.propreties.list', compact('propreties' , 'max_items', 'items_used'));
    }

    // to check langaue 
    // https://polylang.pro/doc/rest-api/
    public function create(Request $request)
    {
        return view('client.propreties.create');
    }

    public function create_action(Request $request)
    {

        // check if the user allowed to add a new item
        $type       = $request->user()->account_type;
        $max_items  = $request->user()->subscription->plan->items;

        if($type == 3) // this is agent sub user
        {
            // find who is parent account, to check and update data to it
            $parent        = $request->user()->parent;
            $manager_data  = UsersModel::where('id', $parent)->first();

            if($manager_data)
            {
                if($manager_data->items_added >= $max_items)
                {

                    return back()
                        ->withErrors(['error' => __('max_items_reached')])
                        ->withInput($request->all());
                }
            }

        }else{ // find account manager max items

            
            if( $request->user()->items_added >= $max_items )
            {

                return back()
                    ->withErrors(['error' => __('max_items_reached')])
                    ->withInput($request->all());
            }

        }    

        // data from user request
        $cover_img_id   = $request->cover_img;        
        $imageIds       = $request->input('images'); // Example: [1, 2, 3]
        $videoIds       = $request->input('videos'); // Example: [1, 2, 3]   

        /*
        // cover image
        
        $cover_img_file = FilesModel::find($cover_img_id);
        $cover_img      = $cover_img_file->wp_id;// save this in wordpress api

        // this is wp file IDs
        $images = [];
        $videos = [];             

        if($imageIds != null)
        // Process the IDs (e.g., assign to the current user or create relationships)
        foreach ($imageIds as $imageId) {

            // Example: Mark each file as used
            FilesModel::where('id', $imageId)->update(['used' => 1]);

            $file = FilesModel::find($imageId); // Retrieve the record by ID

            if ($file) {
                $wp_id = $file->wp_id; // Access column data
                
                array_push($images,  $wp_id );

                // Update the record
                $file->update(['used' => 1]);                
            }

        }

        if($videoIds != null)
        foreach ($videoIds as $videoId) {
            
            // Example: Mark each file as used
            FilesModel::where('id', $videoId)->update(['used' => 1]);

            $file = FilesModel::find($videoId); // Retrieve the record by ID

            if ($file) {
                $wp_id = $file->wp_id; // Access column data
                
                array_push($videos,  $wp_id );

                // Update the record
                $file->update(['used' => 1]);                
            }

        }
        
        if($imageIds != null)
        $images = array_map('intval', $images); // Ensure all values are integers

        if($videoIds != null)
        $videos = array_map('intval', $videos); // Ensure all values are integers
        */

        // sometimes the wordpress API not response !!

        //save some data in wp to update it later       
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('WORDPRESS_USER') . ":" . env('WORDPRESS_KEY')),
        ])->post(env('WORDPRESS_API') . 'real_estate/', [
            'title' =>  $request->title,
            
            // "real_estate_purpose" => $request->purpose,
            // "real_estate_type" => $request->type,

            // 'real_estate_title' =>  $request->title,
            // 'real_estate_short__description' =>  $request->description,
            // 'real_estate_cover_img' => $cover_img,
            // 'real_estate_city' => $request->city,
            // 'real_estate_price' =>  $request->price,
            // 'real_estate_neighborhood' =>  $request->neighborhood,
            // 'real_estate_location' => $request->location,
            // 'real_estate_images' => $images,
            // 'real_estate_videos' => $videos,
            
            // 'real_estate_space' =>  $request->space,
            // 'real_estate_rooms' =>  $request->rooms,
            // 'real_estate_kitchen' => $request->kitchen,
            // 'real_estate_toilets' => $request->bathrooms,
            // 'real_estate_living_room' => $request->has('living_room') ? 'نعم' : 'لا',
            // 'real_estate_halls' => $request->has('hall') ? 'نعم' : 'لا',
            // 'real_estate_elevator' => $request->has('elevator') ? 'نعم' : 'لا',
            // 'real_estate_fiber' => $request->has('fiber') ? 'نعم' : 'لا',
            // 'real_estate_school' => $request->has('school') ? 'نعم' : 'لا',
            // 'real_estate__musque' => $request->has('mosque') ? 'نعم' : 'لا',
            // 'real_estate_garden' => $request->has('garden') ? 'نعم' : 'لا',
            // 'real_estate_swim_pool' => $request->has('pool') ? 'نعم' : 'لا',
            
            'status' => 'pending'
        ]);
        

        if ($response->successful()) {
            
            // Check the items added by account manager
            DB::transaction(function() use ($request){

                $type = $request->user()->account_type;

                if($type == 3) // this is agent sub user
                {
                    // find who is parent account, to check and update data to it
                    $parent = $request->user()->parent;

                    $user = UsersModel::where('id', $parent)->lockForUpdate()->first();

                    if ($user) {
                        // Increment the items_added column
                        $user->increment('items_added');// done !!
                    } else {
                        throw new \Exception('User not found.');
                    }

                }else{ // if i the manager

                    $user_id = $request->user()->id;
                    $user = UsersModel::where('id', $user_id)->lockForUpdate()->first();

                    if ($user) {
                        // Increment the items_added column
                        $user->increment('items_added');// done !!
                    } else {
                        throw new \Exception('User not found.');
                    }

                }

            });

            // save property data in database
            $data = $response->json();

            $facilities_json = [
                "space"             => $request->space,                
                "rooms"             => $request->rooms,                
                "bathrooms"         => $request->bathrooms,                
                "kitchen"           => $request->kitchen,                
                "hall"              => $request->has('hall') ? TRUE : FALSE,                
                "living_room"       => $request->has('living_room') ? TRUE : FALSE,                
                "elevator"          => $request->has('elevator') ? TRUE : FALSE,                
                "fiber"             => $request->has('fiber') ? TRUE : FALSE,                
                "school"            => $request->has('school') ? TRUE : FALSE,                
                "mosque"            => $request->has('mosque') ? TRUE : FALSE,                
                "pool"              => $request->has('pool') ? TRUE : FALSE,                
                "garden"            => $request->has('garden') ? TRUE : FALSE,                
                              
            ];

            $proprety = PropertyModel::create([
                "user_id"           => $request->user()->id,
                "parent_id"         => $request->user()->id,                
                "property_number"   => $data["id"],
                "title"             => $request->title,                
                "description"       => $request->description,   
                "cover_img"         => $cover_img_id,   
                "type"              => $request->type,                
                "purpose"           => $request->purpose,                
                'images'            => implode(',', $imageIds ?? []),
                'videos'            => implode(',', $videoIds ?? []),    
                "license_no"        => $request->license_no,   
                "location"          => $request->location,                
                "city"              => $request->city, 
                "neighborhood"      => $request->neighborhood,                
                "price"             => $request->price,                
                
                'facilities'        => $facilities_json,
                
                'status'            => 'pending'
            ]);

            // this data to be sent to the wordpress website
            $proprety_data = [

                "id"                => $data["id"],
                "title"             => $request->title,                
                "description"       => $request->description,                
                "type"              => $request->type,                
                "purpose"           => $request->purpose,
                "license_no"        => $request->license_no,   
                "location"          => $request->location,                
                "city"              => $request->city, 
                "neighborhood"      => $request->neighborhood,                
                "price"             => $request->price,                
                
                "space"             => $request->space,                
                "rooms"             => $request->rooms,                
                "bathrooms"         => $request->bathrooms,                
                "kitchen"           => $request->kitchen,                
                "hall"              => $request->has('hall') ? TRUE : FALSE,                
                "living_room"       => $request->has('living_room') ? TRUE : FALSE,                
                "elevator"          => $request->has('elevator') ? TRUE : FALSE,                
                "fiber"             => $request->has('fiber') ? TRUE : FALSE,                
                "school"            => $request->has('school') ? TRUE : FALSE,                
                "mosque"            => $request->has('mosque') ? TRUE : FALSE,                
                "pool"              => $request->has('pool') ? TRUE : FALSE,                
                "garden"            => $request->has('garden') ? TRUE : FALSE,
                
                'status'            => 'pending'                
            ];

            $proprety_data = json_decode(json_encode($proprety_data));

            dispatch(function () use ( $proprety_data, $cover_img_id, $imageIds, $videoIds ) { 
                
                $this->update_wp_property_post( $proprety_data, $cover_img_id, $imageIds, $videoIds );// add more data to wordpress post later
            
            })->delay(now()->addMinutes(3));

            
            return back()->with(['success' => __('added_successfuly')]);

        } else {

            //dd($response->json());
            return back()
                ->withErrors(['error' => __('faild_to_save') . ' ' . $response->status()])
                ->withInput($request->all());

        }
    }

    // this is a workaround for updating the wordpress post in background
    public function update_wp_property_post( $proprety_data, $cover_img_id, $imageIds, $videoIds )
    {

        // cover image
        $cover_img_file = FilesModel::find($cover_img_id);
        $cover_img      = $cover_img_file->wp_id;// save this in wordpress api

        // arrais to store wp file IDs
        $images = [];
        $videos = [];

        if($imageIds != null)
        // Process the IDs (e.g., assign to the current user or create relationships)
        foreach ($imageIds as $imageId) {

            // Example: Mark each file as used
            FilesModel::where('id', $imageId)->update(['used' => 1]);

            $file = FilesModel::find($imageId); // Retrieve the record by ID

            if ($file) {
                $wp_id = $file->wp_id; // Access column data
                
                array_push($images,  $wp_id );

                // Update the record
                $file->update(['used' => 1]);                
            }

        }

        if($videoIds != null)
        foreach ($videoIds as $videoId) {
            
            // Example: Mark each file as used
            FilesModel::where('id', $videoId)->update(['used' => 1]);

            $file = FilesModel::find($videoId); // Retrieve the record by ID

            if ($file) {
                $wp_id = $file->wp_id; // Access column data
                
                array_push($videos,  $wp_id );

                // Update the record
                $file->update(['used' => 1]);                
            }

        }
        
        if($imageIds != null)
        $images = array_map('intval', $images); // Ensure all values are integers

        if($videoIds != null)
        $videos = array_map('intval', $videos); // Ensure all values are integers

        //save some data in wp to update it later       
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('WORDPRESS_USER') . ":" . env('WORDPRESS_KEY')),
        ])->post(env('WORDPRESS_API') . 'real_estate/' . $proprety_data->id , [
            
            "id"                                => $proprety_data->id,
            "real_estate_purpose"               => $proprety_data->purpose,
            "real_estate_type"                  => $proprety_data->type,

            'title'                             => $proprety_data->title,
            'real_estate_title'                 => $proprety_data->title,
            'real_estate_short__description'    => $proprety_data->description,
            'real_estate_cover_img'             => $cover_img,
            'real_estate_city'                  => $proprety_data->city,
            'real_estate_price'                 => $proprety_data->price,
            'real_estate_neighborhood'          => $proprety_data->neighborhood,
            'real_estate_location'              => $proprety_data->location,
            'real_estate_images'                => $images,
            'real_estate_videos'                => $videos,
            
            'real_estate_space'                 => $proprety_data->space,
            'real_estate_rooms'                 => $proprety_data->rooms,
            'real_estate_kitchen'               => $proprety_data->kitchen,
            'real_estate_toilets'               => $proprety_data->bathrooms,
            'real_estate_living_room'           => $proprety_data->living_room ? 'نعم' : 'لا',
            'real_estate_halls'                 => $proprety_data->hall ? 'نعم' : 'لا',
            'real_estate_elevator'              => $proprety_data->elevator ? 'نعم' : 'لا',
            'real_estate_fiber'                 => $proprety_data->fiber ? 'نعم' : 'لا',
            'real_estate_school'                => $proprety_data->school ? 'نعم' : 'لا',
            'real_estate__musque'               => $proprety_data->mosque ? 'نعم' : 'لا',
            'real_estate_garden'                => $proprety_data->garden ? 'نعم' : 'لا',
            'real_estate_swim_pool'             => $proprety_data->pool ? 'نعم' : 'لا',            
            'status'                            => 'pending'

        ]);

    }
    
    /**
     * This related to this SDK
     * https://github.com/pionl/laravel-chunk-upload
     */
    public function uploadLargeFiles(Request $request) {
        
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file

        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
        
            $file      = $fileReceived->getFile(); // get file
            
            $extension = $file->getClientOriginalExtension();
            $fileName  = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

            // save it localy
            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('uploads', $file, $fileName);
            
            // push it to storage server
            /*
            $response_img = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode(env('WORDPRESS_USER') . ":" . env('WORDPRESS_KEY')),                
            ])->attach(
                'file', // The file key as expected by WordPress
                file_get_contents($file->getPathname()),
                $file->getClientOriginalName()    
            )->post(env('WORDPRESS_API') . "media");
            */
    
            // dd($image->getClientOriginalName());
            // dd($response_img->json());

            //$data = $response_img->json();

            $file_model           = new FilesModel();
            $file_model->user_id  = $request->user()->id;
            // $file_model->url      = $data["source_url"];
            // $file_model->wp_id    = $data["id"];
            $file_model->used     = 0;
            $file_model->save();

            $file_id =  $file_model->id; // Retrieve the ID of the newly inserted row

            // run this task in background queue

            dispatch(function () use ($file_id , $path) {                 

                // push it to storage server
                $response_img = Http::withHeaders([
                    'Authorization' => 'Basic ' . base64_encode(env('WORDPRESS_USER') . ":" . env('WORDPRESS_KEY')),                
                ])->attach(
                    'file', // The file key as expected by WordPress
                    file_get_contents(storage_path('app/private' . DIRECTORY_SEPARATOR  . $path)), // Get the stored file content
                    basename($path)
                )->post(env('WORDPRESS_API') . "media", [
                    'verify' => false,
                ]);

                $data = $response_img->json();
                
                $db_data = [
                    "url" => $data["source_url"],
                    "wp_id" => $data["id"],
                ];

                FilesModel::where('id', $file_id)->update($db_data);// update data of file

                // Delete the stored file
                Storage::delete($path);                
                
            })->onQueue('save_file');
            

            // delete chunked file
            try {
                if (file_exists($file->getPathname())) {
                    unlink($file->getPathname());
                }
            } catch (Exception $e) {
                // Log the error or handle it as needed
                print("Error deleting chunked file: " . $e->getMessage());
            }
           
            return [
                //'path' => $data["source_url"], //asset('storage/' . $path), 
                'filename' => $fileName,
                'file_id' => $file_id,
                //'wp_id' => $data["id"]
            ];

        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }

}
