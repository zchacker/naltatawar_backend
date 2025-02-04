<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
        
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $view_name , $data_array , $email, $subject;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 25;

    /**
     * Create a new job instance.
     */
    public function __construct( $view_name , $data_array, $email , $subject )
    {
        $this->view_name    = $view_name;
        $this->data_array   = $data_array;
        $this->email        = $email;
        $this->subject      = $subject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $email   = $this->email; 
        $subject = $this->subject;

        Mail::send( $this->view_name , $this->data_array , function ($message) use ( $email , $subject ) {
            $message->to( $email );
            $message->subject( $subject );
        });

    }

}
