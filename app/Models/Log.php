<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class Log extends Authenticatable
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'status',
        'code',
        'data',
        'result',
        'api'
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function saveData($status, $code, $data, $result, $leads_type = 1) {
        $user_id = $data['user_id'];

        $log = new self;
        $log->user_id = isset($user_id) ? $user_id : Auth::user()->id;
        $log->user_id = $user_id;
        $log->status = $status;
        $log->code = $code;
        $log->data = json_encode($data);
        $log->result = $result;
        $log->api = $leads_type;
        $log->save();
    }
}
