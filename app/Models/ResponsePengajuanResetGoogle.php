<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ResponsePengajuanResetGoogle extends Model
{
    protected $table = 'response_pengajuan_reset_googles';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['pengajuan_google_id', 'email_baru', 'password_baru', 'status', 'sudah_kirim_wa', 'waktu_kirim_wa'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = $model->getKey() ?? Str::uuid();
        });
    }

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanResetGoogle::class, 'pengajuan_google_id');
    }
}
