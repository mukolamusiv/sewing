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
        Schema::create('order_process_templates', function (Blueprint $table) {
            $table->id();
            $table->string('step');
            $table->decimal('hours_worked', 10, 2);
            $table->decimal('rate_per_hour', 10, 2);
            $table->boolean('is_moving')->default(false);
            $table->timestamps();
        });

        Schema::create('order_process_to_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_process_template_id')->constrained('order_process_templates')->onDelete('cascade');
            $table->foreignId('order_template_id')->constrained('order_templates')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_process_to_templates');
        Schema::dropIfExists('order_process_templates');
    }
};
