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
        Schema::table('response_pengajuan_reset_googles', function (Blueprint $table) {
            $table->boolean('sudah_kirim_wa')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('response_pengajuan_reset_googles', function (Blueprint $table) {
            //
        });
    }
};
