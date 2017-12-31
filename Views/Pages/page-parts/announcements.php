 <?php 
 if ($user_role == 'i') {
 	include $this->partPath("frontend-parts/post-form");
 }
?>
 
 <div id='post-cont'>

 <?php include $this->partPath("frontend-parts/post-view");?>
 </div>

<script type="text/javascript" src="<?=$base?>js/post-view.js"></script>
<script type="text/javascript" src="<?=$base?>js/comment-view.js"></script>

<script type="text/javascript">
	post.init({
		base:'<?=$base?>',
		type:'<?=$type?>',
		profile_id:'<?=$post_page_id?>'
	});

	post.run();

	comment.init({base:'<?=$base?>'});

	comment.run();
</script>