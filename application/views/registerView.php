<div id="page-content">
       
       
        <!-- Breadcrumb -->
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Регистрация нового пользователя</li>
            </ol>
        </div>
  
  
  
   <div class="container">
   
   <? if(isset($account_created)){?>
	<h1 class="blackText"><? echo $account_created;?></h1>
	<?} else { ?> 
		 <h1 class="blackText">Регистрация нового пользователя</h1>
	<? } ?>
   
   <div class="row">
                <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
	
	
	<?
		if(!isset($promo)){
			$promo = '';
		}
		echo form_open('cabinet/createMember');
		echo form_input('promo',set_value('promo',$promo),'промокод партнера','<i class="fa fa-question-circle tool-tip"  data-toggle="tooltip" data-placement="right" title="Для получения 100 рублей на баланс, которые можно потратить на оплату прохождения квеста, введите промокод. Если у Вас нет промокода, оставте это поле пустым"></i>');
		echo form_input('email',set_value('email',''),'ваш E-mail');
		echo form_input('phone',set_value('phone',''),'ваш телефон');
		echo form_input('name',set_value('name',''),'ваше имя');
		echo @form_password('password','','ваш пароль');
		//echo form_checkbox('is_questroom','я владелец квеструма',set_value('is_questroom',''));
		//echo form_checkbox('is_action','я участник Мегаквеста от ЕКАБУ',set_value('is_action',''));
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
