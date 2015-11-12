<?
class Map extends CI_Controller {
	
	public function __construct() {
           parent::__construct();
           $this->load->model('model_map');
    }
    
    
    public function index($city=false){
	    
	    $this->load->library('geo');
		$data['allCity'] = $this->geo->getAllCity();
		$cityInfo = $this->geo->getCityIdByName($city);
		$data['city_name'] = $cityInfo['name_vp'];
		$data['city_exist'] = $cityInfo['name'];
		
		$zzom = 12;
		
	    $data['siteRoot'] = '';
		$data['base_url'] = '/'.$city.'/'; 
	    $data['city'] = $city;
	   
	    $data['addonScripts'] = '';
	    
	    $data['city_name_pp'] = $cityInfo['name_pp'];
		$data['newPos'] = $this->getNewPositions();
		if($city == 'ru'){
			$zzom = 3;
		}
		
		$map = $this->model_map->getCoordsByCity($city);
		 
		$baloons = ''; 
		
		//var_dump($map);
		
		
		foreach($map as $mm){
			
			if( !preg_match("/[а-яА-ЯёЁ]/i", $mm['name'])){
			 
			 	$mm['name'] = str_replace('"', "'", $mm['name']);
				if($mm['map']!=''){
					$baloons .='
					myPlacemark = new ymaps.Placemark(['.$mm['map'].'], {
				      balloonContent: "Квеструм '.$mm['name'].' тут"
				    }, {
				      balloonPanelMaxMapArea: 0
				    });
				    myMap.geoObjects.add(myPlacemark);
			    
			    
			    '; }
		    }
			
		} 
		 
	    $data['addonFiles'] = '<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
        <script type="text/javascript">
		ymaps.ready(function () {
			var myMap = new ymaps.Map("YMapsID", {
		      center: ['.$map[0]['map'].'],
		      zoom: '.$zzom.',
		      type: "yandex#satellite",
		      controls: [],
		      type: "yandex#map"
		    });
		    var myPlacemark;
		    '.$baloons.'
			//myMap.behaviors.disable("scrollZoom");
			
		});
		
        </script>';
		
		
		$this->load->view('header', $data);
		$this->load->view('mapView', $data);
		$this->load->view('footer');
	    
    }
    
}
?>