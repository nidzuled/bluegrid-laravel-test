<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DirectoryResource;
use App\Models\Directory;

class DirectoryController extends Controller
{
    public function index()
    {
        $paginate = request('per_page') ?? 100;

        return DirectoryResource::collection(
            Directory::paginate($paginate)
        );
    }
}
