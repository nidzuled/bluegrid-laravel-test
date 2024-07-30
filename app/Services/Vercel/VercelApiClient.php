<?php

namespace App\Services\Vercel;

use Illuminate\Support\Facades\Http;

class VercelApiClient
{
    public function __construct(
        protected string $uri,
        protected int $timeout = 0,
        protected null|int $retryTimes = null,
        protected null|int $retryMilliseconds = null,
    ) {}

    public function getFilesAndDirectories()
    {
        $request = Http::withHeaders([
            'Accept' => 'application/json',
        ])->timeout(
            seconds: $this->timeout,
        );

        if ( !is_null($this->retryTimes) && ! is_null($this->retryMilliseconds) ) {
            $request->retry(
                times: $this->retryTimes,
                sleepMilliseconds: $this->retryMilliseconds,
            );
        }

        $response = $request->get(
            url: "{$this->uri}/test",
        );

        if (! $response->successful() ) {
            return $response->toException();
        }

        return $response->json();
    }
}
