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
        Schema::create('cash_calculations', function (Blueprint $table) {
            $table->id();
            $table->integer('ristretto');
            $table->integer('espresso');
            $table->integer('lungo');
            $table->decimal('amount', 8,2);
            $table->integer('number_of_pods');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_calculations');
    }
};
