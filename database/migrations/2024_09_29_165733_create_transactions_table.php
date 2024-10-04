<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('person_id');
            $table->bigInteger('transaction_type')->comment('مبلغ تراکنش');
            $table->bigInteger('transaction_amount')->comment('مبلغ تراکنش');
            $table->string('description', 255)->nullable();
            $table->unsignedBigInteger('jdatetime')->comment('jalali');
            $table->timestamps();

        });

    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
