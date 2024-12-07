<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputPelayanansTable extends Migration
{
    public function up()
    {
        Schema::create('input_pelayanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna');
            $table->foreignId('layanan_id')->constrained('layanan');
            $table->date('tanggal_permintaan');
            $table->string('status', 50)->default('Menunggu Verifikasi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('input_pelayanan');
    }
}
