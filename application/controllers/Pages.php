<?
class pages extends CI_controller{
//----------------------------------------------
	public function __construct() {
           parent::__construct();
           $this->load->model('model_pages');
           
    } 
//----------------------------------------------
	public function index($page,$city=null){
		//var_dump($city);
		if($this->session->userdata('city')==''){
			include($_SERVER['DOCUMENT_ROOT']."/geo/SxGeo.php");
			$SxGeo = new SxGeo($_SERVER['DOCUMENT_ROOT'].'/geo/SxGeoCity.dat');
			$ip = $_SERVER['REMOTE_ADDR'];
			$cityByIp = $SxGeo->getCityFull($ip);
			$city = $cityByIp['city'];
			$this->load->library('geo');
			$cityInfo = $this->geo->getCityIdByRussianName($city['name_ru']);
		}
		else{
			$cityBySlug = $this->model_pages->getCityIdBySlug($this->session->userdata('city'));
			$cityInfo = $this->model_pages->getCityInfoById($cityBySlug);
			$city = $cityInfo['slug'];
			
			
			
		}
		//var_dump($cityByIp);
		
		
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_exist'] = $cityInfo['name'];
		$data['city'] = $city;
		$data['city_name_pp'] = $cityInfo['name_pp'];
		$data['newPos'] = $this->getNewPositions();
		//var_dump($this->session->userdata());
		
	
		$data['siteRoot'] = '/';
		$data['base_url'] = '/'.$city.'/'; 
		$data['addonFiles'] = '<link href="'.$data['siteRoot'].'/frontend/qroomblock/css/modal.css" rel="stylesheet">';
		$data['addonScripts'] = '';
		$data['page'] = $this->model_pages->getPageByUrl($page);
		//$data['page'] = str_replace('*nic*', , );
		if($page=='megaquest'){
		$name = '';
		
		if($this->session->userdata('user_name')!=""){
			switch($this->session->userdata('user_type')){
				case 2:	
					$table = 'mako_Costumers';	
				break;
				
				case 1:
					$table = 'mako_userTable';
				break;	
			}
			$name = $this->model_pages->getUserNameByEmail($table,$this->session->userdata('user_name'));
			$data['page'] = str_replace('*nic*', $name, $data['page']);
			
		}
		//var_dump($name);
		$data['description'] = "Я на квестура – ".$name.". Хочу участвовать в Мегаквесте Екабу. Поддержи меня лайком! #мегаквестекабу";
		}
		//var_dump($this->session->userdata());
		
		$this->load->view('header', $data);
		$this->load->view('pageView', $data);
		$this->load->view('footer');
	}
}
?>