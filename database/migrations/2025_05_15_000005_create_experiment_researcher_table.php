<?php
// database/migrations/2025_05_15_000005_create_experiment_researcher_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('experiment_researcher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experiment_id')->constrained()->onDelete('cascade');
            $table->foreignId('researcher_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['experiment_id', 'researcher_id']);
        });
    }
    public function down() {
        Schema::dropIfExists('experiment_researcher');
    }
};
