<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadSourceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\QueueController;

//! for guest
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});


//! for auth
Route::middleware('auth')->group(function () {

    //! Keys for leads 1
    Route::get('dashboard/keys', [KeyController::class, 'index'])->name('key.index');
    Route::get('dashboard/keys/create', [KeyController::class, 'create'])->name('key.create');
    Route::post('dashboard/keys/store', [KeyController::class, 'store'])->name('key.save');
    Route::get('dashboard/keys/edit/{id}', [KeyController::class, 'edit'])->name('key.edit');
    Route::post('dashboard/keys/update/{id}', [KeyController::class, 'update'])->name('key.update');
    Route::post('dashboard/keys/delete/{id}', [KeyController::class, 'destroy'])->name('key.delete');

    //! Lead source for leads 2
    Route::resource('dashboard/lead_source', LeadSourceController::class);
    Route::post('dashboard/lead_source/store', [LeadSourceController::class, 'store'])->name('lead_source.save');
    Route::post('dashboard/lead_source/update/{id}', [LeadSourceController::class, 'update'])->name('lead_source.update');
    Route::post('dashboard/lead_source/delete/{id}', [LeadSourceController::class, 'destroy'])->name('lead_source.delete');

    // Route::get('dashboard/lead_source', [LeadSourceController::class, 'index'])->name('lead_source.index');
    // Route::get('dashboard/lead_source/create', [LeadSourceController::class, 'create'])->name('lead_source.create');
    // Route::get('dashboard/lead_source/edit/{id}', [LeadSourceController::class, 'edit'])->name('lead_source.edit');

    //! Queues
    // Route::get('dashboard/queues', [QueueController::class, 'index'])->name('queues.index');
    // Route::patch('dashboard/queues/{id}/release', [QueueController::class, 'release'])->name('queue.release');
    Route::resource('dashboard/queues', QueueController::class);


    //! Users
    Route::get('dashboard/users', [UserController::class, 'index'])->name('users.index');
    Route::get('dashboard/user/create', [UserController::class, 'create'])->name('users.create');
    Route::post('dashboard/user/store', [UserController::class, 'store'])->name('users.save');
    Route::get('dashboard/user/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('dashboard/user/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('dashboard/user/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
    Route::put('dashboard/users/password/{id}', [PasswordController::class, 'update'])->name('password.update');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    //! Leads
    Route::get('dashboard/leads/lead1', [LeadController::class, 'lead1'])->name('leads.lead1');
    Route::get('dashboard/leads/lead2', [LeadController::class, 'lead2'])->name('leads.lead2');

    //! API
    Route::post('dashboard/api/send1', [ApiController::class, 'send1'])->name('api.send1');
    Route::post('dashboard/api/send2', [ApiController::class, 'send2'])->name('api.send2');

    //! Logs
    Route::resource('dashboard/logs', LogController::class);

    //! Settings
    Route::resource('dashboard/settings', SettingController::class);

    //! Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
