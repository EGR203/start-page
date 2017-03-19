<?php 
use App\MyFunctions\ViewHelper;
$editMode = isset($editMode)? $editMode : false;
$helper = new ViewHelper($sitesList, $editMode);

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
        <div class="col-md-2">Левая часть </div>
    {{ $helper->showModelContainer() }}
    </div>
        


@stop
