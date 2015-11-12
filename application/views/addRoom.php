
<br>
<?php
	//var_dump($pageContent);
	if(count($pageContent)==0){
		$pageContent['value'] = '';
		$pageContent['cost'] = '';
		$pageContent['text'] = '';
		$pageContent['active'] = '';
		$pageContent['attach']['images'] = 0;
	}
	
	//var_dump($pageContent['ListTime']);
?>
<script> 

 var days_data;
 var isemptyarray=0;
 var fields   <? if(isset($pageContent['ListTime'])){ ?> = JSON.parse('<? echo $pageContent['ListTime']; ?>'); <? } else {  ?> = [0,0,0,0,0,0,0]; isemptyarray=1; <? }?>

 days_data = fields;
  
 //console.log( result );

</script>

<?php echo form_open_multipart('');?>

<div class="mydiv">

<table ng-controller="DayCost" class="table">
	
	
	
	<tr>
		<td valign="top">
			Время/стоимость<br>1) если у вас единое расписание на будни - заполните только "пн" и "сб"<br>2) если на выходных свое расписание - заполните их отдельно 
		</td>
		<td>
			<table class="mdl-data-table mdl-js-data-table">
				<tr>
					<td>
						пн
					</td>
					<td>
						<div ng-repeat="field in data.fields[1]"><span my-date-cost="field" demo-days="days" id="day1"></span></div>
						<button type="button" ng-click="addButton(1)" class="mdl-button mdl-js-button delbtn mdl-button--fab mdl-js-ripple-effect"><i class="glyphicon glyphicon-time">добавить время</i><span class="mdl-button__ripple-container"><span class="mdl-ripple is-animating"></span></span></button>
					</td>
				</tr>
				<tr>
					<td>
						вт
					</td>
					<td>
						<div ng-repeat="field in data.fields[2]"><span my-date-cost="field" demo-days="days" id="day1"></span></div>
						<button type="button"  ng-click="addButton(2)" class="mdl-button mdl-js-button delbtn mdl-button--fab mdl-js-ripple-effect"><i class="glyphicon glyphicon-time">добавить время</i><span class="mdl-button__ripple-container"><span class="mdl-ripple is-animating"></span></span></button>
					</td>
				</tr>
				<tr>
					<td>
						ср
					</td>
					<td>
						<div ng-repeat="field in data.fields[3]"><span my-date-cost="field" demo-days="days" id="day1"></span></div>
						<button type="button"  ng-click="addButton(3)" class="mdl-button mdl-js-button delbtn mdl-button--fab mdl-js-ripple-effect"><i class="glyphicon glyphicon-time">добавить время</i><span class="mdl-button__ripple-container"><span class="mdl-ripple is-animating"></span></span></button>
					</td>
				</tr> 
				<tr>
					<td>
						чт
					</td>
					<td>
						<div ng-repeat="field in data.fields[4]"><span my-date-cost="field" demo-days="days" id="day1"></span></div>
						<button type="button"  ng-click="addButton(4)" class="mdl-button mdl-js-button delbtn mdl-button--fab mdl-js-ripple-effect"><i class="glyphicon glyphicon-time">добавить время</i><span class="mdl-button__ripple-container"><span class="mdl-ripple is-animating"></span></span></button>
					</td>
				</tr>
				<tr>
					<td>
						пт
					</td>
					<td>
						<div ng-repeat="field in data.fields[5]"><span my-date-cost="field" demo-days="days" id="day1"></span></div>
						<button type="button"  ng-click="addButton(5)" class="mdl-button mdl-js-button delbtn mdl-button--fab mdl-js-ripple-effect"><i class="glyphicon glyphicon-time">добавить время</i><span class="mdl-button__ripple-container"><span class="mdl-ripple is-animating"></span></span></button>
					</td>
				</tr>
				<tr>
					<td>
						сб
					</td>
					<td>
						<div ng-repeat="field in data.fields[6]"><span my-date-cost="field" demo-days="days" id="day1"></span></div>
						<button type="button"  ng-click="addButton(6)" class="mdl-button mdl-js-button delbtn mdl-button--fab mdl-js-ripple-effect"><i class="glyphicon glyphicon-time">добавить время</i><span class="mdl-button__ripple-container"><span class="mdl-ripple is-animating"></span></span></button>
					</td>
				</tr>
				<tr>
					<td>
						вс
					</td>
					<td>
						<div ng-repeat="field in data.fields[7]"><span my-date-cost="field" demo-days="days" id="day1"></span></div>
						<button type="button" ng-click="addButton(7)" class="mdl-button mdl-js-button delbtn mdl-button--fab mdl-js-ripple-effect"><i class="glyphicon glyphicon-time">добавить время</i><span class="mdl-button__ripple-container"><span class="mdl-ripple is-animating"></span></span></button>
					</td>
				</tr>
			</table><br>
		</td>
	</tr>
	
	
	<tr>
		<td>
			Жанр
		</td>
		<td>
			<?//var_dump($pageContent['genre']);
				for($i = 1;$i<=4;$i++){
					$genre[$i] = false;
				}
				for($i = 1;$i<=4;$i++){
					$type[$i] = false;
				}
				for($i = 1;$i<=3;$i++){
					$dif[$i] = false;
				}
				
				//var_dump($pageContent);
				if(is_array($pageContent['genre'])){				
					foreach($pageContent['genre'] as $genres){
						switch($genres['value']){
							case 1:
								 $genre[1] = true;
							break;
							case 2:
								 $genre[2] = true;
							break;
							case 3:
								 $genre[3] = true;
							break;
							case 4:
								 $genre[4] = true;
							break;
						}
					}
				}
				
			?>
		
			<? echo form_checkbox('survive',set_value('survive', "Выживание"),$genre[1]); ?>
			<? echo form_checkbox('prison',set_value('prison', "Тюрьма"),$genre[2]); ?>
			<? echo form_checkbox('movie',set_value('movie', "По кинолфильмам"),$genre[3]); ?>
			<? echo form_checkbox('holms',set_value('holms', "Детектив"),$genre[4]); ?>
		</td>
	</tr>
	
	
	<tr>
		<td>
			Тип
		</td>
		<td>
			<?
				//var_dump($pageContent['type']);
				if(is_array($pageContent['type'])){
					foreach($pageContent['type'] as $types){
						switch($types['value']){
							case 1:
								 $type[1] = true;
							break;
							case 2:
								 $type[2] = true;
							break;
							case 3:
								 $type[3] = true;
							break;
							case 4:
								 $type[4] = true;
							break;
						}
					}
				}
				
			?>
			<? echo form_checkbox('forBig',set_value('name', "Для большой компании"),$type[1]); ?>
			<? echo form_checkbox('forKids',set_value('name', "Для детей"),$type[2]); ?>
			<? echo form_checkbox('withAktors',set_value('name', "С актерами"),$type[3]); ?>
			<? echo form_checkbox('strawberry',set_value('name', "18+"),$type[4]); ?>
		</td>
	</tr>
	
	<tr>
		<td>
			Сложность
		</td>
		<td>
			<?
				if(is_array($pageContent['dif'])){
					foreach($pageContent['dif'] as $difs){
						switch($difs['value']){
							case 1:
								 $dif[1] = true;
							break;
							case 2:
								 $dif[2] = true;
							break;
							case 3:
								 $dif[3] = true;
							break;
						
						}
					}
				}
				
			?>
			<? echo form_checkbox('easy',set_value('name', "Легкие"),$dif[1]); ?>
			<? echo form_checkbox('medium',set_value('name', "Средние"),$dif[2]); ?>
			<? echo form_checkbox('hard',set_value('name', "Сложные"),$dif[3]); ?>
			
		</td>
	</tr>
	
	
	<tr>
		<td>
			Название
		</td>
		<td>
			<? echo form_input('name',set_value('name', $pageContent['value']) ,'название'); ?>
		</td>
	</tr>
	 
	<tr>
		<td>
			Стоимость
		</td>
		<td>
			<? echo form_input('cost',set_value('cost',$pageContent['cost']),'стоимость'); ?>
		</td>
	</tr>
	
	<tr>
		<td>
			Описание
		</td>
		<td>
			<div style="position: relative; z-index:9999;"> 
			
			<textarea id="aboutText1" name="aboutText" rows="30" cols="80"><? echo $pageContent['text']; ?></textarea>
		    <script>
             $( document ).ready(function() { //CKEDITOR.replace( 'aboutText' ); 
             //	$('#aboutText1').wysiwyg();
             });
            </script>
            </div>
		</td>
	</tr>
	
	
	<tr>
		<td>
			Фото
		</td>
		<td> 
			<?
				if(isset($pageContent['attach']['images'])){
					if(is_array($pageContent['attach']['images'])){
						$i = 0;
						foreach($pageContent['attach']['images'] as $ai){
							//var_dump($ai);
							if(file_exists($_SERVER["DOCUMENT_ROOT"].$ai)){
							echo '<div id="photo'.$i.'" class="imglist__item"><a href="#"><img class="imglist__image" src="'.$ai.'" height="100px" /></a><a onclick="delImage(\''.$ai.'\','.$i.','.$pageContent['id'].')" class="mdl-button mdl-js-button delbtn mdl-button--fab mdl-js-ripple-effect"><i class="material-icons">clear</i></a></div>';
							$i++;
							}
						}
					}
				}
			?>
		
			
			<div>
				<input type="file" name="photos[]" nv-file-select="" uploader="uploader" multiple  />
			</div>
		</td>
	</tr>
	
	
	<tr>
		<td>
			Активность
		</td>
		<td>
			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="is_active">
			  <input <?if($pageContent['active']==1) echo 'checked="checked"';?> type="checkbox" id="is_active" name="is_active" class="mdl-checkbox__input"  />
			 
			</label>
		</td>
	</tr>
	
</table><br><br>

</div>


<input type="hidden" name="daytime" id="daytime" value=""/>

<button name="submit" value="создать" onclick="checkMe(); return false;" type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
  сохранить
</button>
	<a href="/cabinet/rooms" class="mdl-button mdl-js-button mdl-js-ripple-effect">вернуться к списку</a>	
	


<? echo validation_errors('<p class="errors blackText">'); ?>

<br><br>
</form>


<script type="text/javascript">
	function checkMe(){
		
		var check = 0;
		
		$.each(days_data, function( index, value ) {
		  if(value==0){
			  check ++;
		  }
		  //alert( index + ": " + value );
		});
		
		
		if(check == 7){
			alert("Обязательно заполните расписание !");
			//console.log("a-a-a-a");
		//	return false;
		}
		else{
			$('#daytime').val(JSON.stringify(days_data));
			document.forms[0].submit();
		}
	}
	
</script>