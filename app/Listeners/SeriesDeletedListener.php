<?php

namespace App\Listeners;

use App\Events\SeriesDeletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class SeriesDeletedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SeriesDeletedEvent $event): void
    {
        if (Storage::disk('public')->exists($event->cover)) {
            Storage::disk('public')->delete($event->cover);
            Log::info("Arquivo {$event->cover} excluído");
        } else {
            Log::info("Arquivo {$event->cover} não encontrado");
        }
    }
}
