<?php

namespace Database\Seeders;


use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class UsersRolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $create = Permission::create(['name'=>'create' , 'guard_name'=>'web']);
        $edit =Permission::create(['name'=>'edit' , 'guard_name'=>'web']);
        $delete =Permission::create(['name'=>'delete' , 'guard_name'=>'web']);

        $admin = Role::create(['name'=>'admin' , 'guard_name'=>'web']);
        $user =Role::create(['name'=>'user' , 'guard_name'=>'web']);

        $admin->givePermissionTo($create);
        $admin->givePermissionTo($edit);
        $admin->givePermissionTo($delete);

        $user->givePermissionTo($edit);

        State::create(['name'=>'تهران']);
        State::create(['name'=>'خراسان']);
        State::create(['name'=>'کرمان']);
        City::create(['name'=>'تهران' , 'state_id'=>1]);
        City::create(['name'=>'کرج' , 'state_id'=>1]);
        City::create(['name'=>'مشهد' , 'state_id'=>2]);
        City::create(['name'=>'بیرجند' , 'state_id'=>2]);
        City::create(['name'=>'کرمان' , 'state_id'=>3]);
        City::create(['name'=>'ماهان' , 'state_id'=>3]);


        $adminUser = User::create([
            'email'=>'ahad.mirhabibi@gmail.com',
            'mobile'=>'09387153611',
            'birth_date'=>'1995/03/28',
            'city_id'=>5,
            'status'=>true,
            'full_name'=>'احد میرحبیبی',
            'password' => bcrypt('123')
        ]);


        $adminUser->assignRole('admin');
    }
}
