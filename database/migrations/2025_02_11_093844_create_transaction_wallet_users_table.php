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
        Schema::create('transaction_wallet_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_user_id')->constrained('wallet_users')->cascadeOnDelete();
            $table->decimal('count', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['надходження', 'списання'])->default('надходження');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_wallet_users');
    }
};
