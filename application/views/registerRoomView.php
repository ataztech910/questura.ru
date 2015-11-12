<div id="page-content">
       
       
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Регистрация нового квеструма</li>
            </ol>
        </div>
  
  
  
   <div class="container">
   
   <? if(isset($account_created)){?>
	<h1 class="blackText"><? echo $account_created;?></h1>
	<?} else { ?> 
		 <h1 class="blackText">Регистрация нового квеструма</h1>
	<? } ?>
   
   <div class="row">
                <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
	
	
	<?
		if(!isset($promo)){
			$promo = '';
		}
		echo form_open('cabinet/createMember');
		
		echo form_input('email',set_value('email',''),'ваш E-mail');
		echo form_input('phone',set_value('phone',''),'ваш телефон');
		echo form_input('name',set_value('name',''),'название вашего квеструма');
		echo @form_password('password','','ваш пароль');
		//echo form_checkbox('is_questroom','я владелец квеструма',set_value('is_questroom',''));
		//echo form_checkbox('is_action','я участник Мегаквеста от ЕКАБУ',set_value('is_action',''));
	?>
	
	 <div class="form-group">
	    <label for="tarif">ваш тариф</label>
	    <select id="tarif" name="tarif" class="form-control">
	      
	      <option selected="selected" value="1" <? if(isset($_GET['tarif']) && $_GET['tarif']==1) echo 'selected="selected"'; ?>>Стартап</option>
        </select>
	  </div>   
	
	<div class="form-group">
	    <label for="city">ваш город</label>
	    <select id="city" name="city" class="form-control">
	      <?
		      foreach($allCity as $ac){
			      //echo '<optgroup label="'.$ac['name'].'">';
			     // foreach($ac['childs'] as $acc){
			      	  
				     echo '<option  value="'.$ac['id_region'].'">'.$ac['name'].'</option>';
			     // }
			      //echo '</optgroup>';
		      }
	      ?>
      </select>
	    </div>
	    
	
	    
	    
	<input type="hidden" name="is_questroom" id="is_questroom" value=1 />
	
	
	<?	
		
		echo form_submit('submit','Регистрация');
		//echo anchor('cabinet','Вход');
		echo form_close();
	?>
	<? echo validation_errors('<p class="errors blackText">'); ?>
	<br>

</div>
</div>
</div>
</div>
