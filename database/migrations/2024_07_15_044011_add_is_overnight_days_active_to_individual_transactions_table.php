<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsOvernightDaysActiveToIndividualTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('individual_transactions', function (Blueprint $table) {
            $table->boolean('is_overnight_days_active')->default(true); // True indicates counting is active
        });
    }

    public function down()
    {
        Schema::table('individual_transactions', function (Blueprint $table) {
            $table->dropColumn('is_overnight_days_active');
        });
    }
}
