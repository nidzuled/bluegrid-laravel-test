<?php

namespace App\Listeners;

use App\Events\VercelDataFetched;
use App\Services\Vercel\DataTransformers\VercelDataTransformer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class TransformVercelRequestData implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(VercelDataFetched $event): void
    {
        $transformedData = (new VercelDataTransformer)->transform($event->vercelRequestData);

        Cache::put('vercel_directories_and_files', $transformedData, now()->addHours(24));
    }
}
