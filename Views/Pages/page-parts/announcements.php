 <?php 
 if ($user_role == 'i' && !$course->getReadonly()) {
 	include $this->partPath("frontend-parts/post-form");
 }
?>
 
 <div id='post-cont'>

 <?php include $this->partPath("frontend-parts/post-view");?>
 </div>

<div class="panel panel-white post-load-more panel-shadow text-center" id='id-post-load-more'>
	<img src="<?=$base?>img/loading-posts.gif" style="max-width:100%;max-height:50px;">
</div>

<script type="text/javascript" src="<?=$base?>js/post-view.js"></script>
<script type="text/javascript" src="<?=$base?>js/comment-view.js"></script>

<script type="text/javascript">
	post.init({
		base:'<?=$base?>',
		type:'<?=$type?>',
		profile_id:'<?=$post_page_id?>',
		refreshPostURL:"<?=$refresh_url?>",
		autoPull:true
	});

	post.run();

	comment.init({base:'<?=$base?>'});

	comment.run();
</script>