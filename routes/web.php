<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\PaketUjianController;
use App\Http\Controllers\Admin\PesertaUjianController;
use App\Http\Controllers\Admin\SoalController as SoalController_Admin;
use App\Http\Controllers\Admin\UjianController as UjianController_Admin;
use App\Http\Controllers\Admin\PembelianController as PembelianController_Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/sendEmail', [DashboardController::class, 'sendEmail'])->name(
    'sendEmail'
);
Route::get('/admin/dashboard', [DashboardController::class, 'adminIndex'])
    ->middleware('auth', 'verified', 'role:admin|panitia|bendahara')
    ->name('admin.dashboard');

//route data user
Route::prefix('admin')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/user/data', [UserController::class, 'data'])->name(
            'user.data'
        );
        Route::get('/user/showDetails/{id}', [
            UserController::class,
            'showDetails',
        ])->name('user.showDetails');
        Route::get('/user/export', [UserController::class, 'export'])->name(
            'user.export'
        );
        Route::resource('user', UserController::class);
        Route::post('/user/resetPassword/{id}', [
            UserController::class,
            'resetPassword',
        ])->name('user.resetpassword');
        Route::post('/user/makeAdmin/{action}/{id}', [
            UserController::class,
            'makeAdmin',
        ])->name('user.makeAdmin');
    });

//route data admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/admin/data', [AdminController::class, 'data'])->name(
            'admin.data'
        );
        Route::post('/admin/getUser', [
            AdminController::class,
            'getUser',
        ])->name('admin.getUser');
        Route::resource('admin', AdminController::class);
        Route::post('/admin/resetPassword/{id}', [
            UserController::class,
            'resetPassword',
        ])->name('admin.resetpassword');
        Route::post('/admin/makeAdmin/{action}/{id}', [
            AdminController::class,
            'makeAdmin',
        ])->name('admin.makeAdmin');
    });

//route data voucher
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/voucher/data', [VoucherController::class, 'data'])->name(
            'voucher.data'
        );
        Route::resource('voucher', VoucherController::class);
    });

//route data paket ujian
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/paket/data', [PaketUjianController::class, 'data'])->name(
            'paket.data'
        );
        Route::resource('paket', PaketUjianController::class);
    });

//route data faq
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin|panitia|bendahara'])
    ->group(function () {
        Route::get('/faq/data', [
            \App\Http\Controllers\Admin\FaqController::class,
            'data',
        ])->name('faq.data');
        Route::post('/faq/{id}/pin', [
            \App\Http\Controllers\Admin\FaqController::class,
            'pin',
        ])->name('faq.pin');
        Route::resource(
            'faq',
            \App\Http\Controllers\Admin\FaqController::class
        );
    });

//route data pengumuman
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin|panitia|bendahara'])
    ->group(function () {
        Route::get('/pengumuman/data', [
            \App\Http\Controllers\Admin\PengumumanController::class,
            'data',
        ])->name('pengumuman.data');
        Route::resource(
            'pengumuman',
            \App\Http\Controllers\Admin\PengumumanController::class
        );
    });

//route data bank soal
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin|panitia'])
    ->group(function () {
        Route::get('/bank-soal/data', [
            \App\Http\Controllers\Admin\BankSoalController::class,
            'data',
        ])->name('bank-soal.data');
        Route::resource(
            'bank-soal',
            \App\Http\Controllers\Admin\BankSoalController::class
        );
    });

//route data ujian
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin|panitia|bendahara'])
    ->group(function () {
        Route::get('/ujian/data', [UjianController_Admin::class, 'data'])->name(
            'ujian.data'
        );
        Route::get('/ujian/{id}/publish', [
            UjianController_Admin::class,
            'publish',
        ])->name('ujian.publish');
        Route::get('/ujian/{id}/preview', [
            UjianController_Admin::class,
            'preview',
        ])->name('ujian.preview');
        Route::post('/ujian/{id}/duplicate', [
            UjianController_Admin::class,
            'duplicate',
        ])->name('ujian.duplicate');
        Route::get('/ujian/{id}/packages', [
            UjianController_Admin::class,
            'getPackages',
        ])->name('ujian.packages');
        Route::resource('ujian', UjianController_Admin::class);
    });

//route data pembelian
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin|bendahara'])
    ->group(function () {
        Route::get('/pembelian/data', [
            PembelianController_Admin::class,
            'data',
        ])->name('pembelian.data');
        Route::post('/pembelian/getUser', [
            PembelianController_Admin::class,
            'getUser',
        ])->name('pembelian.getUser');
        Route::get('/pembelian/dataPaket', [
            PembelianController_Admin::class,
            'dataPaket',
        ])->name('pembelian.dataPaket');
        Route::get('/pembelian/getSummary/{id}', [
            PembelianController_Admin::class,
            'getSummary',
        ])->name('pembelian.getSummary');
        
        // Verifikasi pembayaran manual routes
        Route::get('/pembelian/verifikasi', [
            PembelianController_Admin::class,
            'verifikasi',
        ])->name('pembelian.verifikasi');
        Route::get('/pembelian/verifikasi/data', [
            PembelianController_Admin::class,
            'dataVerifikasi',
        ])->name('pembelian.verifikasi.data');
        Route::get('/pembelian/{id}/bukti', [
            PembelianController_Admin::class,
            'buktiTransfer',
        ])->name('pembelian.bukti');
        Route::post('/pembelian/{id}/proses-verifikasi', [
            PembelianController_Admin::class,
            'prosesVerifikasi',
        ])->name('pembelian.proses-verifikasi');
        
        Route::resource('pembelian', PembelianController_Admin::class);
    });

//route data peserta ujian
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin|panitia|bendahara'])
    ->group(function () {
        Route::get('/peserta_ujian/data', [
            PesertaUjianController::class,
            'data',
        ])->name('peserta_ujian.data');
        Route::get('/peserta_ujian/showdata/{id}', [
            PesertaUjianController::class,
            'showData',
        ])->name('peserta_ujian.show_data');
        Route::get('/peserta_ujian/{id}/rekap', [
            PesertaUjianController::class,
            'showPeserta',
        ])->name('peserta_ujian.show_peserta');
        Route::get('/peserta_ujian/showdatapeserta/{id}', [
            PesertaUjianController::class,
            'showDataPeserta',
        ])->name('peserta_ujian.show_data_peserta');
        Route::get('/peserta_ujian/{id}/refresh', [
            PesertaUjianController::class,
            'refresh',
        ])->name('peserta_ujian.refresh');
        Route::resource('peserta_ujian', PesertaUjianController::class, [
            'except' => 'destroy',
        ]);
        Route::delete('peserta_ujian/{ujian_id}/{user_id}', [
            PesertaUjianController::class,
            'destroy',
        ])
            ->middleware('role:admin')
            ->name('peserta_ujian.destroy');
    });

//route data soal
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin|panitia|bendahara'])
    ->group(function () {
        Route::get('/ujian/soal/data/{id}', [
            SoalController_Admin::class,
            'data',
        ])->name('soal.data');
        Route::post('/ujian/soal/upload-image', [SoalController_Admin::class, 'uploadImage'])->name('soal.upload-image');
        // Bulk import routes
        Route::get('/ujian/{id}/soal/bulk-import', [
            SoalController_Admin::class,
            'bulkImportForm',
        ])->name('ujian.soal.bulk-import');
        Route::post('/ujian/{id}/soal/bulk-import', [
            SoalController_Admin::class,
            'bulkImportStore',
        ])->name('ujian.soal.bulk-import.store');
        // Route::get('/ujian/soal/{id}', [SoalController::class, 'index'])->name('soal.index');
        Route::resource('ujian.soal', SoalController_Admin::class)->shallow();
    });

//route pembelian
Route::middleware(['auth', 'verified', 'profiled'])->group(function () {
    Route::resource('pembelian', PembelianController::class, [
        'only' => ['index', 'store', 'show'],
    ]);
    Route::post('/pembelian/pay', [PembelianController::class, 'pay'])->name(
        'pembelian.pay'
    );
    Route::post('/pembelian/applyVoucher', [
        PembelianController::class,
        'applyVoucher',
    ])->name('pembelian.applyVoucher');
    Route::post('/pembelian/upload-bukti', [
        PembelianController::class,
        'uploadBuktiTransfer',
    ])->name('pembelian.upload-bukti');
});

//route tryout
Route::middleware(['auth', 'verified', 'profiled'])->group(function () {
    Route::get('/tryout', [UjianController::class, 'index'])->name(
        'tryout.index'
    );
    Route::get('/tryout/{id}', [UjianController::class, 'show'])->name(
        'tryout.show'
    );
    Route::post('/tryout', [UjianController::class, 'post'])->name(
        'tryout.post'
    );
    Route::get('/{id}/tryout', [UjianController::class, 'index'])->name(
        'tryout.index.with.id'
    );
    Route::get('/tryout/{id}/pembahasan', [
        UjianController::class,
        'pembahasan',
    ])->name('tryout.pembahasan');
    Route::get('/tryout/{id}/nilai', [UjianController::class, 'nilai'])->name(
        'tryout.nilai'
    );
    // Route::resource('tryout', UjianController::class);
});

//route ujian
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/ujian/{id}', [UjianController::class, 'ujian'])->name(
        'ujian.index'
    );
    Route::post('/ujian/store', [UjianController::class, 'store'])->name(
        'ujian.store'
    );
    Route::put('/ujian/mulaiujian/{id}', [
        UjianController::class,
        'mulaiUjian',
    ])->name('ujian.mulai');
    Route::put('/ujian/selesaiujian/{id}', [
        UjianController::class,
        'selesaiUjian',
    ])->name('ujian.selesai');
    Route::put('/ujian/storeragu/{id}', [
        UjianController::class,
        'storeRagu',
    ])->name('ujian.ragu');
    // Route::get('/ujian/nilai/{id}', [UjianController::class, 'nilai'])->name('ujian.nilai');
});

//route profile
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/profile/account', [UserController::class, 'account'])->name(
        'profile.account'
    );
    Route::post('/profile/peserta', [UserController::class, 'peserta'])->name(
        'profile.peserta'
    );
    Route::post('/profile/pendaftar', [
        UserController::class,
        'pendaftar',
    ])->name('profile.pendaftar');
    // Route::post('/profile/photo', [UserController::class, 'photo'])->name('profile.photo');
});

//route faq
Route::get('/faq', [\App\Http\Controllers\FaqController::class, 'index'])->name(
    'faq.index'
);

//route pengumuman
Route::get('/pengumuman', [\App\Http\Controllers\PengumumanController::class, 'index'])->name(
    'pengumuman.index'
);

//route articles (public)
Route::get('/articles', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');

// Admin Article routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/article/data', [\App\Http\Controllers\Admin\ArticleController::class, 'data'])->name('article.data');
        Route::resource('article', \App\Http\Controllers\Admin\ArticleController::class);
    });

// Learning Progress routes
Route::middleware(['auth', 'verified', 'profiled'])->group(function () {
    Route::get('/progress', [\App\Http\Controllers\LearningProgressController::class, 'index'])->name('progress.index');
    Route::post('/progress/record', [\App\Http\Controllers\LearningProgressController::class, 'record'])->name('progress.record');
    Route::get('/progress/data', [\App\Http\Controllers\LearningProgressController::class, 'getProgressData'])->name('progress.data');
});

// User Bank Soal routes
Route::prefix('bank-soal')
    ->name('user.bank-soal.')
    ->middleware(['auth', 'verified', 'profiled'])
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\UserBankSoalController::class, 'index'])->name('index');
        Route::get('/{bankSoal}', [\App\Http\Controllers\UserBankSoalController::class, 'show'])->name('show');
        Route::get('/{bankSoal}/download', [\App\Http\Controllers\UserBankSoalController::class, 'download'])->name('download');
    });

Route::get('sessiondestroy', [UjianController::class, 'sessionDestroy'])->name(
    'session_destroy'
);
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name(
    'google.login'
);
Route::get('/auth/google/callback', [
    GoogleController::class,
    'handleGoogleCallback',
])->name('google.callback');

Route::get('/redirects', function () {
    $user = Auth::user();
    
    // If user is not authenticated, redirect to login
    if (!$user) {
        return redirect()->route('login');
    }
    
    // Role-based redirection
    if ($user->hasRole('tutor')) {
        return redirect()->route('tutor.dashboard');
    } elseif ($user->hasRole('admin') || $user->hasRole('panitia') || $user->hasRole('bendahara')) {
        return redirect()->route('admin.dashboard');
    } else {
        // Regular user - redirect to main dashboard
        return redirect()->route('dashboard');
    }
});

// Tutor routes
Route::prefix('tutor')
    ->name('tutor.')
    ->middleware(['auth', 'verified', 'role:tutor'])
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Tutor\TutorController::class, 'dashboard'])
            ->name('dashboard');
        
        // Live Classes
        Route::resource('live-classes', App\Http\Controllers\Tutor\LiveClassController::class);
        Route::post('/live-classes/{liveClass}/start', [App\Http\Controllers\Tutor\LiveClassController::class, 'start'])
            ->name('live-classes.start');
        Route::post('/live-classes/{liveClass}/end', [App\Http\Controllers\Tutor\LiveClassController::class, 'end'])
            ->name('live-classes.end');
        Route::post('/live-classes/{liveClass}/cancel', [App\Http\Controllers\Tutor\LiveClassController::class, 'cancel'])
            ->name('live-classes.cancel');
        
        // Materials
        Route::resource('materials', App\Http\Controllers\Tutor\MaterialController::class);
        Route::get('/materials/{material}/download', [App\Http\Controllers\Tutor\MaterialController::class, 'download'])
            ->name('materials.download');
        Route::post('/materials/{material}/toggle-featured', [App\Http\Controllers\Tutor\MaterialController::class, 'toggleFeatured'])
            ->name('materials.toggle-featured');
        Route::post('/materials/{material}/toggle-public', [App\Http\Controllers\Tutor\MaterialController::class, 'togglePublic'])
            ->name('materials.toggle-public');
        Route::post('/materials/youtube-info', [App\Http\Controllers\Tutor\MaterialController::class, 'getYouTubeInfo'])
            ->name('materials.youtube-info');
        
        // Bank Soal
        Route::resource('bank-soal', App\Http\Controllers\Tutor\BankSoalController::class);
        Route::get('/bank-soal/{bankSoal}/download', [App\Http\Controllers\Tutor\BankSoalController::class, 'download'])
            ->name('bank-soal.download');
    });

// User Material routes
Route::prefix('materials')
    ->name('user.materials.')
    ->middleware(['auth', 'verified', 'profiled'])
    ->group(function () {
        Route::get('/', [App\Http\Controllers\UserMaterialController::class, 'index'])
            ->name('index');
        Route::get('/{material}', [App\Http\Controllers\UserMaterialController::class, 'show'])
            ->name('show');
        Route::get('/{material}/download', [App\Http\Controllers\UserMaterialController::class, 'download'])
            ->name('download');
        Route::get('/package/{packageId}', [App\Http\Controllers\UserMaterialController::class, 'getMaterialsByPackage'])
            ->name('by-package');
    });

// User Live Zoom routes
Route::prefix('live-zoom')
    ->name('user.live-zoom.')
    ->middleware(['auth', 'verified', 'profiled'])
    ->group(function () {
        Route::get('/', [App\Http\Controllers\UserLiveClassController::class, 'index'])
            ->name('index');
        Route::get('/{liveClass}', [App\Http\Controllers\UserLiveClassController::class, 'show'])
            ->name('show');
    });

require_once __DIR__ . '/jetstream.php';

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::group(['middleware' => ['can:publish articles']], function () {
//     //
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
