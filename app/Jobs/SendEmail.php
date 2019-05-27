<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    public $tries=10;

    public function __construct($data)
    {
        $this->message = $data;
    }


    public function handle()
    {
        $data = $this->message;
        Mail::send(['text' => 'send-mail-comments'],['data'=>$data],function ($message)use($data){
            $my_mail = env('MAIL_USERNAME');
            $message->to($data['email'])->subject('Comment');
            $message->from($my_mail,$my_mail);
        });
    }

}
