<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Property\FilesModel;
use App\Models\Property\PropertyModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

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

        $images = [];
        $videos = [];

        $imageIds = $request->input('images'); // Example: [1, 2, 3]
        $videoIds = $request->input('videos'); // Example: [1, 2, 3]

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

        //save it on wp
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
            'real_estate_images' => $images,
            'real_estate_videos' => $videos,

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
            //$disk = Storage::disk(config('filesystems.default'));
            //$path = $disk->putFileAs('uploads', $file, $fileName);


            // push it to storage server
            $response_img = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode(env('WORDPRESS_USER') . ":" . env('WORDPRESS_KEY')),                
            ])->attach(
                'file', // The file key as expected by WordPress
                file_get_contents($file->getPathname()),
                $file->getClientOriginalName()    
            )->post(env('WORDPRESS_API') . "media");
    
            // dd($image->getClientOriginalName());
            // dd($response_img->json());

            $data = $response_img->json();

            $file_model           = new FilesModel();
            $file_model->user_id  = $request->user()->id;
            $file_model->url      = $data["source_url"];
            $file_model->wp_id    = $data["id"];
            $file_model->used     = 0;
            $file_model->save();

            $file_id =  $file_model->id; // Retrieve the ID of the newly inserted row

            // delete chunked file
            try {
                if (file_exists($file->getPathname())) {
                    unlink($file->getPathname());
                }
            } catch (Exception $e) {
                // Log the error or handle it as needed
                //print("Error deleting chunked file: " . $e->getMessage());
            }

            return [
                'path' => $data["source_url"], //asset('storage/' . $path), 
                'filename' => $fileName,
                'file_id' => $file_id,
                'wp_id' => $data["id"]
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
