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
            $table->foreignId('wallet_id')->constrained('wallets')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->decimal('wallet_to', 10, 2);
            $table->decimal('wallet_after', 10, 2);
            $table->enum('type', ['надходження', 'списання'])->default('надходження');
            $table->string('description')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('companies_id')->nullable()->constrained('companies');
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
