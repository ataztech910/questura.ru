<?
class Model_map extends CI_Model{
		
function __construct(){
	parent::__construct();
}
//--------------------------------------------
function getCoordsByCity($city){
	
	if($city!='ru') { 
	 	$cityId = $this->getCityIdBySlug($city);
	}
	else{
		$cityId = null;
	}
	$mapArray = $this->getMapArray($cityId);
	
	return  $mapArray;
	//var_dump($cityId);
}
//--------------------------------------------
function getMapArray($cityId=null){
	if($cityId!=null)$query = $this->db->get_where('mako_userTable', array('city' => $cityId));
	else $query = $this->db->query('SELECT * FROM mako_userTable');
	if($query->num_rows()>0){
		foreach ($query->result_array() as $row){
			//var_dump($row);
			$result[] = $row;
		}	
	}
	//var_dump($result);
	return $result;	
}
//--------------------------------------------	
}
?>