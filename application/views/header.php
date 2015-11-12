<!DOCTYPE html>

<html lang="ru-RU">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,700' rel='stylesheet' type='text/css'>
    <link href="/alfa/assets/fonts/font-awesome.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/alfa/assets/bootstrap/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="/alfa/assets/css/bootstrap-select.min.css" type="text/css">
    <link rel="stylesheet" href="/alfa/assets/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="/alfa/assets/css/jquery.slider.min.css" type="text/css">
    <link rel="stylesheet" href="/alfa/assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="/alfa/assets/css/style.css" type="text/css">
	<?echo $addonFiles;?>
   <title><? 
		if(!isset($title)){
			echo "Questura - все квесты ".$city_name; 
		}else{
			echo $title;
		}
	?></title>
	
	<meta name="description" content="<? if(isset($description)) echo $description; ?>">

</head>

<body class="page-sub-page page-listing page-grid page-search-results" id="page-top">
<!-- Wrapper -->
<div class="wrapper">
    <!-- Navigation -->
    <div class="navigation">
        <div class="secondary-navigation">
            <div class="container">
                <div class="contact">
                    <figure><strong>Ваш город:</strong><a href="/cityselect" class="promoted"><?=$city_exist?></a></figure>
                </div>
                <div class="user-area">
                    <div class="actions">
                        
                        <?if($this->session->userdata('user_name')!=''){
			        		echo '<a href="/cabinet">привет, '.$this->session->userdata('user_name').'</a>';
			        	}
			        	else{?>
                        
                        <a href="/cabinet/registerroom" class="promoted">Добавить квеструм</a>
                        <a href="/cabinet/register" class="promoted"><strong>Зарегистрироваться</strong></a>
                        <a href="/cabinet">Войти</a>
                        
                        <?}?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <header class="navbar" id="top" role="banner">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-brand nav" id="brand">
                        <a href="/"><img src="/frontend/header/images/qlogo.png" alt="brand"></a>
                    </div>
                </div>
                <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                    <ul class="nav navbar-nav">
                        <li><a href="/<?=$city?>/feedback">Отзывы</a></li>
                        <!--li><a href="/questrooms">Квеструмы</a></li-->
                        <li><a href="/<?=$city?>/map">Карта</a></li>
                        <li><a href="/questrooms">Квеструмы</a></li>
                        <!--li><a href="#">Квест года</a></li-->
                        <!--li><a href="#">Франшизы</a></li-->
                        <!--li><a href="/tarifs">Тарифы</a></li-->
                        <!--li class="active has-child"><a href="#">Обьявления</a>
                            <ul class="child-navigation">
                                <li><a href="#">Вакансии</a></li>
                                <li><a href="#">Резюме</a></li>
                                <li><a href="#">Продажа квестов</a></li>
                            </ul>
                        </li-->
                        <!--li><a href="#">Блог</a></li-->
                        <li><a href="/pages/contacts">Контакты</a></li>
                    </ul>
                </nav><!-- /.navbar collapse-->
                <!--div class="add-your-property">
                    <a href="/cabinet/register" class="btn btn-default"><i class="fa fa-plus"></i><span class="text">Добавить Квест</span></a>
                </div-->
            </header><!-- /.navbar -->
        </div><!-- /.container -->
    </div><!-- /.navigation -->
    <!-- end Navigation -->
