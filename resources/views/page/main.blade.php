<?php
/**
 * Отображает основную страницу
 *
 * @param array $content   массив, содержащий сайты и каталоги, генерируется в class App\Folder::getContent()
 * @param bool  $editMode  булево значение, отвечает за отображние кнопок удаления/создания/update
 * @param array $blockquote  массив ['text' = > string , 'author' => string] с цитатой
 */

$editMode = isset($editMode)? $editMode : false;
$keyArray=['folder' => 'каталог' ,'site' => 'сайт'];
/**
 * Необходима для создания index`а model`и на основе типа элемента и его id
 * @param  string $type folder или site
 * @param  int    $id   id элемента
 * @return int    возвращает уникальный индетификатор
 */
function generateIndex($type, $id){
    return $id . ord( $type[0] ) . ord( $type[1] );
}
?>
@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="col-md-2" >
            <p>Каталоги</p>
            <ul id='{{ $content['info']['id'] }}' class='folder nav second_folders'>
                @foreach($content['folders'] as $folder)
                    <li class='dropdown'>
                        @include('page.components.folder', [ 'folder' => $folder] )
                    </li>
                @endforeach
                @include('page.components.buttons.create', ['type' => 'folder', 'id' => $content['info']['id'] ] )
            </ul>
        </div>
        <div class="col-md-7 ">
            <ul id='{{ $content['info']['id'] }}'class='container-fluid folder main_folder'>
                @include('page.components.sites', [ 'sitesArray' => $content['sites'], 'folder_id' => $content['info']['id']]) 
            </ul>
        </div>
        <div class="col-md-3">
            <blockquote>
                {{ $blockquote->text }}
                <small>
                    {{ $blockquote->author }}
                </small>
            </blockquote>

        </div>
    @stack('models')
    </div>

@stop