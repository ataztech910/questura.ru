<?
class Quest extends CI_Controller {
	
	public function __construct() {
           parent::__construct();
                      
           $this->load->model('model_quest');
    }
   
   public function vendettaKbxyfz(){
	   $this->model_quest->vendettaKbxyfz_do();
   }
   
    
    public function insertparams(){
	   
	    $array = array('Tajjny_Labirinta'=>
	    					array(10=>4,11=>1,3=>2),
					   'DRAKULA88'=>
	    					array(10=>3,10=>4,11=>1,11=>4,3=>3),
	    			   'Pila:_Iskuplenie'=>
	    					array(10=>3,10=>4,11=>1,11=>4,3=>3),
	    			   'Kazematy89'=>
	    					array(10=>2,10=>3,10=>4,11=>1,3=>2),
	    			   'Tajjna_agenta_KGB89'=>
	    					array(10=>3,10=>4,11=>1,3=>2),					
	    
	    			   'Pila'=>
	    					array(10=>3,10=>4,11=>4,3=>3),
					   'Logovo_piratov'=>
	    					array(10=>1,10=>4,11=>1,11=>2,3=>1),		
					   'Logovo_manyaka90'=>
	    					array(10=>4,11=>1,11=>4,3=>3),
					   'Inferno'=>
	    					array(10=>1,11=>1,3=>3),
						'Marshrut__13'=>
	    					array(10=>3,10=>4,11=>1,3=>2),
	    				'Interny'=>
	    					array(10=>3,10=>4,11=>1,11=>2,3=>1),	
						'Vrag_gosudarstva'=>
	    					array(10=>1,10=>2,10=>3,10=>4,11=>1,3=>2),
	    				'Ograblenie_banka80'=>
	    					array(10=>2,10=>3,10=>4,11=>1,3=>2),
	    				'Bunker'=>
	    					array(10=>1,10=>2,10=>3,10=>4,11=>1,3=>3),
	    				'Morg75'=>
	    					array(10=>3,10=>4,11=>1,11=>4,3=>3),
	    				'Vyjjti_iz_komnaty'=>
	    					array(10=>4,10=>4,11=>1,3=>2),	
	    					
	    				'Nora_KHobbita75'=>
	    					array(10=>3,11=>1,11=>2,3=>1),					
	    
	    				'Grobnica_Faraona'=>
	    					array(10=>1,10=>3,11=>1,11=>2,3=>1),
					   'Dzhumandzhi'=>
	    					array(10=>3,11=>1,11=>2,3=>2),			
						'Peshhera_Alladina'=>
	    					array(10=>3,11=>1,11=>2,3=>1),		
						'V_poiskakh_Nolika'=>
	    					array(10=>3,11=>1,11=>2,3=>1),			
						'Kontora_Puaro'=>
	    					array(10=>3,10=>4,11=>1,3=>3),
	    				'Na_Kichmane'=>
	    					array(10=>2,10=>3,10=>4,11=>1,11=>4,3=>3),	
	    				'Tajjna_postoyalca'=>
	    					array(10=>4,11=>1,3=>2),
	    				'Proklyatie_Annabel'=>
	    					array(10=>3,10=>4,11=>1,11=>4,3=>2),
	    				'Missiya_KHronos'=>
	    					array(10=>3,10=>4,11=>1,11=>4,3=>3),
	    				'Teni_Inkvizicii'=>
	    					array(10=>4,11=>1,11=>4,3=>2),		
	    				'Tyuremnaya_kamera'=>
	    					array(10=>2,10=>4,3=>2,11=>1),
	    			   'Katakomby'=>
	    					array(10=>1,10=>3,11=>1,11=>3,3=>3),
	    				'igry_razuma'=>
	    					array(10=>1,10=>3,10=>4,3=>1),
						'Podzemele_srednevekovya'=>
	    					array(10=>1,11=>1,11=>4,3=>2),
	    				'zagadka_sherloka_holmsa'=>
	    					array(10=>3,10=>4,11=>1,11=>2,3=>2),	
	    				'nora_zverya'=>
	    					array(10=>1,10=>4,11=>1,11=>4,3=>3),
	    				'Zvonok'=>
	    					array(10=>3,10=>4,11=>1,11=>4,3=>3),
	    				'Mumiya'=>
	    					array(10=>3,11=>1,3=>1),
	    				'Psikhbolnica'=>
	    					array(10=>2,10=>3,11=>1,11=>4, 3=>2),				
	    				'sokrovischa_nacii'=>
	    					array(10=>3,10=>4,11=>1,11=>2, 3=>1),
	    				'MAGICHESKAYA_KOMNATA_KHUDDU'=>
	    					array(10=>3,10=>4,11=>1,11=>4, 3=>2) );
	    					
	    					
	    	$this->model_quest->insert_params($array);			
	    
    }
    
    
//-----------------------------------------------------
	public function index($city=false,$name=false) {
			//var_dump($city);
			//$this->session->set_userdata('city', $city);
		  	$this->showQuest($city,$name);                
    }
    
//-----------------------------------------------------
	public function dorate(){
		$data['roomId'] = htmlspecialchars( $_GET['roomId'] );
		$data['userId'] = $this->model_quest->getIDbyEmail(htmlspecialchars( $_GET['userEmail'] ));
		$data['commentBody'] = htmlspecialchars( $_GET['message'] );
		$data['rating'] = htmlspecialchars( $_GET['rating'] );
		$data['active'] = 1;
		$data['commentDate'] = date("Y-m-d");
		
		//var_dump($data);
		
		if( $this->model_quest->insertRating($data) ){
			echo 1;
		}
		else{echo 0;}
		
	}    
//-----------------------------------------------------

	public function showQuest($city,$name){
		
		//var_dump($this->session->userdata());
		$this->load->library('geo');
		$data['allCity'] = $this->geo->getAllCity();
		$cityInfo = $this->geo->getCityIdByName($city);
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_exist'] = $cityInfo['name'];
		
		$data['quest'] = $this->model_quest->viewQuest($name);
		if(!$data['quest']){
			show_404();
		}
		
		$data['title'] = "Квест ".$data['quest']['value']." ".$cityInfo['name_pp']." - Questura.ru";
		
		//var_dump($data['title']);
		
		$data['siteRoot'] = '';
		$data['base_url'] = '/'.$city.'/'; 
		$data['canRate'] = $this->model_quest->canRate($this->session->userdata('user_name'), $data['quest']['id']);
		$data['userPhone'] = $this->model_quest->getPhoneByMail($this->session->userdata('user_name'));
		
		$data['comments'] = $this->model_quest->getCommentsByRoom($data['quest']['id']);
		
		
		$data['city'] = $city;
		if(!$this->session->userdata('city')){
			$this->session->set_userdata('city',$city);
		}
		
		
		
		
		
		$data['addonFiles'] = '
		<link href="'.$data['siteRoot'].'/frontend/qroomblock/css/lightbox.css" rel="stylesheet">
		
		<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
        <script type="text/javascript">
		ymaps.ready(function () {
			var myMap = new ymaps.Map("YMapsID", {
		      center: ['.$data['quest']['map'].'],
		      zoom: 15,
		      type: "yandex#satellite",
		      controls: [],
		      type: "yandex#map"
		    });
		    
		    var myPlacemark = new ymaps.Placemark(['.$data['quest']['map'].'], {
		      balloonContent: "Квест '.$data['quest']['value'].' тут"
		    }, {
		      balloonPanelMaxMapArea: 0
		    });
		
			myMap.geoObjects.add(myPlacemark);
		    myMap.behaviors.disable("scrollZoom");
		});
		
        </script>
		';
		$data['addonScripts'] = '<script src="'.$data['siteRoot'].'/frontend/qroomblock/js/lightbox.js"></script>
		
		<script src="'.$data['siteRoot'].'/frontend/qroomblock/js/phphelpers.js"></script>
		<script src="'.$data['siteRoot'].'/frontend/qroomblock/js/order.js"></script>
	

		
<script type="text/javascript" src="/alfa/assets/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="/alfa/assets/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jquery.placeholder.js"></script>
<script type="text/javascript" src="/alfa/assets/js/icheck.min.js"></script>
<script type="text/javascript" src="/alfa/assets/js/retina-1.1.0.min.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jquery.raty.min.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="/alfa/assets/js/tmpl.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="/alfa/assets/js/draggable-0.1.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jquery.slider.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jquery.fitvids.js"></script>

<script type="text/javascript" src="/alfa/assets/js/custom.js"></script>
<script type="text/javascript" src="/frontend/qroomblock/js/jquery.maskedinput.min.js"></script>



<!--[if gt IE 8]>
<script type="text/javascript" src="/alfa/assets/js/ie.js"></script>
<![endif]-->
<script type="text/javascript">
    var propertyId = 0;
    $(window).load(function(){
        initializeOwl(false);
    
    
		jQuery(function($){
		   
		   $("#phone").mask("+7(999) 999-9999");
		  
		});
    
    
    });
    
    
    
</script>


		';
		
		$this->load->library('raspisanie');
		
				
		$dateArray = $this->model_quest->getWorkTime($data['quest']['id']);
		$data['legend'] = $this->raspisanie->generateLegend($data['quest']['id']);
		$data['calendar'] = $this->raspisanie->generateCalendar($dateArray,$data['quest']['id']);
		
		//var_dump($data['legend']);
		
		
		$data['city_name_pp'] = $cityInfo['name_pp'];
		$data['newPos'] = $this->getNewPositions();
		$this->load->view('header', $data);
		$this->load->view('questView', $data);
		$this->load->view('footer');
		//echo $name;
		
	}    
	
//-----------------------------------------------------
   
}
	
?>