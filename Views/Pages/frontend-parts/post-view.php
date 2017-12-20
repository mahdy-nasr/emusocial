<!-- first post-->
<?php foreach ($posts as $post) { 

		$userPostPic = $base."img/Profile/".$post->getUser('gender')."-avatar.png";
		if (!empty($post->getUser('profile_picture')) )
			$userPostPic = $base.$post->getUser('profile_picture');
	?>

					<div class="panel panel-white post panel-shadow">
					  <div class="post-heading">
					      <div class="pull-left image">
					          <img src="<?=$userPostPic?>" class="avatar" alt="user profile image">
					      </div>
					      <div class="pull-left meta">
					          <div class="title h5">
					              <a href="#" class="post-user-name"><?=$post->getUser('first_name').' '.$post->getUser('last_name')?></a>
					      
					          </div>
					          <h6 class="text-muted time"><?=passedTime($post->getCreatedAt())?> ago</h6>
					      </div>
					  </div>
					  <div class='post-description' >
					  	<p style="font-weight: 300;font-size: 22px;" ><?=$post->getText();?></p>
					  </div>
					  <div class="post-image" >
					      <!--img src="img/Post/game.jpg" class="image show-in-modal" alt="image post"-->
					      <?php if($post->hasVideos()) :?>
					      <video width="100%" controls>
							  <source src="<?=$base.$post->getVideos(0,'link')?>" type="video/mp4">
							  Your browser does not support HTML5 video.
						   </video>
						   <?php elseif ($post->hasImages()):?>
						   <img src="<?=$base.$post->getImages(0,'link')?>" class="image show-in-modal" alt="image post">
						   <?php endif;?>
					  </div>
					 
					  <div class="post-description" >
					      
					      <div class="stats" >
					      <?php 
						      $cls = 'not-liked';
						      $user_likes = array_column($post->getLikes(),'user_id');
						      if (in_array($user['id'],$user_likes)) 
						      	$cls  = 'font-main-color';
					      ?>
					          <a href="#"  onclick="return doLike(this);" class='<?=$cls?> stat-item'>
					              <i class="fa fa-thumbs-up icon"></i>
				
					              <span class='stats-num'><?=count($post->getLikes())?></span>
			
					          </a>
					          <!--a href="#" class="stat-item">
					              <i class="fa fa-retweet icon"></i>
					              128
					          </a-->
					          <a href="" class="not-liked stat-item"  onclick='return false;' style='cursor:default;' >
					              <i class="fa fa-comments-o icon"></i>
					        
					              <span class='stats-num'><?=count($post->getComments())?></span>
					     
					          </a>
					      </div>
					  </div>
					  <div class="post-footer" >
					      <?php include $this->partPath("frontend-parts/comment-view");?>
					  </div>
					</div><!-- first post-->
	<?php } ?>

	<script type="text/javascript">
		function doLike(elem) 
		{
			//console.log(elem.getAttribute('value'));
			liked = $(elem).hasClass('font-main-color')?1:0;
			num = parseInt($(elem).find('span').html());
			if (!liked) {
				//alert('do like'); 
				$(elem).find('span').html(num+1);
			} else {
				//alert('remove like');
				$(elem).find('span').html(num-1);
			}
		
			$(elem).toggleClass('font-main-color');
			$(elem).toggleClass('not-liked');

			return false;
		}
		function openReply(elem)
		{
			$(elem).parent().parent().find('.reply').slideToggle();
			return false;
		}
	</script>