
<!-- Timeline content -->
    <div class="container container-timeline" style="margin-top:100px;">
    	<div class="col-md-offset-1 col-md-10">
	    	<?php include $this->partPath("home-parts/loggedLeft");?>
	    	<div class="col-md-7 no-paddin-xs">
	    		<?php include $this->partPath("frontend-parts/post-form");?>


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
						profile_id:'<?=$profile->getId()?>',
						autoPull:true,
						refreshPostURL:"home/getTimelinePosts/"
					});

					post.run();

					comment.init({base:'<?=$base?>'});

					comment.run();
				</script>
	
	    		    		
	    	</div>
    	</div>
    </div>