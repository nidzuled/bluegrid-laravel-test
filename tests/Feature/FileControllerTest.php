<?php

namespace Tests\Feature;

use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsPaginatedFiles()
    {
        File::factory()->count(110)->create();

        $response = $this->getJson('/api/files');

        $response->assertStatus(200)
            ->assertJsonCount(100, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'name',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function testIndexHonorsPerPageParameter()
    {
        File::factory()->count(110)->create();

        $response = $this->getJson('/api/files?per_page=5');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'name',
                    ],
                ],
                'links',
                'meta',
            ]);
    }
}
