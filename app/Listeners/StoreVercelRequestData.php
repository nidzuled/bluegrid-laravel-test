<?php

namespace App\Listeners;

use App\Events\VercelDataFetched;
use App\Services\Vercel\StoreDirectoriesAndFiles;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreVercelRequestData implements ShouldQueue
{
    public function __construct(
        protected StoreDirectoriesAndFiles $storeDirectoriesAndFiles,
    ) {}

    /**
     * Handle the event.
     */
    public function handle(VercelDataFetched $event): void
    {
        $this->storeDirectoriesAndFiles->handle($event->vercelRequestData);
    }
}
