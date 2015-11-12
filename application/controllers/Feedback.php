<?
class Feedback extends CI_Controller {
	public function __construct() {
           parent::__construct();
                      
           $this->load->model('model_feedback');
    }
    
    
    public function index($city=false) {
    	$this->load->library('geo');
		$data['allCity'] = $this->geo->getAllCity();
		$cityInfo = $this->geo->getCityIdByName($city);
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_exist'] = $cityInfo['name'];
		
		$data['siteRoot'] = '';
		$data['base_url'] = '/'.$city.'/'; 
		
    	$data['city'] = $city;
		if(!$this->session->userdata('city')){
			$this->session->set_userdata('city',$city);
		}
		$idsArray = $this->model_feedback->getUsersByCity($cityInfo['id_region']);
		
		
		if(is_array($idsArray)){
			$ids = implode(' , ', $idsArray);
			
			//var_dump($ids);
			$data['comments'] = $this->model_feedback->getFeedByUsers($ids);
		}
		
		
		$data['addonFiles'] = '';
		$data['addonScripts'] = '<script type="text/javascript" src="/alfa/assets/js/jquery.raty.min.js"></script>';
			$data['city_name_pp'] = $cityInfo['name_pp'];
			$data['newPos'] = $this->getNewPositions();
			$this->load->view('header', $data);
			$this->load->view('feedbackView', $data);
			$this->load->view('footer_mini');              
    }

}
?>