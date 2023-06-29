<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// temporary router to do storage:link
// Route::get('/foo', function () {
//     Artisan::call('storage:link');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [HomeController::class, 'login'])->name('home.login');
Route::post('/login/do', [HomeController::class, 'loginDo'])->name('home.login.do');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['auth.level:1'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
        // HALAMAN STATUS BOOKING
        Route::get('/admin/book', [AdminController::class, 'bookPage'])->name('admin.book.page');
        // CRUD ACARA
        Route::get('/admin/{id}/booking', [AdminController::class, 'booking'])->name('booking');
        Route::post('/admin/{id}/booking/do', [AdminController::class, 'bookingDo'])->name('booking.do');
        Route::get('/admin/acara/{id}/detele/do', [AdminController::class, 'acaraDeleteDo'])->name('admin.acara.delete.do');
        // CRUD USER
        Route::get('/admin/user', [AdminController::class, 'user'])->name('admin.user');
        Route::get('/admin/user/add', [AdminController::class, 'userAdd'])->name('admin.user.add');
        Route::post('/admin/user/add/do', [AdminController::class, 'userAddDo'])->name('admin.user.add.do');
        Route::get('/admin/user/{id}/edit', [AdminController::class, 'userEdit'])->name('admin.user.edit');
        Route::post('/admin/user/{id}/edit/do', [AdminController::class, 'userEditDo'])->name('admin.user.edit.do');
        Route::get('/admin/user/{id}/delete/do', [AdminController::class, 'userDeleteDo'])->name('admin.user.delete.do');
        // CRUD DAFTAR BOOKING
        Route::get('/admin/booked', [AdminController::class, 'booked'])->name('admin.booked');
        Route::post('/admin/booked/{id}/cancle/do', [AdminController::class, 'bookedCancleDo'])->name('admin.booked.cancle.do');
        Route::post('/admin/booked/{id}/cancle/batal/do', [AdminController::class, 'bookedCancleBatalDo'])->name('admin.booked.cancle.batal.do');
        // Route::get('/admin/acara/{id}/undangan', [AdminController::class, 'acaraUndangan'])->name('admin.undangan');
        // CRUD RUANGAN
        Route::get('/admin/ruangan', [AdminController::class, 'ruangan'])->name('admin.ruangan');
        Route::get('/admin/ruangan/add', [AdminController::class, 'ruanganAdd'])->name('admin.ruangan.add');
        Route::post('/admin/ruangan/add/do', [AdminController::class, 'ruanganAddDo'])->name('admin.ruangan.add.do');
        Route::post('/admin/ruangan/{id}/delete/do', [AdminController::class, 'ruanganDeleteDo'])->name('admin.ruangan.delete.do');
        Route::post('/admin/ruangan/{id}/maintain/do', [AdminController::class, 'ruanganMaintainDo'])->name('admin.ruangan.maintain.do');
        Route::post('/admin/ruangan/{id}/ready/do', [AdminController::class, 'ruanganReadyDo'])->name('admin.ruangan.ready.do');
    });
    Route::middleware(['auth.level:2'])->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user');
        Route::get('/user/book', [UserController::class, 'bookPage'])->name('user.book.page');
        Route::get('/user/{id}/booking', [UserController::class, 'booking'])->name('user.booking');
        Route::post('/user/{id}/booking/do', [UserController::class, 'bookingDo'])->name('user.booking.do');
        Route::get('/user/acara/{id}/delete/do', [UserController::class, 'acaraDeleteDo'])->name('acara.delete.do');
        Route::get('/user/acara/{id}/edit', [UserController::class, 'acaraEdit'])->name('user.acara.edit');
        Route::post('/user/acara/{id}/edit/do', [UserController::class, 'acaraEditDo'])->name('user.acara.edit.do');
    });
    Route::get('storage/undangan/{filename}', function ($filename) {
        $path = storage_path('storage/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);
        return $response;
    })->name('pdf');
    Route::get('/logout/do', [HomeController::class, 'logoutDo'])->name('home.logout.do');
});