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
        Schema::table('company_transactions', function (Blueprint $table) {
            $table->decimal('vehicle_allowance', 10, 2)->nullable()->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_transactions', function (Blueprint $table) {
            $table->dropColumn('vehicle_allowance');
        });
    }
};
