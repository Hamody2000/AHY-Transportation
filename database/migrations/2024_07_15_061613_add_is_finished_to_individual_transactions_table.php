<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFinishedToIndividualTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('individual_transactions', function (Blueprint $table) {
            $table->boolean('is_finished')->default(false); // False indicates the transaction is not finished
            $table->date('finished_at')->nullable(); // Date when the transaction was finished
        });
    }

    public function down()
    {
        Schema::table('individual_transactions', function (Blueprint $table) {
            $table->dropColumn(['is_finished', 'finished_at']);
        });
    }
}
