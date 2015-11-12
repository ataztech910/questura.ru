<?
class Model_feedback extends CI_Model{
		
	function __construct(){
		parent::__construct();
	}
	
	
	function getQuestDataById($id){
		$query = $this->db->query('SELECT * from mako_ContentTable  WHERE id="'.$id.'"');
		if($query->num_rows()>0){
			$result = $query->result_array();
			return $result[0];
		}
	}
	
//-----------------------------------------

	function getFeedByUsers($ids){
		$result = array();
		//var_dump('SELECT `id` from mako_ContentTable  WHERE userId IN ('.$ids.') and active = 1');
		$query = $this->db->query('SELECT id from mako_ContentTable  WHERE userId IN ('.$ids.') and active = 1');
		if($query->num_rows()>0){
			foreach ($query->result_array() as $row){
				
				$contId[] = $row['id'];
				
			}
			//var_dump($contId);
			
			$contIds = implode(' , ', $contId);
			//var_dump('SELECT * from mako_Comments  WHERE roomId IN ('.$contIds.') and active = 1 order by commentDate');
			$query2 = $this->db->query('SELECT * from mako_Comments  WHERE roomId IN ('.$contIds.') and active = 1 order by commentDate');
			
			if($query2->num_rows()>0){
				$i = 0;
				foreach ($query2->result_array() as $row2){
					$quest = $this->getQuestDataById($row2['roomId']);
					$result[$i] = $row2;
					$result[$i]['user_name'] = $this->getCostumerById($row2['userId']);
					$result[$i]['questName'] = $quest['value'];
					$result[$i]['city'] = $this->getCityByParent($quest['userId']);
					$result[$i]['questUrl'] = '/'.$result[$i]['city'].'/'.$quest['url'];//$quest['questUrl'];
					$i++; 
				}
			}
			
		}
		return $result;
	}
}
?>