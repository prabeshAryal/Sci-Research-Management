<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('elements', function (Blueprint $table) {
            $table->string('model_path')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('elements', function (Blueprint $table) {
            $table->dropColumn('model_path');
        });
    }
}; 