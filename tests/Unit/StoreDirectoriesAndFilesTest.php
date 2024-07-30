<?php

namespace Tests\Unit;

use App\Models\Directory;
use App\Models\File;
use App\Services\Vercel\StoreDirectoriesAndFiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreDirectoriesAndFilesTest extends TestCase
{
    use RefreshDatabase;

    protected $storeDirectoriesAndFiles;

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

    protected function setUp(): void
    {
        parent::setUp();

        $this->storeDirectoriesAndFiles = new StoreDirectoriesAndFiles;
    }

    /**
     * @test
     */
    public function handleStoresDirectoriesAndFiles()
    {
        $this->storeDirectoriesAndFiles->handle($this->sampleData);

        $directoriesCount = Directory::all()->count();
        $filesCount = File::all()->count();

        $this->assertEquals(7, $directoriesCount);
        $this->assertEquals(5, $filesCount);
    }
}
