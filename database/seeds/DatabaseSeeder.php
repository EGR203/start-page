<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('folders')->truncate();
        DB::table('sites')->truncate();
        DB::table('folder_site')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->call( 'App\UserTableSeeder' );
        $this->call( 'App\FolderTableSeeder');
        $this->call( 'App\SiteTableSeeder' );
    }
}
