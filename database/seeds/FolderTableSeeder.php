<?php
namespace App;
use Illuminate\Database\Seeder;

class FolderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $folder = Folder::firstOrCreate([
            'name'=>'default',
        ]);
        
        
        $folder->user()->save( User::first() );
    }
}
