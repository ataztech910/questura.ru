<div ng-controller="referalsCtr">
<div ng-show="loading" class="loading"><img src="/frontend/qroomblock/images/ajax-loader.gif"></div>
 <br>
<div ng-show="referals.length">
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
			телефон
		</th>
		<th>
			e-mail
		</th>
	</tr>
	</thead>
 
 
 
 <tr dir-paginate="referals in referals |  itemsPerPage: pageSize | filter:q track by $index" current-page="currentPage" id="tr{{referals.id}}">
			
			<td>{{referals.phone}}</td>
			<td>{{referals.email}}</td>
			
			
		</tr>

</table>
</div>
<div ng-hide="referals.length"><i>рефералов нет</i></div>


<div ng-controller="paginateController" class="paginateController">
          
          <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/frontend/templates/admin/dirPagination.tpl.html"></dir-pagination-controls>
          
</div>
</div>
</div>
