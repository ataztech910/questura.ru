<?
class Callmanager extends CI_Controller {
	
	public function __construct() {
           parent::__construct();
    	   $this->load->model('model_callmanager');       
    } 

	
	function check(){
		
		if (isset($_GET['zd_echo'])) exit($_GET['zd_echo']);
		
		if($_REQUEST) {
			/*
				
				caller_id - номер звонящего;
				called_did – номер, на который позвонили;
				callstart – время начала звонка
				
			*/
			
			$data['caller_id'] = $_REQUEST['caller_id'];
			$data['called_did'] = $_REQUEST['called_did'];
			$data['callstart'] = date('Y-m-d H:i:s');//$_REQUEST['callstart'];
			
			$this->model_callmanager->insertOrder($data);
			
		}
				
		
		
	}
}
?>