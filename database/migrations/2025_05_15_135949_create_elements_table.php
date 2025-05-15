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
        Schema::create('elements', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('symbol', 4);
            $table->string('name');
            $table->float('atomic_mass')->nullable();
            $table->string('category');
            $table->float('melting_point')->nullable();
            $table->float('boiling_point')->nullable();
            $table->integer('group')->nullable();
            $table->integer('period')->nullable();
            $table->text('description')->nullable();
            $table->string('model_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elements');
    }
};
