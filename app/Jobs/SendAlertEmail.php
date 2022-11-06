<?php

namespace App\Jobs;

use App\Models\Webserver;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAlertEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Webserver $webserver;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Webserver $webserver)
    {
        $this->webserver = $webserver;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(config('settings.admins'))->send(new \App\Mail\ServerUnhealthyMail($this->webserver));
    }
}
