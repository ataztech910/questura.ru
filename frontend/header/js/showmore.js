$("#showmore").click(function(){
	
	var loaded = $("#loaded").val();
	var cityId = $("#cityId").val();
	
	$(".loaderDiv").append("<img src='/frontend/header/images/365.GIF' id='loadme'/>");
	
	$.get( "/loadmore", { loaded: loaded, cityId: cityId })
		  .done(function( data ) {
		   //$('#loaded').val();
		   var result = JSON.parse(data);
		   $(".loaderDiv").append(result['html']);
		   loaded = loaded+','+result['ids'];
		   if($("#loaded").val(loaded)){
			   $("#loadme").remove();
		   }
		   
		   
		   if(result['roomsCount']<=18){
			   $("#showmoreButton").hide();
		   }
		   console.log(result);
		    //alert( "Data Loaded: " + data );
	});
	//console.log('click');
});