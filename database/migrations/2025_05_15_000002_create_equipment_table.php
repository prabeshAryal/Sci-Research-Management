<?php
// database/migrations/2025_05_15_000002_create_equipment_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('manufacturer')->nullable();
            $table->string('serial_number')->unique();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('equipment');
    }
};
