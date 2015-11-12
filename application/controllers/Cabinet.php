<?
class Cabinet extends CI_Controller {
	public $city = 'ekb';
	//public $newpos;
	public function __construct() {
           parent::__construct();
          // var_dump($this->session->userdata());
           $this->load->model('model_cabinet');
           $this->city = $this->session->userdata('city');
           //var_dump($this->session->userdata('city'));
           if($this->city==''){
	           $this->city = 'ekb';
           }
          // $newpos = $this->model_welcome->getNew($data['city_id']);
	}  
	
	
//----------------------------------------------	
	function changetarif(){
		
		$this->model_cabinet->changetarif($_GET['id'],$_GET['userId']);
		echo 1;
	}
//----------------------------------------------	
	function registerroom(){
		$this->load->library('geo');
		//var_dump($this->city);
		$cityInfo = $this->geo->getCityIdByName($this->city);
		$data['allCity'] = $this->geo->getAllCity(1);
		
		//var_dump($data['allCity']);
		
		$data['city_name'] = $cityInfo['name_vp']; 
		$data['city_exist'] = $cityInfo['name'];
		$data['city'] = $this->city;
		//$data['newPos'] = $this->getNewPositions();
		//var_dump($this->session->userdata('ref'));
		
		$data['siteRoot'] = PORTAL_URI;
		$data['base_url'] = '/'.$this->city.'/';
		$data['addonFiles'] = '<link href="'.$data['siteRoot'].'/frontend/qroomblock/css/modal.css" rel="stylesheet">';
		$data['addonScripts'] ='';
		
		$data['admin'] = 'is_admin';
	
		$data['city_name_pp'] = $cityInfo['name_pp'];
		$data['newPos'] = $this->getNewPositions();
	
		$this->load->view('header', $data);
		$this->load->view('registerRoomView', $data);
		$this->load->view('footer_mini');
	}
		
	
//----------------------------------------------
	function resetpassword(){
		
		
		$this->load->library('geo');
		$cityInfo = $this->geo->getCityIdByName($this->city);
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_exist'] = $cityInfo['name'];
		$data['city'] = $this->city;
			
		$data['siteRoot'] = PORTAL_URI;
		$data['base_url'] = '/'.$this->city.'/';
		$data['admin'] = 'is_admin';
		$data['newPos'] = $this->getNewPositions();
		if($this->model_cabinet->respass()){ 
		 $data['ready'] = 'Проверьте почту. Новый пароль выслан Вам по введенному адресу';
		}
		else{
			$data['ready'] = 'Ошибка отправки почты. Повторите попытку позже';
		}
		
		$this->load->view('header', $data);
		$this->load->view('forgotpass', $data);
		$this->load->view('footer_mini'); 
	}    
//----------------------------------------------
    function forgotPass(){
    
    	$this->load->library('geo');
		$cityInfo = $this->geo->getCityIdByName($this->city);
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_exist'] = $cityInfo['name'];
		$data['city'] = $this->city;
		$data['newPos'] = $this->getNewPositions();	
		$data['siteRoot'] = PORTAL_URI;
		$data['base_url'] = '/'.$this->city.'/';
		$data['admin'] = 'is_admin';
    
	 	$this->load->view('header', $data);
		$this->load->view('forgotpass', $data);
		$this->load->view('footer_mini');   
    
    }
//----------------------------------------------
	function acceptRoom(){
		$params = json_decode(file_get_contents('php://input'),true);
		$this->model_cabinet->acceptRoom($params['id'],$params['costumer']);
		//var_dump($params); 
		echo 'done delete';
	}    
//----------------------------------------------
	function akcio(){
		if(($this->session->userdata('user_name')!=""))
		{
			//$quests = $this->model_cabinet->getAkcioQuests();
			$pageContent['quests'] = '';//$quests;
			$this->generatePage('akcio',$pageContent);
		}
		else{ 
			$this->showCabinet();
		}
		
	}    
//----------------------------------------------
	function dellogo(){
		$id = $_GET['id'];
		$logo = $this->model_cabinet->getLogo($id);
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$logo)){
			unlink($_SERVER['DOCUMENT_ROOT'].$logo);
		}
		$this->model_cabinet->relinkAttach($id);
	}    
//----------------------------------------------
	function deleteRoom(){
		$params = json_decode(file_get_contents('php://input'),true);
		$this->model_cabinet->delRoom($params['id']);
		//var_dump($params); 
		echo 'done delete';
	}   
//----------------------------------------------
    function delphoto(){
	    $images = $this->model_cabinet->getAttachArray($_GET['id']);
	    
	    $needle = array_search($_GET['name'],$images['images']);
		echo $needle;
		
		echo $_SERVER['DOCUMENT_ROOT'].$images['images'][$needle];
		
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$images['images'][$needle])){
				unlink($_SERVER['DOCUMENT_ROOT'].$images['images'][$needle]);
		}
		unset($images['images'][$needle]);
		$this->model_cabinet->updateImages(json_encode($images),$_GET['id'] );
		
    }
//----------------------------------------------    
	public function translit($str){
		$abc = array(
       "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g","Д"=>"d",
       "Е"=>"e","Ё"=>"jo","Ж"=>"zh",
       "З"=>"z","И"=>"i","Й"=>"jj","К"=>"k","Л"=>"l",
       "М"=>"m","Н"=>"n","О"=>"o","П"=>"p","Р"=>"r",
       "С"=>"s","Т"=>"t","У"=>"u","Ф"=>"f","Х"=>"kh",
       "Ц"=>"c","Ч"=>"ch","Ш"=>"sh","Щ"=>"shh","Ъ"=>"",
       "Ы"=>"y","Ь"=>"","Э"=>"eh","Ю"=>"yu","Я"=>"ya",
       "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
       "е"=>"e","ё"=>"jo","ж"=>"zh",
       "з"=>"z","и"=>"i","й"=>"jj","к"=>"k","л"=>"l",
       "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
       "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"kh",
       "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
       "ы"=>"y","ь"=>"","э"=>"eh","ю"=>"yu","я"=>"ya","-"=>"","+"=>"",
       " "=>"_",'"'=>"","!"=>"","?"=>"","№"=>"_",")"=>"","("=>"",","=>"","/"=>"",
       "|"=>""
	   );
	   return str_replace(array_keys($abc), array_values($abc), $str); 
	}
//----------------------------------------------
	function correctRoom($id=null){
		//validation rules
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name','название','trim|required');
			$this->form_validation->set_rules('cost','стоимость','trim|required');
			
			$params['genre'][1] = $this->input->post('survive');
					$params['genre'][2] = $this->input->post('prison');
					$params['genre'][3] = $this->input->post('movie');
					$params['genre'][4] = $this->input->post('holms');
							
					$params['type'][1] = $this->input->post('forBig');
					$params['type'][2] = $this->input->post('forKids');
					$params['type'][3] = $this->input->post('withAktors');
					$params['type'][4] = $this->input->post('strawberry');
						
					$params['dif'][1] = $this->input->post('easy');
					$params['dif'][2] = $this->input->post('medium');
					$params['dif'][3] = $this->input->post('hard');
				
				if( $this->form_validation->run() == FALSE ){
					
				}
				else{
					$userId = $this->model_cabinet->getCabinetIdByEmail();
					$json = array();
					$active = 0;
					if($this->input->post('is_active')){
						$active = 1;
					}
					
					$akcio = 0;
					if($this->input->post('is_action')){
						$akcio = 1;
					}
					
					$data['value'] = $this->input->post('name');
					$data['cost'] = $this->input->post('cost');
					$data['daytime'] = json_decode($this->input->post('daytime'),true);
					$data['text'] = $this->input->post('aboutText');
					$data['active'] = $active;
					$data['is_action'] = $akcio;
					$data['userId'] = $userId;
					$data['url'] = $this->translit($data['value']);
					
					$imageIndex = 0;
					if($id){
						$imageIndex = $this->model_cabinet->getImageIndex($id)+1;
					}
					
					//var_dump($_FILES);
					if(is_array($_FILES)){
					$number_of_files_uploaded = count($_FILES['photos']['name']);
					
					for($i = 0; $i < $number_of_files_uploaded; $i++){
							
							$_FILES['userfile']['name']     = $_FILES['photos']['name'][$i];
							$_FILES['userfile']['type']     = $_FILES['photos']['type'][$i];
							$_FILES['userfile']['tmp_name'] = $_FILES['photos']['tmp_name'][$i];
							$_FILES['userfile']['error']    = $_FILES['photos']['error'][$i];
							$_FILES['userfile']['size']     = $_FILES['photos']['size'][$i];
							if(trim($_FILES['userfile']['name'])!=''){
								$this->load->library('upload');
								$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
								$config['allowed_types'] = 'gif|jpg|png';
								$new_name = $userId.'_'.$this->translit($_FILES['userfile']['name']);
								
								$json['images'][$imageIndex] = '/uploads/'.$new_name;
								
								$config['file_name'] = $new_name;
								$this->upload->initialize($config);
								
								if(!$this->upload->do_upload()){
									echo 'error uploading';
								}else{	
									//$json['images'][$imageIndex] = '/uploads/'.$new_name;
									//$imageIndex++;
									//$config['image_library'] = 'imagemagick';
									//$config['library_path'] = '/usr/local/bin/';
									//$config['source_image']	= $config['upload_path'].''.$new_name;
									//$config['new_image']	= $config['upload_path'].''.$new_name;
									//$config['width']	= 1200;
									
									//$this->load->library('image_lib', $config); 
									//$this->image_lib->initialize($config);
									
									
									//if (!$this->image_lib->resize()){
									       // echo $this->image_lib->display_errors();												
									//}else{
									    /*$this->image_lib->clear();
										$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/';	
										$config['allowed_types'] = 'gif|jpg|png';
										$new_name = $userId.'_'.$this->translit($_FILES['userfile']['name']);
										$config['image_library'] = 'imagemagick';
										$config['library_path'] = '/usr/local/bin/';
										$config['source_image']	= $config['upload_path'].''.$new_name;
										$config['new_image']	= $config['upload_path'].''.$new_name;
										
										
										$config['height'] = 500;
										$config['width'] = 808;
										$config['maintain_ratio'] = FALSE;
										$config['x_axis'] = 100;
										$config['y_axis'] = 40;
										
										$upload_data = $this->upload->data();
										//$config['master_dim'] = "width";
										
										
										$this->load->library('image_lib', $config);
										$this->image_lib->initialize($config);
										if (!$this->image_lib->crop()){
										        echo $this->image_lib->display_errors();												}else{
										   // echo 'done';
										}*/
									//}
								}	
							}
					}
					
					if(!$id){
						$this->model_cabinet->insertRoom($data, $json,$params);
						header('location: /cabinet/rooms');
					}
					else{
						$this->model_cabinet->updateRoom($data, $json,$id,$params);
						header("Refresh:0");
					} 
					//var_dump($new_name);
					//var_dump($data,$id);
					
					//
					//$this->rooms();
				}
		}
	} 	
//----------------------------------------------
	public function addRoom($id=null){
		if(($this->session->userdata('user_name')!=""))
		{	
			$data = array();
			if($id)$data = $this->model_cabinet->getRoomById($id);
			//var_dump($data);
			
			if(isset($_POST['submit'])){
				
				if(!$id){
					$this->correctRoom();
				}
				else{
					$this->correctRoom($id);
				}
			
			}
		    $this->generatePage('addRoom',$data);
		}
		else{
			$this->showCabinet();
		}	
	} 
//----------------------------------------------    
    public function index() {
    
       //var_dump($this->session->userdata()); 
       
       if(($this->session->userdata('user_name')!=""))
		{
		   $this->welcome();
		}
		else{
		    $this->showCabinet(); 
		}
                         
    } 
//----------------------------------------------  
	public function showCabinet(){
	
		$data['siteRoot'] = PORTAL_URI;
		$data['base_url'] = '/'.$this->city.'/';
		$data['addonFiles'] = '<link href="'.$data['siteRoot'].'/frontend/qroomblock/css/modal.css" rel="stylesheet">';
		$data['addonScripts'] ='';
		$data['admin'] = 'is_admin';
		
		
		$this->load->library('geo');
		$cityInfo = $this->geo->getCityIdByName($this->city);
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_exist'] = $cityInfo['name'];
		$data['city'] = $this->city;
		
		
		$data['city_name_pp'] = $cityInfo['name_pp'];
		$data['newPos'] = $this->getNewPositions();
		$this->load->view('header', $data);
		$this->load->view('cabinetView', $data);
		$this->load->view('footer_mini');
	}
//----------------------------------------------
	public function register($promo=''){
	
		$this->load->library('geo');
		//var_dump($this->city);
		$cityInfo = $this->geo->getCityIdByName($this->city);
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_exist'] = $cityInfo['name'];
		$data['city'] = $this->city;
		//$data['newPos'] = $this->getNewPositions();
		//var_dump($this->session->userdata('ref'));
		if($promo=='' && $this->session->userdata('ref')!=''){
			$promo = $this->session->userdata('ref');
		}
	
		$data['siteRoot'] = PORTAL_URI;
		$data['base_url'] = '/'.$this->city.'/';
		$data['addonFiles'] = '<link href="'.$data['siteRoot'].'/frontend/qroomblock/css/modal.css" rel="stylesheet">';
		$data['addonScripts'] ='';
		$data['promo'] = $promo;
		$data['admin'] = 'is_admin';
	
		$data['city_name_pp'] = $cityInfo['name_pp'];
		$data['newPos'] = $this->getNewPositions();
	
		$this->load->view('header', $data);
		$this->load->view('registerView', $data);
		$this->load->view('footer_mini');
	}
//----------------------------------------------
	public function createMember(){
		$post['userPromo'] =  $this->input->post('promo'); 
		$post['email'] = $this->input->post('email');
		$post['name'] = $this->input->post('name');
		$checkAction = $this->input->post('is_action');
		if($checkAction){
			$post['is_action'] = 1;
		}
		
		
		$post['phone'] = '7'.preg_replace('/[^0-9]/', '', $this->input->post('phone'));
		$post['password'] = md5($this->input->post('password'));
		$post['active'] = 1;
		$chkIfQuestroom = $this->input->post('is_questroom');
		
		$this->load->library('form_validation');
		//validation rules
		$this->form_validation->set_rules('promo','промокод партнера','trim|callback_if_no_promo');
		$this->form_validation->set_rules('email','ваш E-mail','trim|required|valid_email|callback_if_email_exists');
		$this->form_validation->set_rules('phone','ваше телефон','trim|required');
		$this->form_validation->set_rules('name','ваше имя','trim|required');
		$this->form_validation->set_rules('password','ваш пароль','trim|required|min_length[4]|max_length[32]');
		
		if( $this->form_validation->run() == FALSE ){
			$this->load->library('geo');
			$cityInfo = $this->geo->getCityIdByName($this->city);
			$data['city_name'] = $cityInfo['name_vp'];
			$data['city_exist'] = $cityInfo['name'];
			$data['city'] = $this->city;
			$data['newPos'] = $this->getNewPositions();
			$data['siteRoot'] = PORTAL_URI;
			$data['base_url'] = '/'.$this->city.'/';
			$data['addonFiles'] = '<link href="'.$data['siteRoot'].'/frontend/qroomblock/css/modal.css" rel="stylesheet">';
			$data['addonScripts'] ='';
			$data['admin'] = 'is_admin';
			
			$this->load->view('header', $data);
			$this->load->view('registerView', $data);
			$this->load->view('footer_mini');
			
		}else{
			
			$this->load->library('geo');
			$cityInfo = $this->geo->getCityIdByName($this->city);
			$data['city_name'] = $cityInfo['name_vp'];
			$data['city_exist'] = $cityInfo['name'];
			$data['city'] = $this->city;
			
			$data['siteRoot'] = PORTAL_URI;
			$data['base_url'] = '/'.$this->city.'/';
			$data['addonFiles'] = '<link href="'.$data['siteRoot'].'/frontend/qroomblock/css/modal.css" rel="stylesheet">';
			$data['addonScripts'] ='';
			$data['admin'] = 'is_admin';	
			if(trim($post['userPromo'])!=''){
				$post['balance'] = '100';
			}
			
			
			$post['city'] = $this->input->post('city');
			$post['tarif'] = $this->input->post('tarif');
			
			$this->model_cabinet->create_member($post,$chkIfQuestroom);
			
			$query = $this->model_cabinet->validate();
			$data = array('user_type'=>$query,'user_name'=>$this->input->post('email'), 'is_logged_in'=>true);
			$this->session->set_userdata($data);
			redirect('/cabinet/welcome');
			
			
			//$this->load->view('header', $data);
			//$this->load->view('registerApply', $data);
			//$this->load->view('footer_mini');
			
		}
		
	}
//-------------------------------------------------------------
	public function if_email_exists($email){
		$chk = $this->model_cabinet->checkField('email',$email);
		
		if($chk){
		
			$this->form_validation->set_message('if_email_exists', 'Такой пользователь уже существует. Введите другой E-mail');
			return FALSE;
		
		}
		else{
			return TRUE;
		}
	}	
//-------------------------------------------------------------
	public function if_no_promo($promo){
		
		if($promo==''){
			
			return TRUE;
		}
		else{
			$chk = $this->model_cabinet->checkField('myPromo',$promo);
			
			if(!$chk){
				$this->form_validation->set_message('if_no_promo', 'Такой промокод не существует. Введите другой промокод');
				return FALSE;
			}
			else{
				return TRUE;
			}
		}
	}   
//-------------------------------------------------------------
	public function validate_credentials(){
		//var_dump(123); die();
		//validation rules
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username','ваш логин','trim|required');
		$this->form_validation->set_rules('password','ваш пароль','trim|required');
		if( $this->form_validation->run() == FALSE ){
			$data['siteRoot'] = PORTAL_URI;
			$data['base_url'] = '/'.$this->city.'/';
			
			$this->load->library('geo');
			$cityInfo = $this->geo->getCityIdByName($this->city);
			$data['city_name'] = $cityInfo['name_vp'];
			$data['city_exist'] = $cityInfo['name'];
			$data['city'] = $this->city;
			$data['newPos'] = $this->getNewPositions();
			$data['addonFiles'] = '<link href="'.$data['siteRoot'].'/frontend/qroomblock/css/modal.css" rel="stylesheet">';
			$data['addonScripts'] ='';
			$data['admin'] = 'is_admin';
		
			$this->load->view('header', $data);
			$this->load->view('cabinetView', $data);
			$this->load->view('footer_mini');
		}
		else{
			
			$query = $this->model_cabinet->validate();
			if($query){
				$data = array('user_type'=>$query,'user_name'=>$this->input->post('username'), 'is_logged_in'=>true);
				$this->session->set_userdata($data);
				redirect('/cabinet/welcome');
			}
			else{
				$this->index();
			}

		}
	}	
//----------------------------------------------------------------	
	function setpromo(){
	
	 	$check = $this->model_cabinet->checkPromo( $_GET['promo'] );
	 	echo $check;   
	 	if($check){
			@$data['promo'] = mysql_escape_string( $_GET['promo'] );
			@$data['userId'] = mysql_escape_string( $_GET['userId'] );
			@$data['userType']= mysql_escape_string( $_GET['userType'] );
			@$this->model_cabinet->updatePromo($data);
			
			var_dump($data);
			echo 0;
		}
		else{
			echo 1;
		}
	}
//----------------------------------------------------------------
	function generatePage($page='',$pageContent=''){
		if(($this->session->userdata('user_name')!=""))
		{
			
			$data['activeHome'] = '';
			$data['activeTransact'] = '';
			$data['activeOrders'] = '';
			$data['activeReferals'] = '';
			$data['activeRooms'] = '';
			$data['activeTarif'] = '';
			$data['admin'] = 'is_admin';
			//$data['newPos'] = $this->getNewPositions();
			
			$this->load->library('geo');
			$cityInfo = $this->geo->getCityIdByName($this->city);
			$data['city_name'] = $cityInfo['name_vp'];
			$data['city_exist'] = $cityInfo['name'];
			$data['city'] = $this->city;
			
			
			
						
			$data['siteRoot'] = PORTAL_URI;
			$data['base_url'] = '/'.$this->city.'/';
			$data['admin'] = 'is_admin';
			
			switch($page){
				default:
					$data['activeHome'] = 'active';
					$contentPage = 'aboutPage';
					$data['currpage'] = 'Настройки'; 
				break;
				
				case 'tarifs':
					$data['activeTarif'] = 'active';
					$contentPage = 'tarifPage';
					$data['currpage'] = 'Тарифы'; 
				
				break;
				
				case 'transaction':
					$data['activeTransact'] = 'active';
					$contentPage = 'transactPage';
					$data['currpage'] = 'Движение по счету'; 
				break;
				
				case 'akcio':
					//$data['activeTransact'] = 'mdl-button--colored';
					$contentPage = 'akcioPage';
				break;
				
				case 'orders':
					$data['activeOrders'] = 'active';
					$data['currpage'] = 'Заказы'; 
					$contentPage = 'ordersPage';
				break;
				
				case 'referals':
					$data['activeReferals'] = 'active';
					$data['currpage'] = 'Рефералы'; 
					$contentPage = 'referalsPage';
				break;
				
				case 'rooms':
					$data['activeRooms'] = 'active';
					$data['currpage'] = 'Комнаты'; 
					$contentPage = 'roomsPage';
				break;
				
				case 'addRoom':
					$data['activeRooms'] = 'active';
					$data['currpage'] = 'Добавление комнаты'; 
					$contentPage = 'addRoom';
					
				break;
				
			}
			
			
			$data['addonFiles'] = '
			<script src="'.$data['siteRoot'].'/frontend/header/js/config.js"></script>
			
			
			<link href="'.$data['siteRoot'].'/frontend/qroomblock/css/modal.css" rel="stylesheet">
			
			<script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
			
  <script data-require="angular.js@1.3.0" data-semver="1.3.0" src="https://code.angularjs.org/1.3.0/angular.js"></script>
  			
  
			<script src="'.$data['siteRoot'].'/frontend/qroomblock/js/angular/angular-route.min.js"></script>
			<script src="'.$data['siteRoot'].'/frontend/qroomblock/js/angular/angular-resource.js"></script>
			<script src="'.$data['siteRoot'].'/frontend/qroomblock/js/angular/pagination.js"></script>
			<script src="'.$data['siteRoot'].'/frontend/qroomblock/js/angular/controllers.js"></script>
			<script src="'.$data['siteRoot'].'/frontend/qroomblock/js/angular/app.js"></script>
			
			';
			
			$data['addonScripts'] ='<script src="'.$data['siteRoot'].'/frontend/qroomblock/js/promo.js"></script>
				
			';
			$data['pageContent'] = $pageContent;
			$data['user_data'] = $this->model_cabinet->getDataByEmail();
			$data['angular'] = 'ng-app="cabinetApp"';
			
			//var_dump($data['user_data'][0]['id']);
			
			if(isset($data['user_data'][0]['attach'])){
				$data['user_data'][0]['attach'] = json_decode($data['user_data'][0]['attach']);
			}
			
			//var_dump($data['user_data'][0]['attach']);
			//var_dump($data['user_data']); 
			
			$data['allCity'] = $this->geo->getAllCity();
			$data['user_data'][0]['balanceReal'] = $data['user_data'][0]['balance']-$this->model_cabinet->getRealBalanceById($data['user_data'][0]['id']);
			 
			@$data['user_data'][0]['cityId'] = $data['user_data'][0]['city'];
			
			if(isset($data['user_data'][0]['city'])){
				$data['user_data'][0]['city'] = $this->model_cabinet->getCityById($data['user_data'][0]['city']);
			}
		
			//var_dump($contentPage);
		
			$this->load->view('header', $data);
			$this->load->view('cabinetWelcome', $data);
			$this->load->view($contentPage, $data);
			$this->load->view('pre_footer');
			$this->load->view('footer_mini');
			
		}
		else{
		    $this->showCabinet(); 
		}	
	}	
//----------------------------------------------------------------
	function preference(){
		if(isset($_POST['updateQr'])){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name','имя/название','trim|required');
			$this->form_validation->set_rules('email','email','trim|required');
			$this->form_validation->set_rules('phone','phone','trim|required');
			
		
			if( $this->form_validation->run() == FALSE ){
					
			}
			else{
					$data['userType'] = $this->input->post('userType');
					$data['id'] = $this->input->post('userId');
					$data['email'] = $this->input->post('email');
					$data['name'] = $this->input->post('name');
					$data['city'] = $this->input->post('city');
					$data['phone'] = $this->input->post('phone');
					$data['address'] = $this->input->post('address');
					$data['map'] = $this->input->post('map');
					$data['aboutText'] = $this->input->post('aboutText');
					switch($data['userType']){
						case 1:
							$data['attach']['about'] = $data['aboutText'];
							
							$this->load->library('upload');
							
							if(trim($_FILES['userfile']['name'])!=''){
								
																
								$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
								$config['allowed_types'] = 'gif|jpg|png';
								$new_name = $data['id'].'_'.$_FILES['userfile']['name'];
								$data['attach']['logo'] = '/uploads/'.$new_name;
								 
								$config['file_name'] = $new_name;
								$this->upload->initialize($config);
								$this->upload->do_upload();
								$this->upload->display_errors('<p>', '</p>');
							}
							else{
								$logo = $this->model_cabinet->getLogo($data['id']);
								//var_dump($logo);

								if($logo){
									$data['attach']['logo'] = $logo;
								}
							}
							unset($data['aboutText']);
							unset($data['userType']);
							$data['attach'] = json_encode($data['attach']);
							$this->session->set_userdata('user_name', $data['email']);
							$this->model_cabinet->updateQRoom($data);
						break;
						
						default:
							$this->model_cabinet->updateUser($data['email'], $data['name'],$data['phone'], $data['city'],$data['id']);
						break;	
					}
					//var_dump($data);
			}
		}
		$this->generatePage();
	}
//----------------------------------------------------------------
	function checkEmailBeforeIn($email){
		return $this->model_cabinet->checkEmailOrExit($email);
	}
//----------------------------------------------------------------
	function welcome(){
		//var_dump($this->session->userdata('user_name'));
		if(($this->session->userdata('user_name')!="") && $this->checkEmailBeforeIn($this->session->userdata('user_name')))
		{	
			//$this->generatePage();
			$this->orders();
		}
		else{
			@$this->logout();
			header('location: '.PORTAL_URI.'/cabinet/');
			@$this->showCabinet();
		}	
	}
	
	
	function tarifs(){
		if(($this->session->userdata('user_name')!=""))
		{
			$pageContent['tarifs'] = $this->model_cabinet->getTarifs();
			$pageContent['current'] = $this->model_cabinet->getCurrTarif();
			$pageContent['userId'] = $this->model_cabinet->getUserForTarif();
			$this->generatePage('tarifs',$pageContent);
		}
		else{
			$this->showCabinet();
		}
	}
		
	
	function transaction(){
		if(($this->session->userdata('user_name')!=""))
		{
			$pageContent['transactions'] = '';
			$this->generatePage('transaction',$pageContent);
		}
		else{
			$this->showCabinet();
		}
	}	
	
	function orders(){
		if(($this->session->userdata('user_name')!=""))
		{
			
			$pageContent['orders'] = '';
			$this->generatePage('orders',$pageContent);
		
		}
		else{
			$this->showCabinet();
		}
	}
	
	function referals(){
		if(($this->session->userdata('user_name')!=""))
		{
			$userId = $this->model_cabinet->getCabinetIdByEmail();
			$promo =  $this->model_cabinet->getPromoById($userId);
			
			$referals = $this->model_cabinet->getRefsByPromo($promo);
			$pageContent['referals'] = $referals;
			$this->generatePage('referals',$pageContent);
		}
		else{
			$this->showCabinet();
		}
	}
	
	
	function rooms(){
		if(($this->session->userdata('user_name')!=""))
		{
			
			$userId = $this->model_cabinet->getCabinetIdByEmail();
			$promo =  $this->model_cabinet->getPromoById($userId);
			
			//$referals = $this->model_cabinet->getRefsByPromo($promo);
			$pageContent = '';
			$this->generatePage('rooms',$pageContent);
		}
		else{
			$this->showCabinet();
		}
	}
//-----------------------------------------------------------------
	function deleteTransaction(){
		
		$params = json_decode(file_get_contents('php://input'),true);
		$this->model_cabinet->delTransaction($params['id'],$params['comment']);
		//var_dump($params); 
		echo 'done delete';
		
	}
//-----------------------------------------------------------------
	function proceedTransaction(){
	
		$params = json_decode(file_get_contents('php://input'),true);
		$this->model_cabinet->proceedTransaction($params['id']);
		echo 'done proceed';
	}
//-----------------------------------------------------------------
	function akciojson(){
		if(($this->session->userdata('user_name')!=""))
		{
			//$userId = $this->model_cabinet->getCabinetIdByEmail(); 
			$rooms = $this->model_cabinet->getAcioRoomsById();
			//var_dump(json_encode($rooms),json_last_error());
			echo json_encode($rooms);
			
		}
		else{
			echo 0;
		}
	}
	
	function roomsjson(){
		if(($this->session->userdata('user_name')!=""))
		{
			$userId = $this->model_cabinet->getCabinetIdByEmail();
			$rooms = $this->model_cabinet->getRoomsById($userId);
			echo json_encode($rooms);
			
		}
		else{
			echo 0;
		}
	}
//-----------------------------------------------------------------	
	function referalsjson(){
		if(($this->session->userdata('user_name')!=""))
		{
			$userId = $this->model_cabinet->getCabinetIdByEmail();
			$promo =  $this->model_cabinet->getPromoById($userId);
			$referals = $this->model_cabinet->getRefsByPromo($promo);
			
			echo json_encode($referals);
			
		}
		else{
			echo 0;
		}
	}	
//-----------------------------------------------------------------
	function transactionjson(){
		if(($this->session->userdata('user_name')!=""))
		{
		$userId = $this->model_cabinet->getCabinetIdByEmail();
		$transactions = $this->model_cabinet->getTransactionsById($userId);
		echo json_encode($transactions);
		}
		else{
			echo 0;
		}
	}	
//-----------------------------------------------------------------
	function orderjson(){
		if(($this->session->userdata('user_name')!=""))
		{
			
			$userId = $this->model_cabinet->getCabinetIdByEmail();
			$orders = $this->model_cabinet->getOrdersById($userId);
			echo json_encode($orders);
		
		}
		else{
			echo 0;
		}
	}
//-----------------------------------------------------------------
	public function logout()
	 {
	  $newdata = array(
	  'user_id'   =>'',
	  'user_name'  =>'',
	  'user_email'     => '',
	  'is_logged_in' => FALSE,
	  );
	  $this->session->unset_userdata($newdata );
	  $this->session->sess_destroy();
	  $this->index();
	  header('location: '.PORTAL_URI.'/cabinet/');
	 }	
		  
}

?>