<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('npk')->primary(); // Set NPK as the primary key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role'); // Add status field
            $table->unsignedBigInteger('depts');
            $table->string('NoWa');

            $table->foreign('depts')->references('id')->on('depts')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};