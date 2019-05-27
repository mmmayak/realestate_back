<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'company'=>'adminCompany',
            'phone'=>'999999999',
            'isAdmin'=>true,
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'name' => 'Simple user',
            'email' => 'user@user.com',
            'company'=>'adminCompany',
            'phone'=>'1111111111',
            'isAdmin'=>false,
            'password' => bcrypt('secret'),
        ]);
    }
}
