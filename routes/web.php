<?php

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
Route::middleware(['isAdmin'])->group(function () {

    Route::get('/admin/dashboard', [App\Http\Controllers\HomeController::class, 'view'])->name('adminHome');

    Route::get('/admin/kerjasama', [App\Http\Controllers\KerjasamaController::class, 'index']);
    Route::get('/admin/kerjasama/i', [App\Http\Controllers\KerjasamaController::class, 'x']);
    Route::post('/admin/kerjasama/update', [App\Http\Controllers\KerjasamaController::class, 'update']);
    Route::get('/admin/kerjasama/edit/{id}', [App\Http\Controllers\KerjasamaController::class, 'edit']);
    Route::get('/admin/kerjasama/detail/{id}', [App\Http\Controllers\KerjasamaController::class, 'show']);
    Route::get('/admin/kerjasama/repo/{id}', [App\Http\Controllers\KerjasamaController::class, 'showRepo']);
    Route::get('/admin/kerjasama/export', [App\Http\Controllers\KerjasamaController::class, 'export']);

    Route::get('/admin/jenis-kerjasama', [App\Http\Controllers\JenisKerjasamaController::class, 'index']);
    Route::get('/admin/jenis-kerjasama/add', [App\Http\Controllers\JenisKerjasamaController::class, 'create']);
    Route::post('/admin/jenis-kerjasama/store', [App\Http\Controllers\JenisKerjasamaController::class, 'store']);
    Route::post('/admin/jenis-kerjasama/update', [App\Http\Controllers\JenisKerjasamaController::class, 'update']);
    Route::get('/admin/jenis-kerjasama/edit/{id}', [App\Http\Controllers\JenisKerjasamaController::class, 'edit']);

    Route::get('/admin/unit', [App\Http\Controllers\UnitController::class, 'index']);
    Route::get('/admin/unit/add', [App\Http\Controllers\UnitController::class, 'create']);
    Route::post('/admin/unit/store', [App\Http\Controllers\UnitController::class, 'store']);
    Route::post('/admin/unit/update', [App\Http\Controllers\UnitController::class, 'update']);
    Route::get('/admin/unit/edit/{id}', [App\Http\Controllers\UnitController::class, 'edit']);

    Route::get('/admin/perjanjian-kerjasama', [App\Http\Controllers\PKSController::class, 'index']);
    Route::get('/admin/perjanjian-kerjasama/add', [App\Http\Controllers\PKSController::class, 'create']);
    Route::post('/admin/perjanjian-kerjasama/store', [App\Http\Controllers\PKSController::class, 'store']);
    Route::post('/admin/perjanjian-kerjasama/update', [App\Http\Controllers\PKSController::class, 'update']);
    Route::get('/admin/perjanjian-kerjasama/edit/{id}', [App\Http\Controllers\PKSController::class, 'edit']);

    Route::get('/admin/pengajuan-kerjasama', [App\Http\Controllers\ReviewController::class, 'index']);
    Route::get('/admin/pengajuan-kerjasama/detail/{id}', [App\Http\Controllers\ReviewController::class, 'show']);
    Route::get('/admin/pengajuan-kerjasama/edit/{id}', [App\Http\Controllers\ReviewController::class, 'edit']);
    Route::post('/admin/pengajuan-kerjasama/update', [App\Http\Controllers\ReviewController::class, 'update']);
    Route::get('/admin/pengajuan-kerjasama/delete/{id}', [App\Http\Controllers\ReviewController::class, 'delete']);
    Route::get('/admin/pengajuan-kerjasama/add', [App\Http\Controllers\ReviewController::class, 'create']);
    Route::post('/admin/pengajuan-kerjasama/store', [App\Http\Controllers\ReviewController::class, 'store']);

    Route::get('/admin/my-profile/{id}', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('/admin/my-profile/update', [App\Http\Controllers\UserController::class, 'profileUpdate']);

    Route::get('/admin/user', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('/admin/user/add', [App\Http\Controllers\UserController::class, 'create']);
    Route::get('/admin/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit']);
    Route::get('/admin/user/deactivate/{id}', [App\Http\Controllers\UserController::class, 'deactivate']);
    Route::get('/admin/user/activate/{id}', [App\Http\Controllers\UserController::class, 'activate']);
    Route::post('/admin/user/store', [App\Http\Controllers\UserController::class, 'store']);
    Route::post('/admin/user/update', [App\Http\Controllers\UserController::class, 'update']);
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


});
