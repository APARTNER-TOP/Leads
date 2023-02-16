<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class Check extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static function isAdmin() {
        if(Auth::user()->admin === 1) {
            return true;
        }

        return false;
    }
}
