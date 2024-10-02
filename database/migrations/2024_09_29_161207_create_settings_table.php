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
            $table->unsignedInteger('date')->comment('jalali, should 8 digit');
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
