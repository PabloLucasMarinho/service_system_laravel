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
    Schema::create('appointment_service', function (Blueprint $table) {
      $table->foreignUuid('appointment_uuid')
        ->constrained('appointments', 'uuid')
        ->cascadeOnDelete();
      $table->foreignUuid('service_uuid')
        ->constrained('services', 'uuid')
        ->cascadeOnDelete();
      $table->foreignUuid('promotion_uuid')
        ->constrained('promotions', 'uuid')
        ->cascadeOnDelete();
      $table->primary(['appointment_uuid', 'service_uuid']);

      $table->decimal('original_price', 10);
      $table->string('manual_discount_type')->nullable();
      $table->decimal('manual_discount_value', 5)->nullable();
      $table->decimal('manual_discount_amount', 10)->nullable();
      $table->decimal('promotion_amount_snapshot', 10)->nullable();
      $table->decimal('final_price', 10);
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('appointment_service');
  }
};
