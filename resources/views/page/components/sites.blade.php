<?php 
/**
 * Отображает коллекцию сайтов
 * 
 * @param array $sitesArray     часть массива App\Folder::getContent() ['sites']
 * @param int   $folder_id  id folder`а, содержайщий $sitesArray
 */
    $isMainFolder = false; 
    if($folder_id == $content['info']['id']){
        $isMainFolder = true;
    }
?>
@foreach($sitesArray as $site)

    <a href='{{$site['url'] }}' class="" title='{{ $site['url'] }}' >
            <li class="btn btn-default item_site {{ 
                        ($isMainFolder)? 'col-md-4 thumbnail col-md-offset-1' : 'menu-item btn btn-default btn-block'
                        }}" style="background: url(http://mini.s-shot.ru/1024x200/JPEG/450/Z100/?{{ urlencode($site['url']) }}) no-repeat;
                            background-origin: padding-box;
                            background-size: 100% auto;">


                @include('page.components.buttons.remove', ['type' => 'site', 'id' => $site['id'] ] )
                @include('page.components.buttons.update', ['type' => 'site', 'id' => $site['id'] , 'name' => $site['name'] , 'url' => $site['url'] ] )
                <span class="site_name" >
                    {{ $site['name'] }}
                </span>
            </li>
        </a>
    @if( ! $isMainFolder)
        {{-- Для разделения сайтов в списке  --}}
        <li role='separator' class='divider'></li>
    @endif
@endforeach
    
@include('page.components.buttons.create', ['type' => 'site', 'id' => $folder_id] )
