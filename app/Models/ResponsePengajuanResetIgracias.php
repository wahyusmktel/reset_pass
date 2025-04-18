<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ResponsePengajuanResetIgracias extends Model
{
    protected $table = 'response_pengajuan_reset_igracias';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['pengajuan_igracias_id', 'username_baru', 'password_baru', 'status', 'sudah_kirim_wa', 'waktu_kirim_wa'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = $model->getKey() ?? Str::uuid();
        });
    }

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanResetIgracias::class, 'pengajuan_igracias_id');
    }
}
