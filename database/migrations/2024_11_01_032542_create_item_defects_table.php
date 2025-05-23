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
        Schema::create('item_defects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idTypeDefact');
            $table->string('itemDefact');
            $table->foreign('idTypeDefact')->references('id')->on('type_defects')->onDelete('cascade')->onUpdate('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_defects');
    }
};