 <div id="page-content">
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Выбор города</li>
            </ol>
        </div>
        
     <div class="container">
            <div class="row">
                <!-- Property Detail Content -->
                <div class="col-md-12 col-sm-12">  
 <div>
     <h2>Выберите город:</h2>
	 <?
	 if(is_array($allCity)){
	 	echo '<table class="citymodal__table"><tr>';
		 foreach($allCity as $ac){
			if(count($ac['childs'])>0){
			 	 echo '<td valign="top"><h4 class="citymodal__header">'.$ac['name'].'</h4>';
				 echo '<ul class="citylist">';
				 foreach($ac['childs'] as $ch){
					 echo '<li class="citylist__element"><a class="citylist__link" href="/'.$ch['slug'].'">'.$ch['name'].'</a></li>';
				 }
				 echo '</ul>';
			 }
			 echo '</td>';
		 }
		 echo '</tr></table>';
	 }
	 ?>
  </div>
  
  </div>
  </div>
  </div>
  </div>
  
  