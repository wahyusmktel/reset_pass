<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Rombel extends Model
{
    protected $table = 'rombels';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['siswa_id', 'kelas_id', 'status'];

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

    public function kelas()
    {
        return $this->belongsTo(MasterKelas::class, 'kelas_id');
    }
}
