<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Site
 *
 * @property-read \Franzose\ClosureTable\Extensions\Collection|\App\Folder[] $folders
 * @mixin \Eloquent
 */
class Site extends Model
{
    protected $fillable = ['url','name'];
    protected $hidden = ['created_at','updated_at','pivot'];
    public static $defaultSites = [
        ['url' => 'http://vk.com', 'name' => 'Вконтакте'],
        ['url' => 'http://youtube.com', 'name' => 'Youtube'],
        ['url' => 'http://pikabu.ru', 'name' => 'Пикабу'],
        ['url' => 'http://translate.google.ru', 'name' => 'TRANSLATE'],
        ['url' => 'http://habrahabr.ru', 'name' => 'Habrababr'],
        ['url' => 'http://farpost.ru', 'name' => 'Farpost']
        ];


    public static function getDefaultCollection(){
        $collection = [];
        foreach (static::$defaultSites as $site){
            $collection[] =new Site(['url' => $site['url'], 'name' => $site['name'] ]);
        }
        return $collection;
    }

    public function folders(){
        return $this->belongsToMany('App\Folder');
    }
    
}
