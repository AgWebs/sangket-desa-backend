<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BantuanController;
use App\Http\Controllers\BanjarController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KepalaKeluargaController;
use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\BantuanPendudukController;
use App\Http\Controllers\AuthController;

// ─── Publik (tidak perlu login) ─────────────────────────────────────────────
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ─── Wajib login (Bearer token) — semua data desa dilindungi di sini ──────────
Route::get('/databantuan', [BantuanController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/databantuan', [BantuanController::class, 'store']);
    Route::get('/databantuan/{bantuan:kode_bantuan}', [BantuanController::class, 'show']);
    Route::match(['put', 'patch'], '/databantuan/{bantuan:kode_bantuan}', [BantuanController::class, 'update']);
    Route::delete('/databantuan/{bantuan:kode_bantuan}', [BantuanController::class, 'destroy']);

    Route::get('/banjar', [BanjarController::class, 'index']);
    Route::post('/banjar', [BanjarController::class, 'store']);
    Route::get('/banjar/{id}', [BanjarController::class, 'show']);
    Route::match(['put', 'patch'], '/banjar/{id}', [BanjarController::class, 'update']);
    Route::delete('/banjar/{id}', [BanjarController::class, 'destroy']);

    Route::get('/fasilitaspublik', [FasilitasController::class, 'index']);
    Route::post('/fasilitaspublik', [FasilitasController::class, 'store']);
    Route::get('/fasilitaspublik/{id}', [FasilitasController::class, 'show']);
    Route::match(['put', 'patch'], '/fasilitaspublik/{id}', [FasilitasController::class, 'update']);
    Route::delete('/fasilitaspublik/{id}', [FasilitasController::class, 'destroy']);

    Route::get('/kepalakeluarga', [KepalaKeluargaController::class, 'index']);
    Route::post('/kepalakeluarga', [KepalaKeluargaController::class, 'store']);
    Route::get('/kepalakeluarga/{kepalaKeluarga:no_kk}', [KepalaKeluargaController::class, 'show']);
    Route::match(['put', 'patch'], '/kepalakeluarga/{kepalaKeluarga:no_kk}', [KepalaKeluargaController::class, 'update']);
    Route::delete('/kepalakeluarga/{kepalaKeluarga:no_kk}', [KepalaKeluargaController::class, 'destroy']);

    Route::get('/anggotakeluarga', [AnggotaKeluargaController::class, 'index']);
    Route::post('/anggotakeluarga', [AnggotaKeluargaController::class, 'store']);
    Route::get('/anggotakeluarga/{anggotaKeluarga:nik}', [AnggotaKeluargaController::class, 'show']);
    Route::match(['put', 'patch'], '/anggotakeluarga/{anggotaKeluarga:nik}', [AnggotaKeluargaController::class, 'update']);
    Route::delete('/anggotakeluarga/{anggotaKeluarga:nik}', [AnggotaKeluargaController::class, 'destroy']);

    Route::get('/bantuanpenduduk', [BantuanPendudukController::class, 'index']);
    Route::post('/bantuanpenduduk', [BantuanPendudukController::class, 'store']);
    Route::match(['put', 'patch'], '/bantuanpenduduk/{id}', [BantuanPendudukController::class, 'update']);
    Route::delete('/bantuanpenduduk/{id}', [BantuanPendudukController::class, 'destroy']);
});
