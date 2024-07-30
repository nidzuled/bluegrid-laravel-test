<?php

namespace Tests\Feature;

use App\Models\Directory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DirectoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsPaginatedDirectories()
    {
        Directory::factory()->count(110)->create();

        $response = $this->getJson('/api/directories');

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
        Directory::factory()->count(110)->create();

        $response = $this->getJson('/api/directories?per_page=5');

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
