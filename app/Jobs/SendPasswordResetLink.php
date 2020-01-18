<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class SendPasswordResetLink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,SendsPasswordResetEmails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $id;
    public function __construct($user)
    {
        $this->id=$user;
    }



    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PasswordBroker $broker)
    {
      $user = new User();
      $user = $user::where('id',$this->id)->first();
           $token = $broker->createToken($user);
           $user->sendPasswordResetNotification($token);
    }
}
