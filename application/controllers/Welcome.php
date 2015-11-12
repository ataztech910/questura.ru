<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	private $onPage = 6; 
	
	public function __construct() {
           parent::__construct();
           $this->load->model('model_welcome');
           
    }
//----------------------------------------------------------------------------
	public function loadmore(){
		$loaded = json_decode(file_get_contents('php://input'),true);
		$data = '';
		$idsArray = $this->model_welcome->getUsersByCity($_REQUEST['cityId']);
		if(is_array($idsArray)){
			$ids = implode(' , ', $idsArray);
			$data['rooms'] = $this->model_welcome->getRoomsByUsers($ids,$_REQUEST['loaded']);
		}else{
			$data['rooms'] = array();
		}
		
		
		
		$data['roomsCount'] = $this->model_welcome->getCountRoomsByUsers($ids,$_REQUEST['loaded']);
		
		
		
		//var_dump($data);
		
		if(20 > $data['roomsCount']){
			$echo['roomsCount'] = false;
		}
		else{
			
		}
		foreach($data['rooms'] as $dr){
			$loaded[] = $dr['id'];
		}
		$loadedStr = implode(',',$loaded);
		
		$data['curLoaded'] = $_REQUEST['loaded'];
		$data['city'] = $_REQUEST['cityId'];
		
		$echo['html'] = $this->load->view('showMoreView', $data,TRUE);
		$echo['ids'] = $loadedStr;
		$echo['roomsCount']	 = $data['roomsCount'];
		 
		echo json_encode($echo);
		//var_dump($_REQUEST);
		//echo $loaded;
	}
//----------------------------------------------------------------------------	
	public function index($city=false,$page=1,$sort="rating",$filter=null)
	{
		//var_dump($_GET);
		
		$data['sort'] = $sort;
		if($sort=="costASC"){
			$sort = "cost ASC";
		}
		if($sort == "costDESC"){
			$sort = "cost DESC";
		}
		
		$cityCheck = $this->model_welcome->checkCity($city);
		if(!$cityCheck){
			$this->session->set_userdata('city', '');
			show_404();
			die();
		}
		
		
		if(isset($_GET['ref'])){
			$this->session->set_userdata('ref', $_GET['ref']);
		}
		
	
		
		if(!$city){
			//var_dump($this->session->userdata('city'));
			if($this->session->userdata('city')){
				$city = $this->session->userdata('city');
			}
			//redirect('/ekb/', 'refresh');
		}
		
		if ( ! file_exists($city.'/')){ 
			$city = $city;//$this->city = $this->session->userdata('city'); 
		}
		
		
		$this->session->set_userdata('city', '');
		include($_SERVER['DOCUMENT_ROOT']."/geo/SxGeo.php");
		$SxGeo = new SxGeo($_SERVER['DOCUMENT_ROOT'].'/geo/SxGeoCity.dat');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		
		if($this->session->userdata('city') == 'uploads'){
			$this->session->set_userdata('city', '');
			$city = '';
		}
		
		//var_dump($city, $this->session->userdata('city'));
		
		$cityByIp = $SxGeo->getCityFull($ip);
		//var_dump($cityByIp);
		//var_dump($cityByIp);
		$slug = $this->model_welcome->getSlugByName($cityByIp['city']['name_ru']); 
		if($slug['name']==''){
			$slug['name'] = 'Москва';
			$slug['slug'] = 'moscow';
		}
		elseif(!$slug){
			$slug['name'] = 'Москва';
			$slug['slug'] = 'moscow';
		}
		//$slug['name'] = 'Москва';
		//$slug['slug'] = 'moscow';
		
		$data['mayBeCity'] = $slug;
		$this->load->library('geo');
		$data['allCity'] = $this->geo->getAllCity();
		$cityInfo = $this->geo->getCityIdByName($city);
		$this->session->set_userdata('city', $city);
		if(!$city){
			$city = $cityInfo['slug'];
		}
		else{
			$data['title'] = "Квесты в реальности ".$cityInfo['name_pp']." - Questura.ru";
		}
		//var_dump($city,$cityInfo);
		//var_dump($city, $this->session->userdata('city'));
		//var_dump($cityInfo);
		
		
		//var_dump($page);
		
		$idsArray = $this->model_welcome->getUsersByCity($cityInfo['id_region']);
		
		if(is_array($idsArray)){
			$ids = implode(' , ', $idsArray);
			$data['rooms'] = $this->model_welcome->getRoomsByUsers($ids,null,$page,$sort,$filter);
		}else{
			$ids = '';
			$data['rooms'] = array();
		}
		$data['roomsCount'] = $this->model_welcome->getCountRoomsByUsers($ids);
		$data['AllroomsCount'] = $this->model_welcome->getCountRoomsByUsers($ids,null,$filter);
		
		//var_dump($data['roomsCount']);
		if($this->onPage>$data['roomsCount']){
			$data['roomsCount'] = false;
		}
		
		
		//var_dump($this->onPage,$data['roomsCount']);
		if(!$idsArray || count($idsArray)==0) {
			//show_404();
			//die();
		}
		
		//var_dump($cityInfo);
		if($cityInfo['name_vp']==''){
			$cityInfo['name_vp'] = 'Вашего города';
		}
		if($cityInfo['name_pp']==''){
			$cityInfo['name_pp'] = 'в вашем городе';
		}
		$data['city_parentId'] =  $cityInfo['id_parent'];
		$data['city_id'] = $cityInfo['id_region'];
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_name_pp'] = $cityInfo['name_pp'];
		$data['city_exist'] = $cityInfo['name'];
		
		//var_dump($city);
		//$sort = false;
		
		
		switch($sort){
				case 'enters' :
					$data['titleOnPage'] = 'Популярные квесты '.$data['city_name'];
				break;
				case 'id' :
					$data['titleOnPage'] = 'Новые квесты '.$data['city_name'];
				break;
				default: $data['titleOnPage'] = 'Лучшие квесты '.$data['city_name'];
				
		}
		
		//var_dump($sort);
		$data['city'] = $city;
		$data['base_url'] = '/'.$city.'/';
		$data['siteRoot'] = '';
		
		$data['newPos'] = $this->getNewPositions();//$this->model_welcome->getNew($data['city_id']);
		
		
		//var_dump($data['newPos']);
		
		$data['addonFiles'] = '';
		$data['addonScripts'] = '<script src="'.$data['siteRoot'].'/frontend/header/js/showmore.js"></script>';
		
		$hasSort = '';
		if($data['sort']!='rating'){
			$hasSort = $data['sort'].'/';
		}
		if($filter){
			$hasSort = 'quest/'.$filter;
		}
		
		$this->load->library('pagination');
		$config['base_url'] = '/'.$city.'/'.$hasSort;
		$config['total_rows'] = $data['AllroomsCount'];
		$config['per_page'] = 12; 
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		//$data['user_name'] = $this->model_welcome->getUserNameByEmail();
		//var_dump($data['pages']);
		
		$this->load->view('header', $data);
		$this->load->view('welcome_message', $data);
		$this->load->view('footer');
	
	}
	
}
