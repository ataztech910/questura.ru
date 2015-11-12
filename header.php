<!DOCTYPE html>
<html>
<head>
	<title><? 
		if(!isset($title)){
			echo "Questura - все квесты ".$city_name; 
		}else{
			echo $title;
		}
	?></title>
	
	<meta name="description" content="<? if(isset($description)) echo $description; ?>">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="/frontend/header/css/font-awesome.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	
	<link href="/frontend/header/css/header.css" rel="stylesheet">
	<?echo $addonFiles;?>
	<link href="/frontend/qroomblock/css/modal.css" rel="stylesheet">
	
	
	
</head>
<body class="body body__reggular" ng-app="cabinetApp">
<div class="mdl-layout mdl-layout--fixed-header mdl-js-layout">
  <header class="curled mdl-layout__header mdl-layout__header--scroll mdl-shadow--2dp">
        <div class="mdl-layout__header-row">
          <span class="android-title mdl-layout-title">
            <a href="/<? //echo $base_url; ?>"><img alt="Questura - все квесты <? echo $city_name; ?>" class="android-logo-image" src="/frontend/header/images/questuralogo.png"></a>
          </span>
          <!-- Add spacer, to align navigation to the right in desktop -->
          <div class="android-header-spacer mdl-layout-spacer"></div>
         
          <!-- Navigation -->
          <div class="android-navigation-container">
            <nav class="android-navigation mdl-navigation">
              <a class="mdl-navigation__link mdl-typography--text-uppercase" href="http://vk.com/questuraekb" target="_blank">Мы ВКонтакте</a>
              <a class="mdl-navigation__link mdl-typography--text-uppercase" href="/cityselect"><? echo $city_exist; ?></a>
              <a class="mdl-navigation__link mdl-typography--text-uppercase" href="/cabinet"><?
	        	if($this->session->userdata('user_name')!=''){
	        		echo 'привет, '.$this->session->userdata('user_name');
	        	}
	        	else{
	        	?>
	        	Личный кабинет
	        	<?}?></a>
            </nav>
          </div> 
        </div>
      </header>
 
  <div class="mdl-layout__drawer ">
    <span class="mdl-layout-title">Questura</span>
    <nav class="mdl-navigation">
      <a class="mdl-navigation__link" href="/pages/about">О проекте</a>
      <a class="mdl-navigation__link" href="/pages/team">Команда</a>
      <a class="mdl-navigation__link" href="/pages/contacts">Контакты</a>
     
    </nav>
  </div>



<div class="android-content mdl-layout__content">
<div class="android-more-section stillTry">
<div class="android-card-container mdl-grid">