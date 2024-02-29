<?php

namespace Database\Seeders;

use App\Models\Permision;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
           [ 'name' => 'super-admin','display_name' => 'super Admin','group'=>'system'],
           [ 'name' => 'admin','display_name' => 'Admin','group'=>'system'],
           [ 'name' => 'employee','display_name' => 'employee','group'=>'system'],
           [ 'name' => 'manager','display_name' => 'manager','group'=>'system'],
           [ 'name' => 'user','display_name' => 'user','group'=>'system'],
        ];
        foreach($roles as $role){
            Role::updateOrCreate($role);
        }

        // Tìm hoặc tạo người dùng super-admin
        $superAdmin = User::whereEmail('admin@gmail.com')->first();
        if (!$superAdmin) {
            $superAdmin = User::factory()->create([
                'email' => 'admin@gmail.com',
                'password' => Hash::make('27012004'),
                'name'=>'Huỳnh Duy'
        ]);
        }
        $superAdmin->assignRole('super-admin','admin');
        //phía dưới tôi muốn cấp quyền cho manager là tạo category và xem 
        $managerRole = Role::where('name', 'manager')->first();
        if ($managerRole) {
            $managerRole->givePermissionTo(['show-category', 'create-category', 'update-category']);
        }

        $permissions = [
            [ 'name' => 'create-user','display_name' => 'create user','group'=>'User'],
            [ 'name' => 'update-user','display_name' => 'update user','group'=>'User'],
            [ 'name' => 'show-user','display_name' => 'show user','group'=>'User'],
            [ 'name' => 'delete-user','display_name' => 'delete user','group'=>'User'],

            [ 'name' => 'create-role','display_name' => 'create role','group'=>'Role'],
            [ 'name' => 'update-role','display_name' => 'update role','group'=>'Role'],
            [ 'name' => 'show-role','display_name' => 'show role','group'=>'Role'],
            [ 'name' => 'delete-role','display_name' => 'delete role','group'=>'Role'],

            [ 'name' => 'create-category','display_name' => 'create category','group'=>'category'],
            [ 'name' => 'update-category','display_name' => 'update category','group'=>'category'],
            [ 'name' => 'show-category','display_name' => 'show category','group'=>'category'],
            [ 'name' => 'delete-category','display_name' => 'delete category','group'=>'category'],

            [ 'name' => 'create-product','display_name' => 'create product','group'=>'product'],
            [ 'name' => 'update-product','display_name' => 'update product','group'=>'product'],
            [ 'name' => 'show-product','display_name' => 'show product','group'=>'product'],
            [ 'name' => 'delete-product','display_name' => 'delete product','group'=>'product'],

            [ 'name' => 'create-coupon','display_name' => 'create coupon','group'=>'coupon'],
            [ 'name' => 'update-coupon','display_name' => 'update coupon','group'=>'coupon'],
            [ 'name' => 'show-coupon','display_name' => 'show coupon','group'=>'coupon'],
            [ 'name' => 'delete-coupon','display_name' => 'delete coupon','group'=>'coupon'],

            [ 'name' => 'list-order','display_name' => 'list order','group'=>'orders'],
            [ 'name' => 'update-order-status','display_name' => 'update order status','group'=>'coupon'],

            
        ];
        
        // foreach($permissions as $item){
        //     Permision::updateOrCreate($item);
            
        // }
        foreach($permissions as $item){
            Permision::updateOrCreate(
                ['name' => $item['name'], 'guard_name' => 'web'],
                $item
            );
        }
    }
}
