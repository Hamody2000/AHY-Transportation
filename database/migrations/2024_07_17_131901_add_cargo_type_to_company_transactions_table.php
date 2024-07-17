// database/migrations/xxxx_xx_xx_xxxxxx_add_cargo_type_to_company_transactions_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCargoTypeToCompanyTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('company_transactions', function (Blueprint $table) {
            $table->string('cargo_type')->nullable(); // Add this line to the migration file
        });
    }

    public function down()
    {
        Schema::table('company_transactions', function (Blueprint $table) {
            $table->dropColumn('cargo_type');
        });
    }
}
