<?php

namespace App\Listeners;

use App\Events\VercelDataFetched;
use App\Services\Vercel\StoreDirectoriesAndFiles;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreVercelRequestData implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(VercelDataFetched $event): void
    {
        (new StoreDirectoriesAndFiles)->handle($event->vercelRequestData);
    }
}
