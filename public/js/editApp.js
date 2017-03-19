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
        
        //Удаление папки и сайта
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
        
        
        // добавление папки
        $('button.submit_create_folder').on('click',function(event){
            
            event.preventDefault();
            event.stopPropagation();
            
            type = $(this).parent().children("input[name='type']").val();
            parent_id = $(this).parent().children("input[name='parent_id']").val();
            name = $(this).parent().children("label").children("input[name='name']").val();
            
            
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
        
        //добавление сайта
        $('button.submit_create_site').on('click',function(event){
            
            event.preventDefault();
            event.stopPropagation();
            
            type = $(this).parent().children("input[name='type']").val();
            parent_id = $(this).parent().children("input[name='parent_id']").val();
            name = $(this).parent().children("label").children("input[name='name']").val();
            url = $(this).parent().children("label").children("input[name='url']").val();
            
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
        // изменение папки
        $('button.submit_edit_folder').on('click',function(event){
            
            event.preventDefault();
            event.stopPropagation();
            
            type = $(this).parent().children("input[name='type']").val();
            id = $(this).parent().children("input[name='id']").val();
            name = $(this).parent().children("label").children("input[name='name']").val();
            
            
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
        
        //изменение сайта
        $('button.submit_edit_site').on('click',function(event){
            
            event.preventDefault();
            event.stopPropagation();
            
            type = $(this).parent().children("input[name='type']").val();
            id = $(this).parent().children("input[name='id']").val();
            name = $(this).parent().children("label").children("input[name='name']").val();
            url = $(this).parent().children("label").children("input[name='url']").val();
            
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
        
        
        //подстановка URL`а без 'http://' в input[ name ]
        $("input[name='url']").on('blur',function(event){
            url = $(this).val();
            name_input = $(this).parent().parent().children("label").children("input[name='name']");

            if( /^https?:\/\/.*/.test(url) ){
                name_input.prop('value', ( /^https?:\/\/(.*)/.exec(url) )[1] );
            }
            else{
                name_input.prop('value', url);
            }
        });    
        
        //автоподстановка `http://` в url и удаление такого случая : `http://http://`
        $("input[name='url']").on('change, focus',function(event){
            
            url = $(this).val();
            correct_url = /^https?:\/\/.*/.test(url) || /^localhost.*/.test(url) ;
            double_http = /^https?:\/\/https?:\/\/.*/.test(url);
            if(! correct_url ){
                $(this).prop('value', 'http://'+url);
            }
            else if(double_http){
                $(this).prop('value', (/^https?:\/\/(.*)/.exec(url))[1] );
            }
            
            
        });

    });
})(jQuery);
