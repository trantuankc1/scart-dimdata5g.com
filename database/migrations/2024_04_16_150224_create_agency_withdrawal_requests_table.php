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
        Schema::create('agency_withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('agency_user_id');
            $table->string('bank_name');
            $table->string('name_account_owner');
            $table->string('bank_account_number');
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['new', 'processing', 'completed'])->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_withdrawal_requests');
    }
};
