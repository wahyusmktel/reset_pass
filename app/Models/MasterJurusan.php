<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MasterJurusan extends Model
{
    protected $table = 'master_jurusans';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['nama_jurusan', 'kode_jurusan', 'status'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = $model->getKey() ?? Str::uuid();
        });
    }

    public function kelas()
    {
        return $this->hasMany(MasterKelas::class, 'jurusan_id');
    }
}
