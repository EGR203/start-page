<?php
/**
 * Создает на месте вызова кнопку создания элемента, если глобальный параметр $editMode = true
 * 
 * @param string $type folder или site - тип созаваемого элемента
 * @param int    $id    id папки, в который будет создан элемент
 */
?>
@if($editMode)
    <?php
    $index = generateIndex($type, $id);
    ?>
    <button type="button" class=" btn btn-block btn-success" data-toggle="modal" data-target="#modal_{{ $index }}" >
        <span class="glyphicon glyphicon-plus"></span>
        Добавить {{ $keyArray[$type] }}
    </button>

    @push('models')
        @include('page.components.model' , ['index' => $index , 'type' => $type, 'id' => $id, 'action'=> 'create'] )
    @endpush
    
@endif