<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MasterSiswa extends Model
{
    protected $table = 'master_siswas';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['nama', 'nis', 'nisn', 'email', 'no_hp', 'status', 'password', 'tmp_rombel'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }

    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'siswa_id');
    }

    public function pengajuanResetGoogle()
    {
        return $this->hasMany(PengajuanResetGoogle::class, 'siswa_id');
    }

    public function pengajuanResetMylms()
    {
        return $this->hasMany(PengajuanResetMylms::class, 'siswa_id');
    }

    public function pengajuanResetIgracias()
    {
        return $this->hasMany(PengajuanResetIgracias::class, 'siswa_id');
    }

    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'siswa_id');
    }
}
