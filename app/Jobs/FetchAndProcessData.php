<?php

namespace App\Jobs;

use App\Events\VercelDataFetched;
use App\Services\Vercel\VercelApiClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchAndProcessData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(VercelApiClient $vercelApiClient): void
    {
        $vercelRequestData = $vercelApiClient->getFilesAndDirectories();

        Log::info('Data fetched from external API', ['timestamp' => now()]);

        VercelDataFetched::dispatch($vercelRequestData);
    }
}
