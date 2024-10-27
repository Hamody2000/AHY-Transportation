<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('daily_expenses', function (Blueprint $table) {
            // Make the amount column nullable
            $table->decimal('amount', 10, 2)->nullable()->change(); // Adjust the precision as needed
        });
        
        Schema::table('daily_expenses', function (Blueprint $table) {
            $table->decimal('income', 10, 2)->nullable(); // Adjust the precision as needed
        });
    }

    public function down()
    {
        Schema::table('daily_expenses', function (Blueprint $table) {
            $table->dropColumn('income');
        });
    }
};
