<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\UserController;
// use Illuminate\Support\Facades\Auth;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    //             ->name('password.request');

    // Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    //             ->name('password.email');

    // Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    //             ->name('password.reset');

    // Route::post('reset-password', [NewPasswordController::class, 'store'])
    //             ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard/key', [KeyController::class, 'index'])->name('key.index');
    Route::get('dashboard/key/create', [KeyController::class, 'create'])->name('key.create');
    Route::post('dashboard/key/store', [KeyController::class, 'store'])->name('key.save');
    Route::get('dashboard/key/edit/{id}', [KeyController::class, 'edit'])->name('key.edit');
    Route::post('dashboard/key/update/{id}', [KeyController::class, 'update'])->name('key.update');
    Route::post('dashboard/key/delete/{id}', [KeyController::class, 'destroy'])->name('key.delete');

    Route::get('dashboard/users', [UserController::class, 'index'])->name('users.index');
    Route::get('dashboard/users/create', [UserController::class, 'create'])->name('users.create');

    Route::post('dashboard/users/store', [UserController::class, 'store'])->name('users.save');
    Route::get('dashboard/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('dashboard/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('dashboard/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');


    // Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
    //             ->name('verification.notice');

    // Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    //             ->middleware(['signed', 'throttle:6,1'])
    //             ->name('verification.verify');

    // Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //             ->middleware('throttle:6,1')
    //             ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
