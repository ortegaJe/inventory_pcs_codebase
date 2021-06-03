<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
                $roleAdmin = Role::create(['name' => 'super_admin']);
                $roleMacarena = Role::create(['name' => 'tec_mac']);
                $roleTemporal = Role::create(['name' => 'tec_tmp']);

                Permission::create(['name' => 'admin.inventory.dash.index'])->syncRoles([$roleAdmin, $roleMacarena, $roleTemporal]);

                Permission::create(['name' => 'admin.inventory.desktop.index'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.desktop.create'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.desktop.edit'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.desktop.show'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.desktop.destroy'])->syncRoles([$roleAdmin]);

                Permission::create(['name' => 'admin.inventory.laptop.index'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.laptop.create'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.laptop.edit'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.laptop.show'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.laptop.destroy'])->syncRoles([$roleAdmin]);

                Permission::create(['name' => 'admin.inventory.allinone.index'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.allinone.create'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.allinone.edit'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.allinone.show'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.allinone.destroy'])->syncRoles([$roleAdmin]);

                Permission::create(['name' => 'admin.inventory.turneros.index'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.turneros.create'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.turneros.edit'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.turneros.show'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.turneros.destroy'])->syncRoles([$roleAdmin]);

                Permission::create(['name' => 'admin.inventory.raspberry.index'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.raspberry.create'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.raspberry.edit'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.raspberry.show'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.raspberry.destroy'])->syncRoles([$roleAdmin]);

                Permission::create(['name' => 'admin.inventory.tecnicos.index'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.tecnicos.create'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.tecnicos.edit'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.tecnicos.show'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.tecnicos.destroy'])->syncRoles([$roleAdmin]);

                Permission::create(['name' => 'admin.inventory.roles.index'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.roles.create'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.roles.edit'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.roles.show'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.roles.destroy'])->syncRoles([$roleAdmin]);

                Permission::create(['name' => 'admin.inventory.campus.index'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.campus.create'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.campus.edit'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.campus.show'])->syncRoles([$roleAdmin]);
                Permission::create(['name' => 'admin.inventory.campus.destroy'])->syncRoles([$roleAdmin]);

                Permission::create(['name' => 'admin.inventory.campu.desktop.index'])
                        ->syncRoles([$roleAdmin, $roleMacarena, $roleTemporal]);
                Permission::create(['name' => 'admin.inventory.campu..desktopcreate'])
                        ->syncRoles([$roleAdmin, $roleMacarena, $roleTemporal]);
                Permission::create(['name' => 'admin.inventory.campu.desktop.edit'])
                        ->syncRoles([$roleAdmin, $roleMacarena, $roleTemporal]);
                Permission::create(['name' => 'admin.inventory.campu.desktop.show'])
                        ->syncRoles([$roleAdmin, $roleMacarena, $roleTemporal]);
                Permission::create(['name' => 'admin.inventory.campu.desktop.destroy'])
                        ->syncRoles([$roleAdmin, $roleMacarena, $roleTemporal]);
        }
}
