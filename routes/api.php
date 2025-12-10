<?php

use App\Http\Controllers\Api\CertificateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MedicineController;
use App\Http\Controllers\Api\RequestController;
use App\Jobs\UpdateCertificateCache;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// MEDICINES API

Route::get('/medicines', [MedicineController::class, 'index']);

// CERTIFICATES API

Route::get('/certificates', [CertificateController::class, 'getCertificates']);

Route::get('/certificates/{id}', [CertificateController::class, 'showCertificate']);

Route::post('/certificates', [CertificateController::class, 'searchCertificate']);

Route::post('/certificates/create', [CertificateController::class, 'store']);

Route::put('/certificates/update/{id}', [CertificateController::class, 'update']);

Route::delete('/certificates/delete/{id}', [CertificateController::class, 'destroy']);

Route::get('/certificates/cache', [UpdateCertificateCache::class, 'handle']);

//Requests Api

Route::get('/requests', [RequestController::class, 'index']);