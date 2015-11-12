<?
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends CI_Controller {
	
public function __construct() {
           parent::__construct();
           $this->load->model('model_order');
}
//------------------------------------------------------------------	

function makePhoneNormal($phone){
	
	$phone = str_replace("+", "", $phone);
	$phone = str_replace(" ", "", $phone);
	$phone = str_replace("(", "", $phone);
	$phone = str_replace(")", "", $phone);
	$phone = str_replace("-", "", $phone);
	
	return $phone;
	
}

//------------------------------------------------------------------	
public function index(){
		
		$roomId = htmlspecialchars( $_GET['roomId'] );
		$dateTime = htmlspecialchars( $_GET['dateTime'] );
		$userEmail = htmlspecialchars( $_GET['userEmail'] );
		$userPhone = htmlspecialchars( $_GET['userPhone'] );
		$orderDate = htmlspecialchars( $_GET['orderDate'] );
		$orderTime = htmlspecialchars( $_GET['orderTime'] );
		
		
		$userPhone = $this->makePhoneNormal($userPhone);
		
		
		$data['contentId'] = $roomId;
		$data['date'] = date('Y-m-d H:i:s');//
		$data['comment'] = $dateTime;
		$data['status'] = 1;
		$data['realDate'] = $orderDate;
		$data['realTime'] = $orderTime;

		$data['costumer'] = $this->model_order->checkUser($userEmail, $userPhone);
		$data['userId'] = $this->model_order->getRoomFatherById($roomId);
		
		if(!$data['costumer']){
			//start insart user
			$data['costumer'] = $this->model_order->insertUser($userEmail, $userPhone);
			//start insert order
			echo 'Insert data is - '.$data['costumer'];
		}
		else {
			echo 'Select data is - '.$data['costumer'];
		}
		
		$data['costumer'] = $userPhone;
		$data['email'] = $userEmail;
		
		$this->model_order->insertOrder($data);
		
		
}
//------------------------------------------------------------------
public function alertAdmin($roomId, $dateTime,$userData){
	
	$roomName = $this->model_order->getRoomNameByRoom($roomId);
	$email = $this->model_order->getEmailByRoom($roomId);
	$html = '<h1>Регистрация на '.$dateTime.'</h1>
			 <div>Комната: '.$roomName.' </div>
			 <div>Данные пользователя: '.$userData.' </div>';
	
	$to  = $email; 
	$subject = "Новая заявка с портала QUESTURA.RU"; 
	
	$message = ' 
	<html> 
	    <head> 
	        <title>Новая заявка с портала QUESTURA.RU</title> 
	    </head> 
	    <body> 
	        <p>
	        '.$html.'
	        </p> 
	    </body> 
	</html>'; 
	
	$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
	$headers .= "From: Birthday Reminder <info@questura.ru>\r\n"; 
	mail($to, $subject, $message, $headers); 
		
}
	
}
?>