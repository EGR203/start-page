<?php 

use App\OutputHelp\ViewHelper;
$editMode = isset($editMode)? $editMode : false;
$helper = new ViewHelper($content, $editMode);

?>

@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="col-md-2" >
            <p>Каталоги</p>
                {{ $helper->showSecondsFolders() }}
        </div>
        <div class="col-md-7 ">
                {{ $helper->showMainFolder() }}
        </div>
        <div class="col-md-3">
            <blockquote>
                {{ $blockquote->text }}
                <small>
                    {{ $blockquote->author }}
                </small>
            </blockquote>

        </div>
    {{ $helper->showModelContainer() }}
    </div>
        


@stop

