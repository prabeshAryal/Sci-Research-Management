<?php
// database/migrations/2025_05_15_000006_create_experiment_equipment_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('experiment_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experiment_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['experiment_id', 'equipment_id']);
        });
    }
    public function down() {
        Schema::dropIfExists('experiment_equipment');
    }
};
