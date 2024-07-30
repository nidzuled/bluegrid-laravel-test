<?php

namespace Tests\Unit;

use App\Services\Vercel\DataTransformers\VercelDataTransformer;
use Tests\TestCase;

class VercelDataTransformerTest extends TestCase
{
    protected $sampleData = [
        'items' => [
            ['fileUrl' => 'http://34.8.32.234:48183/$360Section/'],
            ['fileUrl' => 'http://34.8.32.234:48183/$360Section/360.7B12DBA104F7493B51086D5C3F01DDDA.q3q'],
            ['fileUrl' => 'http://34.8.32.234:48183/$RECYCLE.BIN/'],
            ['fileUrl' => 'http://34.8.32.234:48183/$RECYCLE.BIN/S-1-5-18/desktop.ini'],
            ['fileUrl' => 'http://34.8.32.234:48183/$RECYCLE.BIN/S-1-5-21-3419125061-2900363665-2697401647-1008/'],
            ['fileUrl' => 'http://34.8.32.234:48183/$RECYCLE.BIN/S-1-5-21-3419125061-2900363665-2697401647-1008/desktop.ini'],
            ['fileUrl' => 'http://34.8.32.234:48183/$RECYCLE.BIN/S-1-5-21-3419125061-2900363665-2697401647-1030/'],
            ['fileUrl' => 'http://34.8.32.234:48183/test-fail.txt'],
            ['fileUrl' => 'http://34.8.32.234:48183/360Rec/20210222/'],
            ['fileUrl' => 'http://34.8.32.234:48183/360Rec/20210222/10167BE.vir'],
        ],
    ];

    public function testTransform()
    {
        $transformer = new VercelDataTransformer();
        $result = $transformer->transform($this->sampleData);

        $expected = [
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

        $this->assertEquals($expected, $result);
    }
}
