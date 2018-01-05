<ul class="list-group">
	<?php foreach ($courses as $key => $course) {?>
		<?php if($course['is_department']):?>
			<li class="list-group-item"><i class="fa fa-cubes"></i>&nbsp; <?=$course['code']?>&nbsp; <a href="<?=$base."page/?page_id={$course['page_id']}"?>"><?=$course['name']?></a></li>
		<?php else:?>
	<li class="list-group-item"><i class="fa fa-bookmark"></i>&nbsp; <?=$course['code']?>&nbsp; <a href="<?=$base."page/?page_id={$course['page_id']}"?>"><?=$course['name']?></a></li>
		<?php endif;?>
	<?php }?>
	
</ul>