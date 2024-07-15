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
        Schema::create('company_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->date('date');
            $table->decimal('total_received', 8, 2)->default(0);
            $table->decimal('price_per_ton', 10, 2);
            $table->decimal('price_per_ton_car', 10, 2);

            $table->integer('tonnage');
            $table->decimal('overnight_stay', 10, 2)->nullable();
            $table->string('location_from');
            $table->string('location_to');
            $table->decimal('total', 10, 2);
            $table->decimal('commission', 10, 2)->default(0);
            $table->decimal('weight', 8, 2)->default(0);
            $table->decimal('detention', 8, 2)->default(0);
            $table->decimal('loading', 8, 2)->default(0);
            $table->decimal('transfer', 8, 2)->default(0);
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('employees')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_transactions');
    }
};
