<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDriverIdPhotoToTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add column to company_transactions table
        Schema::table('company_transactions', function (Blueprint $table) {
            $table->string('driver_id_photo')->nullable();
        });

        // Add column to individual_transactions table
        Schema::table('individual_transactions', function (Blueprint $table) {
            $table->string('driver_id_photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop column from company_transactions table
        Schema::table('company_transactions', function (Blueprint $table) {
            $table->dropColumn('driver_id_photo');
        });

        // Drop column from individual_transactions table
        Schema::table('individual_transactions', function (Blueprint $table) {
            $table->dropColumn('driver_id_photo');
        });
    }
}