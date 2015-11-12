<?
class Model_welcome extends CI_Model{
		
	function __construct(){
		parent::__construct();
	}
//---------------------------------------------	
/*
	
	Model for get users by City
	
*/		
		
//-----------------------------------------------

function checkCity($city){
	$query = $this->db->get_where('mako_region', array('slug' => $city));
	$row = $query->result_array();
	if($query->num_rows()>0){
		return true;
	}
	else{
		return false;
	}
}		
//---------------------------------------------
function getSlugByName($name){
	$query = $this->db->get_where('mako_region', array('name' => $name));
	$row = $query->result_array();
	//var_dump($row);
	if($query->num_rows()>0){
		return $row[0];
	}
	else{
		return false;
	}
}	
//---------------------------------------------
	function getCountRoomsByUsers($ids,$checkIds=null,$filter=null){
	//	var_dump($ids);
		$exeption = '';
		if($checkIds!=null){
			$exeption = ' and id not IN ('.$checkIds.') ';
		}
		//var_dump($exeption);
		if($filter==null){
			$this->db->from('mako_ContentTable');
			if($ids!=''){
				$this->db->where('userId IN ('.$ids.') and active = 1 '.$exeption);
			}
			else{
				$this->db->where(' active = 1 '.$exeption);
			}
			return $this->db->count_all_results();
		}
	    //var_dump($this->db->count_all_results());
		if($filter!=null){
				
			    switch($filter){
				    case 'survival':
				    	$wh = 't2.type=10 and t2.value=1';
				    break;
				    case 'prison':
				    	$wh = 't2.type=10 and t2.value=2';
				    break; 
				    case 'movies':
				    	$wh = 't2.type=10 and t2.value=3';
				    break;
				    case 'detective':
				    	$wh = 't2.type=10 and t2.value=4';
				    break;
				    case 'forbigcompany':
				    	$wh = 't2.type=11 and t2.value=1';
				    break;
				    case 'forkids':
				    	$wh = 't2.type=11 and t2.value=2';
				    break;
				    case 'perfomance':
				    	$wh = 't2.type=11 and t2.value=3';
				    break;
				     case 'strawberry':
				    	$wh = 't2.type=11 and t2.value=4';
				    break;
				    case 'light':
				    	$wh = 't2.type=3 and t2.value=1';
				    break;
				    case 'medium':
				    	$wh = 't2.type=3 and t2.value=2';
				    break;
				    case 'hard':
				    	$wh = 't2.type=3 and t2.value=3';
				    break;
				}
				$query = $this->db->query('SELECT *,t1.id as categoryId,t1.value as name FROM mako_ContentTable as t1 INNER JOIN mako_ParamsTable as t2  ON (t1.id = t2.contentId) where '.$wh.' and userId IN ('.$ids.') and active = 1');
		
		
		return $query->num_rows();		
		}
		
		
		
		
		
		 
	}
//---------------------------------------------

function getNew($city=null){
	$where = '';
	$return = array();
	if($city) $where = 'where t2.city = "'.$city.'"';
	$sql = 'select t1.url as url, t1.userId as userId, t1.id as catId, t1.value as name, t2.address as address, t1.attach as attach from mako_ContentTable as t1 INNER join mako_userTable as t2 ON (t1.userId = t2.id) '.$where.' ORDER BY t1.id DESC LIMIT 2';
	
	$query = $this->db->query($sql);
	if($query->num_rows()>0){
			$i = 0;
	       	foreach ($query->result_array() as $row){
	       		
		       	$return[$i]['name'] = $row['name'];
		       	$return[$i]['url'] = $row['url'];
		       	$return[$i]['address'] = $row['address'];
		       	$return[$i]['attach'] =  json_decode($row['attach'], true);
		        $return[$i]['params'] = $this->getParam($row['catId']);
		       	$return[$i]['city'] = $this->getCityByParent($row['userId']);
		       	if(isset($return[$i]['attach']['images']) ){
			       	foreach($return[$i]['attach']['images'] as $ii){
				       	if(file_exists($_SERVER['DOCUMENT_ROOT'].$ii)){
					       $return[$i]['image'] = $ii;	
				       	}
			       	}
		       	}
		       	
		       	foreach($return[$i]['params'] as $pp){
			    
			    	if($pp['icon'] == 'fa-money'){
				    	$return[$i]['cost'] = $pp['paramValue'];
			    	}
			       	
		       	}
		       	//var_dump($return);
		       	$i++;
		       	
	       	}
		   	
	}   
	return $return;    	
}
//----------------------------------------------
function getTarif($id){
		$query = $this->db->query('SELECT tarif FROM mako_userTable WHERE id = "'.$id.'"');
		$row = $query->result_array();
		return $row[0]['tarif'];
	}	
//---------------------------------------------
/*
Model get rooms by users
*/
	function getRoomsByUsers($ids,$exeption=null,$page,$order="rating",$filter=false){
		if($ids){
			$i = 0;
			$ifExeption = '';
			if($exeption!=null){
				$ifExeption = ' and id not in ('.$exeption.')';
			}
			//var_dump('SELECT * FROM mako_ContentTable where userId IN ('.$ids.') and active = 1 '.$ifExeption.' order by rating LIMIT '.($page-1).' , 12');
			if($order!="cost ASC" && $order!="cost DESC"){
			$query = $this->db->query('SELECT * FROM mako_ContentTable where userId IN ('.$ids.') and active = 1 '.$ifExeption.' order by '.$order.' DESC LIMIT '.($page-1).' , 12');
			}
			else{
				$order = str_replace('cost', 't2.value', $order);
				$query = $this->db->query('SELECT *,t1.id as categoryId,t1.value as name FROM mako_ContentTable as t1 INNER JOIN mako_ParamsTable as t2  ON (t1.id = t2.contentId) where t2.`type` = 1 and userId IN ('.$ids.') and active = 1 '.$ifExeption.' order by '.$order.' LIMIT '.($page-1).' , 12');
		    }
		    if($filter){
			    switch($filter){
				    case 'survival':
				    	$wh = 't2.type=10 and t2.value=1';
				    break;
				    case 'prison':
				    	$wh = 't2.type=10 and t2.value=2';
				    break; 
				    case 'movies':
				    	$wh = 't2.type=10 and t2.value=3';
				    break;
				    case 'detective':
				    	$wh = 't2.type=10 and t2.value=4';
				    break;
				    case 'forbigcompany':
				    	$wh = 't2.type=11 and t2.value=1';
				    break;
				    case 'forkids':
				    	$wh = 't2.type=11 and t2.value=2';
				    break;
				    case 'perfomance':
				    	$wh = 't2.type=11 and t2.value=3';
				    break;
				     case 'strawberry':
				    	$wh = 't2.type=11 and t2.value=4';
				    break;
				    case 'light':
				    	$wh = 't2.type=3 and t2.value=1';
				    break;
				    case 'medium':
				    	$wh = 't2.type=3 and t2.value=2';
				    break;
				    case 'hard':
				    	$wh = 't2.type=3 and t2.value=3';
				    break;
				}
				$query = $this->db->query('SELECT *,t1.id as categoryId,t1.value as name FROM mako_ContentTable as t1 INNER JOIN mako_ParamsTable as t2  ON (t1.id = t2.contentId) where '.$wh.' and userId IN ('.$ids.') and active = 1 '.$ifExeption.' order by '.$order.' LIMIT '.($page-1).' , 12');
				//var_dump('SELECT *,t1.id as categoryId,t1.value as name FROM mako_ContentTable as t1 INNER JOIN mako_ParamsTable as t2  ON (t1.id = t2.contentId) where '.$wh.' and userId IN ('.$ids.') and active = 1 '.$ifExeption.' order by '.$order.' LIMIT '.($page-1).' , 12');
				
		    }
			
			
		//var_dump('SELECT * FROM mako_ContentTable where userId IN ('.$ids.') and active = 1 '.$ifExeption.' order by '.$order.' LIMIT '.($page-1).' , 12');
			
			foreach ($query->result_array() as $row){
		        
		        @$result[$i] = $row;
		        
		        
		        //var_dump($row['catId']);
		        if(isset($row['name'])) {
		        	$result[$i]['value'] = $row['name'];
		        	 //var_dump('and');
		        }
		        if(isset($row['categoryId'])) { 
		        	//var_dump('here');
		        	$row['id'] = $row['categoryId']; 
		        }
		        
		        
		        if(!empty($result[$i]['attach'] )){
		        	$result[$i]['attach'] = json_decode($result[$i]['attach'], true);
		        }
		        @$result[$i]['city'] = $this->getCityByParent($row['userId']);
		        @$result[$i]['tarif'] = $this->getTarif($row['userId']);
		        @$result[$i]['params'] = $this->getParam($row['id']);
		        @$result[$i]['address'] = $this->getAddressByUser($row['userId']);
		        @$result[$i]['phone'] = $this->getPhoneByUser($row['userId']);
		        
		       
		        $i++;
		        
	        }
			return @$result;
		}else{
			return FALSE;
		}
		
	}


}
	
?>	