<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = new \App\User;

        // $user->email = 'admin@dycode.co.id';
        // $user->password = bcrypt('admin1234');
        // $user->name = 'admin';
        // $user->save();
        $credentials = [
        	'email' => 'admin@dycode.co.id',
        	'password' => 'admin1234',
        ];
        $role1 = \Sentinel::getRoleRepository()->createModel()->create([
        	'name' => 'Admin',
        	'slug' => 'admin'
        ]);
        $role2 = \Sentinel::getRoleRepository()->createModel()->create([
        	'name' => 'Vendor',
        	'slug' => 'vendor'
        ]);
        $menus1 = \DB::table('menus')->insertGetId(['name'=>'Video', 'slug'=>'video']);
        $menus2 = \DB::table('menus')->insertGetId(['name'=>'Comment', 'slug'=>'comments']);
        $menus3 = \DB::table('menus')->insertGetId(['name'=>'Users', 'slug'=>'users']);
        $menus4 = \DB::table('menus')->insertGetId(['name'=>'Vendor', 'slug'=>'vendors']);

        $rm = \DB::table('role_menus')->insert(['menu_id'=>$menus1, 'role_id'=>$role1->id]);
        $rm = \DB::table('role_menus')->insert(['menu_id'=>$menus2, 'role_id'=>$role1->id]);
        $rm = \DB::table('role_menus')->insert(['menu_id'=>$menus3, 'role_id'=>$role1->id]);
        $rm = \DB::table('role_menus')->insert(['menu_id'=>$menus4, 'role_id'=>$role1->id]);

        $rm = \DB::table('role_menus')->insert(['menu_id'=>$menus1, 'role_id'=>$role2->id]);
        $rm = \DB::table('role_menus')->insert(['menu_id'=>$menus2, 'role_id'=>$role2->id]);
        $rm = \DB::table('role_menus')->insert(['menu_id'=>$menus3, 'role_id'=>$role2->id]);

        $users = \Sentinel::registerAndActivate($credentials);
        $users->first_name = "Administrator";
        $users->last_name = "Doku";
        $users->cobrand_id = 0;
        $users->save();
        $role1->users()->attach($users);
        $credentials = [
            'email' => 'admin@vendor.co.id',
            'password' => 'admin1234',
        ];
        $users = \Sentinel::registerAndActivate($credentials);
        $users->first_name = "Administrator";
        $users->last_name = "Vendor";
        $users->cobrand_id = 1;
        $users->save();
        $role2->users()->attach($users);


    }
}