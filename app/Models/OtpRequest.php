<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OtpRequest extends Model
{
    protected $fillable = ['siswa_id', 'otp_code', 'expires_at', 'is_verified'];

    public function isExpired()
    {
        return Carbon::now()->gt($this->expires_at);
    }

    public function siswa()
    {
        return $this->belongsTo(MasterSiswa::class);
    }
}
