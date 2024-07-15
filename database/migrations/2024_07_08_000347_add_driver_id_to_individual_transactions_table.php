<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDriverIdToIndividualTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('individual_transactions', function (Blueprint $table) {
            // Add the driver_id column and set it to nullable
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('individual_transactions', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['driver_id']);

            // Drop the driver_id column
            $table->dropColumn('driver_id');
        });
    }
}
