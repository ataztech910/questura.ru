<br>
<a href="/cabinet/addRoom" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
  <i class="glyphicon glyphicon-plus">Добавить комнату</i>
</a>

<div ng-controller="roomsCtr">
<div ng-show="loading" class="loading"><img src="/frontend/qroomblock/images/ajax-loader.gif"></div>
 <br>
<div ng-show="rooms.length">
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
					название
				</th>
				<th>
					состояние
				</th>
				<th>
				</th>
				
			</tr>
		</thead>
 
 
 
 <tr dir-paginate="rooms in rooms |  itemsPerPage: pageSize | filter:q track by $index" current-page="currentPage" id="tr{{rooms.id}}">
	
	 <td><a target="_blank" href="/{{rooms.city}}/{{rooms.url}}">{{rooms.value}}</a></td>
	 
	 <td id="td{{rooms.id}}">{{rooms.active}}</td>
	 
	 <td class="normalBtnTd">
		 <div  id="act{{rooms.id}}" >
	      <a data-id="{{rooms.id}}" href="/cabinet/addRoom/{{rooms.id}}" class="correctBtn mdl-button mdl-js-button" >
			  <i class="glyphicon glyphicon-pencil"></i>
		  </a>
		  <button data-id="{{rooms.id}}" class="correctBtn cancelOrder mdl-button mdl-js-button" ng-click="deleteRoom(rooms.id,$index)">
			  <i class="glyphicon glyphicon-remove"></i>
			</button>
			
			
		</div>
	 </td>
	 
 </tr>

</table>
</div>
<div ng-hide="rooms.length"><i>комнат нет</i></div>


<div ng-controller="paginateController" class="paginateController">
          
          <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/frontend/templates/admin/dirPagination.tpl.html"></dir-pagination-controls>
          
</div>
</div>
</div>
