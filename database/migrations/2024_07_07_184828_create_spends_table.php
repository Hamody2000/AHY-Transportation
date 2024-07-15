<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpendsTable extends Migration
{
    public function up()
    {
        Schema::create('spends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('individual_transactions')->onDelete('cascade');
            $table->decimal('value', 10, 2);
            $table->text('spend_details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spends');
    }
}
