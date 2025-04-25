<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogResetGooglesTable extends Migration
{
    public function up()
    {
        Schema::create('log_reset_googles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('pegawai_nip')->nullable(); // bisa null untuk siswa
            $table->string('email');
            $table->string('password_baru');
            $table->boolean('status')->default(false); // true = berhasil, false = gagal
            $table->text('pesan')->nullable(); // log error atau sukses
            $table->timestamp('waktu_reset')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_reset_googles');
    }
}
