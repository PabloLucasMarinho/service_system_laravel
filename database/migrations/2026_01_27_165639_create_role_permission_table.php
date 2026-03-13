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
    Schema::create('role_permission', function (Blueprint $table) {
      $table->foreignUuid('role_uuid')
        ->constrained('roles', 'uuid')
        ->cascadeOnDelete();
      $table->foreignUuid('permission_uuid')
        ->constrained('permissions', 'uuid')
        ->cascadeOnDelete();
      $table->primary(['role_uuid', 'permission_uuid']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('role_permission');
  }
};
