<?php

namespace App\Jobs;

use App\Models\Property\FilesModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FileUploadJob implements ShouldQueue
{
    use Queueable;

    protected $file_id;
    protected $path;

    /**
     * Create a new job instance.
     */
    public function __construct( $file_id, $path )
    {
        $this->file_id  = $file_id;
        $this->path     = $path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // push it to storage server
        $response_img = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('WORDPRESS_USER') . ":" . env('WORDPRESS_KEY')),                
        ])->attach(
            'file', // The file key as expected by WordPress
            file_get_contents(storage_path('app/private' . DIRECTORY_SEPARATOR  . $this->path)), // Get the stored file content
            basename($this->path)
        )->post(env('WORDPRESS_API') . "media", [
            'verify' => false,
        ]);

        $data = $response_img->json();
        
        $db_data = [
            "url" => $data["source_url"],
            "wp_id" => $data["id"],
        ];

        FilesModel::where('id', $this->file_id)->update($db_data);// update data of file

        // Delete the stored file
        Storage::delete($this->path);
        
    }
}
