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
        Schema::table('locations', function (Blueprint $table) {
            $table->time('open_monday')->nullable();
            $table->time('open_tuesday')->nullable();
            $table->time('open_wednesday')->nullable();
            $table->time('open_thursday')->nullable();
            $table->time('open_friday')->nullable();
            $table->time('open_saturday')->nullable();
            $table->time('open_sunday')->nullable();
            $table->time('closed_monday')->nullable();
            $table->time('closed_tuesday')->nullable();
            $table->time('closed_wednesday')->nullable();
            $table->time('closed_thursday')->nullable();
            $table->time('closed_friday')->nullable();
            $table->time('closed_saturday')->nullable();
            $table->time('closed_sunday')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn([
                'open_monday', 'open_tuesday', 'open_wednesday', 'open_thursday', 
                'open_friday', 'open_saturday', 'open_sunday',
                'closed_monday', 'closed_tuesday', 'closed_wednesday', 'closed_thursday',
                'closed_friday', 'closed_saturday', 'closed_sunday',
            ]);
        });
    }
};
