var currRating=0;
$('.inner').click(
	function(){
		currRating = $('#hint').val();
		//alert($('#hint').val());
	}
)
function doRate(){
	var roomId = $('#roomId').val();
	var message = $('#form-rating-message').val();
	var userEmail = $('#userEmail').val();
	var rating = currRating;
	
	console.log(roomId,message,userEmail,rating);
	
	
	$.get( "/dorate", { userEmail: userEmail,roomId:roomId,message:message,rating:rating } )
		  .done(function( data ) {
		    
		  	if(data == 1){
			  	$('#myrate').hide();
			  	$('.rating-form').html('Благодарим за отзыв о квесте');
		  	}
		    console.log(data);
		    //alert( "Data Loaded: " + data );
	});	
	
}

$('#myModal').on('hide.bs.modal', function (e) {
   
   if($('#end').val() == 1) location.href = location.href;

})

var orderDate = '';
var orderTime = '';


function generateOrder(id){
	var order = $('#'+id).data('cost');
	orderDate = $('#'+id).data('day');
	orderTime = $('#'+id).data('time');
	
	$("#orderHeader").html(order);
	$("#orderValue").val(order);
}


$('.confirmit').click(function(){
	
	var userPhone = $('#phone').val();
	var userEmail = $('#email').val();
	var roomId = $('#roomId').val();
	var dateTime = $('#orderValue').val();
	var roomUrl = $('#roomUrl').val();
	var errors = new Array();
	
	console.log(orderDate,orderTime,roomId);
	$('.formErr').html('');
	if(userPhone==''){
		errors[0] = 'Не заполнено поле Телефон';
	}
	else{
		errors[0] = '';
	}
	if(userEmail==''){
		errors[1] = 'Не заполнено поле E-mail';
	}
	else{
		errors[1] = '';
	}
	
	
	
	if(errors.length>0){
		for(var i=0;i<2;i++){
			if(errors[i] && errors[i]!=''){
				$('.formErr').append(errors[i]+'<br>');
			}
		}
	}
	
	
	if(userPhone!=='' && userEmail!==''){
	
		$.get( "/order", { orderDate:orderDate, orderTime:orderTime,userPhone: userPhone, userEmail: userEmail,roomId:roomId,dateTime:dateTime,roomUrl:roomUrl } )
		  .done(function( data ) {
		    
		    //location.href = '#modalAccept';
		    $('.modal-body').html('Ваша заявка принята. Менеджер квеструма свяжется с Вами в течение 5ти минут<input type="hidden" id="end" value = "1" />');
		    $('.modal-footer').html('<button type="button" onclick="location.href=location.href" class="btn btn-primary" data-dismiss="modal">Закрыть</button>')
		    console.log(data);
		    //alert( "Data Loaded: " + data );
		});
		
		//console.log(userPhone,userEmail, roomId, dateTime,roomUrl);
	
	}
	else{
		
	}
});