<ul class="list-group">
	<?php foreach($events as $event){?>

	<li class="list-group-item"><i class="fa fa-calendar text-danger"></i>&nbsp; <a href='<?=$base."page/viewPost/?post_id={$event['post_id']}&page_id={$event['page_id']}"?>'> <?=$event['title'].' &nbsp; '.$event['date']?></a></li>

	<?php }?>
	
</ul>