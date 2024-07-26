<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/get-equipment', [EquipmentController::class, 'getEquipment']);
Route::post('/update-equipment', [EquipmentController::class, 'updateEquipment']);
Route::post('/upload-file', [UploadController::class, 'uploadFile']);
Route::get('/fetch-all-equipments', [EquipmentController::class, 'fetchAllEquipments']);
Route::post('/sync-equipments', [EquipmentController::class, 'syncEquipments']);
Route::post('/sync-uploads', [UploadController::class, 'syncUploads']);
