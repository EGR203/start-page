<?php
/**
 * Отображает model - окошко с формой
 * 
 * @param string $type folder или site - тип обновляемого элемента
 * @param int   $id  id  folder`а, содержайщий $sitesArray
 */
?>
  
<div id="modal_{{ $index }}" class="modal" tabindex="-1" >
    <div class="modal-dialog" role="document">
        <div class="modal-content thumbnail ">
            <form action='{{ route("edit.$action") }}' method="post">
                {{ csrf_field() }}
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="id" value="{{ $id }}">
                @if( $type == 'site')
                    <label> URL сайта :
                        <input type="url" name="url" class="input-lg" autocomplete="off"

                            @if( $action == 'update')
                                value="{{ $url }} "
                            @endif

                               >
                    </label>
                @endif
                <label >{{ $type }} name :
                    <input type="text" name="name" class="input-lg" autocomplete="off"
                        @if( $action == 'update')
                             value="{{ $name }} "
                        @endif

                           >
                </label>
                <button type="submit" class="submit_{{ $action }}_{{ $type }} btn btn-default">
                    {{ $action }}
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </form>
        </div>
    </div>
</div>

