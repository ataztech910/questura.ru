<header><h1>Выберите Ваш тариф</h1></header>
<section id="pricing">
<div class="row">
	<?
		//var_dump($pageContent);
		foreach($pageContent['tarifs'] as $tt){
		
		
			$btn = 'текущий тариф';
			
			if($tt['id']!=$pageContent['current']){
				$btn = '<a href="#" onclick="changetarif('.$tt['id'].',\''.$tt['tarif_name'].'\','.$pageContent['userId'].');" class="btn btn-default">Выбрать</a>';
			}
		
			echo '<div class="col-md-3 col-sm-6">
                        <div class="price-box promoted">
                            <header><h2>'.$tt['tarif_name'].'</h2></header>
                            <div class="price">
                                <figure>'.$tt['tarif_cost'].'</figure>
                                <small>/ месяц</small>
                            </div>
                           '.$tt['tarif_text'].'
                            '.$btn.'
                        </div><!-- /.price-box -->
                    </div><!-- /.col-md-3 -->';
		}
	?>
</div>
</section>
<script>
	
	function changetarif(id,tname,userId){
		if(confirm("Перейти на тариф \""+tname+"\" ?"))	{
			
			$.get( "/cabinet/changetarif", { id: id, userId: userId } )
		  .done(function( data ) {
		    
		    console.log(data);
		    
		    if(data==1){
			  
			  location.reload();
			  
		    }
		    else{
			    console.log('ошибка записи в базу');
			   
		    }
		    
		   }); 
			
		}	
	}
	
</script>