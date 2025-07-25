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
        Schema::create('age_loads', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('min_age');
            $table->unsignedTinyInteger('max_age');
            $table->decimal('load', 4, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('age_loads');
    }
};
