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
                $roleUser = Role::create(['name' => 'tec_sedes']);
                $builderDesktop = Role::create(['name' => 'builder_desktop']);
                $builderLaptop = Role::create(['name' => 'builder_laptop']);
                $builderTurnero = Role::create(['name' => 'builder_turnero']);
                $builderAllInOne = Role::create(['name' => 'builder_all_in_one']);
                $builderRaspberry = Role::create(['name' => 'builder_raspberry']);

                Permission::create(['name' => 'admin.inventory.dash.index'])->syncRoles([$roleAdmin, $roleUser]);

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

                Permission::create(['name' => 'user.inventory.desktop.index'])
                        ->syncRoles([$roleUser, $builderDesktop]);
                Permission::create(['name' => 'user.inventory.desktop.create'])
                        ->syncRoles([$roleUser, $builderDesktop]);
                Permission::create(['name' => 'user.inventory.desktop.edit'])
                        ->syncRoles([$roleUser, $builderDesktop]);
                Permission::create(['name' => 'user.inventory.desktop.show'])
                        ->syncRoles([$roleUser, $builderDesktop]);
                Permission::create(['name' => 'user.inventory.desktop.destroy'])
                        ->syncRoles([$roleUser, $builderDesktop]);

                Permission::create(['name' => 'user.inventory.allinone.index'])
                        ->syncRoles([$roleUser, $builderAllInOne]);
                Permission::create(['name' => 'user.inventory.allinone.create'])
                        ->syncRoles([$roleUser, $builderAllInOne]);
                Permission::create(['name' => 'user.inventory.allinone.edit'])
                        ->syncRoles([$roleUser, $builderAllInOne]);
                Permission::create(['name' => 'user.inventory.allinone.show'])
                        ->syncRoles([$roleUser, $builderAllInOne]);
                Permission::create(['name' => 'user.inventory.allinone.destroy'])
                        ->syncRoles([$roleUser, $builderAllInOne]);

                Permission::create(['name' => 'user.inventory.laptop.index'])
                        ->syncRoles([$roleUser, $builderLaptop]);
                Permission::create(['name' => 'user.inventory.laptop.create'])
                        ->syncRoles([$roleUser, $builderLaptop]);
                Permission::create(['name' => 'user.inventory.laptop.edit'])
                        ->syncRoles([$roleUser, $builderLaptop]);
                Permission::create(['name' => 'user.inventory.laptop.show'])
                        ->syncRoles([$roleUser, $builderLaptop]);
                Permission::create(['name' => 'user.inventory.laptop.destroy'])
                        ->syncRoles([$roleUser, $builderLaptop]);

                Permission::create(['name' => 'user.inventory.turnero.index'])
                        ->syncRoles([$roleUser, $builderTurnero]);
                Permission::create(['name' => 'user.inventory.turnero.create'])
                        ->syncRoles([$roleUser, $builderTurnero]);
                Permission::create(['name' => 'user.inventory.turnero.edit'])
                        ->syncRoles([$roleUser, $builderTurnero]);
                Permission::create(['name' => 'user.inventory.turnero.show'])
                        ->syncRoles([$roleUser, $builderTurnero]);
                Permission::create(['name' => 'user.inventory.turnero.destroy'])
                        ->syncRoles([$roleUser, $builderTurnero]);

                Permission::create(['name' => 'user.inventory.raspberry.index'])
                        ->syncRoles([$roleUser, $builderRaspberry]);
                Permission::create(['name' => 'user.inventory.raspberry.create'])
                        ->syncRoles([$roleUser, $builderRaspberry]);
                Permission::create(['name' => 'user.inventory.raspberry.edit'])
                        ->syncRoles([$roleUser, $builderRaspberry]);
                Permission::create(['name' => 'user.inventory.raspberry.show'])
                        ->syncRoles([$roleUser, $builderRaspberry]);
                Permission::create(['name' => 'user.inventory.raspberry.destroy'])
                        ->syncRoles([$roleUser, $builderRaspberry]);
        }
}
