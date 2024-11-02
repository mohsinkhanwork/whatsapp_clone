<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class ProcessAttachment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $attachment;

    public function __construct(Message $message, $attachment)
    {
        $this->message = $message;
        $this->attachment = $attachment;
    }

    public function handle()
    {
        $fileType = $this->attachment->getMimeType();
        $folder = strpos($fileType, 'video') !== false ? 'video' : 'picture';
        $path = $this->attachment->storeAs("root/{$folder}", $this->attachment->getClientOriginalName(), 'public');

        $this->message->update(['attachment_path' => $path]);
    }
}
