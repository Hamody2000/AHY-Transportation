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
        Schema::create('individual_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('location_from');
            $table->string('location_to');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('truck_fare', 10, 2)->default(0); // Fare given to truck
            $table->decimal('company_commission', 10, 2)->default(0); // Commission for the company
            $table->decimal('vehicle_allowance', 10, 2)->default(0); // Allowance for the vehicle
            $table->decimal('tips', 10, 2)->default(0); // Tips (profit)
            $table->decimal('fare', 10, 2);
            $table->decimal('remaining_truck_fare', 10, 2)->default(0);
            $table->decimal('final_truck_fare', 10, 2);
            $table->decimal('commission', 10, 2)->default(0);
            $table->integer('agreed_days_with_client')->nullable();
            $table->integer('agreed_days_with_vehicle')->nullable();
            $table->decimal('overnight_price_with_client', 10, 2)->default(0);
            $table->decimal('overnight_price_with_vehicle', 10, 2)->default(0);
            $table->integer('overnight_days')->nullable();
            $table->decimal('net_overnight', 8, 2)->nullable();
            $table->decimal('remaining_fare', 10, 2)->default(0);
            $table->decimal('detention', 8, 2)->nullable();
            $table->decimal('loading', 8, 2)->default(0);
            $table->decimal('transfer', 8, 2)->default(0);
            $table->decimal('total_received', 8, 2)->default(0);
            $table->decimal('total_spent', 8, 2)->default(0);
            $table->decimal('weight', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('individual_transactions');
    }
};
