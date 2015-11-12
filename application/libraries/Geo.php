<?
class Geo extends CI_Model{
	
	function getCityReqursive($parent=0){
		
		$query = $this->db->query('SELECT * FROM mako_region where id_parent='.$parent.' ORDER by region_order DESC,name');
		$i=0;
		$arr = array();
		foreach ($query->result_array() as $row){
			$arr[$i] = $row;
			if($parent==0){
				$arr[$i]['childs'] = $this->getCityReqursive($row['id_region']);
			}
			$i++;
		}
		return $arr;
	}
//-------------------------------------------------------
	function getAllCity($parent=0){
		return $this->getCityReqursive($parent);
	}	
//-------------------------------------------------------	
function getCityIdByName($name){
		//var_dump($name);
		$query = $this->db->get_where('mako_region', array('slug' => $name));
		$row = $query->result_array();
		return @$row[0];
	}

function getCityIdByRussianName($name){
		//var_dump($name);
		$query = $this->db->get_where('mako_region', array('name' => $name));
		$row = $query->result_array();
		return @$row[0];
	}	

}
?>