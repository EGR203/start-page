<?php
namespace App;
use Franzose\ClosureTable\Models\Entity;

/**
 * App\Folder
 *
 * @property int $parent_id
 * @property int $position
 * @property-read int $real_depth
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Site[] $sites
 * @mixin \Eloquent
 */
class Folder extends Entity implements FolderInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'folders';
    protected $hidden = ["parent_id","position","real_depth","deleted_at"];

    protected $fillable = ['name'];
    /**
     * ClosureTable model instance.
     *
     * @var FolderClosure
     */
    protected $closure = 'App\FolderClosure';
    
    public function sites(){
        return $this->belongsToMany('App\Site');
    }
    public function isMain(){
        if($this->parent_id == null){
            return true;
        }
        return false;
    }

    public function user(){

        return $this->hasOne('App\User');

    }

    
    public function getContent(){
        $content=[];
        $content['info']=['id'=> $this->id, 'name' => $this->name];
        $content['sites']=[];
        $content['folders']=[];
        
        $sites = $this->sites()->orderBy('updated_at','desc')->get();
        
        foreach ($sites as $site){
            $content['sites'][]=$site->toArray();
        }
        if($this->hasChildren()){
            foreach ($this->getChildren() as $child){
                $content['folders'][] = $child->getContent();
            }
        }
        
        return $content;
    }
    
    public function scopeGetMains($query){
        return $query->where('main', '=', 1);
    }
}
