<?
	class Model_questroom extends CI_Model{
		
	function __construct(){
		parent::__construct();
	}
	
	
	function getRoomById($id){
		
		$query = $this->db->query('select * from mako_userTable where id = "'.$id.'" ');
		if($query->num_rows() > 0){
			$row = $query->result_array();
			$row[0]['attach'] = json_decode($row[0]['attach'], true);
			return $row[0];
		}
		
	}
	
	function getRoomsByUser($userId){
		$query = $this->db->query('SELECT `id`,`value`,`attach`,`active`,`url` from mako_ContentTable  WHERE userId="'.$userId.'" and active = 1');
		$i = 0;
		$result = false;
		if($query->num_rows() > 0){
			foreach ($query->result_array() as $row)
			{
	        	$result[$i] = $row;
	        	$result[$i]['attach'] = json_decode($result[$i]['attach'], true);
				$result[$i]['params'] = $this->getParam($result[$i]['id']);
				$result[$i]['address'] = $this->getAddressByUser($userId);
				$result[$i]['phone'] = $this->getPhoneByUser($userId);
	        	$i++;
			}
		}
		return $result;
	}
	
	
	function getCityByUserCity($cityId){
		
		$query = $this->db->query('select * from mako_region where id_region = "'.$cityId.'" ');
		if($query->num_rows() > 0){
			$row = $query->result_array();
			return $row[0];
		}
		
	}
//-----------------------------------------------------------------
	function getCNameBySlug($slug){
		$query = $this->db->get_where('mako_region', array('slug' => $slug));
		if($query->num_rows() > 0){
			$row = $query->result_array();
			return $row[0];
		}
	}	
//-----------------------------------------------------------------
	function getCountRoomsUser($userId){
		$query = $this->db->query('SELECT count(*) as count from mako_ContentTable  WHERE userId="'.$userId.'" and active = 1');
		if($query->num_rows() > 0){
			$row = $query->result_array();
			return $row[0]['count'];
		}
	}	
//-----------------------------------------------------------------
	function getQRoomsByCityId($cityId){
		$result = '';
		$where = 'where city = "'.$cityId.'"';
		if($cityId==1)$where ='';
		$query = $this->db->query('select * from mako_userTable  '.$where);
		if($query->num_rows() > 0){
			$i = 0;
			foreach ($query->result_array() as $row)
			{
				$result[$i] = $row;
				$result[$i]['count'] = $this->getCountRoomsUser($row['id']);	
				//var_dump($result[$i]['count']);
				$result[$i]['attach'] = json_decode($result[$i]['attach'], true);
				$i++;
			}
		}
		return $result;
	}
//-----------------------------------------------------------------		 

}
?>