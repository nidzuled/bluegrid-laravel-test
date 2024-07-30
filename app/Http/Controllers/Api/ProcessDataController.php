<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\FetchAndProcessData;
use Illuminate\Support\Facades\Cache;

class ProcessDataController extends Controller
{
    public function __invoke()
    {
        if (! Cache::has('vercel_directories_and_files')) {
            FetchAndProcessData::dispatch();

            return response()->json(['message' => 'Data is being processed. Please check back later.'], 202);
        }

        return response()->json(Cache::get('vercel_directories_and_files'));
    }
}
