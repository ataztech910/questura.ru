<?
class Model_cabinet extends CI_Model{
		
	function __construct(){
		parent::__construct(); 
	}	
	
	
function changetarif($id, $userId){
		
		$data['tarif'] = $id;
		$this->db->update('mako_userTable', $data, array('id'=>$userId) );
				
	}
	
	function getUserForTarif(){
		$userId = $this->getCabinetIdByEmail();
		return $userId;
	}
	
	function getCurrTarif(){
		$userId = $this->getCabinetIdByEmail();
		$getTarif = $this->getTarif($userId);
		
		return $getTarif;
	}
	function getTarifs(){
		$query = $this->db->query('SELECT * FROM mako_Tarif');
		foreach ($query->result_array() as $row){
			$result[] = $row;
		}
		return $result;
		//var_dump($userId);
	}
//-----------------------------------------------------	
	function getTarif($id){
		$query = $this->db->query('SELECT tarif FROM mako_userTable WHERE id = "'.$id.'"');
		$row = $query->result_array();
		return $row[0]['tarif'];
	}	
	
	
	function getCabinetIdByEmail(){
		switch($this->session->userdata('user_type')){
			case '1':
				$query = $this->db->query('SELECT id from mako_userTable  WHERE email="'.$this->session->userdata('user_name').'"');
			break;
			
			case '2':
				$query = $this->db->query('SELECT id from mako_Costumers  WHERE email="'.$this->session->userdata('user_name').'"');
			break;
		}
		$row = $query->result_array();
		
		return $row[0]['id'];
	}
	
//---------------------------------------------------	
	function getUserTypeByEmail($email){
		$query = $this->db->query('SELECT * FROM mako_userTable WHERE email = "'.$email.'"');
		if($query->num_rows()>0){
			return 'mako_userTable';
		}
		else{
			$query = $this->db->query('SELECT * FROM mako_Costumers WHERE email = "'.$email.'"');
			if($query->num_rows()>0){
				return 'mako_Costumers';
			}
		}
	}
//---------------------------------------------------	
	function respass(){
		$newPass = $this->generatePassword();
		$email = $this->input->post('email');
		//var_dump($email);
		
		$subj = "Новый пароль для портала Questura.ru";
		
		$content = "<div>
						Ваш новый пароль для входа в личный кабинет на портале Questura.ru:
						
						<b>".$newPass."</b>
					</div>";
		
		
		$table = $this->getUserTypeByEmail($email);
		
		$doUpdate['password'] = md5($newPass);
		$this->db->update($table, $doUpdate, array('email'=>$email) );
		$this->sendMail($email, $subj, $content);
		return true;
	}
//---------------------------------------------------
	function getQRNameById($id){
		$query = $this->db->query('SELECT name FROM mako_userTable WHERE id = "'.$id.'"');
		$row = $query->result_array();
		return $row[0]['name'];
	}
	
	function getCostumerByData($type,$email){
		switch($type){
			case 1:
				$table = 'mako_userTable';
			break;
			
			case 2:
				$table = 'mako_Costumers';
			break;
		}
		
		$query = $this->db->query('SELECT id FROM '.$table.' WHERE email = "'.$email.'"');
		$row = $query->result_array();
		return $row[0]['id'];
	}
	
	function acceptRoom($id, $costumer){
		$data['contentId'] = $id;
		$data['userId'] = $costumer;
		
		$this->db->insert('mako_akcioLog', $data);
	}
//---------------------------------------------------	
	function getOpenById($user,$room){
		$query = $this->db->query('SELECT id FROM mako_akcioLog WHERE userId = "'.$user.'" and contentId = "'.$room.'"');
		if($query->num_rows()>0){
			return false;
		}else{
			return true;
		}
		
	}	
//---------------------------------------------------	
	function getAcioRoomsById(){
		//var_dump( $this->session->userdata() );
		$costumer = $this->getCostumerByData($this->session->userdata('user_type'), $this->session->userdata('user_name'));
		$query = $this->db->query('SELECT * FROM mako_ContentTable WHERE is_action = 1');
		foreach ($query->result() as $row){
			$row->text = html_entity_decode($row->text);
			$row->text = strip_tags($row->text);
			//$row->text = substr($row->text,0,600).'...';
			$row->costumer = $costumer;
			$row->quesroom = $this->getQRNameById($row->userId);
			$row->open = $this->getOpenById($costumer,$row->id);
		}
		//var_dump($query->result_array());
		return $query->result_array();
	}
//---------------------------------------------------
	function getAttach($id){
		$query = $this->db->query('SELECT attach FROM mako_userTable WHERE id ="'.$id.'"');
		$row = $query->result_array();
		$row[0]['attach'] = json_decode($row[0]['attach'],true);
		return $row[0]['attach'];
	}
//---------------------------------------------------
	function relinkAttach($id){
		$data['attach'] = $this->getAttach($id);
		unset($data['attach']['logo']);
		$data['attach'] = json_encode($data['attach']);
		//var_dump($data);
		$data['id'] = $id;
		$this->updateQRoom($data);
	}	
//---------------------------------------------------
	function getLogo($id){
		$query = $this->db->query('SELECT attach FROM mako_userTable WHERE id ="'.$id.'"');
		$row = $query->result_array();
		if($query->num_rows()>0){
			$row[0]['attach'] = json_decode($row[0]['attach'],true);
			return @$row[0]['attach']['logo'];
		}
		else return false;
	}	
//---------------------------------------------------
	function updateUser($email, $name,$phone, $city,$id){
		$dataUpdate['email'] = $email;
		$dataUpdate['name'] = $name;
		$dataUpdate['phone'] = $phone;
		$dataUpdate['city'] = $city;
		
		$this->db->set($dataUpdate);
		$this->db->where('id', $id);
		$this->db->update('mako_Costumers');	
	}
//---------------------------------------------------
	function updateQRoom($data){
		$id = $data['id'];
		unset($data['id']);
		
		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update('mako_userTable');
	}	
//---------------------------------------------------
	function delRoom($id){
		$images = $this->getAttachArray($id);
		foreach($images['images'] as $ii){
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$ii)){
				unlink($_SERVER['DOCUMENT_ROOT'].$ii);
			}
		}
		$this->db->delete('mako_ContentTable', array('id' => $id));
	}
//---------------------------------------------------
	function updateImages($json,$id){
		$dataInsert['attach'] = $json;
		$this->db->set($dataInsert);
		$this->db->where('id', $id);
		$this->db->update('mako_ContentTable');	
	}	
//---------------------------------------------------
	function getAttachArray($id){
		$query = $this->db->query('SELECT attach FROM mako_ContentTable WHERE id ="'.$id.'"');
		$row = $query->result_array();
		$checkMe = json_decode($row[0]['attach'],true);
		//var_dump($row[0]['attach']);
		if(isset($checkMe['images'])){
			if($query->num_rows()>0 && is_array($checkMe['images'])){
				$row[0]['attach'] = json_decode($row[0]['attach'],true);
			}
			else{
				$row[0]['attach'] = false;
			}
			return $row[0]['attach'];  
		}
	}
//---------------------------------------------------
	function getImageIndex($id){
		$count = $this->getAttachArray($id);
		if(isset($count['images'])){
			return count($count['images']);
		}
	}	
//---------------------------------------------------
	function updateRoom($data,$json,$id, $params=null){
		$oldAttach = $this->getAttachArray($id);
		
		
		if(is_array($oldAttach)){
			@$json['images'] = array_merge($oldAttach['images'],$json['images']);
		}
		
		//var_dump($json['images']);
		
		if(count($json)>0 && $json['images']!=null){
			$dataInsert['attach'] = json_encode($json);
		}
		
	
		$url = $this->checkUrlAndChange($data['url'],$data['userId'],$id);
		$dataInsert['value'] = htmlspecialchars( $data['value'] ); 
		$dataInsert['text'] = $data['text'];
		$dataInsert['active'] = $data['active'];
		$dataInsert['is_action'] = $data['is_action'];
		$dataInsert['url'] = $url;
		//var_dump($dataInsert['attach']);
		
		$this->db->set($dataInsert);
		$this->db->where('id', $id);
		$this->db->update('mako_ContentTable');
		
		//update one cost param
		//$this->db->set('value',$data['cost']);
		//$this->db->where('contentId', $id);
		//$this->db->where('type', 1);
		
		$doUpdate['value'] = $data['cost'];
		
		
		$this->db->update('mako_ParamsTable', $doUpdate, array('contentId'=>$id,'type'=>1) );
		
		
		/*if( $this->db->update('mako_ParamsTable') ){
			echo 1;
		}
		else{
			var_dump($this->db->update('mako_ParamsTable'));
		}*/
		//var_dump(mysql_error());
		
		
		//filters loop
		//echo 'do delete';
		$this->db->delete('mako_ParamsTable', array('contentId' => $id,'type'=>10));
		$this->db->delete('mako_ParamsTable', array('contentId' => $id,'type'=>11)); 
		$this->db->delete('mako_ParamsTable', array('contentId' => $id,'type'=>3));
		
		foreach($params['genre'] as $key=>$value){
			if($value!=NULL){
				
				$ParamInsert['value'] = $key;
				$ParamInsert['orderId'] = 0;
				$ParamInsert['type'] = 10;
				$ParamInsert['contentId'] = $id;
				$this->db->insert('mako_ParamsTable', $ParamInsert);
				
			}
		}
		
		foreach($params['type'] as $key=>$value){
			if($value!=NULL){
				$ParamInsert['value'] = $key;
				$ParamInsert['orderId'] = 0;
				$ParamInsert['type'] = 11;
				$ParamInsert['contentId'] = $id;
				$this->db->insert('mako_ParamsTable', $ParamInsert);
			}
		}
		
		foreach($params['dif'] as $key=>$value){
			if($value!=NULL){
				$ParamInsert['value'] = $key;
				$ParamInsert['orderId'] = 0;
				$ParamInsert['type'] = 3;
				$ParamInsert['contentId'] = $id;
				$this->db->insert('mako_ParamsTable', $ParamInsert);
			}
		}
		
		//daytime loop
		$this->db->delete('mako_ParamsTable', array('contentId' => $id,'type'=>7));
		$this->db->delete('mako_ParamsTable', array('contentId' => $id,'type'=>8)); 
		$this->db->delete('mako_ParamsTable', array('contentId' => $id,'type'=>9));
		
		$i = 1;
		
		//var_dump($data['daytime']);
		if(isset($data['daytime'])){
		unset($data['daytime'][0]);
		foreach($data['daytime'] as $at){
			//var_dump(count($at));
			if(count($at)>0){
				$j = 0;
				foreach($at as $adata){
					$dataDayTime['parent'] = $i;
					$dataDayTime['type'] = 7;
					$dataDayTime['contentId'] = $id;
					$dataDayTime['orderId'] = $j;
					$dataDayTime['value'] = $adata['hour'];
					$this->db->insert('mako_ParamsTable', $dataDayTime);
					
					$dataDayTime['parent'] = $i;
					$dataDayTime['type'] = 8;
					$dataDayTime['contentId'] = $id;
					$dataDayTime['orderId'] = $j;
					$dataDayTime['value'] = $adata['min'];
					$this->db->insert('mako_ParamsTable', $dataDayTime);
					
					$dataDayTime['parent'] = $i;
					$dataDayTime['type'] = 9;
					$dataDayTime['contentId'] = $id;
					$dataDayTime['orderId'] = $j;
					$dataDayTime['value'] = $adata['cost'];
					$this->db->insert('mako_ParamsTable', $dataDayTime);
					$j++;
				}
				
			}$i++;
				
		}
	  }
	}
//---------------------------------------------------
	function checkEmailOrExit($email){
		$query = $this->db->query('SELECT `id` from mako_userTable  WHERE email = "'.$email.'"');
		if($query->num_rows()>0){
			return true;
		}
		else{
			$query = $this->db->query('SELECT `id` from mako_Costumers  WHERE email = "'.$email.'"');
			if($query->num_rows()>0){
				return true;
			}
			else{
				return false;
			}
		}
	}	
//---------------------------------------------------
	function checkUrlAndChange($value,$id,$currId=null){
		$andId = "";
		if($currId!=null){
			$andId = ' and id <> "'.$currId.'"';
		}
	
		$query = $this->db->query('SELECT `id` from mako_ContentTable  WHERE url = "'.$value.'" '.$andId);
		if($query->num_rows()>0){
			return $value.$id;
		}
		else{
			return $value;
		}	
	}
//---------------------------------------------------	
	function insertRoom($data, $json, $params=null){
	
		$url = $this->checkUrlAndChange($data['url'],$data['userId']);
	
		$dataInsert['attach'] = json_encode($json);
		$dataInsert['value'] = htmlspecialchars($data['value']);
		
		$dataInsert['text'] = $data['text'];
		$dataInsert['active'] = $data['active'];
		$dataInsert['userId'] = $data['userId'];
		$dataInsert['url'] = $url;
		
		
		$this->db->insert('mako_ContentTable', $dataInsert);
		
		$query = $this->db->query('SELECT `id` from mako_ContentTable  WHERE userId = "'.$data['userId'].'" and value="'.htmlspecialchars($data['value']).'"');
		
		$row = $query->result_array();
		
		//insert one cost param
		$dataParam['type'] = 1;
		$dataParam['contentId'] = $row[0]['id'];
		$dataParam['value'] = $data['cost'];
		$this->db->insert('mako_ParamsTable', $dataParam);
		
		$i = 1;
		$id = $dataParam['contentId'];
		//params by genre
		foreach($params['genre'] as $key=>$value){
			if($value!=NULL){
				
				$ParamInsert['value'] = $key;
				$ParamInsert['orderId'] = 0;
				$ParamInsert['type'] = 10;
				$ParamInsert['contentId'] = $id;
				$this->db->insert('mako_ParamsTable', $ParamInsert);
				
			}
		}
		
		foreach($params['type'] as $key=>$value){
			if($value!=NULL){
				$ParamInsert['value'] = $key;
				$ParamInsert['orderId'] = 0;
				$ParamInsert['type'] = 11;
				$ParamInsert['contentId'] = $id;
				$this->db->insert('mako_ParamsTable', $ParamInsert);
			}
		}
		
		foreach($params['dif'] as $key=>$value){
			if($value!=NULL){
				$ParamInsert['value'] = $key;
				$ParamInsert['orderId'] = 0;
				$ParamInsert['type'] = 3;
				$ParamInsert['contentId'] = $id;
				$this->db->insert('mako_ParamsTable', $ParamInsert);
			}
		}
		
		//daytime loop
		
		
		unset($data['daytime'][0]);
		//var_dump($data['daytime']);
		if(isset($data['daytime'])){
		foreach($data['daytime'] as $at){
			//var_dump(count($at));
			if(count($at)>0){
				$j = 0;
				foreach($at as $adata){
					$dataDayTime['parent'] = $i;
					$dataDayTime['type'] = 7;
					$dataDayTime['contentId'] = $id;
					$dataDayTime['orderId'] = $j;
					$dataDayTime['value'] = $adata['hour'];
					$this->db->insert('mako_ParamsTable', $dataDayTime);
					
					$dataDayTime['parent'] = $i;
					$dataDayTime['type'] = 8;
					$dataDayTime['contentId'] = $id;
					$dataDayTime['orderId'] = $j;
					$dataDayTime['value'] = $adata['min'];
					$this->db->insert('mako_ParamsTable', $dataDayTime);
					
					$dataDayTime['parent'] = $i;
					$dataDayTime['type'] = 9;
					$dataDayTime['contentId'] = $id;
					$dataDayTime['orderId'] = $j;
					$dataDayTime['value'] = $adata['cost'];
					$this->db->insert('mako_ParamsTable', $dataDayTime);
					$j++;
				}
				
			}$i++;
				
		}
	  }
	}
//---------------------------------------------------
	function checkField($value,$field){
		$query = $this->db->query('SELECT `id` from mako_userTable  WHERE '.$value.'="'.$field.'"');
		if( $query->num_rows() > 0 ){
			return TRUE;
		}
		else{
			$query = $this->db->query('SELECT `id` from mako_Costumers  WHERE '.$value.'="'.$field.'"');
			if( $query->num_rows() > 0 ){
				return TRUE;
			}
			else return FALSE;
		}
	}
//---------------------------------------------------
	function checkPromo($promo){
		$query = $this->db->query('SELECT `id` from mako_userTable  WHERE myPromo ="'.$promo.'"');
		if( $query->num_rows() > 0 ){
			return FALSE;
		}
		else{
			$query = $this->db->query('SELECT `id` from mako_Costumers  WHERE myPromo ="'.$promo.'"');
		    if( $query->num_rows() > 0 ){
				return FALSE;
			}	
			else{
				return TRUE;
			}
		}
		
	}	
//---------------------------------------------------
	function create_member($data,$check){
		
				
		if(!$check){
			
			//var_dump($data);
			//die();
			unset($data['city']); 
			unset($data['tarif']); 
			
			$this->db->insert('mako_Costumers', $data);	
			
		}
		else{
			unset($data['userPromo']);
			$data['limit'] = 100;
			$this->db->insert('mako_userTable', $data);	
		}
			
	}
//---------------------------------------------------
	function validate(){
		
		$email = $this->input->post('email');
		$username = $this->input->post('username');
		
		if( $email=='' ){
			$login = $this->input->post('username');
		}
		else{
			$login = $this->input->post('email');
		}
		
		
		//var_dump('SELECT * from mako_userTable  WHERE email="'.$login.'" and password ="'.md5($this->input->post('password')).'"');
		
		$query = $this->db->query('SELECT * from mako_userTable  WHERE email="'.$login.'" and password ="'.md5($this->input->post('password')).'"');
		
		if( $query->num_rows() > 0 ){
			
			return 1;
			
		}
		else{
			$query = $this->db->query('SELECT * from mako_Costumers  WHERE email="'.$login.'" and password ="'.md5($this->input->post('password')).'"');
			if( $query->num_rows() > 0 ){
			
				return 2;
				
			}
			else{
				return false;
			}
		}
	}
//---------------------------------------------------
	function getParamByType($id,$type){
		$query = $this->db->get_where('mako_ParamsTable',array('contentId'=>$id,'type'=>$type));
		$row = $query->result_array();
		
		if( $query->num_rows() > 0 ){ return $row[0]['value']; }
	}	
	
	function getAllParamByType($id,$type){
		$query = $this->db->get_where('mako_ParamsTable',array('contentId'=>$id,'type'=>$type));
		//$row = $query->result_array();
		
		if( $query->num_rows() > 0 ){ 
			$i = 0;
			foreach($query->result_array() as $row){
				$arr[$i] = $row;
				$i++;
			}
			
			return $arr; 
		}
	}
	
//---------------------------------------------------
	function getRoomById($id){
		$query = $this->db->get_where('mako_ContentTable',array('id'=>$id));
		$row = $query->result_array();
		$indexedOnly = array();
		$data = $this->getWorkTime($id);
		
		//arsort($data);
		//var_dump($data);
		
		$row[0]['genre'] = $this->getAllParamByType($id,10);
		$row[0]['type'] = $this->getAllParamByType($id,11);
		$row[0]['dif'] = $this->getAllParamByType($id,3);
		
		$row[0]['cost'] = $this->getParamByType($id,1);
		$row[0]['ListTime'] = json_encode($data);
		$row[0]['value'] = html_entity_decode($row[0]['value'],ENT_QUOTES, 'UTF-8') ;
		
		$row[0]['attach'] = json_decode($row[0]['attach'],true);
		return $row[0];
	}
//---------------------------------------------------
	function getRoomsById($id){
		$query = $this->db->query('SELECT * from mako_ContentTable WHERE userId="'.$id.'"');
		foreach ($query->result() as $row){
			switch($row->active){
				case 0: 
					$row->active = 'неактивен';
				break;
				case 1: 
					$row->active = 'активен';
				break;
			}
			$row->city = $this->getCityByParent($id);
			$row->value = htmlspecialchars_decode($row->value);
			///$row['value'] = htmlspecialchars_decode($row['value']);
		}
		return $query->result_array();
	}	
//---------------------------------------------------
	function getOrdersById($id){
		$query = $this->db->query('SELECT * from mako_Orders WHERE userId="'.$id.'" and status <> 3 order by date DESC,status');
		foreach ($query->result() as $row){
			$date = date_create($row->date);
			$row->date = date_format($date,'d.m.Y H:i:s');
			$row->status = $this->getActionById($row->status,'mako_OrderNames');
			//$row->userId = $this->getUserPhoneById($row->userId,'mako_OrderNames');
		}
		return $query->result_array();
	}	
//---------------------------------------------------
	function getUserPhoneById($id){
		$query = $this->db->query('SELECT `phone` from mako_Costumers WHERE id="'.$id.'"');
		$row = $query->result_array();
		return $row[0]['phone'];
	}
	
	function getUserEmailById($id,$table){
		$query = $this->db->query('SELECT `email` from '.$table.' WHERE id="'.$id.'"');
		$row = $query->result_array();
		return $row[0]['email'];
	}
	
	function getUserNameById($id){
		$query = $this->db->query('SELECT `name` from mako_userTable WHERE id="'.$id.'"');
		$row = $query->result_array();
		return $row[0]['name'];
	}	
//---------------------------------------------------
	function getActionById($id,$table){
		$query = $this->db->query('SELECT `value` from '.$table.' WHERE id="'.$id.'"');
		$row = $query->result_array();
		return $row[0]['value'];
	}
//---------------------------------------------------
	function getTransactionsById($id){
		$query = $this->db->query('SELECT * from mako_Transactions WHERE userId="'.$id.'" and active = 1 order by action');
		foreach ($query->result() as $row){
			$date = date_create($row->dateTime);
			$row->dateTime = date_format($date,'d.m.Y H:i:s');
			$row->action = $this->getActionById($row->action,'mako_TransactionsNames');
		}
		return $query->result_array();
	}	
//---------------------------------------------------
	
//---------------------------------------------------
	function getDataByEmail(){
		switch($this->session->userdata('user_type')){
			case '1':
				$query = $this->db->query('SELECT * from mako_userTable  WHERE email="'.$this->session->userdata('user_name').'"');
			break;
			
			case '2':
				$query = $this->db->query('SELECT * from mako_Costumers  WHERE email="'.$this->session->userdata('user_name').'"');
			break;
		}
		//var_dump($this->session->userdata('user_type'));
		return $query->result_array();
	}
//----------------------------------------------------
	function getCityById($id){
		
		switch($id){
			case '1':
				return 'Екатеринбург';
			break;
		}
		
	}
//-----------------------------------------------------
	function getPromoById($id){
		
		switch($this->session->userdata('user_type')){
			case '1':
				$query = $this->db->query('SELECT myPromo from mako_userTable  WHERE email="'.$this->session->userdata('user_name').'"');
			break;
			
			case '2':
				$query = $this->db->query('SELECT myPromo from mako_Costumers  WHERE email="'.$this->session->userdata('user_name').'"');
			break;
		}
	
		$row = $query->result_array();
		return $row[0]['myPromo'];
	
	}	
//------------------------------------------------------
	function getRefsByPromo($promo){
		$query = $this->db->query('SELECT * from mako_Costumers  WHERE userPromo <> "" and userPromo="'.$promo.'"');
		return $query->result_array();
	}	
//------------------------------------------------------	
	function updatePromo($data){
		switch($data['userType']){
			case 1:
				$table = 'mako_userTable';
			break;
			
			case 2:
				$table = 'mako_Costumers';
			break;
		}
		$query = $this->db->query('update `'.$table.'` set myPromo = "'.$data['promo'].'" where id = "'.$data['userId'].'"');
	}
//------------------------------------------------------
	function getRealBalanceById($id){
		$query = $this->db->query('SELECT * from mako_Transactions  WHERE userId="'.$id.'" and ( action = 1 or action = 2) and active=1');
		$summ = 0;	
		foreach ($query->result_array() as $row){
			//var_dump($row);
			if($row['action']==1){
				$summ+=$row['count'];
			}
			else{
				$summ-=$row['count'];
			}
		}
		
		return $summ;
	}	
//------------------------------------------------------
	function sendMail($to, $subj, $content){
	
		$mailTemplate='<table cellpadding="5" cellspacing="0" width="800" align="center" style="border-collapse:collapse; font-family: Arial,serif;">
<tr>
	<td style="background-color: #1b8f62;">
		<img src="http://questura.ru/frontend/header/images/questuralogo.png" />
	</td>
</tr> 
<tr>
	<td>
		<h1>Портал Questura.ru с сообщает</h1>
	</td>
</tr>
<tr>
	<td>
		{{content}}
	</td>
</tr>

<tr>
	<td>
		<hr>
		<p>с уважением команда <a style="color: #1b8f62" href="http://questura.ru">Questura.ru</a></p>
		<p>давайте дружить: <a style="color: #1b8f62" href="http://vk.com/questura">Мы ВКонтакте</a> :: <a style="color: #1b8f62" href="https://instagram.com/questura.ru/">Мы в Instagramm</a></p>
	</td>
</tr>
</table>
';
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);	
		$this->email->clear();
		$this->email->to($to);
        $this->email->from('ekb@questura.ru',"Портал Questura.ru");
        $this->email->subject($subj);
        $saleMessage = str_replace('{{content}}', $content, $mailTemplate);
        $this->email->message($saleMessage);
        $this->email->send();

	}
//------------------------------------------------------
	function transactionPattern( $id, $actionIn, $actionOut, $math ){
		$query = $this->db->query('SELECT * from mako_Transactions  WHERE orderId="'.$id.'" and action = "'.$actionIn.'" and active=1');
		foreach($query->result_array() as $row){
			$updateData = array('active'=>0);
			$this->db->where('id', $row['id']);			  
			$this->db->update('mako_Transactions', $updateData);
			$insertData = array('active'=>1,
								'action'=>$actionOut,
								'whois'=>$row['whois'],
								'count'=>$row['count'], 
								'dateTime'=>date('Y-m-d H:i:s'),
								'orderId'=>$row['orderId'],
								'userId'=>$row['userId'] );
			$this->db->insert('mako_Transactions', $insertData);
			switch($row['whois']){
				case '0':
					$table = 'mako_userTable';
				break;
				
				case '1':
					$table = 'mako_Costumers';
				break;
			}
			$to = $this->getUserEmailById($row['userId'],$table);
			$query = $this->db->query('SELECT `balance` from `'.$table.'`  WHERE id="'.$row['userId'].'"');
			 
			if( $query->num_rows() > 0 ){
			$rowWhois = $query->result_array();
			switch($math){
				case 'minus':
					$newBalance = $rowWhois[0]['balance'] - $row['count'];
					$subj = 'С вашего счета списана комиссия';
					$content = '<p>С вашего счета списана комиссия за покупателя (300 рублей)</p>';
				break;
				
				case 'plus':
					$newBalance = $rowWhois[0]['balance'] + $row['count'];
					$subj = 'Ваш баланс пополнился';
					$content = '<p>Ваш баланс пополнился на 100 рублей</p>';
				break;
			}
			$this->sendMail($to, $subj, $content);
			$updateBalance = array('balance'=>$newBalance);	
			$this->db->where('id', $row['userId']);	
			$this->db->update($table, $updateBalance);
			}
		}
		//return 1;
	}
//------------------------------------------------------	
	function delTransaction($id,$comment){
		$query = $this->db->query('SELECT * from mako_Transactions  WHERE orderId="'.$id.'" and   active=1');
		//var_dump('SELECT * from mako_Transactions  WHERE orderId="'.$id.'" and  and active=1');
		
		foreach($query->result_array() as $row){
			if($row['action']==1) { $user = $row['userId']; }
			$updateData = array('active'=>0);
			$this->db->where('id', $row['id']);			  
			$this->db->update('mako_Transactions', $updateData);
		}
		$name = $this->getUserNameById($user);
		
		$content = 'Квеструм '.$name.' отменил бронь по причине "'.$comment.'"';
		$subj = 'Отмена брони квеструмом '.$name.'';
		$this->sendMail('ekb@questura.ru', $subj, $content);
		
		$updateOrder = array('status'=>'3',	
							 'comment'=>$comment);
		$this->db->where('id', $id);						 
		$this->db->update('mako_Orders', $updateOrder);
		//return 1;
	}
//------------------------------------------------------	
	function proceedTransaction($id){
		/*start of displace procedure*/
		$this->transactionPattern( $id, 1, 4, 'minus' );
		/*end of displace procedure*/
		
		/*start of apply procedure*/
		$this->transactionPattern( $id, 2, 3, 'plus' );
		/*end of apply procedure*/
		
		$updateOrder = array('status'=>'2');
		$this->db->where('id', $id);
		$this->db->update('mako_Orders', $updateOrder);
		
	}	
//------------------------------------------------------
}	
?>