<ul class="list-group">
	<?php foreach ($all_courses as $key => $course) {?>
		<?php 
			$styl_courses="";
			if ($course['readonly'])
				$styl_courses = "style='color:gray;'";
		?>
		<?php if($course['is_department']):?>
			<li class="list-group-item"><i class="fa fa-cubes"></i>&nbsp; <?=$course['code']?>&nbsp; <a <?=$styl_courses?> href="<?=$base."page/?page_id={$course['page_id']}"?>"><?=$course['name']?></a></li>
		<?php else:?>
	<li class="list-group-item"><i class="fa fa-bookmark"></i>&nbsp; <?=$course['code']?>&nbsp; <a <?=$styl_courses?> href="<?=$base."page/?page_id={$course['page_id']}"?>"><?=$course['name']?></a></li>
		<?php endif;?>
	<?php }?>
	
</ul>