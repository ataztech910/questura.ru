
<!-- Page Content -->
    <div id="page-content">
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active"><?php echo $quest['value'] ?></li>
            </ol>
        </div>
        <!-- end Breadcrumb -->

        <div class="container">
            <div class="row">
                <!-- Property Detail Content -->
                <div class="col-md-9 col-sm-9">
                    <section id="property-detail">
                        <header class="property-title">
                            <h1>Квест: <?php echo $quest['value'] ?></h1>
                            <figure><? echo $quest['address']; ?></figure>
                            <span class="actions">
                                <!--<a href="#" class="fa fa-print"></a>-->
                                <!--a href="#" class="bookmark" data-bookmark-state="empty"><span class="title-add">Добавить в избранное</span><span class="title-added">Добавленно</span></a-->
                            </span>
                        </header>
                        <section id="property-gallery">
                            <div class="owl-carousel property-carousel">
                                
                                <? if(isset($quest['attach']['images'])){
								   foreach($quest['attach']['images'] as $images){
								   if(file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$images)){?>
                                   <div class="property-slide">
                                        <img alt="<?php echo $quest['value'] ?>" src="<?=$images;?>">
                                   </div><!-- /.property-slide -->
                                <?}}}?>
                                  <!-- /.property-slide -->
                            </div><!-- /.property-carousel -->
                        </section>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <section id="quick-summary" class="clearfix">
                                    <header><h2><? echo $quest['phone']; ?></h2></header>
                                    <dl>
                                        <dt>Город:</dt>
                                            <dd><?=$city_exist;?></dd>
                                        <!--dt>Район:</dt>
                                            <dd>Виз</dd>
                                        <dt>Метро:</dt>
                                            <dd>Геологическая</dd-->
                                        <dt>Адрес:</dt>
                                            <dd><? echo $quest['address']; ?></dd>
                                        <dt>Сложность:</dt>
                                            <dd>Средне</dd>
                                        <dt>Квеструм:</dt>
                                            <dd><?=$quest['questRoom']['name'];?></dd>
                                        <dt>Стоимость:</dt>
                                            <dd><span class="tag price"> <?php foreach ($quest['params'] as $params) {
													
										if($params['icon']=='fa-money'){
										$dop = ' <i class="fa fa-rub"></i>';
										$icon = '<b>'.$params['paramValue'].'</b> '.$dop;
													}else{ 
														//$icon = '';
													}}
													echo $icon;
													?></span></dd>
                                        <!--dt>Участников:</dt>
                                            <dd>2-4</dd>
                                        <dt>Время:</dt>
                                            <dd>60 минут</dd-->
                                        <dt>Посещений:</dt>
                                            <dd>0</dd>
                                        <dt>Рейтинг:</dt>
                                            <dd><div class="rating rating-overall" data-score="<?=$quest['rating'];?>"></div></dd>
                                    </dl>
                                </section><!-- /#quick-summary -->
                            </div><!-- /.col-md-4 -->
                            <div class="col-md-8 col-sm-12">
                                <section id="description">
                                    <header><h2>Описание квеста</h2></header>
                                    <p>
                                        <?echo html_entity_decode( str_replace("\n","<br>",$quest['text']) );?>
                                    </p>
                                </section><!-- /#description -->
                                <!--section id="property-features">
                                    <header><h2>Метки</h2></header>
                                    <ul class="list-unstyled property-features-list">
                                        <li>Ограбление</li>
                                        <li>По фильмам</li>
                                        <li>Атмосферно</li>
                                        <li>С электроникой</li>
                                        <li>Без замочков</li>
                                        <li>Страшно</li>
                                    </ul>
                                </section--><!-- /#property-features -->
                                <section id="floor-plans">
                                    <div class="floor-plans">
                                    <? if ($calendar!=''){?>
                                    <header><h2>Расписание</h2></header>
                                    <p>
                                    <? if( count($legend)>0 ){ ?>
                                    Стоимость отличается по цветам:
                                    <? foreach($legend as $key=>$value){ ?>
                                    	<span class="btn <?=$value?>"><?=$key?></span>
                                    <?}?>
                                    <br>Для отправки заявки, выберите время, и кликните по нему.
                                    <? } ?>
                                    </p>
                                     
                                    <? 
	                                    echo $calendar;
                                    ?>   
                                 
									<?}?>
                                    </div>
                                </section><!-- /#floor-plans -->
                               
                                <? if($quest['map']!=""){?>
                                <section id="property-map">
                                    <header><h2>Карта</h2></header>
                                    <div class="property-detail-map-wrapper">
                                        <!--div class="property-detail-map" id="property-detail-map"></div--><div id="YMapsID" style="width: 100%; height: 300px"></div>
                                    </div>
                                </section><!-- /#property-map -->
                                <?}?>
                                
                                <section id="property-rating">
                                    <header><h2>Рейтинг</h2></header>
                                    <div class="clearfix">
                                        
                                        <?
                                        
                                       
	                                    if($canRate && $this->session->userdata('is_logged_in')==true){
                                        ?>
                                        <aside id="myrate">
                                            <header>Оценить</header>
                                            <div class="rating rating-user">
                                                <div class="inner"></div>
                                            </div>
                                        </aside>
                                        <?}?>
                                        
                                        <figure>
                                            <header>Текущий рейтинг</header>
                                            <div class="rating rating-overall" data-score="<?=$quest['rating'];?>"></div>
                                        </figure>
                                    </div>
                                    
                                    
                                    <div class="rating-form">
                                        <header>Оценить квест, и оставить отзыв возможно, только после посещения квеста!</header>
                                        <form role="form" id="form-rating" method="post"  class="clearfix">
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                    	
                                                        <label for="form-rating-message">Ваш Отзыв<em>*</em></label>									<input id="hint" type="hidden" id="hint"/>
                                                        <input type="hidden" id="userEmail" value="<?=$this->session->userdata('user_name');?>">
                                                        <textarea class="form-control" id="form-rating-message" rows="6" name="form-rating-message" required></textarea>
                                                    </div><!-- /.form-group -->
                                                </div><!-- /.col-md-12 -->
                                            </div><!-- /.row -->
                                            <div class="form-group">
                                                <button type="button" onclick="doRate();" class="btn pull-right btn-default" id="form-rating-submit">Оставить отзыв</button>
                                            </div><!-- /.form-group -->
                                            <div id="form-rating-status"></div>
                                        </form><!-- /#form-contact -->
                                    </div><!-- /.rating-form -->
                                </section><!-- /#property-rating -->
                                <!--section id="video-presentation">
                                    <header><h2>Видео</h2></header>
                                    <div class="video">
                                        <iframe src="//player.vimeo.com/video/34741214?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="500" height="281" ></iframe>
                                    </div>
                                </section--><!-- /#video-presentation -->
                            </div><!-- /.col-md-8 -->
                            <div class="col-md-12 col-sm-12">
                                <section id="contact-agent">
                                    <header><h2>Квеструм: <?=$quest['questRoom']['name'];?> </h2></header>
                                    <div class="row">
                                        <section class="agent-form">
                                            <div class="col-md-7 col-sm-12">
                                                <aside class="agent-info clearfix">
                                                    <figure>
                                                    	<? 
                                                   //var_dump($quest['questRoom']['attach']['logo']);
                                                    	
                  if(isset($quest['questRoom']['attach']['logo']) && file_exists($_SERVER['DOCUMENT_ROOT'].$quest['questRoom']['attach']['logo'])) {?>
                                                    
                                                    	<img alt="" src="<?=$quest['questRoom']['attach']['logo'];?>"/>
                                                    
                                                    <?}else{
	                                                    ?>
	                                                    
	                                                    <img style="width: 50%;" src="/alfa/assets/img/agent-01.jpg" />
	                                                    
	                                                    <?
	                                                
                                                    }?>
                                                    </figure>
                                                    <div class="agent-contact-info">
                                                        <dl>
                                                            <dt>Телефон:</dt>
                                                            <dd><? echo $quest['phone']; ?></dd>
                                                            <dt>Email:</dt>
                                                            <dd><a href="mailto:<?=$quest['questRoom']['email'];?>"><?=$quest['questRoom']['email'];?></a></dd>
                                                            <!--dt>Сайт:</dt>
                                                            <dd>pobia.ru</dd-->
                                                        </dl>
                                                        <hr>
                                                        <a href="/questrooms/<?=$quest['userId'];?>" class="link-arrow">Квесты от квеструма <?=$quest['questRoom']['name'];?> </a>
                                                    </div>
                                                </aside><!-- /.agent-info -->
                                            </div><!-- /.col-md-7 -->
                                            <div class="col-md-5 col-sm-12">
                                                <div class="agent-form">
                                                                                                           
                                                        
                                            </div><!-- /.col-md-5 -->
                                        </section><!-- /.agent-form -->
                                    </div><!-- /.row -->
                                </section><!-- /#contact-agent -->
                                <hr class="thick">
                                <section id="similar-properties">
                               
                              <? if($quest['others']){ ?>
                               
<header><h2 class="no-border">Другие квесты квеструма</h2></header>
                      
                      <?php  
                      $i=1;
                      foreach ($quest['others'] as $room){ ?>
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
										?>
											<img src="<? echo $ii;?>" alt="<?echo $room['value'];?>" />
										 
										 <? break;
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
                      
                      <? if($i==3){?>
                      </div>
                      <?}?>
                      <!-- /.row-->
                      
                      <?}?>
                      
                      
                      <?}?>
                      
                                </section><!-- /#similar-properties -->
                                <?if (count($comments)>0){ ?>
                                <hr class="thick">
                                <section id="comments">
                                    <header><h2 class="no-border">Отзывы</h2></header>
                                    
                                    <ul class="comments">
                                        <? foreach($comments as $cc){ ?>
                                        <li class="comment">
                                            <figure>
                                                <!--div class="image">
                                                   
                                                </div-->
                                            </figure>
                                            <div class="comment-wrapper">
                                                <div class="name pull-left"><?=$cc['user_name'];?></div>
                                                <span class="date pull-right"><span class="fa fa-calendar"></span><?=date("d.m.Y", strtotime($cc['commentDate']));?></span>
                                                <div class="rating rating-individual" data-score="<?=$cc['rating'];?>"></div>
                                                <p><?=$cc['commentBody'];?></p>
                                                
                                                <hr>
                                            </div>
                                        </li>
                                       <?}?>
                                        
                                    </ul>
                                </section>
                                <?}?>
                            </div><!-- /.col-md-12 -->
                        </div><!-- /.row -->
                    </section><!-- /#property-detail -->
                </div><!-- /.col-md-9 -->
                <!-- end Property Detail Content -->

               <?php
               	 include $_SERVER['DOCUMENT_ROOT'].'/tmpl/sidebar.php';
                ?>

            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
    <!-- end Page Content -->
    
    
    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Электронная бронь на квест</h4>
      </div>
      <div class="modal-body">
      <h3>Заказ на:</h3>
      <h4 id="orderHeader"></h4>
      введите ваши данные для бронирования:
      
      <form role="form" action="" method="post">
      <input type="hidden" id="orderValue" value="" />
      <input type="hidden" id="roomId" value="<?=$quest['id'];?>" />
      <input type="hidden" id="roomUrl" value="<?=$quest['url'];?>" />
      
     
        <div class="form-group phoneGroup">
		    <label class="sr-only" for="phone">Ваш телефон</label>
		    <input required type="text" value="<?if($userPhone!='') echo $userPhone;?>" class="form-control" id="phone" placeholder="Ваш телефон">
			
		  </div>
		  <div 	class="form-group emailGroup">
		    <label class="sr-only" for="email">Ваш E-mail</label>
		    <input required type="email" value="<? if($this->session->userdata('is_logged_in')) echo $this->session->userdata('user_name'); ?>" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" class="form-control" id="email" placeholder="Ваш E-mail">
		</div>
		
		<div class="has-error formErr"></div>
		</form>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default confirmit" >Забронировать</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>
