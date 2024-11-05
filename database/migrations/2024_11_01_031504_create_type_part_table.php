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
        Schema::create('type_parts', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedBigInteger('idCustomer');

            $table->foreign('idCustomer')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_parts');
    }
};