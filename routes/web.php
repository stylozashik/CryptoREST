<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;


Route::get('/', [DataController::class , 'index']);
Route::post('/get/data' , [DataController::class , 'store_data']);
Route::get('/getBitcoinInfo' , [DataController::class , 'show_data']);
