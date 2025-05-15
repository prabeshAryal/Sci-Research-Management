<?php
// database/migrations/2025_05_15_000001_create_researchers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('researchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('institution')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('researchers');
    }
};
