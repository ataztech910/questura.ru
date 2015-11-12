<?
class Model_cityselect extends CI_Model{
	
	function getCityReqursive($parent=0){
		
		$query = $this->db->query('SELECT * FROM mako_region where id_parent='.$parent.' ORDER by region_order DESC,name');
		
		//var_dump('SELECT * FROM mako_region where id_parent='.$parent.' ORDER by region_order DESC,name');
		
		$i=0;
		$arr = array();
		foreach ($query->result_array() as $row){
			if($parent>0){
				$checkContent = $this->checkContent($row['id_region']);
				if($checkContent){
					$arr[$i] = $row;
				}
			}
			else{
				$arr[$i] = $row;
			}
			if($parent==0){
					$arr[$i]['childs'] = $this->getCityReqursive($row['id_region']);
			}
			$i++;
			
		}
		return $arr;
	}
//-------------------------------------------------------
	function checkContent($id){
		$query = $this->db->query('SELECT * FROM mako_userTable where city='.$id);
		if($query->num_rows()>0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}	
//-------------------------------------------------------
	function getAllCity($city=0){
		return $this->getCityReqursive($city);
	}	
//-------------------------------------------------------	
function getCityIdByName($name){
		$query = $this->db->get_where('mako_region', array('slug' => $name));
		if($query->num_rows()>0){
			$row = $query->result_array();
			//var_dump($row);
			return $row[0];
		}
	}

}	
	
?>