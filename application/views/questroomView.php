
<!-- Page Content -->
    <div id="page-content">
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Главная</a></li>
                <li><a href="/questrooms">Квеструмы</a></li>
                <li class="active"><?=$qr['name']?></li>
            </ol>
        </div>
        <!-- end Breadcrumb -->

        <div class="container">
            <div class="row">
                <!-- Agent Detail -->
                <div class="col-md-9 col-sm-9">
                    <section id="agent-detail">
                        <header><h1><?=$qr['name']?></h1></header>
                        <section id="agent-info">
                            <div class="row">
                                <div class="col-md-3 col-sm-3">
					             <figure class="agency-image">
					             	<? if(isset($qr['attach']['logo']) && file_exists($_SERVER['DOCUMENT_ROOT'].$qr['attach']['logo'])) {?>
                                                    
                                                    	<img alt="" src="<?=$qr['attach']['logo'];?>"/>
                                                    
                                                    <?}else{
	                                                    ?>
	                                                    
	                                                    <img src="/alfa/assets/img/agent-01.jpg" />
	                                                    
	                                                    <?
	                                                
                                                    }?>
					             </figure>
                                </div><!-- /.col-md-3 -->
                                <div class="col-md-5 col-sm-5">
                                    <h3>Контакты</h3>
                                    <address>
                                       <?=$qr['address']?>
                                    </address>
                                    <dl>
                                        <dt>Телефон:</dt>
                                        <dd><?=$qr['phone']?></dd>
                                        <dt>Email:</dt>
                                        <dd><a href="mailto:<?=$qr['email']?>"><?=$qr['email']?></a></dd>
                                        <!--dt>Сайт:</dt>
                                        <dd>klayfo.ru</dd-->
                                    </dl>
                                </div><!-- /.col-md-5 -->
                                <div class="col-md-4 col-sm-4">
                                    <!--div id="social">
                                        <h3>Социальные сети</h3>
                                        <div class="agent-social">
                                            <a href="#" class="fa fa-twitter btn btn-grey-dark"></a>
                                            <a href="#" class="fa fa-facebook btn btn-grey-dark"></a>
                                            <a href="#" class="fa fa-linkedin btn btn-grey-dark"></a>
                                        </div>
                                    </div-->
                                </div><!-- /.col-md-4 -->
                            </div><!-- /.row -->
                            <div class="row">

                            </div><!-- /.row -->
                        </section><!-- /#agent-info -->
                        <hr class="thick">
                                               
                        <section id="agent-properties">
						<header><h3>Квесты от <?=$qr['name'];?> (<?=count($qr['others']);?>)</h3></header>
                            <div class="layout-expandable">
                                
                                <?php  
                      $i=1;
                      foreach ($qr['others'] as $room){ ?>
                      <? if ($i==1){?>
                      <div class="row">
                      <?}?>
                      
                            <div class="col-md-4 col-sm-4">
                                <div class="property equal-height">
                                    <a href="<? echo $base_url; ?><? echo $room['url'] ?>">
                                        <div class="property-image">
                                            <? if(isset($room['attach']['images'])){ 
											foreach($room['attach']['images'] as $ii){
												//var_dump($ii);
											if(file_exists($_SERVER['DOCUMENT_ROOT'].$ii)){	
										   ?>
											<img src="<? echo $ii;?>" alt="<?echo $room['value'];?>" />
										 
										 <? break;
										 }
										    }
										   } ?>
                                        </div>
                                        <div class="overlay">
                                            <div class="info">
                                                <div class="tag price">
	                                                <?php foreach ($room['params'] as $params) {
													
										if($params['icon']=='fa-money'){
										$dop = ' <i class="fa fa-rub"></i>';
										$icon = '<b>'.$params['paramValue'].'</b> '.$dop;
													}else{ 
														//$icon = '';
													}}
													echo $icon;
													?>
                                                </div>
                                                <h3><?php echo stripslashes($room['value']); ?></h3>
                                                <figure><?=$room['address'];?></figure>
                                            </div>
                                            <ul class="additional-info">
                                                <li>
                                                    <header>Посещений:</header>
                                                    <figure>0</figure>
                                                </li>
                                                <li>
                                                    <header>Рейтинг:</header>
                                                    <figure>0</figure>
                                                </li>
                                            </ul>
                                        </div>
                                    </a>
                                </div><!-- /.property -->
                            </div><!-- /.col-md-3 -->
                      
                      <? if($i==3){
	                      $i=0;
                      ?>
                      </div>
                      <?}$i++;?>
                      <!-- /.row-->
                      
                      <?}?>
                      
                      
                      
                                
                                
                                
                               
                                
                            </div>
                            
                            
                            
                            
                            <!--div class="center">
                                <span class="show-all">Показать все квесты</span>
                            </div-->
                        </section><!-- /#agent-properties -->
                        <div class="row">
                            <div class="col-md-12">
                                <section id="property-map">
                                    <div class="property-detail-map-wrapper">
                                     	<div id="YMapsID" style="width: 100%; height: 300px"></div>
                                    </div>
                                </section><!-- /#property-map -->
                            </div>
                        </div><!-- /.row -->
                    </section><!-- /#agent-detail -->
                </div><!-- /.col-md-9 -->
                <!-- end Agent Detail -->

  <?php
               	 include $_SERVER['DOCUMENT_ROOT'].'/tmpl/sidebar.php';
                ?>
 </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
    <!-- end Page Content -->