<?php

namespace App\Jobs;

use App\Models\Property\FilesModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PropretyAPIUpdate implements ShouldQueue
{
    use Queueable;

    protected $proprety_data, $cover_img_id, $imageIds, $videoIds;

    /**
     * Create a new job instance.
     */
    public function __construct( $proprety_data, $cover_img_id, $imageIds, $videoIds )
    {
        $this->proprety_data = $proprety_data;
        $this->cover_img_id = $cover_img_id;
        $this->imageIds = $imageIds;
        $this->videoIds = $videoIds;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // check if all images are uploaded or not, so retry add it correctly !!!!
        
        // cover image
        $cover_img_file = FilesModel::find($this->cover_img_id);
        $cover_img      = $cover_img_file->wp_id;// save this in wordpress api

        // arrais to store wp file IDs
        $images = [];
        $videos = [];

        if($this->imageIds != null)
        // Process the IDs (e.g., assign to the current user or create relationships)
        foreach ($this->imageIds as $imageId) {

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

        if($this->videoIds != null)
        foreach ($this->videoIds as $videoId) {
            
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
        
        if($this->imageIds != null)
        $images = array_map('intval', $images); // Ensure all values are integers

        if($this->videoIds != null)
        $videos = array_map('intval', $videos); // Ensure all values are integers

        //save some data in wp to update it later       
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('WORDPRESS_USER') . ":" . env('WORDPRESS_KEY')),
        ])->post(env('WORDPRESS_API') . 'real_estate/' . $this->proprety_data->id , [
            
            "id"                                => $this->proprety_data->id,
            "real_estate_purpose"               => $this->proprety_data->purpose,
            "real_estate_type"                  => $this->proprety_data->type,

            'title'                             => $this->proprety_data->title,
            'real_estate_title'                 => $this->proprety_data->title,
            'real_estate_short__description'    => $this->proprety_data->description,
            'real_estate_cover_img'             => $cover_img,
            'real_estate_city'                  => $this->proprety_data->city,
            'real_estate_price'                 => $this->proprety_data->price,
            'real_estate_neighborhood'          => $this->proprety_data->neighborhood,
            'real_estate_location'              => $this->proprety_data->location,
            'real_estate_phone'                 => $this->proprety_data->phone,
            'real_estate_images'                => $images,
            'real_estate_videos'                => $videos,
            
            'real_estate_space'                 => $this->proprety_data->space,
            'real_estate_rooms'                 => $this->proprety_data->rooms,
            'real_estate_kitchen'               => $this->proprety_data->kitchen,
            'real_estate_toilets'               => $this->proprety_data->bathrooms,
            'real_estate_living_room'           => $this->proprety_data->living_room ? 'نعم' : 'لا',
            'real_estate_halls'                 => $this->proprety_data->hall ? 'نعم' : 'لا',
            'real_estate_elevator'              => $this->proprety_data->elevator ? 'نعم' : 'لا',
            'real_estate_fiber'                 => $this->proprety_data->fiber ? 'نعم' : 'لا',
            'real_estate_school'                => $this->proprety_data->school ? 'نعم' : 'لا',
            'real_estate__musque'               => $this->proprety_data->mosque ? 'نعم' : 'لا',
            'real_estate_garden'                => $this->proprety_data->garden ? 'نعم' : 'لا',
            'real_estate_swim_pool'             => $this->proprety_data->pool ? 'نعم' : 'لا',            
            'status'                            => 'pending'

        ]);

        Log::info( $this->proprety_data->phone );
    }
}
