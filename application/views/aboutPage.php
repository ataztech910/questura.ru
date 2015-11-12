<?echo form_open_multipart('cabinet/preference');?>

<? 
   echo form_hidden('userId',$user_data[0]['id']); 
   echo form_hidden('userType',$this->session->userdata('user_type') ); 
?>
<table class="table">
  <thead>
    <tr>
      <th>Параметр</th>
      <th>Значение</th>
    </tr>
  </thead>
  
  <tbody>
    <? if(isset($user_data[0]['email'])) { ?>
    <tr>
      <td>E-mail</td>
      <td><?echo form_input('email',set_value('email',$user_data[0]['email']),'ваш email');?></td>
    </tr>
    <?}?>
    
    <? if(isset($user_data[0]['myPromo'])) { ?>
    <tr>
      <td>Промокод</td>
      <td>
      	<?
	      	if(trim($user_data[0]['myPromo'])==''){
		?>
			<span id="promoSpan">
			<div class="mdl-textfield mdl-js-textfield textfield-demo">
				<input class="mdl-textfield__input" maxlength="20" type="text" id="promo" value=""/>
			    <label class="mdl-textfield__label" for="promo">введите промокод</label>
			</div>
			<button type="button" id="createPromo" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
			  сохранить
			</button>
			</span>
		<?      	
	      	}
      	?>
      	<?echo $user_data[0]['myPromo']?>
      </td>
    </tr>
    <?}?>
    
    <? if(isset($user_data[0]['userPromo'])) { ?>
    <tr>
      <td>Пришел по коду</td>
      <td><?echo $user_data[0]['userPromo']?></td>
    </tr>
    <?}?>
    
    
    <tr>
      <td>Имя / Название</td>
      <td><?echo form_input('name',set_value('name',$user_data[0]['name']),'имя или название');?></td>
    </tr>
    
    <? if(isset($user_data[0]['cityId'])) { ?>
    <tr>
      <td>Город</td>
      <td>
      <div class="mui-select">
      <select id="city" name="city">
	    <option >выберите город</option>
	      <?
		      foreach($allCity as $ac){
			      echo '<optgroup label="'.$ac['name'].'">';
			      foreach($ac['childs'] as $acc){
			      	  $selected = '';
			      	  if($acc['id_region']==$user_data[0]['cityId']){
				      	  $selected = "selected='selected'";
			      	  }	
				      echo '<option '.$selected.' value="'.$acc['id_region'].'">'.$acc['name'].'</option>';
			      }
			      echo '</optgroup>';
		      }
	      ?>
      </select>
      </div>
      </td>
    </tr>
    <?}?>
    
	<? if(isset($user_data[0]['phone'])) { ?>
    <tr>
      <td>Телефон</td>
      <td><?echo form_input('phone',set_value('phone',$user_data[0]['phone']),'введите телефон');?></td>
    </tr>
    <? } ?>
   
    <? if($this->session->userdata('user_type')==1){ ?>
    
    <? if(isset($user_data[0]['address'])) { ?>
    <tr>
      <td>Адрес</td>
      <td><?echo form_input('address',set_value('address',$user_data[0]['address']),'введите адрес');?></td>
    </tr>
    <? } ?>
    
    <? if(isset($user_data[0]['map'])) { ?>
    <tr>
      <td>Координаты <br>( введите, чтобы попасть на карту квестов)</td>
      <td><?echo form_input('map',set_value('map',$user_data[0]['map']),'введите координаты');?></td>
    </tr>
    <?}?>
    
    
    <tr>
	    <td>
		    Лого
	    </td>
	    <td>
		    <? if(!empty($user_data[0]['attach']->logo)) { ?>
		    <div class="imglist__item">
		    	<img class="imglist__image" src="<? echo $user_data[0]['attach']->logo; ?>" height="45" /><a style="cursor:pointer;" onclick="deleteLogo(<?echo $user_data[0]['id'];?>)" class="mdl-button mdl-js-button delbtn mdl-button--fab mdl-js-ripple-effect"><i class="glyphicon glyphicon-remove"></i></a>
		    </div>
		    <?}?>
		    <input type="file" name="userfile" id="userfile" />
	    </td>
    </tr>
    
    <tr>
	    <td>
		    Описание
	    </td>
	    <td> 
	    	<textarea id="aboutText1" rows="20" cols="80" name="aboutText"><? if($user_data[0]['attach']!='') echo @$user_data[0]['attach']->about; ?></textarea>
		    <script>
            //CKEDITOR.replace( 'aboutText' );
            </script>
	    </td>
    </tr>
    <?}?>
   
  </tbody>	  
  </table>
 <br>
 <button name="updateQr" type="submit" id="updateForm" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
			  обновить
			</button>
 


</form>
