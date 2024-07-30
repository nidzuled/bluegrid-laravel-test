<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Models\File;

class FileController extends Controller
{
    public function index()
    {
        $paginate = request('per_page') ?? 100;

        return FileResource::collection(
            File::paginate($paginate)
        );
    }
}
