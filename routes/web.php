<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\User;
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

Route::middleware('guest')->group(function () {

    Route::get('/', function () {
        return view('auth.login');
    });

    Route::get('register', [RegisteredUserController::class, 'create'])
                    ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    // if(!DB::connection()->getPdo() || DB::connection()->getDatabaseName()  == 'forge' || !DB::connection()->getDatabaseName()) {
    //     Route::get('/', function () {
    //         return view('welcome');
    //     });
    // } else if(DB::connection()->getDatabaseName()) {
    //     $user_count = User::count() ?? 0;

    //     if(!$user_count) {
    //         Route::get('/', [RegisteredUserController::class, 'create'])
    //                 ->name('register');

    //         Route::post('register', [RegisteredUserController::class, 'store']);
    //     } else {
    //         Route::get('/', [AuthenticatedSessionController::class, 'create'])
    //                 ->name('login');
    //     }
    // }
});

Route::get('/dashboard', function () {

    $user = User::find(2);
    $keys = Key::all();

    return view('dashboard.index', compact('keys', 'user'));
})->middleware(['auth', 'verified'])->name('dashboard');

require_once __DIR__.'/auth.php';
