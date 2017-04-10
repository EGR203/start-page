<?php
/**
 * Отображает единичный каталог и рекурсивно вложенные в него
 * 
 * @param array $folder 'folder' из массива App\Folder::getContent()
 */
?>
        
@include('page.components.buttons.remove', ['type' => 'folder', 'id' => $folder['info']['id'] ])
@include('page.components.buttons.update', ['type' => 'folder', 'id' => $folder['info']['id'], 'name'=>$folder['info']['name']])

<p class='folder_name btn btn-block dropdown-toggle  ' data-toggle='dropdown' data-id='folder_{{ $folder['info']['id'] }}' >
{{ $folder['info']['name'] }}
</p>
<ul id='{{ $folder['info']['id'] }}' class='folder dropdown-menu'>


@if( isset($folder['sites']) )
   @include('page.components.sites', ['sitesArray' => $folder['sites'],'folder_id' => $folder['info']['id'] ])
@endif

@if( isset($folder['folders']) )
    @foreach ($folder['folders'] as $childFolder)
        <li class='menu-item dropdown dropdown-submenu' >
            @include('page.components.folder', ['folder' => $childFolder])
        </li>
    @endforeach
@endif


@include('page.components.buttons.create', ['type' => 'folder', 'id' => $folder['info']['id'] ] )        

</ul>
        
    