<!-- Page Content -->
    <div id="page-content">
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Квеструмы</li>
            </ol>
        </div>
        <!-- end Breadcrumb -->

        <div class="container">
            <div class="row">
                <!-- Agent Detail -->
                <div class="col-md-9 col-sm-9">
                    <section id="agents-listing">
                        <header><h1>Квеструмы</h1></header>
                       
                            
                            <? if(count($qrooms)>0){ 
	                           $i=1;
	                           foreach($qrooms as $qr){
                            
							   if($i==1){
								   echo ' <div class="row">';
							   }	   
                            ?>
                           
                            <div class="col-md-12 col-lg-6">
                                <div class="agent">
                                    
                                    <a href="/questrooms/<?=$qr['id']?>" class="agent-image">
                                    	
                                    	<? if(isset($qr['attach']['logo']) && file_exists($_SERVER['DOCUMENT_ROOT'].$qr['attach']['logo'])) {?>
                                                    
                                                    	<img alt="" src="<?=$qr['attach']['logo'];?>"/>
                                                    
                                                    <?}else{
	                                                    ?>
	                                                    
	                                                    <img src="/alfa/assets/img/agent-01.jpg" />
	                                                    
	                                                    <?
	                                                
                                                    }?>
                                    
                                    </a>
                                    
                                    <div class="wrapper">
                                        <header><a href="/questrooms/<?=$qr['id']?>"><h2><?=$qr['name']?></h2></a></header>
                                        <aside><?=$qr['count'];?> Квеста</aside>
                                        <dl>
                                            <dt>Телефон:</dt>
                                            <dd><?=$qr['phone']?></dd>
                                          
                                            <dt>Email:</dt>
                                            <dd><a href="mailto:<?=$qr['email']?>"><?=$qr['email']?></a></dd>
                                            <dt>Адрес:</dt>
                                            <dd><?=$qr['address']?></dd>
                                        </dl>
                                    </div>
                                </div><!-- /.agent -->
                            </div><!-- /.col-md-12 -->
                            
                         
                        <? $i++;      if($i==3){$i=1; echo '</div><!-- /.row -->';}?>
                       <? }}?>
                        
                        
                    </section><!-- /#agents-listing -->
                   
                </div><!-- /.col-md-9 -->
                <!-- end Agent Detail -->

                <!-- sidebar -->
               <?php
               	 include $_SERVER['DOCUMENT_ROOT'].'/tmpl/sidebar.php';
                ?>
                <!-- end Sidebar -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
    <!-- end Page Content -->