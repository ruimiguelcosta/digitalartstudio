<?php

namespace App\Jobs;

use App\Mail\AlbumManagerEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendAlbumManagerEmailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $email,
        public string $albumName,
        public string $password,
        public string $loginUrl
    ) {}

    public function handle(): void
    {
        Mail::to($this->email)->send(
            new AlbumManagerEmail($this->albumName, $this->password, $this->loginUrl)
        );
    }
}
