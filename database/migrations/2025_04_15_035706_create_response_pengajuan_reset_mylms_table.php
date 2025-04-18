<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('response_pengajuan_reset_mylms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengajuan_mylms_id');
            $table->string('username_baru');
            $table->string('password_baru');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('pengajuan_mylms_id')->references('id')->on('pengajuan_reset_mylms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_pengajuan_reset_mylms');
    }
};
