<div id="page-content">
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Отзывы</li>
            </ol>
        </div>
        
     <div class="container">
            <div class="row">
                <!-- Property Detail Content -->
                <div class="col-md-9 col-sm-9">    
        
        <!-- end Breadcrumb -->
<?if (count($comments)>0){ ?>
                                
                                <section id="comments">
                                    <header><h2 class="no-border">Отзывы</h2></header>
                                    
                                    <ul class="comments">
                                        <? foreach($comments as $cc){ ?>
                                        <li class="comment">
                                            <figure style="position: relative">
                                        <a target="_blank" href="<?=$cc['questUrl']?>">Квест: <?=$cc['questName']?></a>
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
                                <?}
	                                else{
		                                echo '<b>Отзывов пока нет</b>';
	                                }
                                ?></div></div></div>
</div>        