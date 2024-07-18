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
            //
            $table->unsignedBigInteger('loader_id')->nullable(); // Add loader_id column

            // Add foreign key constraint for loader_id
            $table->foreign('loader_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_transactions', function (Blueprint $table) {
            $table->dropForeign(['loader_id']);
            $table->dropColumn('loader_id');
        });
    }
};

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
            //
            $table->unsignedBigInteger('loader_id')->nullable(); // Add loader_id column

            // Add foreign key constraint for loader_id
            $table->foreign('loader_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_transactions', function (Blueprint $table) {
            $table->dropForeign(['loader_id']);
            $table->dropColumn(['cargo_type', 'loader_id']);
        });
    }
};
