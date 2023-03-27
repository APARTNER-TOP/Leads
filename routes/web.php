<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Key;

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

//! run queue php artisan queue:work --max-jobs=10
Route::get('/queue_run', function () {
    Artisan::call('queue:work', ['--tries' => 1]);
    // Artisan::call('queue:work', ['--tries' => 3, '--max-jobs' => 50]);
});

Route::middleware('guest')->group(function () {

    Route::get('/', function () {
        return view('auth.login');
    });

    Route::get('register', [RegisteredUserController::class, 'create'])
                    ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::get('/dashboard', function () {
    $keys = Key::all();

    return view('dashboard.leads.lead1', compact('keys'));
})->middleware(['auth', 'verified'])->name('dashboard');

require_once __DIR__.'/auth.php';
