<?php

use App\Http\Controllers\Api\DirectoryController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\ProcessDataController;
use Illuminate\Support\Facades\Route;

Route::get('files-and-directories', ProcessDataController::class);
Route::get('directories', [DirectoryController::class, 'index']);
Route::get('files', [FileController::class, 'index']);
