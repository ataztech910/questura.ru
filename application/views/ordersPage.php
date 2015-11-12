
<div ng-controller="orderCtr">
<div ng-show="loading" class="loading">
	<img src="/frontend/qroomblock/images/ajax-loader.gif">
</div>
<br>
<div ng-show="orders.length">
<div class="row">
     <div class="col-md-8">
              <label for="search">фильтр:</label>
              <input ng-model="q" id="search" class="form-control" placeholder="фильтр">
      </div>
            <div class="col-md-4">
              <label for="search">строк на странице:</label>
              
              <select class="form-control" ng-model="pageSize">
	              <option selected="selected">1</option>
	              <option>5</option>
	              <option>10</option>
	              <option>100</option>
              </select>
              
           
            </div>
   
</div>
<br/>
<div class="my-properties">
<div class="table-responsive">
<table class="table">
 <theader>
 	<tr>
	 	<th>телефон</th>
	 	<th>дата/время</th>
	 	<th>дополнительно</th>
	 	<th>статус</th>
	 	<th></th>
 	</tr>
 </theader>
 
 
 <tbody>
 <tr dir-paginate="orders in orders |  itemsPerPage: pageSize | filter:q track by $index" current-page="currentPage" id="tr{{orders.id}}">
	
	 <td>{{orders.costumer}}</td>
	 <td>{{orders.date}}</td>
	 <td>{{orders.comment}}</td>
	 <td id="td{{orders.id}}">{{orders.status}}</td>
	 <td class="normalBtnTd">
		 <div  id="act{{orders.id}}" ng-show="orders.status=='новый'">
	      <button data-id="{{orders.id}}" class="correctBtn mdl-button mdl-js-button" ng-click="confirmOrder(orders.id)">
			  <i class="glyphicon glyphicon-ok"></i>
		  </button>
		  <button data-id="{{orders.id}}" class="correctBtn cancelOrder mdl-button mdl-js-button" ng-click="cancelOrder(orders.id,$index)">
			  <i class="glyphicon glyphicon-remove"></i>
			</button>
		</div>
	 </td>
	 
 </tr>
</tbody>
</table>
</div>
</div>
</div>

<div ng-hide="orders.length"><i>заказы отсутствуют</i></div>


<div ng-controller="paginateController" class="paginateController">
          
          <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/frontend/templates/admin/dirPagination.tpl.html"></dir-pagination-controls>
          
</div>
</div>