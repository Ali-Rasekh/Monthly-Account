<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->float('Shareholder_interest_percentage')->unsigned()->comment('درصد سهامداران');
            $table->float('partners_percentage')->unsigned()->comment('درصد شرکا');
            $table->unsignedBigInteger('jdatetime')->comment('jalali');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
