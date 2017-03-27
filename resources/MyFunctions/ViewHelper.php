<?php

namespace App\MyFunctions;

class ViewHelper{
    
    protected $content;
    protected $dataIsSet = false;
    protected $editMode;
    protected $index = 0;
    protected $buttons = [];
    protected $keyArray=[['ru'=>'каталог', 'en'=>'folder'],['ru'=>'сайт', 'en'=>'site']];
    const _folder = 0;
    const _site = 1;
            
    function __construct(array $sitesList,bool $editMode ) {
        $this->content = $sitesList;
        $this->editMode = $editMode;
        if( ! is_null($this->content) ){
            $this->dataIsSet = true;
        }
    }
    
    public function showSite($site, bool $isMainFolder = false, bool $offset = false){
        if($isMainFolder==false){
            $offset=FALSE;
        }
        $site['name'] = ($site['name'] == null)? $site['url'] : $site['name'];
        ?>
        <a href='<?php echo $site['url']; ?>' class="" title='<?php echo $site['url'];?>' >
                
                <li class="btn btn-default item_site
                            <?php 
                            if( $isMainFolder){
//                                echo'col-md-5 thumbnail';
                                echo'col-md-4 thumbnail col-md-offset-1 ';
                            }else{
                                echo 'menu-item btn btn-default btn-block '; 
                            }
//                            if($offset){
//                                echo ' col-md-offset-2';
//                            }
                            ?> " style="background: url(http://mini.s-shot.ru/1024x200/JPEG/450/Z100/?<?php echo urlencode($site['url']); ?>) no-repeat;
                                background-origin: padding-box;
                                background-size: 100% auto;">
<!--                    <img src="http://mini.s-shot.ru/1024x500/JPEG/300/Z100/?<?php echo urlencode($site['url']); ?>">-->
                    
                    <?php 
                    $this->addRemoveButton(self::_site, $site['id']);
                    $this->addEditButton(self::_site,$site['id'],$site['name'],$site['url']);
                    ?>
                    
                    <span class="site_name" >
                        <?php
                        echo $site['name'];
                        ?>
                    </span>
                </li>
            </a>
            
        <?php
        if( ! $isMainFolder){
            echo "<li role='separator' class='divider'></li>";
        }
    }
    
    public function showSites(array $sitesArray,int $folder_id){

        $isMainFolder = false; 
        
        if($folder_id == $this->content['info']['id']){
            $isMainFolder = true;
        }
        
        //-------------------------Sites display------------------------------
        foreach ($sitesArray as $siteIndex=>$site){
            $this->showSite($site, $isMainFolder, $siteIndex % 2 != 0 );
        }

        $this->addCreateButton(self::_site, $folder_id); 

        //-------------------------------------------------------------------

    }
    public function showFolder(array $folder){
            
        $this->addRemoveButton(self::_folder, $folder['info']['id']);
        $this->addEditButton(self::_folder,$folder['info']['id'],$folder['info']['name']);

        echo "<p class='folder_name btn btn-block dropdown-toggle  ' data-toggle='dropdown' data-id='folder_"
        .$folder['info']['id']."' >".$folder['info']['name'];
        
        echo "</p>"
            ."<ul id='".$folder['info']['id']."' class='folder dropdown-menu'>";


        if(isset($folder['sites'])){
            $this->showSites($folder['sites'], $folder['info']['id']);
        }

        if(isset($folder['folders'])){

            foreach ($folder['folders'] as $childFolder){
                
                echo "<li class='menu-item dropdown dropdown-submenu' >";
                $this->showFolder($childFolder);
                echo "</li>";
                
            }
        }
        $this->addCreateButton(self::_folder, $folder['info']['id']); 
              
        echo "</ul>";
        
    }
    
    public function showSecondsFolders(){
        
        echo "<ul id='".$this->content['info']['id']."' class='folder nav second_folders'>";
        if( $this->dataIsSet ){
            foreach($this->content['folders'] as $folder){
                echo "<li class='dropdown'>";
                $this->showFolder($folder); 
                echo '</li>';
            }
        }
        $this->addCreateButton(self::_folder, $this->content['info']['id']); 
        echo '</ul>';
    }
    
    
    protected function addCreateButton(int $type, int $parent_id){
        if($this->editMode){
            ?>
                <button type="button" class=" btn btn-block btn-success"
                        data-toggle="modal" data-target="#modal_<?php echo $this->index; ?>" >
                    <span class="glyphicon glyphicon-plus"></span>
                    Добавить <?php echo $this->keyArray[$type]['ru']; ?>
                </button>
            <?php
            
            $data = ['type'=> $type, 'parent_id' => $parent_id, 'action' => 'create']; 
            $this->regCreateButton($this->index++, $data);
        }
    }
    
    protected function addRemoveButton(int $type,int $id){
        if($this->editMode){
            echo "<button title='Удалить ". $this->keyArray[$type]['ru']."' class='button-control remove_"
                    . $this->keyArray[$type]['en']."' type='button' data-id='"
                    .$id."'>×</button>";

        }
        
    }
    protected function addEditButton(int $type, int $id, string $name, $url = null){
        if($this->editMode){
            echo "<button type='button' data-toggle='modal' data-target='#modal_".$this->index."' "
                    . " title='Редактировать ". $this->keyArray[$type]['ru']
                    ."' class='button-control edit_". $this->keyArray[$type]['en']
                    ."' type='button' ><span class='glyphicon glyphicon-pencil'></span></button>";
            
            $data = ['type' => $type, 'id' => $id, 'action'=> 'edit', 'name'=>$name, 'url'=> $url];
            $this->regCreateButton($this->index++ , $data);
        }
    }

    protected function regCreateButton(int $index, $data){
        $this->buttons[] = ['index' => $index, 'data' =>$data] ;
    }
    
    public function showModelContainer(){
        
        foreach ($this->buttons as $button){
             $typeContent = $button['data']['type'];
             $id = ($button['data']['action']=='create') ? $button['data']['parent_id'] : $button['data']['id'];
             $action = $button['data']['action'] ;
        ?>
            <div id="modal_<?php echo $button['index'];?>" class="modal" tabindex="-1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content thumbnail ">
                        <form action="<?php echo ($action=='create')? route('edit.create') : route('edit.update');?>" method="post">
                            <?php  echo csrf_field(); ?>
                            <input type="hidden" name="type" value="<?php echo $this->keyArray[$typeContent]['en'];?>">

<!-- //////////////////////////  Додумать parent_id-->

                            <input type="hidden" name="<?php if($action=='create'){echo 'parent_';} ?>id" value="<?php echo $id;?>">

                            <?php 
                            if($typeContent == self::_site){
                            ?>
                            <label >URL сайта :
                                <input type="url" name="url" class="input-lg" autocomplete="off"
                                    <?php
                                    if($action == 'edit'){
                                        echo "value='".$button['data']['url']."'";
                                    }
                                    ?>
                                       
                                       >
                            </label>
                            <label> Имя сайта: 
                                <input type="text" name='name' class='input-lg' autocomplete="off"
                                    <?php
                                    if($action == 'edit'){
                                        echo "value='".$button['data']['name']."'";
                                    }
                                    ?>
                                       >
                            </label>
                            
                            <?php
                            }else{ ?>       
                            
                            <label >Название каталога :
                                <input type="text" name="name" class="input-lg"
                                    <?php
                                    if($action == 'edit'){
                                        echo "value='".$button['data']['name']."'";
                                    }
                                    ?>
                                       
                                       >
                            </label>
                            
                            <?php } ?> 
                            <button type="submit" class="<?php echo "submit_".$action."_".$this->keyArray[$typeContent]['en'];?> btn btn-default">
                                <?php
                                if($action =='edit'){
                                    echo 'Изменить';
                                }else{
                                    echo 'Создать';
                                }
                                ?>
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </form>
                    </div>
                </div>
            </div>
        <?php
        }
    }
    
    public function showMainFolder(){
        echo "<ul id='".$this->content['info']['id']." 'class='container-fluid folder main_folder'>";
            if($this->dataIsSet ){
                $this->showSites($this->content['sites'], $this->content['info']['id']);
            }
        echo "</ul>";
        
    }
}
