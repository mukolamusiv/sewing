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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('material_id')->constrained('materials');
            $table->foreignId('companies_id')->constrained('companies');
            //$table->decimal('count', 10, 2)->default(0);
            $table->foreignId('user_id')->constrained('users');
            //$table->foreignId('warehouse_id')->constrained('warehouses');
            //$table->foreignId('order_id')->nullable()->constrained('orders');
            $table->decimal('total',10,2)->default(0);
            $table->decimal('discount',10,2)->default(0);
            $table->decimal('total_discount',10,2)->default(0);
            $table->decimal('total_payment',10,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
