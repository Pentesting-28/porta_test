<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailUserInactive;
use Throwable;

class SendEmailUserInactive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $inactive_users = User::whereDate('last_login', '<', now()->subDays(30))->get();
            echo $inactive_users;
            foreach ($inactive_users as $key => $user) {
                Mail::to($user->email)->send(new EmailUserInactive($user));
            }

        } catch (Throwable $th) {
            // output an error
            echo $th;
        }
    }
}
