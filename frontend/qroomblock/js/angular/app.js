var cabinetApp = angular.module('cabinetApp', ['angularUtils.directives.dirPagination','filters']);

angular.module('filters', []).filter('htmlToPlaintext', function() {
    return function(text) {
      return String(text).replace(/<[^>]+>/gm, '');
    }
});



cabinetApp.controller('orderCtr', orderCtr);
cabinetApp.controller('transactionCtr', transactionCtr);
cabinetApp.controller('referalsCtr', referalsCtr);
cabinetApp.controller('roomsCtr', roomsCtr);
cabinetApp.controller('akcioCtr', akcioCtr);
cabinetApp.controller('paginateController', paginateController);
cabinetApp.controller('DayCost', DayCost);
cabinetApp.directive('myDateCost', function() {
  return {
    template: 'час:<select name="hour" ng-model="field.hour" ng-change="addTime()">'
    			   	+'<option>01</option>'
    			   	+'<option>02</option>'
    			   	+'<option>03</option>'
    			   	+'<option>04</option>'
    			   	+'<option>05</option>'
    			   	+'<option>06</option>'
    			   	+'<option>07</option>'
    			   	+'<option>08</option>'
    			   	+'<option>09</option>'
    			   	+'<option>10</option>'
    			   	+'<option>11</option>'
    			   	+'<option>12</option>'
    			   	+'<option>13</option>'
    			   	+'<option>14</option>'
    			   	+'<option>15</option>'
    			   	+'<option>16</option>'
    			   	+'<option>17</option>'
    			   	+'<option>18</option>'
    			   	+'<option>19</option>'
    			   	+'<option>20</option>'
    			   	+'<option>21</option>'
    			   	+'<option>22</option>'
    			   	+'<option>23</option>'
    			   	+'<option>00</option>'
    			   +'</select> минута:'
    			   +'<select name="minute" ng-model="field.min" ng-change="addMinutes()">'
    			   	+'<option>00</option>' 
    			   	+'<option>05</option>'
    			   	+'<option>10</option>'
    			   	+'<option>15</option>'
    			   	+'<option>20</option>'
    			   	+'<option>25</option>'
    			   	+'<option>30</option>'
    			   	+'<option>35</option>'
    			   	+'<option>40</option>'
    			   	+'<option>45</option>'
    			   	+'<option>50</option>'
    			   	+'<option>55</option>'
    			   +'</select> - стоимость <input onkeyup="return false;" ng-model="field.cost" type="text" ng-change="addCost()" class="costInp" /> <a style="cursor:pointer;" data-id = "{{$index}}" data-parent="{{field.parent}}"  ng-click="killMyTime($event)" >x</a>' 
  };
});

