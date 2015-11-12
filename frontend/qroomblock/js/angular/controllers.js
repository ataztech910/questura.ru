function akcioCtr($scope, $http){
	$scope.loading = true;
    $http.get(portalAdminRoot+'akciojson').success(function(data) {
      console.log(data);
        
      $scope.currentPage = 1; //current page
      $scope.pageSize = 10;
	  $scope.rooms = data;
      
	  $scope.pageChangeHandler = function(num) {
     	 console.log('meals page changed to ' + num);
	  };
	 $scope.loading = false;
	 
	 $scope.acceptRoom = function (id,costumer,index){
		 
		 var cancel = confirm('Квест пройден ?');
		 if(cancel){
				//$scope.rooms.splice(index,1);
				$('#act'+id).hide();
				$http.post(portalAdminRoot+'acceptRoom', {'id':id, 'costumer': costumer}).success(function(data) {
				 
				     console.log(data);
				 
				});
				
     }
		 
	 }
	 
	 
});
}
//-------------------------------------------------------------

function DayCost($scope, $http){
	
	 var counter = 0;
	 var result = [];
	 
	 
	 
	//console.log(fields); 
	result[0] = [];
	$.each(fields, function(index, field) {
		 	result[index] = Array();
		 		
		 	$.each(field, function(index2, field2) {
			 		result[index][index2] = field2;
			 		

		 	});
		 });
		 
	 fields = result;
	

	 var obj = { 'fields': fields.reduce(function(o, v, i) {
		  o[i] = v;
		  return o;
		}, {})}; 	
	 $scope.data =  obj
	 
	 console.log( obj );
	
	
	
	
	$scope.addCost = function (){
		//$scope.data.fields[id][index]['cost'] = this.val;
		days_data = $scope.data.fields;
		console.log($scope.data);
	}
	
	$scope.addMinutes = function (){
		//$scope.data.fields[id][index]['min'] = this.minute;
		days_data = $scope.data.fields;
		console.log($scope.data); 
	}
	
	$scope.addTime = function (){
		//$scope.data.fields[id][index]['hour'] = this.select;
		days_data = $scope.data.fields;
		//console.log(json);
		console.log($scope.data); 
	}
	$scope.addButton = function (id){
		//var index = counter;
		//console.log(index,id);
		//console.log($scope.data.fields[id]);
		$scope.data.fields[id].push({
			parent: id,
			id : counter,
			hour: 0,
			min: 0,
			cost: ""
		});
		counter++;
		console.log($scope.data);
	}
	
	$scope.killMyTime = function (e){
		var id = $(e.target).data('id');
		var parent = $(e.target).data('parent');
		console.log(id,parent);
		//console.log(typeof($scope.data.fields[parent]));
		$scope.data.fields[parent].splice(id,1);
		days_data = $scope.data.fields;
		console.log($scope.data.fields);
	}
	
	
}
//----------------------------------------------------------------------------
function roomsCtr($scope, $http){
	$scope.loading = true;
    $http.get(portalAdminRoot+'roomsjson').success(function(data) {
      console.log(data);
        
      $scope.currentPage = 1; //current page
      $scope.pageSize = 10;
	  $scope.rooms = data;
      
	  $scope.pageChangeHandler = function(num) {
     	 console.log('meals page changed to ' + num);
	  };
	 $scope.loading = false;
	 
	  $scope.deleteRoom = function (id,index){
		 
		 var cancel = confirm('Удалить запись ?');
		 if(cancel){
				$scope.rooms.splice(index,1);
				$http.post(portalAdminRoot+'deleteRoom', {'id':id}).success(function(data) {
				 
				 console.log(data);
				 
				});
				
		 }
		 
	 }
	 
	 
});
}
function referalsCtr($scope, $http){
	$scope.loading = true;
    $http.get(portalAdminRoot+'referalsjson').success(function(data) {
      console.log(data);
        
      $scope.currentPage = 1; //current page
      $scope.pageSize = 10;
	  $scope.referals = data;
      
	  $scope.pageChangeHandler = function(num) {
     	 console.log('meals page changed to ' + num);
	  };
	 $scope.loading = false;
});
}
//------------------------------------------------------------------
function transactionCtr($scope, $http){
	$scope.loading = true;
    $http.get(portalAdminRoot+'transactionjson').success(function(data) {
      console.log(data);
        
      $scope.currentPage = 1; //current page
      $scope.pageSize = 10;
	  $scope.transactions = data;
      
	  $scope.pageChangeHandler = function(num) {
     	 console.log('meals page changed to ' + num);
	  };
	 $scope.loading = false;
});
}
//------------------------------------------------------------------
function orderCtr($scope, $http){



//this is a table controller	
	$scope.loading = true;
    $http.get(portalAdminRoot+'orderjson').success(function(data) {
      
        console.log(data);
      $scope.currentPage = 1; //current page
      $scope.pageSize = 10;
	  $scope.orders = data;
      
	  $scope.pageChangeHandler = function(num) {
     	 console.log('meals page changed to ' + num);
	  };
	 $scope.loading = false;
	 $scope.confirmOrder = function(id){
		 if(confirm('Вы подтверждаете заявку ?')){
			
			$('#td'+id).html('принят');
			$('#act'+id).fadeOut();
			
			 $http.post(portalAdminRoot+'proceedTransaction', {'id':id}).success(function(data) {
				 
				 console.log(data);
				 
			 });
		}
	 }
	 
	 $scope.cancelOrder = function (id,index){
		 
		 var cancel = prompt('Заполните причину отмены?', 'сделка отменилась');
		 if(cancel){
				$scope.orders.splice(index,1);
				$http.post(portalAdminRoot+'deleteTransaction', {'id':id, 'comment':cancel}).success(function(data) {
				 
				 console.log(data);
				 
				});
				
		 }
		 
	 }
	 
});
}
//-------------------------------------------------------  
function paginateController($scope) {
  $scope.pageChangeHandler = function(num) {
    console.log('going to page ' + num);
  };
}
//-------------------------------------------------------
