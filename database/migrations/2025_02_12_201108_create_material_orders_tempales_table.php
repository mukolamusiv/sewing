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
        Schema::create('material_orders_tempales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials');
            $table->foreignId('order_templates_id')->constrained('order_templates');
            $table->decimal('quantity', 8, 2);
            $table->timestamps();
        });

        Schema::create('material_order_to_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_orders_tempales_id')->constrained('material_orders_tempales')->onDelete('cascade');
            $table->foreignId('order_template_id')->constrained('order_templates')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_order_to_templates');
        Schema::dropIfExists('material_orders_tempales');
    }
};
