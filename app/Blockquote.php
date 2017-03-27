<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blockquote extends Model
{
    
    
    protected $fillable = ['text', 'author'];
    
    
    static function getRandom(){
        $maxId = self::max('id') ;
        $item = null;
        while ( ! $item ){
            $item = self::find(rand(1, $maxId));
        }
        return $item;
    }
}
