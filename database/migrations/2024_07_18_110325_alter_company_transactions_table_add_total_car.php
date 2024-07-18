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
        Schema::table('company_transactions', function (Blueprint $table) {
            $table->decimal('totalCar', 10, 2)->nullable()->default(0.00)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('company_transactions', function (Blueprint $table) {
            $table->decimal('totalCar', 10, 2)->nullable(false)->default(null)->change();
        });
    }
};
