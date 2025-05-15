<?php
// database/migrations/2025_05_15_000004_create_observations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('observations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experiment_id')->constrained()->onDelete('cascade');
            $table->date('observation_date');
            $table->text('data');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('observations');
    }
};
