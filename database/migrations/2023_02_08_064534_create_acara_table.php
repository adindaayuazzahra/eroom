<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_acara', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_ruangan');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('nama_rapat');
            $table->integer('jumlah_orang');
            $table->string('undangan');
            $table->boolean('sound')->nullable();
            $table->boolean('tv')->nullable();
            $table->boolean('snack_pagi')->nullable();
            $table->boolean('snack_siang')->nullable();
            $table->boolean('makan_siang')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('status');
            $table->string('pesan');
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_ruangan')->references('id')->on('tb_ruangan')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_acara');
    }
};
