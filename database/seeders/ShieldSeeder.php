<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
class ShieldSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_card::codes","view_any_card::codes","create_card::codes","update_card::codes","restore_card::codes","restore_any_card::codes","replicate_card::codes","reorder_card::codes","delete_card::codes","delete_any_card::codes","force_delete_card::codes","force_delete_any_card::codes","view_categories","view_any_categories","create_categories","update_categories","restore_categories","restore_any_categories","replicate_categories","reorder_categories","delete_categories","delete_any_categories","force_delete_categories","force_delete_any_categories","view_queue::monitor","view_any_queue::monitor","create_queue::monitor","update_queue::monitor","restore_queue::monitor","restore_any_queue::monitor","replicate_queue::monitor","reorder_queue::monitor","delete_queue::monitor","delete_any_queue::monitor","force_delete_queue::monitor","force_delete_any_queue::monitor","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user"]},{"name":"filament_user","guard_name":"web","permissions":["view_card::codes","view_any_card::codes","create_card::codes","update_card::codes","restore_card::codes","restore_any_card::codes","replicate_card::codes","reorder_card::codes","delete_card::codes","delete_any_card::codes","force_delete_card::codes","force_delete_any_card::codes","view_categories","view_any_categories","create_categories","update_categories","restore_categories","restore_any_categories","replicate_categories","reorder_categories","delete_categories","delete_any_categories","force_delete_categories","force_delete_any_categories"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions,true))) {

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = Utils::getRoleModel()::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name']
                ]);

                if (! blank($rolePlusPermission['permissions'])) {

                    $permissionModels = collect();

                    collect($rolePlusPermission['permissions'])
                        ->each(function ($permission) use($permissionModels) {
                            $permissionModels->push(Utils::getPermissionModel()::firstOrCreate([
                                'name' => $permission,
                                'guard_name' => 'web'
                            ]));
                        });
                    $role->syncPermissions($permissionModels);

                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions,true))) {

            foreach($permissions as $permission) {

                if (Utils::getPermissionModel()::whereName($permission)->doesntExist()) {
                    Utils::getPermissionModel()::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
