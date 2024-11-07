<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fix_proses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPart');
            $table->unsignedBigInteger('idColor');
            $table->unsignedBigInteger('idShift');
            $table->unsignedBigInteger('idLine');
            $table->string('typeDefact');
            $table->string('keterangan');
            $table->string('role');
            $table->string('idNPK');

            $table->foreign('idLine')->references('id')->on('lines')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('idNPK')->references('npk')->on('users')->onDelete('cascade')->onUpdate('cascade');
          
            $table->foreign('idPart')->references('id')->on('parts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('idColor')->references('id')->on('colors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('idShift')->references('id')->on('shifts')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fix_proses');
    }
};