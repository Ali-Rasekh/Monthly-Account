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
        Schema::create('monthly_profits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id'); // شناسه شخص
            $table->float('current_wealth')->unsigned()->default(0); // دارایی شخص در آن لحظه
            $table->float('current_belongings')->unsigned()->default(0); // متعلقات شخص در آن لحظه
            $table->float('current_participation_percentage')->unsigned()->default(0); // درصد شراکت شخص در آن لحظه
            $table->float('wealth_profit')->default(0); // سود حاصل از دارایی
            $table->float('belongings_profit')->default(0); // سود حاصل از متعلقات
            $table->float('participation_profit')->default(0); // سود حاصل از شراکت
            $table->float('total_profit')->default(0); // کل سود شخص در آن لحظه
            $table->unsignedBigInteger('jdatetime')->comment('jalali');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_profits');
    }
};
