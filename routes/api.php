<?php

use App\Http\Controllers\Api\ProcessDataController;
use Illuminate\Support\Facades\Route;

Route::get('files-and-directories', ProcessDataController::class);
