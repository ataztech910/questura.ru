<?
class Tarifs extends CI_Controller {
	
	public function __construct() {
           parent::__construct();
           $this->load->model('model_quest');
    }
//------------------------------------------------------    
    function index(){
	    
	    
	    $city = $this->session->userdata('city');
	    
	    $this->load->library('geo');
		$data['allCity'] = $this->geo->getAllCity();
		$cityInfo = $this->geo->getCityIdByName($city);
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_exist'] = $cityInfo['name'];
		
	    $data['siteRoot'] = '';
		$data['base_url'] = '/'.$city.'/'; 
	    $data['city'] = $city;
	   
	    $data['addonScripts'] = '';
	    $data['addonFiles'] = '';
	    
	    $this->load->view('header', $data);
		$this->load->view('tarifView', $data);
		$this->load->view('footer_mini');
	    
    }
    
    
    
}	
?>