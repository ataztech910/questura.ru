<div ng-controller="akcioCtr">
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

<table class="mdl-data-table mdl-js-data-table  mdl-shadow--2dp">
<thead>
			<tr>
				<td>
					№
				</td>
				<td>
					квеструм
				</td>
				<td width="300px">
					название
				</td>
				
				<td>
				</td>
				
			</tr>
		</thead>
 
 
 
 <tr dir-paginate="rooms in rooms |  itemsPerPage: pageSize | filter:q track by $index" current-page="currentPage" id="tr{{rooms.id}}">
	
	<td >{{$index+1}}</td>	
	
	 <td id="td{{rooms.id}}">{{rooms.quesroom}}</td>	
	 
	 <td><a href="/ekb/{{rooms.url}}" target="_blank">{{rooms.value}}</a></td>
	 
	 <td class="normalBtnTd">
		 <div  id="act{{rooms.id}}" >
	      <a ng-show="rooms.open" data-id="{{rooms.id}}" ng-click="acceptRoom(rooms.id,rooms.costumer,$index)" class="correctBtn mdl-button mdl-js-button" >
			  <i class="material-icons">done</i>
		  </a>
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
</div>
</div>