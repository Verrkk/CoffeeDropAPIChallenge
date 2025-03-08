<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cash_calculations')) {
            Schema::create('cash_calculations', function (Blueprint $table) {
                $table->id();
                $table->integer('ristretto');
                $table->integer('espresso');
                $table->integer('lungo');
                $table->decimal('amount', 6, 2);
                $table->integer('number_of_pods')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_calculations');
    }
};
