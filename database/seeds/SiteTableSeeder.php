<?php
namespace App;
use Illuminate\Database\Seeder;

class SiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        

        $folder = Folder::first();
        $folder->sites()->saveMany( Site::getDefaultCollection() ); 
        
    }
}
