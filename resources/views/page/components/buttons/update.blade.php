<?php
/**
 * Обновляет элемент,  если глобальный параметр $editMode = true
 * 
 * @param string $type folder или site - тип обновляемого элемента
 * @param int    $id   id элемента 
 * @param string $name имя элемента
 *                         
 * @param string $url = null Параметр используется только для $type == site, содержащий URL сайта
 */
?>
      

@if($editMode)
       <?php 
    $url = isset($url) ? $url : null ; 
    $index = generateIndex($type, $id);
    ?>
   
    <button type='button' data-toggle='modal' data-target='#modal_{{ $index }}' title='Редактировать {{ $keyArray[$type] }}' class='button-control edit_{{ $type }}' type='button'>
        <span class='glyphicon glyphicon-pencil'></span>
    </button>
    

    
    @push('models')
        @include('page.components.model' , ['index' => $index,  'type' => $type, 'id' => $id, 'action'=> 'update', 'name'=>$name, 'url'=> $url] )
    @endpush
    
@endif