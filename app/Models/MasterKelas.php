<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MasterKelas extends Model
{
    protected $table = 'master_kelas';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['nama_kelas', 'tingkat_kelas', 'jurusan_id', 'status'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = $model->getKey() ?? Str::uuid();
        });
    }

    public function jurusan()
    {
        return $this->belongsTo(MasterJurusan::class, 'jurusan_id');
    }

    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'kelas_id');
    }

    public function pengajuanResetGoogle()
    {
        return $this->hasManyThrough(
            \App\Models\PengajuanResetGoogle::class,
            \App\Models\Rombel::class,
            'kelas_id',
            'siswa_id',
            'id',
            'siswa_id'
        );
    }

    public function pengajuanResetMylms()
    {
        return $this->hasManyThrough(
            \App\Models\PengajuanResetMylms::class,
            \App\Models\Rombel::class,
            'kelas_id',
            'siswa_id',
            'id',
            'siswa_id'
        );
    }

    public function pengajuanResetIgracias()
    {
        return $this->hasManyThrough(
            \App\Models\PengajuanResetIgracias::class,
            \App\Models\Rombel::class,
            'kelas_id',
            'siswa_id',
            'id',
            'siswa_id'
        );
    }
}
