<?
class Model_callmanager extends CI_Model{
		
	function __construct(){
		parent::__construct();
	}
//-------------------------------------------------
	function insertOrder($data){
		
		$debug['value'] = '
		Звонил: '.$data['caller_id'].'<br>
		Принимал: '.$data['called_did'].'<br>
		Дата: '.$data['callstart'].'<br>
		';
		$this->db->insert('mako_Debug', $debug);
	
		
		$questroomData= $this->getQuestroomDataByPhone($data['called_did']);
		$callerData = $this->getCostumerDataByPhone($data['caller_id'],$questroomData['myPromo']);
		$checkReferal = $this->checkReferal($callerData['userPromo']);
		
		$orderData['contentId'] = 0;
		$orderData['userId'] = $questroomData['id'];
		$orderData['date'] = $data['callstart'];
		$orderData['status'] = 1;
		$orderData['costumer'] = $data['caller_id'];
		
		
		$this->db->insert('mako_Orders', $orderData);
		$orderId = $this->getOrderIdByData($orderData);
		//транзакция заморозки суммы на счету квеструма
		$transactionData['action'] = 1;
		$transactionData['active'] = 1; 
		$transactionData['count'] = 300;
		$transactionData['dateTime'] = $data['callstart'];
		$transactionData['orderId'] = $orderId;
		$transactionData['userId'] =  $questroomData['id'];
		$transactionData['whois'] = 0;
		$this->db->insert('mako_Transactions', $transactionData);
		
		//транзакция постановки в очериедь суммы на счет покупателя
		$transactionData['action'] = 2;
		$transactionData['active'] = 1; 
		$transactionData['count'] = 100;
		$transactionData['dateTime'] = $data['callstart'];
		$transactionData['orderId'] = $orderId;
		$transactionData['userId'] =  $callerData['id'];
		$transactionData['whois'] = 1;
		$this->db->insert('mako_Transactions', $transactionData);
		
		if($questroomData['id']!=$checkReferal[0]['id'] && $checkReferal){
			
			//транзакция постановки в очериедь суммы на счет реферала
			$transactionData['action'] = 2;
			$transactionData['active'] = 1; 
			$transactionData['count'] = 100;
			$transactionData['dateTime'] = $data['callstart'];
			$transactionData['orderId'] = $orderId;
			$transactionData['userId'] =  $checkReferal[0]['id'];
			$transactionData['whois'] = $checkReferal[0]['whois'];
			$this->db->insert('mako_Transactions', $transactionData);
			
		}
		
		
	}
//-------------------------------------------------
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
//-------------------------------------------------	
	function getOrderIdByData($orderData){
		$query = $this->db->query('SELECT id from mako_Orders WHERE contentId="'.$orderData['contentId'].'" and  userId = "'.$orderData['userId'].'" and date="'.$orderData['date'].'" and status ="'.$orderData['status'].'"');
		
		$row = $query->result_array();
		return $row[0]['id'];
	}
//-------------------------------------------------
	function getQuestroomDataByPhone($phone){
		$query = $this->db->query('SELECT * from mako_userTable WHERE phoneID="'.$phone.'"');
		$row = $query->result_array();
		return $row[0];
	}
//-------------------------------------------------
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
//-------------------------------------------------		
}
?>