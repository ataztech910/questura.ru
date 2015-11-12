<?
class Model_order extends CI_Model{
		
	function __construct(){
		parent::__construct();
	}
		
//--------------------------------------------------
	function getEmailByRoom($roomId){
		
		$query = $this->db->query('SELECT userId FROM mako_ContentTable where id = "'.$roomId.'"');
		$row = $query->row_array();
		
		$queryUser = $this->db->query('SELECT email FROM mako_userTable where id = "'.$row['userId'].'"');
		$rowUser = $queryUser->row_array();
		
		
		return $rowUser['email'];
		
	}	
//---------------------------------------------------
	function checkUser($userEmail, $userPhone){
		
		$userPhone = str_replace('-', '', $userPhone);
		$userPhone = str_replace(' ', '', $userPhone);
		$userPhone = trim($userPhone);
	
		$query = $this->db->query('SELECT id FROM mako_Costumers where email = "'.$userEmail.'" OR phone = "7'.$userPhone.'"');
		
		$row = $query->row_array();
		//var_dump($row);
		
		return $row['id'];
	}
//---------------------------------------------------
	function getRoomNameByRoom($roomId){
		$query = $this->db->query('SELECT `value` FROM mako_ContentTable where id = "'.$roomId.'"');
		$row = $query->row_array();
		return $row['value'];
	}
//---------------------------------------------------
function getOrderIdByData($orderData){
		$query = $this->db->query('SELECT id from mako_Orders WHERE contentId="'.$orderData['contentId'].'" and  userId = "'.$orderData['userId'].'" and date="'.$orderData['date'].'" and status ="'.$orderData['status'].'"');
		
		$row = $query->result_array();
		return $row[0]['id'];
}
//----------------------------------------------------	
	function getQuestroomDataById($id){
		$query = $this->db->query('SELECT * from mako_userTable WHERE id="'.$id.'"');
		$row = $query->result_array();
		return $row[0];
	}
//----------------------------------------------------
	function getCostumerDataByPhone($phone,$referalCode){
		$query = $this->db->query('SELECT * from mako_Costumers WHERE phone="'.$phone.'"');
		if( $query->num_rows() > 0 ){
			$row = $query->result_array();
		}
		else{
			$insertData['userPromo'] = $referalCode;
			$insertData['phone'] = $phone;
			$insertData['active'] = 1;
			
			$this->db->insert('mako_Costumers', $insertData);
			
			$query = $this->db->query('SELECT * from mako_Costumers WHERE phone="'.$phone.'"');
			$row = $query->result_array();
			
		}
		return $row[0];
	}	
//----------------------------------------------------
	function checkReferal($promo){
		if(trim($promo)!=''){
			$query = $this->db->query('SELECT id from mako_userTable WHERE myPromo="'.$promo.'"');
			if( $query->num_rows() > 0 ){
				$row = $query->result_array();
				$row[0]['whois'] = 0;
				return $row;
			}	
			else{
				$query = $this->db->query('SELECT id from mako_Costumers WHERE myPromo="'.$promo.'"');
				if( $query->num_rows() > 0 ){
					$row = $query->result_array();
					$row[0]['whois'] = 1;
					return $row;
				}	
				else {
					return false;
				}
			}
		}
		else{
			return false;
		}
	}
//----------------------------------------------------	
	function insertOrder($data){
		
		/*
		$data['contentId']
		$data['date'] 
		$data['comment']
		$data['status'] = 1;
		$data['costumer'] 
		$data['userId']
		*/
		$email = $data['email'];
		unset($data['email']);
		$questroomData= $this->getQuestroomDataById($data['userId']);
		$callerData = $this->getCostumerDataByPhone($data['costumer'],$questroomData['myPromo']);
		
		if($callerData['userPromo']!=''){
			$checkReferal = $this->checkReferal($callerData['userPromo']);
		}
		else{
			$checkReferal = false;
		}
		$this->load->library('email');
		$mailTemplate='<table cellpadding="5" cellspacing="0" width="800" align="center" style="border-collapse:collapse; font-family: Arial,serif;">
<tr>
	<td style="background-color: #1b8f62;">
		<img src="http://questura.ru/frontend/header/images/questuralogo.png" />
	</td>
</tr> 
<tr>
	<td>
		<h1>Портал Questura.ru с радостью сообщает</h1>
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

	$checkTarif = $this->getTarifByRoom($data['contentId']);

		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		if($checkTarif>0){
		$this->db->insert('mako_Orders', $data);
		$orderId = $this->getOrderIdByData($data);
		//транзакция заморозки суммы на счету квеструма
		$transactionData['action'] = 1;
		$transactionData['active'] = 1; 
		$transactionData['count'] = 300;
		$transactionData['dateTime'] = $data['date'];
		$transactionData['orderId'] = $orderId;
		$transactionData['userId'] =  $questroomData['id'];
		$transactionData['whois'] = 0;
		$this->db->insert('mako_Transactions', $transactionData);
		} 
		//отправка письма квеструму и квестуре о новом заказе
		$this->email->clear();
		$this->email->to($questroomData['email']);
        $this->email->from('ekb@questura.ru',"Портал Questura.ru");
        $this->email->subject('Новый заказ с сайта Questura.ru для '.$questroomData['name']);
        
        $sale = '<p>Вам поступил новый заказ:</p>
		<p>Дата/Время: <b>'.$data['date'].'</b></p>
		<p>Телефон: <b>+'.$data['costumer'].'</b></p>
		<p>E-mail: <b>'.$email.'</b></p>
		<p>Комментарий: <b>'.$data['comment'].'</b></p>
		<p>Комната: <b>'.$this->getRoomNameByRoom($data['contentId']).'</b></p>';
        
        $saleMessage = str_replace('{{content}}', $sale, $mailTemplate);
        $this->email->message($saleMessage);
        $this->email->send();
        
        
		$this->email->clear();
		$this->email->to('ekb@questura.ru');
		
        $this->email->from('ekb@questura.ru',"Портал Questura.ru");
        $this->email->subject('Новый заказ с сайта Questura.ru для '.$questroomData['name']);
        
        $sale = '<p>Поступил новый заказ:</p>
		<p>Дата/Время: <b>'.$data['date'].'</b></p>
		<p>Телефон: <b>+'.$data['costumer'].'</b></p>
		<p>E-mail: <b>'.$email.'</b></p>
		<p>Комментарий: <b>'.$data['comment'].'</b></p>
		<p>Комната: <b>'.$this->getRoomNameByRoom($data['contentId']).'</b></p>';
        
        $saleMessage = str_replace('{{content}}', $sale, $mailTemplate);
        $this->email->message($saleMessage);
        $this->email->send();
		
		if($checkTarif>0){
		//транзакция постановки в очериедь суммы на счет покупателя
		$transactionData['action'] = 2;
		$transactionData['active'] = 1; 
		$transactionData['count'] = 100;
		$transactionData['dateTime'] = $data['date'];
		$transactionData['orderId'] = $orderId;
		$transactionData['userId'] =  $callerData['id'];
		$transactionData['whois'] = 1;
		$this->db->insert('mako_Transactions', $transactionData);
		}
		//письмо клиенту о возможном получении бонуса 
		$this->email->clear();
		$this->email->to($email);
        $this->email->from('ekb@questura.ru',"Портал Questura.ru");
        $this->email->subject('Ваш бонус с сайта Questura.ru для '.$questroomData['name']);
        
        $toClient = '<p>Вы совершили новый заказ:</p>
		<p>Дата/Время: <b>'.$data['date'].'</b></p>
		<p>Телефон: <b>+'.$data['costumer'].'</b></p>
		<p>E-mail: <b>'.$email.'</b></p>
		<p>Комментарий: <b>'.$data['comment'].'</b></p>
		<p>Комната: <b>'.$this->getRoomNameByRoom($data['contentId']).'</b></p>
		<p>Для получения бонуса - после прохождения квеста уточните о завершении сделки у владельца квеструма</p>';
        
        $saleMessage = str_replace('{{content}}', $toClient, $mailTemplate);
        $this->email->message($saleMessage);
        $this->email->send();
		
		
		if($checkTarif>0){
		if(is_array($checkReferal)){
			if($questroomData['id']!=$checkReferal[0]['id']){
				//транзакция постановки в очериедь суммы на счет реферала
				$transactionData['action'] = 2;
				$transactionData['active'] = 1; 
				$transactionData['count'] = 100;
				$transactionData['dateTime'] = $data['date'];
				$transactionData['orderId'] = $orderId;
				$transactionData['userId'] =  $checkReferal[0]['id'];
				$transactionData['whois'] = $checkReferal[0]['whois'];
				$this->db->insert('mako_Transactions', $transactionData);
				
				//письмо мастеру-реферала о возможном получении бонуса 
				$this->email->clear();
				$this->email->to($callerData['email']);
		        $this->email->from('ekb@questura.ru',"Портал Questura.ru");
		        $this->email->subject('Реферал совершил бронь с сайта Questura.ru у '.$questroomData['name']);
		        
		        $toClient = '<p>Ваш реферал забронировал квест:</p>
				<p>Дата/Время: <b>'.$data['date'].'</b></p>
				<p>Телефон: <b>+'.$data['costumer'].'</b></p>
				<p>E-mail: <b>'.$email.'</b></p>
				<p>Комментарий: <b>'.$data['comment'].'</b></p>
				<p>Комната: <b>'.$this->getRoomNameByRoom($data['contentId']).'</b></p>
				<p>Если сделка совершиться - бонус придет на ваш счет</p>';
		        
		        $saleMessage = str_replace('{{content}}', $toClient, $mailTemplate);
		        $this->email->message($saleMessage);
		        $this->email->send();
			}
		}
		}
		
		return 'done';//$this->db->insert('mako_Orders', $data);
		
	}
//---------------------------------------------------
//---------------------------------------------------
	function insertUser($email,$phone){
		$data['phone'] = '7'.$phone;
		$data['email'] = $email;
		$data['password'] = $this->generatePassword(5);
		$this->db->insert('mako_Costumers', $data);
		$row = $this->checkUser($data['email'], $data['phone']);
		return $row;
	}	
//---------------------------------------------------
	function getRoomFatherById($roomId){
		$query = $this->db->query('SELECT `userId` FROM mako_ContentTable where id = "'.$roomId.'"');
		
		$row = $query->row_array();
		
		return $row['userId'];
	}	
//---------------------------------------------------	
}
?>