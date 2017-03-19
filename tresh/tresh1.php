<!--
<div class="container-fluid">
    <div class="col-md-2" >
        <p>Каталоги</p>
        <ul id="{{ $sitesList['info']['id'] }}" class="folder nav">
            @if( $dataIsSet )
                @foreach($sitesList['folders'] as $folder)
                <li class="dropdown"  >
                        {{ showFolder($folder, $editMode) }} 
                    </li>
                @endforeach
                @endif
            {{ addEditButton(_folder, $editMode) }}

        </ul>
    </div>
    <div class="col-md-7 ">

    </div>
    <div class="col-md-2">Левая часть </div>
</div>
-->



<?php


$dataIsSet = isset($sitesList);
$editMode = isset($editMode)? $editMode : false;
$index = 12312312;
define('_folder' , 0);
define('_site', 1);





function showSite($site, bool $isMainFolder = false, bool $offset = false){
    if($isMainFolder==false){
        $offset=FALSE;
    }
    ?>
        <a href='{{ $site['url'] }}' target="_blank">
        <li class="
                    <?php 
                    if( $isMainFolder){
                        echo'col-md-5 thumbnail';
                    }else{
                        echo 'menu-item btn btn-default btn-block '; 
                    }
                    if($offset){
                        echo ' col-md-offset-2';
                    }
                    ?> ">
            
                @if( preg_match('/^http/', $site['url']) )
                {{preg_split('/https*:\/\//', $site['url'])[1]}} 
                @else 
                {{ $site['url'] }}
                @endif
                <br>
                <img src="http://mini.s-shot.ru/1024x100/JPEG/300/Z100/?{{ urlencode($site['url']) }}">
        </li>
        </a>
    <?php
}


function showSites(array $sitesArray, bool $editMode, bool $isMainFolder = false){
  
    //-------------------------Sites display------------------------------
    foreach ($sitesArray as $siteIndex=>$site){
        showSite($site, $isMainFolder, $siteIndex % 2 != 0 );
    }
    
    addEditButton(_site, $editMode); 

    //-------------------------------------------------------------------

}


function showFolder($folder,bool $editMode){
    ?>
        <p class='folder_name btn btn-block dropdown-toggle  ' data-toggle="dropdown" >
                {{ $folder['info']['name'] }}
                <span class="glyphicon glyphicon-triangle-right"></span>
        </p>
        <ul id="{{$folder['info']['id']}}" class="folder dropdown-menu">
            
    <?php
    
    if(isset($folder['sites'])){
        showSites($folder['sites'], $editMode, false);
    }
    
    if(isset($folder['folders'])){
        
        foreach ($folder['folders'] as $childFolder){
            ?>
            <li class="menu-item dropdown dropdown-submenu" >
            <?php    
            
            showFolder($childFolder,$editMode);
            
            ?>
            </li>
            <?php
        }
    }
    addEditButton(_folder, $editMode); 
    ?>      


        </ul>
    <?php
}

function addEditButton(int $editWhat,bool $editMode){
    global $index;
    
    $keyArray=[['ru'=>'каталог', 'en'=>'folder'],['ru'=>'сайт', 'en'=>'site']];
    if($editMode){
        ?>
            <button type="button" class=" btn btn-block btn-success"
                    data-toggle="modal" data-target="#modal_{{$index}}" >
                <span class="glyphicon glyphicon-plus"></span> Добавить {{$keyArray[$editWhat]['ru']}}
            </button>
        
            <div id="modal_{{$index++}}" class="modal" tabindex="-1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content thumbnail ">
                        <form action="{{route('edit.update')}}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="type" value="{{$keyArray[$editWhat]['en']}}">
                            
<!-- //////////////////////////  Додумать parent_id-->
                            
                            <input type="hidden" name="parent_id" value="">
                            <label >Введите название {{$keyArray[$editWhat]['ru']}}а :
                                <input type="text" name="content" class="input-lg">
                            </label>
                            <button type="submit" class="add_{{$keyArray[$editWhat]['en']}} btn btn-default">
                                Создать
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </form>
                    </div>
                </div>
            </div>
        <?php
    }
}


?>
