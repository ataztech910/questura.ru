<?
	
class Raspisanie extends CI_Model{
	var $styles = array(0=>'btn-info',1=>'btn-success',2=>'btn-danger',3=>'btn-warning',4=>'btn-default');
//------------------------------------------------------------------
	function generateLegend($itemId){
		
		$this->db->order_by("value"); 
		$this->db->group_by("value"); 
		
		$query = $this->db->get_where('mako_ParamsTable',array('contentId'=>$itemId,'type'=>9));
		$rowHour = $query->result_array();
		//var_dump($itemId);
		$i = 0;
		$legend = array();
		if(count($rowHour)>0){
			foreach($rowHour as $rh){
				$legend[$rh['value']] = $this->styles[$i];
				$i++;
			}
		}
		
		return $legend;
			
	}
//------------------------------------------------------------------
	function generateAllDays($arr){
		//
		if(count($arr)>0){
			for($i=1;$i<=7;$i++){
				
				//var_dump($arr[$i]);
				if(!$arr[$i]){
					$arr[$i] = $arr[$i-1];
				}
			}
		//	var_dump($arr);
			return $arr;
		}
	
	}
//------------------------------------------------------------------
	function checkArray($array){
		
		foreach($array as $aa){
			if(count($aa)>0){
				return true;
			}
		}
		return false;
	}
//------------------------------------------------------------------
	function checkDate($date,$time){
		$query = $this->db->get_where('mako_Orders',array('realDate'=>$date,'realTime'=>$time));
		if($query->num_rows()>0){
			$hasorder = 0;
			foreach ($query->result_array() as $row){
				if($row['status']==1) {
					$hasorder = 1;		
				}
			}
			
			if($hasorder==1) return false;
			else return true;
		
		}
		else{
			return true;
		}
	}	
//------------------------------------------------------------------
	function generateCalendar($array,$itemId){
		$result = '';
		$checkArray = $this->checkArray($array);
		if(count($array)>0 && $checkArray){
			$days = array(1=>'понедельник',
						  2=>'вторник',
						  3=>'среда',
						  4=>'четверг',
						  5=>'пятница',
						  6=>'суббота',
						  7=>'воскресенье');
			
			
			$generateDays =  $this->generateAllDays($array) ;
			$generateLegend = $this->generateLegend($itemId);
			//ksort($generateDays);
			
			//var_dump($generateDays);
			$result ='
			<button class="btn btn-default" id="showotherweek" onclick="showotherweek();">следующая неделя &rarr;</button>
			<table class="table">';
			$j = 0;
			$i = 1;
			$weekclass = "thisweek";
			for($k=1;$k<=14;$k++){
				//01.01
				$myday = date('d.m',strtotime("Today + ".($k-date('N'))." Days"));
				if($myday!="01.01"){
					if($k>7){
						$weekclass="nextweek";
					}
					$result .='<tr class="'.$weekclass.'">
							   	<td>
							   		'.$days[$i].'<br><b>'.$myday.'</b>
							   	</td><td>';
					asort($generateDays[$i]);
					
					foreach($generateDays[$i] as $cal){
						//onclick="alert( $(this).data(\'cost\') )"
						$checkButton = $this->checkDate($myday, $cal['hour'].':'.$cal['min']);
						if($checkButton){
							$result .= '<button onclick="generateOrder(this.id)" data-toggle="modal" data-target="#myModal" data-day="'.$myday.'" data-time="'.$cal['hour'].':'.$cal['min'].'"  data-cost="'.$myday.' на '.$cal['hour'].':'.$cal['min'].', стоимоcть: '.$cal['cost'].' рублей" id="'.$i.'_'.$j.'" class="btn '.$generateLegend[$cal['cost']].'">'.$cal['hour'].':'.$cal['min'].'</button>';
							$j++;
						
						}	
					
					}
					
							   
					$result .= '</td></tr>';
				}	$i++;
					if($i==8) $i= 1;
				
			}
			$result .='</table>
			<script>
				var check = 0;
				
				function showotherweek(){
					
					if(check==0){
						check = 1;
						$("#showotherweek").html("&larr; предыдущая неделя");
						$(".nextweek").show("slow");
						$(".thisweek").hide();
					}
					else{
						check = 0;
						$("#showotherweek").html("следующая неделя &rarr;");
						$(".thisweek").show("slow");
						$(".nextweek").hide();
					}
				}
				
			</script>
			';
			
		}
		
		return $result;
	}
//------------------------------------------------------------------
	function checkViewModel($array){
		if(count($array[1])>0 && count($array[2])>0){
			//if there all days not similar
			return 0;
		}
		else{
			if(count($array[1])>0 && count($array[7])==0){
				//if sunday is lite saturday
				return 1;
			}
			else{
				//if there is week of monday/saturday and sunday
				return 2;
			}
		}
	}	
//------------------------------------------------------------------	
	function run($calendar, $dateArray){
		$result = '';
		for($i=0;$i<7;$i++){
		$date = date('Y-m-d', mktime(0, 0, 0, $dateArray['month']  , $dateArray['day']+$i, $dateArray['year']));
		$raspisanie = $this->checkMyDate($date,$calendar);
		
		$result .= '<tr><td class="mdl-data-table__cell--non-numeric">'.date('d.m.Y', mktime(0, 0, 0, date("m")  , date("d")+$i, date("Y"))).'</td><td class="mdl-data-table__cell--normalpadding">'.$this->createCalendarButtons($raspisanie).'</td></tr>';
		}	
		
		return $result;
	}
	
//------------------------------------------------------------------
	
	function checkMyDate($date,$checkArray){
		$i=0;
		if(is_array($checkArray)){
			foreach($checkArray as $ca){
				$key = array_search($date, $ca);
				if($key){
					return $checkArray[$i];
				}
				$i++;	
			}	
		}
	}
//------------------------------------------------------------------	
	function createCalendarButtons($array){
		$btn = '';
			//if(is_array($array)){
			//foreach($array['time'] as $key=>$value){
				/*
				$disabled='';
				$modal = '';
				switch($value){
					case 'free':
						$btnClass = 'mdl-button--colored call-modal';
						$modal = 'modal';
					break;
					
					case 'reserved': 
						$btnClass = 'mdl-js-ripple-effect';
						$disabled = 'disabled';
					break;
					
					case 'ordered': 
						$btnClass = 'mdl-js-ripple-effect mdl-button--accent';
						$disabled = 'disabled';
					break;
				}*/ 
				$br = '';
				$btnClass = 'mdl-button--colored call-modal';
				if($array['time']=='0:0'){
					$array['time'] ='';
				}
				else{
					$array['time'] =$array['time'].'';
					$br = '<br>';
				}
				$btn.='<a href="#modal" data-value="'.$array['dayname'].' в '.$array['time'].' за '.$array['cost'].' руб." class="plusCost mdl-button mdl-js-button mdl-button--raised '.$btnClass.'">'.$array['time'].''.$br.''.$array['cost'].' руб.</a>&nbsp;';
			
			//}
		//}
		return $btn;	
	}
//------------------------------------------------------------------	 
	
}	
	
?>