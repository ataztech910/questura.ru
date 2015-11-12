<?
class Model_pages extends CI_Model{
		
	function __construct(){
		parent::__construct();
	}
//----------------------------------------------

	function getPageByUrl($page){
		$query = $this->db->query('select * from mako_Pages where url = "'.$page.'" and active=1');
		$row = $query->result_array();
		//var_dump($page);
		
		return $row[0];
	} 
	
//----------------------------------------------
	function getUserNameByEmail($table,$email){
		$query = $this->db->query('select `name` from '.$table.' where email = "'.$email.'"');
		$row = $query->result_array();
		//var_dump('select `name` from '.$table.' where email = "'.$email.'"');
		return $row[0]['name'];
	}

}	
?>