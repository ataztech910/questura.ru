<?php 
if(count($rooms)>0){
foreach ($rooms as $room){ 
	//$loaded[]=$room['id'];
	
?>
<div class="mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-card  mdl-textcenter hover-shadow" >
	
	<div class="mdl-card__media curled">
		<? if($room['url']!='Megakvest_EKABU'){ ?>
		<a href="/<? echo $room['city'].'/'; ?><? echo $room['url'] ?>">
		<?}
			else{
				?>
					<a href="/pages/megaquest">
				<?
			}
		?>	
			<?
				if(isset($room['attach']['images'])){
					foreach ($room['attach']['images'] as $img) {
						echo '<img alt="'.$room['value'].'" height="231" src="'.$img.'" />';
						break;
					}
				}
			?>
			
		</a>
		
		<div class="mdl-card__actions ">
			<span class="demo-card-image__filename">
			
			<?php 
			if(is_array($room['params'])){
			foreach ($room['params'] as $params) {?>
			<?
			if($params['icon']=='fa-money'){
					$dop = ' <i class="fa fa-rub"></i>';
			$icon = '<b>'.$params['paramValue'].'</b> '.$dop;
			}else{ 
				$icon = '';
			}
			}
			?>
			<? if($room['url']!='Megakvest_EKABU'){ ?>
			<a  href="/<? echo $room['city'].'/'; ?><? echo $room['url'] ?>" title class="room--params nounderline">
			<?
				}else{
					?>
					<a class="room--params nounderline" href="/pages/megaquest">
					<?
				}
				
			?>
			<? echo $icon; ?></a>
		<?php } ?></span>
		</div>
	</div>
	
	<? if($room['url']!='Megakvest_EKABU'){ ?>
	<a class="nounderline" href="/<? echo $room['city'].'/'; ?><? echo $room['url'] ?>">
	<?
		
		}else{
					?>
					<a class="nounderline" href="/pages/megaquest">
					<?
				}
		
	?>
	
	<div class="mdl-card__title mdl-textcenter">
		<h4 class="mdl-card__title-text mdl-textcenter"><?php echo stripslashes($room['value']); ?></h4><?if($room['is_action']==1){?><i id="tt<?echo $room['id'];?>" class="material-icons">extension</i>
									<div class="mdl-tooltip" for="tt<?echo $room['id'];?>">
											Участник <strong>Мегаквеста от ЕКАБУ</strong>
									</div>
		<?}?>
	</div>
	</a>
</div>		
<?}

}?>
