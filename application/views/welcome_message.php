<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

 <!-- Page Content -->
    <div id="page-content">
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><!--a href="#">Главная</a--></li>
            </ol>
        </div>
        <!-- end Breadcrumb -->

        <div class="container">
            <div class="row">
                <!-- Results -->
                <div class="col-md-9 col-sm-9">
                   
                    <section id="results">
                        <header><h1><?php echo $titleOnPage ?></h1></header>
                        
                        <section id="search-filter">
                            <figure><h3><i class="fa fa-search"></i>Всего квест комнат:</h3>
                                <span class="search-count"><?=$AllroomsCount;?></span>
                                
                                <div class="sorting">
                                    <div class="form-group">
                                        <select class="frontendSort" name="sorting" onchange="gotoUrl(this.value);">						
                                        
                                        
                                            <option <? if($sort=='rating') echo 'selected="selected"';?> value="rating">Лучшие</option>
                                            <option <? if($sort=='enters') echo 'selected="selected"';?> value="enters">Популярные</option>
                                            <option <? if($sort=='id') echo 'selected="selected"';?> value="id">Новые</option>
                                            <!--option <? if($sort=='costDESC') echo 'selected="selected"';?> value="costASC">Дорогие</option>
                                            <option <? if($sort=='costASC') echo 'selected="selected"';?> value="costDESC">Дешевые</option-->
                                            <!--option value="4">Со скидкой</option-->
                                            <!--option value="4">Рядом</option-->
                                        </select>
                                    </div>
                                </div>
                                <script>
	                                
	                                function gotoUrl(url){
	                                	if(url!="rating"){
		                                	location.href='/<?=$city?>/'+url;
		                                }
		                                else{
			                                location.href="/";
		                                }
	                                }
	                                
                                </script>
                            </figure>
                        </section>
                        
                        <section id="properties">
                        
                        
                        <?php 
                        
							if($rooms!=null){
							
								
								$i = 1;
								foreach ($rooms as $room){
								$loaded[]=$room['id'];
									//var_dump($room);
	
						?>
                        
                        
                        <? if($i==1){ ?><div class="row"> <?}?>
                            
                            
                            <div class="col-md-4 col-sm-4">
                                <div class="property equal-height">
                                   <?if($room['tarif']==0){?>
                                    <figure class="tag status">
                                    	Не участвует а программе Questura!
                                    </figure>
								   <?}?>			
									
                                    <a href="/<? echo $room['city'].'/'; ?><? echo $room['url'] ?>">
                                        <div class="property-image">
                                            <?
			if(isset($room['attach']['images'])){
				foreach ($room['attach']['images'] as $img) {
					$hasEnd = 0;
					if(file_exists($_SERVER['DOCUMENT_ROOT'].$img)){
						echo '<img alt="'.$room['value'].'"  src="'.$img.'" />';
															break;
														}
													}
												}
											?>
											
											<?php 
											if(is_array($room['params'])){
											foreach ($room['params'] as $params) {?>
											<?
											if($params['icon']=='fa-money'){
													$dop = ' <i class="fa fa-rub"></i>';
											$icon = '<b>'.$params['paramValue'].'</b> '.$dop;
											}else{ 
												//$icon = '';
											}
											
											}
											
											}
											?>
											
                                        </div>
                                        
                                        <div class="overlay">
                                            <div class="info">
                                                <div class="tag price"><?=$icon;?></div>
                                                <h3><?php echo stripslashes($room['value']); ?></h3>
                                                <figure><?=$room['address'];?></figure>
                                            </div>
                                            <ul class="additional-info">
                                                <li>
                                                    <header>Популярность:</header>
                                                    <figure>0</figure>
                                                </li>
                                                <li>
                                                    <header>Рейтинг:</header>
                                                    <figure><?=$room['rating'];?></figure>
                                                </li>
                                            </ul>
                                        </div>
                                    </a>
                                </div><!-- /.property -->
                            </div><!-- /.col-md-3 -->
                            
                        
                        
                        <? if($i==3){ $hasEnd = 1; ?></div><?}
	                        $i++;
	                        if($i >3)$i = 1;
                        ?><!-- /.row-->
                        
                        <?}
	                        
	                        if($hasEnd == 0){
		                        echo '</div>';
	                        }}
	                        else{
		                        echo '<b>Комнат нет</b>';
	                        }
                        ?>
                        
                        
                        

                        <!-- Pagination -->
<div class="center">

                         <? if($AllroomsCount>9){ ?> 
                            <ul class="pagination">
                                
                                <? if($pages){ 
	                                
	                                echo $pages;
                                ?>
                                
                                <!--li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li-->
								<? } ?>
                            </ul><!-- /.pagination-->
                        <?}?>    
                            
                        </div><!-- /.center-->

                        </section><!-- /#properties-->
                        
                        
                        
                    </section><!-- /#results -->
                </div><!-- /.col-md-9 -->
                <!-- end Results -->

                <?php
               	 include $_SERVER['DOCUMENT_ROOT'].'/tmpl/sidebar.php';
                ?>

            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
    <!-- end Page Content -->



<? 
//var_dump($this->session->userdata('city'));
if($this->session->userdata('city')==''){  ?>
<div class="filled">
	<div class="popup centred">
	<span class="yes-reply centred"></span>
	<span class="no-reply centred"></span>
	<a href="#" onclick="$('.filled').hide();" class=" mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect closeBtn">
		<i class="glyphicon glyphicon-remove"></i>
	</a>
	<p>Ваш город "<? echo $mayBeCity['name']; ?>"?</p>
	<a href="<? echo $mayBeCity['slug']; ?>" class="buttonPopup yes transition">Да</a>
	<a href="/cityselect" class="buttonPopup no transition">Нет</a>
	</div> 
	<div class="refresh transition"></div>
</div>
<?}?>




