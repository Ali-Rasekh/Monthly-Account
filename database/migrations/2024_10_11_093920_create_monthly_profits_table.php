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
            $table->float('current_wealth')->unsigned(); // دارایی شخص در آن لحظه
            $table->float('current_belongings')->unsigned(); // متعلقات شخص در آن لحظه
            $table->float('current_participation_percentage')->unsigned(); // درصد شراکت شخص در آن لحظه
            $table->float('wealth_profit'); // سود حاصل از دارایی
            $table->float('belongings_profit'); // سود حاصل از متعلقات
            $table->float('participation_profit'); // سود حاصل از شراکت
            $table->float('total_profit'); // کل سود شخص در آن لحظه
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
