<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PengajuanResetGoogle extends Model
{
    protected $table = 'pengajuan_reset_googles';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['siswa_id', 'keterangan', 'status_pengajuan', 'status'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = $model->getKey() ?? Str::uuid();
        });
    }

    public function siswa()
    {
        return $this->belongsTo(MasterSiswa::class, 'siswa_id');
    }

    public function response()
    {
        return $this->hasOne(ResponsePengajuanResetGoogle::class, 'pengajuan_google_id');
    }
}
