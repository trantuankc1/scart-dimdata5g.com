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
        Schema::create('agency_order_sim', function (Blueprint $table) {
            $table->id();
            $table->uuid('agency_user_id');
            $table->string('sim_type')->nullable();
            $table->integer('quantity');
            $table->string('delivery_address');
            $table->string('contact_email');
            $table->string('phone');
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_order_sim');
    }
};
