<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Folder;
use App\Site;
use App\Blockquote;

class FolderController extends Controller
{
    
    public function remove(Request $request){
        $user = \Auth::getUser();
        $json = $request->all();


        if(!isset($json['type']) || ! isset($json['id'])){
            return \Response::json('data no set', 403);
        }

        if($json['type']=='site'){
            $object = Site::find($json['id']);
            if($object == null){
                return \Response::json($json['type'].' not found', 403);
            }
            $res =$object->delete();
            
        }
        
        if($json['type']=='folder'){
            $object = Folder::find($json['id']);
            
            if($object == null){
                return \Response::json($json['type'].' not found', 403);
            }
             $res = $object->deleteSubtree(true);
        }
        
        
       
        return \Response::json($res, 200);
        
    }
    
    public function create(Request $request){
        
        $user = \Auth::getUser();
        $json = $request->all();
        
        $type = isset($json['type']) ? $json['type'] : \Response::json('type not set', 403);
        $parentId = isset($json['parent_id']) ? $json['parent_id'] : \Response::json('parent_id not set', 403);
        $name = isset($json['name']) ? $json['name'] : \Response::json('name not set', 403);
        
        $parentFolder = Folder::where('id','=', $parentId )->first();
        
        if($type == 'site'){
            $url = isset($json['url']) ? $json['url'] : \Response::json('url not set', 403);

            $siteValidator = \Validator::make($json,['url' => 'url', 'name' => 'required']);
            if($siteValidator->passes()){
                $res = $parentFolder->sites()->save( Site::create(['url'=> $url,'name' => $name]) );
                return \Response::json($res, 200);

            }
            else {
                return \Response::json($siteValidator->errors()->all(), 403);
            }
            
        }elseif($type =='folder'){
            
            
            $folderValidator = \Validator::make($json,['name' => 'required']);
            if($folderValidator->passes()){
                $res = $parentFolder->addChild( Folder::create(['name'=> $name]) );
                return \Response::json($res, 200);
            }
            else {
                return \Response::json($folderValidator->errors()->all(), 403);
            }
        }
        
        return \Response::json(['Has not catalog or site'], 403);
        
        
    }
    
    public function update(Request $request){
        
        $user = \Auth::getUser();
        $json = $request->all();
        
        $type = isset($json['type']) ? $json['type'] : \Response::json('type not set', 403);
        $id = isset($json['id']) ? $json['id'] : \Response::json('id not set', 403);
        $name = isset($json['name']) ? $json['name'] : \Response::json('name not set', 403);
        
        
        if($type == 'site'){
            
            $item = Site::find($id);
            if($item ==null ){
                return \Response::json('Item not found', 403 );
            }
            
            
            $url = isset($json['url']) ? $json['url'] : \Response::json('url not set', 403);

            $siteValidator = \Validator::make($json,['url' => 'url', 'name' => 'required']);
            if($siteValidator->passes()){
                $item->url = $url;
                $item->name = $name;
                $res = $item->save();
                return ($res)? \Response::json($res,200) : \Response::json('Не могу сохранить в бд',403);

            }
            else {
                return \Response::json($siteValidator->errors()->all(), 403);
            }
            
        }elseif($type =='folder'){
            $item = Folder::find($id);
            if($item ==null ){
                return \Response::json('Item not found', 403 );
            }
            
            $folderValidator = \Validator::make($json,['name' => 'required']);
            if($folderValidator->passes()){
                $item->name = $name;
                $res = $item->save();
                return ($res)? \Response::json($res,200) : \Response::json('Не могу сохранить в бд',403);
            }
            else {
                return \Response::json($folderValidator->errors()->all(), 403);
            }
        }
        
        return \Response::json(['Has not catalog or site'], 403);
        
        
    }

    public function edit(){
        $folder = \Auth::getUser()->folder;
        if($folder == null){
            abort(404);
        }
        $sitesList = $folder->getContent();
        
        
        $blockquote = Blockquote::getRandom();
        return view('page.main')->with(['sitesList' => $sitesList, 'editMode' => true, 'blockquote' => $blockquote ]);
    }
    
    public function index(){
        $folder = ( \Auth::guest() )? Folder::first() : \Auth::getUser()->folder;
        if($folder == null){
            $folder = Folder::create(['name' => 'default']);
            $folder->sites()->saveMany( Site::getDefaultCollection() );
        }
        $sitesList = $folder->getContent();
        

        $blockquote = Blockquote::getRandom();
        return view('page.main')->with(['sitesList'=> $sitesList, 'blockquote' => $blockquote ]);
    }
    
    
}
