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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_account_id')->references('id')->on('accounts')->cascadeOnDelete();
            $table->foreignId('receiver_account_id')->references('id')->on('accounts')->cascadeOnDelete();
            $table->decimal('amount_in_sender_currency');
            $table->decimal('amount_in_receiver_currency');
            $table->decimal('amount_in_base_currency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
