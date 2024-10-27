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
        Schema::table('individual_transactions', function (Blueprint $table) {
            $table->date('detention_date_client')->nullable();
            $table->date('detention_date_car')->nullable();
        });

        Schema::table('company_transactions', function (Blueprint $table) {
            $table->date('detention_date_client')->nullable();
            $table->date('detention_date_car')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('individual_transactions', function (Blueprint $table) {
            $table->dropColumn(['detention_date_client', 'detention_date_car']);
        });

        Schema::table('company_transactions', function (Blueprint $table) {
            $table->dropColumn(['detention_date_client', 'detention_date_car']);
        });
    }
};
