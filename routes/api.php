<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebserverController;
use App\Http\Controllers\RequestLogController;

Route::resource('webserver', WebserverController::class);

Route::get('request-history/{id}', [\App\Http\Controllers\WebserverRequestHistoryController::class, 'requestHistory']);
