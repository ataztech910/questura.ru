<div ng-controller="transactionCtr">
<div ng-show="loading" class="loading"><img src="/frontend/qroomblock/images/ajax-loader.gif"></div>
 <br>
<div ng-show="transactions.length">
<div class="row">
     <div class="col-xs-4">
              <label for="search">фильтр:</label>
              <input ng-model="q" id="search" class="form-control" placeholder="фильтр">
            </div>
            <div class="col-xs-4">
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
<thead>
			<tr>
				<th>
					состояние
				</th>
				<th>
					сумма,руб
				</th>
				<th>
					дата
				</th>	
			</tr>
		</thead>
 
 
 
 <tr dir-paginate="transactions in transactions |  itemsPerPage: pageSize | filter:q track by $index" current-page="currentPage" id="tr{{transactions.id}}">
			
			<td>{{transactions.action}}</td>
			<td>{{transactions.count}}</td>
			<td>{{transactions.dateTime}}</td>
			
		</tr>

</table>
</div>
<div ng-hide="transactions.length"><i>транзакции не проводились</i></div>


<div ng-controller="paginateController" class="paginateController">
          
          <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/frontend/templates/admin/dirPagination.tpl.html"></dir-pagination-controls>
          
</div>
</div>
</div>
