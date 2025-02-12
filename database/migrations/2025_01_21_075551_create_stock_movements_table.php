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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_in_id')->nullable()->constrained('warehouses')->onDelete('cascade');
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 8, 2);
            $table->foreignId('supplier_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->enum('movement_type', ['in', 'out','move']);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('warehouse_out_id')->nullable()->constrained('warehouses')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
