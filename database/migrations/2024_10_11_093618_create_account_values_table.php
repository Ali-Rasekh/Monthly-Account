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
        Schema::create('account_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('account_id');
            $table->float('value')->unsigned();
            $table->unsignedBigInteger('jdatetime')->comment('jalali');
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_values');
    }
};
