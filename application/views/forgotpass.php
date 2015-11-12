<div class="form-login">
	<h2 class="blackText">Введите E-mail для сброса пароля</h2>
	
	<?
		if(isset($ready)){
			echo '<h4>'.$ready.'</h4>'; 
		}
		
		echo form_open('cabinet/resetpassword');
		echo form_input('email','','ваш E-mail');
		
		echo form_submit('submit','Сброс');
		echo anchor('cabinet','Авторизация');
		echo form_close();
	?>
	<? echo validation_errors('<p class="errors blackText">'); ?>
	<br><br>
</div>