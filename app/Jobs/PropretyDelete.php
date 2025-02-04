<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PropretyDelete implements ShouldQueue
{
    use Queueable;

    protected $proprety_id;

    /**
     * Create a new job instance.
     */
    public function __construct( $proprety_id )
    {
        $this->proprety_id = $proprety_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('WORDPRESS_USER') . ":" . env('WORDPRESS_KEY')),
        ])->delete(env('WORDPRESS_API') . 'real_estate/' . $this->proprety_id , [

            "id"  => $this->proprety_id,
            "force" => true
        ]);

        // Log::info( "Item Deleted" );

    }
}
