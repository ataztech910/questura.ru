<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Cityselect extends CI_Controller {
	
	public function __construct() {
           parent::__construct();
            $this->load->model('model_cityselect');
    }
	
	function index($city=''){
		
		$data['allCity'] = $this->model_cityselect->getAllCity();
		$cityInfo = $this->model_cityselect->getCityIdByName($city);
	
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_exist'] = $cityInfo['name'];
		$data['title'] = 'Questura - все квесты '.$data['city_name'];
		$data['city'] = $city;
		$data['base_url'] = '/'.$city.'/';
		
		//var_dump($data['rooms']);
		$data['addonFiles'] = '';
		$data['addonScripts'] = '';
		
		$this->load->view('header', $data);
		$this->load->view('cityselectView', $data);
		$this->load->view('footer_mini');
	
	}
	
}	
?>