<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elements', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unique();
            $table->string('symbol', 2);
            $table->string('name');
            $table->decimal('atomic_mass', 10, 3);
            $table->string('category');
            $table->decimal('melting_point', 10, 2)->nullable();
            $table->decimal('boiling_point', 10, 2)->nullable();
            $table->integer('group');
            $table->integer('period');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elements');
    }
}; 