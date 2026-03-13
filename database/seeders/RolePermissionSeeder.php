<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $adminRole = DB::table('roles')->where('name', 'admin')->first();
    $employeeRole = DB::table('roles')->where('name', 'employee')->first();

    $allPermissions = DB::table('permissions')->pluck('uuid');

    // Admin tem todas as permissões
    foreach ($allPermissions as $permissionUuid) {
      DB::table('role_permission')->insert([
        'role_uuid' => $adminRole->uuid,
        'permission_uuid' => $permissionUuid,
      ]);
    }

    // Employee só pode ver e criar
    $employeePermissions = DB::table('permissions')
      ->whereIn('name', [
        'clients.view',
        'clients.create',
        'appointments.view',
        'appointments.create',
      ])
      ->pluck('uuid');

    foreach ($employeePermissions as $permissionUuid) {
      DB::table('role_permission')->insert([
        'role_uuid' => $employeeRole->uuid,
        'permission_uuid' => $permissionUuid,
      ]);
    }
  }
}
