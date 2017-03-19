<?php
namespace App;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'admin', 
            'password'=> \Hash::make('adminadmin'), 
            'email' => 'admin@admin.com'
            ]);
        
    }
}
