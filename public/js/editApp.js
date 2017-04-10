// open dropdown-submenu onclick
(function($){
	$(document).ready(function(){
        //АJAX авторизация
        $.ajaxSetup({    
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //открытие сабменю по шелчку 
		$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
			event.preventDefault(); 
			event.stopPropagation(); 
			$(this).parent().siblings().removeClass('open');
			$(this).parent().toggleClass('open');
		});
        
        //AJAX delete - Удаление папки и сайта
        $('button.remove_site, button.remove_folder').on('click',function(event){
            
            if( $(this).hasClass('remove_site') ){
               type = 'site';
            }
            else{
                type = 'folder';   
            }   
            
            event.preventDefault();
            event.stopPropagation();
            $this = $(this);
            
            if ( confirm('Элемент будет удален.') ){
                $.post('edit/remove',{
                    'type': type,
                    'id' : $(this).attr('data-id')
                },
               function(data, textStatus, request){
                    $this.parent().css('display','none');
                }
                ); 
            }
            return false;
        });
        
        
        //AJAX add -  добавление папки
        $('button.submit_create_folder').on('click',function(event){
            
            event.preventDefault();
            event.stopPropagation();
            
            var type = $(this).parent().children("input[name='type']").val();
            var parent_id = $(this).parent().children("input[name='id']").val();
            var name = $(this).parent().children("label").children("input[name='name']").val();
            
            
            alert('It`s gone : type - '+type+' parent_id - '+parent_id+' name - '+name);
            $.post('edit/create',{
                'parent_id': parent_id ,
                'type': type,
                'name': name
                }, function(data, textStatus, request){
                    location.reload();
                }
            );
            return false;
        });
        
        //AJAX add - добавление сайта
        $('button.submit_create_site').on('click',function(event){
            
            event.preventDefault();
            event.stopPropagation();
            
            var type = $(this).parent().children("input[name='type']").val();
            var parent_id = $(this).parent().children("input[name='id']").val();
            var name = $(this).parent().children("label").children("input[name='name']").val();
            var url = $(this).parent().children("label").children("input[name='url']").val();
            
            alert('It`s gone : type - '+type+' parent_id - '+parent_id+' name - '+name+' url - '+url);
            
            
            
            $.post('edit/create',{
                'parent_id': parent_id,
                'type': type,
                'name': name,
                'url' : url
                }, function(data, textStatus, request){
                    location.reload();
                }
            );
            return false;
        });
        
        
        //отключение перехода по ссылке у кнопки редакции
        $('.edit_site').on('click',function(event){
            event.stopPropagation();
            event.preventDefault();
        
            $($(this).attr('data-target')).modal('toggle');
            
            return false;
        });
        //AJAX update -  изменение папки
        $('button.submit_update_folder').on('click',function(event){
            
            event.preventDefault();
            event.stopPropagation();
            
            var type = $(this).parent().children("input[name='type']").val();
            var id = $(this).parent().children("input[name='id']").val();
            var name = $(this).parent().children("label").children("input[name='name']").val();
            
            
            alert('It`s gone : type - '+type+' id - '+id+' name - '+name);
            $.post('edit/update',{
                'id': id ,
                'type': type,
                'name': name
                }, function(data, textStatus, request){
                    location.reload();
                }
            );
            return false;
        });
        
        //AJAX update - изменение сайта
        $('button.submit_update_site').on('click',function(event){
            
            event.preventDefault();
            event.stopPropagation();
            
            var type = $(this).parent().children("input[name='type']").val();
            var id = $(this).parent().children("input[name='id']").val();
            var name = $(this).parent().children("label").children("input[name='name']").val();
            var url = $(this).parent().children("label").children("input[name='url']").val();
            
            alert('It`s gone : type - '+type+' id - '+id+' name - '+name+' url - '+url);
            
            
            
            $.post('edit/update',{
                'id': id,
                'type': type,
                'name': name,
                'url' : url
                }, function(data, textStatus, request){
                    location.reload();
                }
            );
            return false;
        });
        
        
//        подстановка URL`а без 'http://' в input[ name ]
        $("input[name='url']").on('keydown, blur',function(event){
            var url_input = $(this);
            var name_input = $(this).parent().parent().children("label").children("input[name='name']");

            if( /^https?:\/\/.*/.test(url_input.val()) ){
                //перенос строки из URL в NAME input, причем подстрока "http(s)://" (один или многораз повторяющаяся) удаляется  
                name_input.prop('value', ( /^(https?:\/\/)+(.*)/.exec(url_input.val()) )[2] ); 
            }
            else{
                name_input.prop('value', url_input.val());
            }
        });    
//            $("input[name='name']").on('focus',function(event){
//            url =  $(this).parent().parent().children("label").children("input[name='url']").val();
//            name_input =$(this);
//
//            if( /^https?:\/\/.*/.test(url) ){
//                name_input.prop('value', ( /^https?:\/\/(.*)/.exec(url) )[1] );
//            }
//            else{
//                name_input.prop('value', url);
//            }
//        });  
        
        
        autocomplite = function(event){
            
            var url_input = $(this);
            var correct_url = /^https?:\/\/.*/.test(url_input.val()) || /^localhost.*/.test(url_input.val()) ;
            
            //double_HTTP
            while(/^https?:\/\/https?:\/\/.*/.test(url_input.val())){  
                url_input.prop('value', (/^https?:\/\/(.*)/.exec(url_input.val()))[1] );
            }
            
            
            
            if(! correct_url ){
                url_input.prop('value', 'http://'+url_input.val());
            }
        };
        //автоподстановка `http://` в url и удаление такого случая : `http://http://`
        $("input[name='url']").on('keydown', function(event){
            if( $(this).val().length > 8  ){
                autocomplite.apply(this,event);
            }
        });
        $("input[name='url']").on('focus', autocomplite);
        $("input[name='url']").on('blur', autocomplite);

    });
})(jQuery);

