<?php
/**
 * Удаляет элемент, если глобальный параметр $editMode = true
 * 
 * @param string $type folder или site - тип удаляемого элемента
 * @param int    $id    id удаляемого элемента
 */
?>

@if($editMode)
    <button title="Удалить {{ $keyArray[$type] }}" class="button-control remove_{{ $type }}" type='button' data-id='{{ $id }}'>×</button>
@endif