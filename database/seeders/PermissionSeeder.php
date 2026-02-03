<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'الاعدادات',
                'routes' => 'settings.index,settings.update'
            ],
            [
                'name' => 'الاقسام',
                'routes' => 'categories.index,categories.create,categories.store,categories.edit,categories.update,categories.destroy'
            ],
            [
                'name' => 'المناطق',
                'routes' => 'regions.index,regions.create,regions.store,regions.edit,regions.update,regions.destroy'
            ],
            [
                'name' => 'المدن',
                'routes' => 'cities.index,cities.create,cities.store,cities.edit,cities.update,cities.destroy'
            ],
            [
                'name' => 'تواصل معنا',
                'routes' => 'contacts.index,contacts.destroy'
            ],
            [
                'name' => 'العملاء',
                'routes' => 'clients.index,clients.destroy'
            ],
            [
                'name' => 'التعليقات',
                'routes' => 'comments.index,comments.destroy'
            ],
            [
                'name' => 'المطاعم',
                'routes' => 'restaurants.index,restaurants.destroy'
            ],
            [
                'name' => 'المنتجات',
                'routes' => 'products.index,products.create,products.store,products.edit,products.update,products.destroy'
            ],
            [
                'name' => 'الطلبات',
                'routes' => 'orders.index,orders.show,orders.destroy'
            ],
            [
                'name' => 'العروض',
                'routes' => 'offers.index,offers.create,offers.store,offers.edit,offers.update,offers.destroy'
            ],
            [
                'name' => 'العمليات المالية',
                'routes' => 'payments.index,payments.destroy'
            ],
            [
                'name' => 'المستخدمين',
                'routes' => 'users.index,users.create,users.store,users.edit,users.update,users.destroy'
            ],
            [
                'name' => 'الرتب والادوار',
                'routes' => 'roles.index,roles.create,roles.store,roles.edit,roles.update,roles.destroy'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name'],
                'guard_name' => 'web'
            ], [
                'routes' => $permission['routes']
            ]);
        }
    }
}
