<?php

namespace Tests\Feature;

use App\Jobs\FetchAndProcessData;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProcessDataControllerTest extends TestCase
{
    public function testInvokeDispatchesJobAndReturns202WhenCacheIsEmpty()
    {
        Cache::shouldReceive('has')
            ->with('vercel_directories_and_files')
            ->once()
            ->andReturn(false);

        Queue::fake();
        Queue::assertNothingPushed();

        $response = $this->getJson('/api/files-and-directories');

        Queue::assertPushed(FetchAndProcessData::class);

        $response->assertStatus(202)
            ->assertJson([
                'message' => 'Data is being processed. Please check back later.'
            ]);
    }

    public function testInvokeReturnsCachedDataWhenAvailable()
    {
        $cachedData = [
            '34.8.32.234' => [
                [
                    '$360Section' => [
                        '360.7B12DBA104F7493B51086D5C3F01DDDA.q3q'
                    ],
                ],
                [
                    '$RECYCLE.BIN' => [
                        [
                            'S-1-5-18' => [
                                'desktop.ini'
                            ]
                        ],
                        [
                            'S-1-5-21-3419125061-2900363665-2697401647-1008' => [
                                'desktop.ini'
                            ]
                        ],
                        [
                            'S-1-5-21-3419125061-2900363665-2697401647-1030' => []
                        ],

                    ]
                ],
                'test-fail.txt',
                [
                    '360Rec' => [
                        [
                            '20210222' => [
                                '10167BE.vir'
                            ]
                        ]

                    ]
                ]
            ]
        ];

        Cache::shouldReceive('has')
            ->with('vercel_directories_and_files')
            ->once()
            ->andReturn(true);
        Cache::shouldReceive('get')
            ->with('vercel_directories_and_files')
            ->once()
            ->andReturn($cachedData);

        $response = $this->getJson('/api/files-and-directories');

        $response->assertStatus(200)
            ->assertJson($cachedData);
    }
}
