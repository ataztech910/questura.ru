<?
	
class Questroom extends CI_Controller {

	public function index($name=false) {
		   
		   $this->load->model('model_questroom');
		   $this->showQuestroom($name); 
                         
    }
//-----------------------------------------------------

	public function showQuestroom($name){
		//var_dump($city);
		
		
		$qr = $this->model_questroom->getRoomById($name);
		$cityInfo = $this->model_questroom->getCityByUserCity($qr['city']);
		$city = $cityInfo['slug'];
		
		//var_dump($city);
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_exist'] = $cityInfo['name'];
		
		$data['siteRoot'] = '';
		$data['base_url'] = '/'.$city.'/'; 
		
		$data['city'] = $city;
		
		
		$data['addonFiles'] = '
		<link href="'.$data['siteRoot'].'/frontend/qroomblock/css/lightbox.css" rel="stylesheet">
		
		<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
        <script type="text/javascript">
		ymaps.ready(function () {
			var myMap = new ymaps.Map("YMapsID", {
		      center: ['.$qr['map'].'],
		      zoom: 15,
		      type: "yandex#satellite",
		      controls: [],
		      type: "yandex#map"
		    });
		    
		    var myPlacemark = new ymaps.Placemark(['.$qr['map'].'], {
		      balloonContent: "Квеструм '.$qr['name'].' тут"
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
		<script src="'.$data['siteRoot'].'/frontend/qroomblock/js/order.js"></script>';
		
		//echo $name;
		
		
		$qr['others'] = $this->model_questroom->getRoomsByUser($qr['id']);
		
		//var_dump($qr['others']);
		
		$data['qr'] = $qr;
		
		
		//var_dump($qr);
		
		$this->load->view('header', $data);
		$this->load->view('questroomView', $data);
		$this->load->view('footer_mini');
		
	}    
	
//-----------------------------------------------------
   
   public function showQuestroomList(){
		
		$this->load->model('model_questroom');
		$data['city'] = $this->session->userdata('city');		
		$cityInfo = $this->model_questroom->getCNameBySlug($data['city']);
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_exist'] = $cityInfo['name'];
		$data['qrooms'] = $this->model_questroom->getQRoomsByCityId($cityInfo['id_region']);
		//var_dump($data['qrooms']);
		$data['addonFiles'] = '';
		$data['addonScripts'] = '';
		
		$this->load->view('header', $data);
		$this->load->view('questroomListView', $data);
		$this->load->view('footer_mini');
		
	} 
   
}
	
?>