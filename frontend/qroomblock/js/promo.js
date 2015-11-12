function deleteLogo(id){
	if(confirm('удалить фото ?')){
		  $.get( "/cabinet/dellogo", { id:id } )
		  .done(function( data ) {
		    $('.imglist__item').fadeOut();
		    console.log(data);
		  });
	}	
}
//--------------------------------------------------------------------

function delImage(name,index,id){
	if(confirm('удалить фото ?')){
		  $.get( "/cabinet/delphoto", { name:name,id:id } )
		  .done(function( data ) {
		    $('#photo'+index).fadeOut();
		    console.log(data);
		  });
	}	
}
//--------------------------------------------------------------------
$('#createPromo').click(function(){
	
	var promo = $('#promo').val();
	var userId = $('input[name=userId]').val();
	var userType = $('input[name=userType]').val();
	
	if(promo!=''){
		if(confirm('Подтвердите создание промокода "'+promo+'"')){
			
			$.get( "/cabinet/setpromo", { promo: promo, userId: userId,userType:userType } )
		  .done(function( data ) {
		    
		    if(data==1){
			    alert('Такой промокод уже существует. Выберите другой');
		    }
		    else{
			    
			    $('#promoSpan').html(promo);
		    }
		    console.log(data);
		    //alert( "Data Loaded: " + data );
			});
	
		}
	}
	
});
//--------------------------------------------------------------------
$('.confirmOrder').click(function(){
	if(confirm('Вы подтверждаете заявку ?')){
		console.log($(this).attr('data-id'));
		$('#td'+$(this).attr('data-id')).html('принят');
		$('#act'+$(this).attr('data-id')).fadeOut();
	}
});
//--------------------------------------------------------------------

//--------------------------------------------------------------------

$('.cancelOrder').click(function(){
	var cancel = prompt('Заполните причину отмены?', 'сделка отменилась');
	if(cancel){
		$('#tr'+$(this).attr('data-id')).fadeOut();
		console.log($(this).attr('data-id'));
		
	}
});