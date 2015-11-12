 <!-- Page Footer -->
    <footer id="page-footer">
        <div class="inner">
            <aside id="footer-main">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <article>
                                <h3>О проекте</h3>
                                <p>Впервые в истории Квестов внедренна реферальная система. На нашем портале реализованые честный рейтинг и отзывы. 
                                КвестРумам больше не нужно беспокоится о создании своего сайта и продвижении.</p><hr>
                                <a href="/pages/about" class="link-arrow">Подробнее</a>
                            </article>
                        </div><!-- /.col-sm-3 -->
                        <div class="col-md-3 col-sm-3">
                            <article>
                                <h3>Новые квесты <?=$city_name_pp?></h3>
                                
                                <? if(count($newPos)>0){ 
	                               foreach($newPos as $np){
                                ?>
                                
                                <div class="property small">
                                    <a href="/<? echo $np['city'].'/'; ?><? echo $np['url'] ?>">
                                        <div class="property-image">
                                           <img src="<?=$np['image']?>">
                                        </div>
                                    </a>
                                    <div class="info">
                                        <a href="/<? echo $np['city'].'/'; ?><? echo $np['url'] ?>"><h4><?=$np['name'];?></h4></a>
                                        <figure><?=$np['address'];?></figure>
                   <div class="tag price"><? if(isset($np['cost']) ) echo $np['cost'];?></div>
                                    </div>
                                </div><!-- /.property -->
                                
                                  <?}?>
                                <?}?>
                                
                            </article>
                        </div><!-- /.col-sm-3 -->
                        <div class="col-md-3 col-sm-3">
                            <article>
                                <h3>Контакты</h3> 
                                <a href="mailto:adm@questura.ru">adm@questura.ru</a><br><br>
                                <a target="_blank" href="http://vk.com/questura">Вконтакте</a><br>
                                <a target="_blank" href="http://vk.com/questuraekb">Вконтакте Екатеринбург</a><br>
                                <a target="_blank" href="https://instagram.com/questura.ru/">Инстаграм</a><br>
                            </article>
                        </div><!-- /.col-sm-3 -->
                        <div class="col-md-3 col-sm-3">
                            <article>
                            	<img src="/frontend/header/images/qlogo.png" />
                                <!--h3>Полезное</h3>
                                <ul class="list-unstyled list-links">
                                    <li><a href="#">Все квесты</a></li>
                                    <li><a href="#">Правила</a></li>
                                    <li><a href="#">Сценарии квестов</a></li>
                                    <li><a href="#">Видео квесты</a></li>
                                    <li><a href="#">Каталог сайтов</a></li>
                                </ul-->
                            </article>
                        </div><!-- /.col-sm-3 -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </aside><!-- /#footer-main -->
            <aside id="footer-thumbnails" class="footer-thumbnails"></aside><!-- /#footer-thumbnails -->
            <aside id="footer-copyright">
                <div class="container">
                    <span>Copyright © 2015</span>
                    <span class="pull-right"><a href="#page-top" class="roll">Вверх</a></span>
                </div>
            </aside>
        </div><!-- /.inner -->
    </footer>
    <!-- end Page Footer -->
</div>




<script type="text/javascript" src="/alfa/assets/js/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/alfa/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/alfa/assets/js/smoothscroll.js"></script>
<script type="text/javascript" src="/alfa/assets/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="/alfa/assets/js/icheck.min.js"></script>
<script type="text/javascript" src="/alfa/assets/js/retina-1.1.0.min.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="/alfa/assets/js/tmpl.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="/alfa/assets/js/draggable-0.1.js"></script>
<script type="text/javascript" src="/alfa/assets/js/jquery.slider.js"></script>
<script type="text/javascript" src="/alfa/assets/js/custom.js"></script>

<?echo $addonScripts;?> 
<!--[if gt IE 8]>
<script type="text/javascript" src="assets/js/ie.js"></script>
<![endif]-->

<script>
	$( document ).ready(function() {
			$('html').css('height','100%');
			$('html').css('height','auto');
  	});
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter31701641 = new Ya.Metrika({
                    id:31701641,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/31701641" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!--LiveInternet counter--><script type="text/javascript"><!--
new Image().src = "//counter.yadro.ru/hit?r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random();//--></script><!--/LiveInternet-->

</body>
</html>