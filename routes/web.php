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

Route::get('/admin/template/download/{id}', [App\Http\Controllers\TemplateSuratController::class, 'download'])
    ->name('template.download')
    ->middleware('auth');
Route::get('/getout', function () {
    Auth::logout();
    return redirect('/');
});
Route::get('/chart/data', [App\Http\Controllers\WebController::class, 'chartData']);
Route::get('/chart/unit', [App\Http\Controllers\WebController::class, 'chartByUnit']);
Route::get('/chart/sifat', [App\Http\Controllers\WebController::class, 'chartBySifat']);
Route::get('/chart/sifat-year', [App\Http\Controllers\WebController::class, 'chartBySifatYear']);
Route::get('/chart/jenis-year', [App\Http\Controllers\WebController::class, 'chartByJenisYear']);
Route::get('/chart/memorandum', [App\Http\Controllers\WebController::class, 'chartByMemorandum']);
Route::get('/chart/jenis-kerjasama', [App\Http\Controllers\WebController::class, 'chartByJenisKerjasama']);
Route::get('/api/prodi/find/{units}', [ProdiController::class, 'getProdiByUnitIDs'])->name('prodi.find');
Route::get('/about', [App\Http\Controllers\WebController::class, 'index'])->name('about');
Route::get('/api/track/{id}',[App\Http\Controllers\v1\trackerApi::class, 'getKerjasama'])->name('track.kerjasama');
Route::get('/trackpengajuan',[App\Http\Controllers\WebController::class, 'trackingPengajuan'])->name('tracking');



Auth::routes(['register' => false]);
Route::get('/sso/login', [App\Http\Controllers\Auth\SSOController::class, 'loginSSO'])->name('sso.login');
Route::get('/sso/cb', [App\Http\Controllers\Auth\SSOController::class, 'callbackSSO'])->name('sso.callback');
Route::post('/sso/cb', [App\Http\Controllers\Auth\SSOController::class, 'registerSSO'])->name('sso.register');


Route::get('/checkrole', [RoleController::class, 'checkRole'])->name('checkrole');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//route untuk admin
Route::middleware(['isAdmin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'view'])->name('adminHome');
    Route::get('/api/getAllKerjasama',[App\Http\Controllers\WebController::class, 'getAllKerjasama']);
    Route::prefix('kerjasama')->group(function () {
        Route::get('/', [App\Http\Controllers\KerjasamaController::class, 'index']);
        Route::get('/i', [App\Http\Controllers\KerjasamaController::class, 'x']);
        // Route::post('/', [App\Http\Controllers\KerjasamaController::class, 'update']);
        Route::get('/edit/{id}', [App\Http\Controllers\KerjasamaController::class, 'edit']);
        Route::post('/update', [App\Http\Controllers\KerjasamaController::class, 'update']);
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
    Route::prefix('review')->group(function() {
        Route::get('/', [App\Http\Controllers\ReviewController::class, 'index']);
        Route::post('/tolak', [App\Http\Controllers\ReviewController::class, 'tolakDirektur']);
        Route::get('/terima/{id}', [App\Http\Controllers\ReviewController::class, 'terimaDirektur']);
        Route::get('/detail/{id}', [App\Http\Controllers\ReviewController::class, 'show']);


    });

    Route::prefix('prodi')->group(function() {
        Route::get('/', [ProdiController::class , 'index']);
        Route::get('/add', [ProdiController::class , 'create']);
        Route::post('/store', [ProdiController::class , 'store']);
        Route::get('/edit/{id}', [ProdiController::class , 'edit']);
        Route::post('/update', [ProdiController::class , 'update']);
        Route::delete('delete/{id}',[ProdiController::class, 'delete']);
        Route::get('/find/{id}', [ProdiController::class, 'getProdiByUnitID'])->name('fetch.prodi');
    });
    Route::prefix('kriteria')->group(function(){
        route::prefix('mitra')->group(function(){
            Route::get('/',[KriteriaMitraController::class, 'index']);
            Route::get('/add',[KriteriaMitraController::class, 'create']);
            Route::post('/store',[KriteriaMitraController::class, 'store']);
            Route::get('/edit/{id}',[KriteriaMitraController::class, 'edit']);
            Route::post('/update',[KriteriaMitraController::class, 'update']);
            Route::delete('/delete/{id}',[KriteriaMitraController::class, 'delete']);
        });
        route::prefix('kemitraan')->group(function(){
            Route::get('/',[KriteriaKemitraanController::class, 'index']);
            Route::get('/add',[KriteriaKemitraanController::class, 'create']);
            Route::post('/store',[KriteriaKemitraanController::class, 'store']);
            Route::get('/edit/{id}',[KriteriaKemitraanController::class, 'edit']);
            Route::post('/update',[KriteriaKemitraanController::class, 'update']);
            Route::delete('/delete/{id}',[KriteriaKemitraanController::class, 'delete']);
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
        Route::get('/record', [App\Http\Controllers\ReviewController::class, 'record']);
        Route::post('/store-record', [App\Http\Controllers\ReviewController::class, 'store_record']);
        Route::post('/store', [App\Http\Controllers\ReviewController::class, 'store']);
        Route::post('/dokumenakhir',[App\Http\Controllers\ReviewController::class,'dokumenAkhirAdmin']);
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
    Route::prefix('template')->group(function(){
        Route::get('/', [App\Http\Controllers\TemplateSuratController::class, 'index']);
        Route::get('/add', [App\Http\Controllers\TemplateSuratController::class, 'create']);
        Route::post('/store', [App\Http\Controllers\TemplateSuratController::class, 'store']);
        Route::get('/download/{id}', [App\Http\Controllers\TemplateSuratController::class, 'download']);
        Route::get('/delete/{id}',[App\Http\Controllers\TemplateSuratController::class, 'destroy']);
        Route::get('/edit/{id}', [App\Http\Controllers\TemplateSuratController::class, 'edit'])->name('template.edit');
        Route::post('/update/{id}', [App\Http\Controllers\TemplateSuratController::class, 'update'])->name('template.update');


    });
    Route::prefix('agreement')->group(function(){
        Route::get('/', [App\Http\Controllers\ImplementationAgreementController::class, 'index']);
        Route::get('/add', [App\Http\Controllers\ImplementationAgreementController::class, 'create']);
        Route::post('/store', [App\Http\Controllers\ImplementationAgreementController::class, 'store']);
        Route::get('/detail/{id}', [App\Http\Controllers\ImplementationAgreementController::class,'show']);
        Route::get('/edit/{id}', [App\Http\Controllers\ImplementationAgreementController::class, 'edit']);
        Route::post('/update', [App\Http\Controllers\ImplementationAgreementController::class, 'update']);
        Route::get('/delete/{id}', [App\Http\Controllers\ImplementationAgreementController::class, 'destroy']);

    });
    Route::prefix('bidang-kerjasama')->group(function(){
        Route::get('/', [App\Http\Controllers\BidangKerjasamaController::class,'index']);
        Route::get('/add', [App\Http\Controllers\BidangKerjasamaController::class,'create']);
        Route::post('/store', [App\Http\Controllers\BidangKerjasamaController::class,'store']);
        Route::get('/edit/{id}', [App\Http\Controllers\BidangKerjasamaController::class,'edit']);
        Route::post('/update/', [App\Http\Controllers\BidangKerjasamaController::class,'update']);
        Route::get('/delete/{id}', [App\Http\Controllers\BidangKerjasamaController::class,'destroy']);

    });
});

//route untuk direktur
Route::middleware(['isDirektur'])->prefix('direktur')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'view'])->name('DirekturHome');
    Route::get('/kerjasama', [App\Http\Controllers\KerjasamaController::class, 'index']);
    Route::get('/kerjasama/detail/{id}', [App\Http\Controllers\KerjasamaController::class, 'show']);
    Route::get('/kerjasama/repo/{id}', [App\Http\Controllers\KerjasamaController::class, 'showRepo']);
    Route::get('/kerjasama/export', [App\Http\Controllers\KerjasamaController::class, 'export']);

    Route::get('/my-profile/{id}', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('/my-profile/update', [App\Http\Controllers\UserController::class, 'profileUpdate']);

    Route::get('/review', [App\Http\Controllers\ReviewController::class, 'index']);
    Route::post('/review/tolak', [App\Http\Controllers\ReviewController::class, 'tolakDirektur']);
    Route::get('/review/terima/{id}', [App\Http\Controllers\ReviewController::class, 'terimaDirektur']);
    Route::get('/review/detail/{id}', [App\Http\Controllers\ReviewController::class, 'show']);
});


//route untuk pemimpin
Route::middleware(['isPemimpin'])->prefix('pemimpin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'view'])->name('PemimpinHome');
    Route::get('/kerjasama', [App\Http\Controllers\KerjasamaController::class, 'index']);
    Route::get('/kerjasama/detail/{id}', [App\Http\Controllers\KerjasamaController::class, 'show']);
    Route::get('/kerjasama/repo/{id}', [App\Http\Controllers\KerjasamaController::class, 'showRepo']);
    Route::get('/kerjasama/export', [App\Http\Controllers\KerjasamaController::class, 'export']);

    Route::get('/my-profile/{id}', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('/my-profile/update', [App\Http\Controllers\UserController::class, 'profileUpdate']);

    Route::get('/review', [App\Http\Controllers\ReviewController::class, 'index']);
    Route::post('/review/tolak', [App\Http\Controllers\ReviewController::class, 'tolakWadir']);
    Route::get('/review/terima/{id}', [App\Http\Controllers\ReviewController::class, 'terimaWadir']);
    Route::get('/review/detail/{id}', [App\Http\Controllers\ReviewController::class, 'show']);
});


//route untuk legal
Route::middleware(['isLegal'])->prefix('legal')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'view'])->name('LegalHome');
    Route::get('/kerjasama', [App\Http\Controllers\KerjasamaController::class, 'index']);
    Route::get('/kerjasama/detail/{id}', [App\Http\Controllers\KerjasamaController::class, 'show']);
    Route::get('/kerjasama/repo/{id}', [App\Http\Controllers\KerjasamaController::class, 'showRepo']);
    Route::get('/kerjasama/export', [App\Http\Controllers\KerjasamaController::class, 'export']);

    Route::get('/my-profile/{id}', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('/my-profile/update', [App\Http\Controllers\UserController::class, 'profileUpdate']);

    Route::get('/review', [App\Http\Controllers\ReviewController::class, 'index']);
    Route::post('/review/tolak', [App\Http\Controllers\ReviewController::class, 'tolakLegal']);
    Route::get('/review/terima/{id}', [App\Http\Controllers\ReviewController::class, 'terimaLegal']);
    Route::get('/review/detail/{id}', [App\Http\Controllers\ReviewController::class, 'show']);
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


        Route::get('/pic/template', [App\Http\Controllers\TemplateSuratController::class, 'index']);
        Route::get('/pic/template/download/{id}', [App\Http\Controllers\TemplateSuratController::class, 'download']);

});
