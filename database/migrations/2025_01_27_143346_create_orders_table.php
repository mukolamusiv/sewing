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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('companies')->onDelete('cascade');
            $table->enum('status', ['нове','очікує матеріали', 'виготовляється', 'готово','доставлено'])->default('нове');
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->foreignId('material_id')->constrained('materials');
            $table->foreignId('order_template_id')->nullable()->constrained('order_templates')->onDelete('cascade');
            $table->string('time')->nullable();
            $table->integer('count')->default(1);
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
