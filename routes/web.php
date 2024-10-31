<?php

use App\Http\Controllers\KriteriaKemitraanController;
use App\Http\Controllers\KriteriaMitraController;
use App\Http\Controllers\ProdiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [App\Http\Controllers\WebController::class, 'index']);
Route::get('/php', function () {
    return phpinfo();
});
Route::get('/chart/data', [App\Http\Controllers\WebController::class, 'chartData']);
Route::get('/chart/unit', [App\Http\Controllers\WebController::class, 'chartByUnit']);
Route::get('/chart/sifat', [App\Http\Controllers\WebController::class, 'chartBySifat']);
Route::get('/chart/sifat-year', [App\Http\Controllers\WebController::class, 'chartBySifatYear']);
Route::get('/chart/jenis-year', [App\Http\Controllers\WebController::class, 'chartByJenisYear']);
Route::get('/chart/memorandum', [App\Http\Controllers\WebController::class, 'chartByMemorandum']);
Route::get('/chart/jenis-kerjasama', [App\Http\Controllers\WebController::class, 'chartByJenisKerjasama']);

Route::get('/about', [App\Http\Controllers\WebController::class, 'index'])->name('about');




Auth::routes(['register' => false]);

Route::get('/checkrole', [RoleController::class, 'checkRole'])->name('checkrole');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//route untuk admin
Route::middleware(['isAdmin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'view'])->name('adminHome');
    Route::prefix('kerjasama')->group(function () {
        Route::get('/', [App\Http\Controllers\KerjasamaController::class, 'index']);
        Route::get('/i', [App\Http\Controllers\KerjasamaController::class, 'x']);
        Route::post('/', [App\Http\Controllers\KerjasamaController::class, 'update']);
        Route::get('/edit/{id}', [App\Http\Controllers\KerjasamaController::class, 'edit']);
        Route::get('/detail/{id}', [App\Http\Controllers\KerjasamaController::class, 'show']);
        Route::get('/repo/{id}', [App\Http\Controllers\KerjasamaController::class, 'showRepo']);
        Route::get('/export', [App\Http\Controllers\KerjasamaController::class, 'export']);
        Route::get('/delete/{id}', [App\Http\Controllers\KerjasamaController::class, 'delete']);
    });

    Route::prefix('jenis-kerjasama')->group(function () {
        Route::get('/', [App\Http\Controllers\JenisKerjasamaController::class, 'index']);
        Route::get('/add', [App\Http\Controllers\JenisKerjasamaController::class, 'create']);
        Route::post('/store', [App\Http\Controllers\JenisKerjasamaController::class, 'store']);
        Route::post('/update', [App\Http\Controllers\JenisKerjasamaController::class, 'update']);
        Route::get('/edit/{id}', [App\Http\Controllers\JenisKerjasamaController::class, 'edit']);
    });
    Route::prefix('unit')->group(function () {
        Route::get('/', [App\Http\Controllers\UnitController::class, 'index']);
        Route::get('/add', [App\Http\Controllers\UnitController::class, 'create']);
        Route::post('/store', [App\Http\Controllers\UnitController::class, 'store']);
        Route::post('/update', [App\Http\Controllers\UnitController::class, 'update']);
        Route::get('/edit/{id}', [App\Http\Controllers\UnitController::class, 'edit']);
    });
    Route::prefix('prodi')->group(function() {
        Route::get('/', [ProdiController::class , 'index']);
        Route::get('/add', [ProdiController::class , 'create']);
        Route::post('/store', [ProdiController::class , 'store']);
        Route::get('/find/{id}', [ProdiController::class, 'getProdiByUnitID'])->name('fetch.prodi');
    });
    Route::prefix('kriteria')->group(function(){
        route::prefix('mitra')->group(function(){
            Route::get('/',[KriteriaMitraController::class, 'index']);
            Route::get('/add',[KriteriaMitraController::class, 'create']);
            Route::post('/store',[KriteriaMitraController::class, 'store']);
            Route::get('/edit/{id}',[KriteriaMitraController::class, 'edit']);
            Route::post('/update',[KriteriaMitraController::class, 'update']);
            Route::get('/delete/{id}',[KriteriaMitraController::class, 'delete']);
        });
        route::prefix('kemitraan')->group(function(){
            Route::get('/',[KriteriaKemitraanController::class, 'index']);
            Route::get('/add',[KriteriaKemitraanController::class, 'create']);
            Route::post('/store',[KriteriaKemitraanController::class, 'store']);
            Route::get('/edit/{id}',[KriteriaKemitraanController::class, 'edit']);
            Route::post('/update',[KriteriaKemitraanController::class, 'update']);
            Route::get('/delete/{id}',[KriteriaKemitraanController::class, 'delete']);
        });
    });
    Route::prefix('perjanjian-kerjasama')->group(function () {
        Route::get('/', [App\Http\Controllers\PKSController::class, 'index']);
        Route::get('/add', [App\Http\Controllers\PKSController::class, 'create']);
        Route::post('/store', [App\Http\Controllers\PKSController::class, 'store']);
        Route::post('/update', [App\Http\Controllers\PKSController::class, 'update']);
        Route::get('/edit/{id}', [App\Http\Controllers\PKSController::class, 'edit']);
    });
    Route::prefix('pengajuan-kerjasama')->group(function () {
        Route::get('/', [App\Http\Controllers\ReviewController::class, 'index']);
        Route::get('/detail/{id}', [App\Http\Controllers\ReviewController::class, 'show']);
        Route::get('/edit/{id}', [App\Http\Controllers\ReviewController::class, 'edit']);
        Route::post('/update', [App\Http\Controllers\ReviewController::class, 'update']);
        Route::get('/delete/{id}', [App\Http\Controllers\ReviewController::class, 'delete']);
        Route::get('/add', [App\Http\Controllers\ReviewController::class, 'create']);
        Route::post('/store', [App\Http\Controllers\ReviewController::class, 'store']);
    });
    Route::prefix('my-profile')->group(function () {
        Route::get('/{id}', [App\Http\Controllers\UserController::class, 'edit']);
        Route::post('/update', [App\Http\Controllers\UserController::class, 'profileUpdate']);
    });
    Route::prefix('user')->group(function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index']);
        Route::get('/add', [App\Http\Controllers\UserController::class, 'create']);
        Route::get('/edit/{id}', [App\Http\Controllers\UserController::class, 'edit']);
        Route::get('/deactivate/{id}', [App\Http\Controllers\UserController::class, 'deactivate']);
        Route::get('/activate/{id}', [App\Http\Controllers\UserController::class, 'activate']);
        Route::post('/store', [App\Http\Controllers\UserController::class, 'store']);
        Route::post('/update', [App\Http\Controllers\UserController::class, 'update']);
    });
});

//route untuk pemimpin
Route::middleware(['isPemimpin'])->group(function () {
    Route::get('/pemimpin/dashboard', [App\Http\Controllers\HomeController::class, 'view'])->name('PemimpinHome');
    Route::get('/pemimpin/kerjasama', [App\Http\Controllers\KerjasamaController::class, 'index']);
    Route::get('/pemimpin/kerjasama/detail/{id}', [App\Http\Controllers\KerjasamaController::class, 'show']);
    Route::get('/pemimpin/kerjasama/repo/{id}', [App\Http\Controllers\KerjasamaController::class, 'showRepo']);
    Route::get('/pemimpin/kerjasama/export', [App\Http\Controllers\KerjasamaController::class, 'export']);

    Route::get('/pemimpin/my-profile/{id}', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('/pemimpin/my-profile/update', [App\Http\Controllers\UserController::class, 'profileUpdate']);

    Route::get('/pemimpin/review', [App\Http\Controllers\ReviewController::class, 'index']);
    Route::post('/pemimpin/review/tolak', [App\Http\Controllers\ReviewController::class, 'tolak']);
    Route::get('/pemimpin/review/terima/{id}', [App\Http\Controllers\ReviewController::class, 'terima']);
    Route::get('/pemimpin/review/detail/{id}', [App\Http\Controllers\ReviewController::class, 'show']);
});


//route untuk legal
Route::middleware(['isLegal'])->group(function () {
    Route::get('/legal/dashboard', [App\Http\Controllers\HomeController::class, 'view'])->name('PicHome');
});

Route::middleware(['isPic'])->group(function () {
    Route::get('/pic/dashboard', [App\Http\Controllers\HomeController::class, 'view'])->name('PicHome');

    Route::get('/pic/pengajuan-kerjasama', [App\Http\Controllers\ReviewController::class, 'index']);
    Route::get('/pic/pengajuan-kerjasama/detail/{id}', [App\Http\Controllers\ReviewController::class, 'show']);
    Route::get('/pic/pengajuan-kerjasama/edit/{id}', [App\Http\Controllers\ReviewController::class, 'edit']);
    Route::post('/pic/pengajuan-kerjasama/update', [App\Http\Controllers\ReviewController::class, 'update']);
    Route::get('/pic/pengajuan-kerjasama/delete/{id}', [App\Http\Controllers\ReviewController::class, 'delete']);
    Route::get('/pic/pengajuan-kerjasama/add', [App\Http\Controllers\ReviewController::class, 'create']);
    Route::post('/pic/pengajuan-kerjasama/store', [App\Http\Controllers\ReviewController::class, 'store']);

    Route::get('/pic/kerjasama', [App\Http\Controllers\KerjasamaController::class, 'index']);
    Route::get('/pic/kerjasama/i', [App\Http\Controllers\KerjasamaController::class, 'x']);
    Route::post('/pic/kerjasama/update', [App\Http\Controllers\KerjasamaController::class, 'update']);
    Route::get('/pic/kerjasama/edit/{id}', [App\Http\Controllers\KerjasamaController::class, 'edit']);
    Route::get('/pic/kerjasama/detail/{id}', [App\Http\Controllers\KerjasamaController::class, 'show']);
    Route::get('/pic/kerjasama/repo/{id}', [App\Http\Controllers\KerjasamaController::class, 'showRepo']);
    Route::get('/pic/kerjasama/export', [App\Http\Controllers\KerjasamaController::class, 'export']);

    Route::get('/pic/my-profile/{id}', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('/pic/my-profile/update', [App\Http\Controllers\UserController::class, 'profileUpdate']);
});
