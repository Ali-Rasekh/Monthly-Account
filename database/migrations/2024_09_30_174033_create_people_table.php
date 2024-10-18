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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('mobile', 11)->nullable();
            $table->float('wealth')->default(0);
            $table->float('belongings')->default(0)->comment('متعلقات');
            $table->unsignedTinyInteger('is_partner');
            $table->float('percentage_of_participation')->default(0)->comment('درصد شراکت');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
