<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('SuperAdmin')) {
        return redirect()->route('admin');
    } elseif (auth()->user()->hasRole('User')) {
        $kafedras = DB::table('kafedras')->get();
        $requests = DB::table('requests')->where('from', \Illuminate\Support\Facades\Auth::id())->get();
        return view('layouts.index', compact('kafedras', 'requests'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','role:Admin,SuperAdmin'])->prefix('admin')->group(function () {
    Route::resources([
        'roles' => RoleController::class,
        'permissions' => PermissionController::class,
        'users' => UserController::class,
        'requests' => RequestController::class,
    ]);
    Route::get('admin', function () {
        return view('dashboard');
    })->name('admin');
    Route::post('/bugungi', [\App\Repositories\FilterRepository::class, 'bugungi']);
    Route::post('/bajarilmagani', [\App\Repositories\FilterRepository::class, 'bajarilmagani']);
    Route::post('/changestatus', [\App\Repositories\FilterRepository::class, 'changeStatus']);
    Route::post('/confirm', [\App\Repositories\FilterRepository::class, 'confirm']);
});
Route::get('/document/{id}', [DocumentController::class, 'openDocument'])->name('document.open');
Route::post('/document/{id}/sign', [DocumentController::class, 'signDocument'])->name('document.sign');
require __DIR__ . '/auth.php';
