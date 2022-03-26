<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;


Route::get('/', [DataController::class , 'index']);
Route::post('/get/data' , [DataController::class , 'store']);
Route::get('/getBitcoinInfo' , [DataController::class , 'show']);
