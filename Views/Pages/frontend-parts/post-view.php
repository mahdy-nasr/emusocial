<!-- first post-->

<?php if(!count($posts)) die;foreach ($posts as $post) { 	?>

					<div class="panel panel-white post panel-shadow">
					  <div class="post-heading">
					      <div class="pull-left image">
					          <img src="<?=$base.$post->getUser('profile_picture')?>" class="avatar" alt="user profile image">
					      </div>
					      <div class="pull-left meta">
					          <div class="title h5">
					              <a href="#" class="post-user-name"><?=$post->getUser('name')?></a>
					      
					          </div>
					          
					          <?php 
					          $post_link = "/page/viewPost/?page_id={$post->getPageId()}&post_id={$post->getId()}";
					          
					          	if ($post->getIsUser()) {
					          		$post_link="/profile/viewPost/?id={$post->getIsUser()}&post_id={$post->getId()}";
					          	}
					          ?>

					          <a href="<?=$post_link?>"><h6 class="text-muted time"><?=passedTime($post->getCreatedAt())?> ago</h6></a>
					      </div>
					      <div class="pull-right meta" style='position: relative;;'>
					          <div class="title h5 opt-div">
					          <?php if($post->isAnnouncement()):?>
					          
					          <i class="announcement-class fa fa-bullhorn "></i>
					          
					          <?php endif;?>
					          <?php if($user->getId() == $post->getUser('id')||isset($user_role)&&$user_role=='i'):?>
					              <a href="#"  class="post-user-del">...</a>
					               <?php endif;?>
					          </div>
					          <ul class='opt-del-post opt-del'>
					          	<a href='#' link="<?=$post->getId();?>"  ><li>delete the post!</li></a>
					          </ul>
					      </div>
					  </div>
					  <div class='post-description' >
					  	<p style="font-weight: 300;font-size: 22px;" ><?=htmlentities($post->getText());?></p>
					  </div>
					
					  <div class="post-image" style='border:none;'>
					      <!--img src="img/Post/game.jpg" class="image show-in-modal" alt="image post"-->
					      <?php if($post->getEvent()):?>
					      <div style="width:100%; margin:0;padding:0;" id='event-div'>

			              		<div class="col-xs-6 no-padding-margin">
			              			<div class="input-group no-padding-margin" style="width:100%;">
			              				<span class="input-group-addon icon-input" id="basic-addon4">
			              					<i class="fa fa-bookmark-o" aria-hidden="true"></i>
			              				</span>
			              			
			              				<input type="text" readonly="readonly" value='<?=$post->getEvent('title')?>'  class="form-control" style="margin:0;border-radius:0 !important;background-color:#fff;"  >
			              			</div>
			              		</div>
			              		<div class="col-xs-6 no-padding-margin">
			              			<div class="input-group no-padding-margin" style="width:100%;">

			              				<span class="input-group-addon icon-input" id="basic-addon5">
			              					<i class="fa fa-map-marker" aria-hidden="true"></i>
			              				</span>
			              				<input type="text" readonly="readonly" value='<?=$post->getEvent('place')?>'  class="form-control" style="margin:0;background-color:#fff;border-radius:0 !important;"  >
			              			</div>
			              		</div>
			              		<div class="col-xs-6 no-padding-margin">
						              <div class="input-group no-padding-margin" id='date-div' style="width:100%;">
										  <span class="input-group-addon icon-input" id="basic-addon1"> 
										  	<i class="fa fa-calendar" aria-hidden="true"></i>
										  </span>
										  <input type="text" readonly="readonly" value="<?=$post->getEvent('date')?>"  class="form-control" style="margin:0;background-color:#fff;border-radius:0 !important;"  >
									   </div>
								</div>
								<div class="col-xs-6 no-padding-margin" style="border-right:1px solid #bbb;">
								   <div class="input-group no-padding-margin" id='time-div' style="width:100%;">
									  <span class="input-group-addon icon-input" id="basic-addon2" >
									  	<i class="fa fa-clock-o" aria-hidden="true"></i>
									  </span>
									  <input type="text" readonly="readonly" value="<?=$post->getEvent('time')?>"  class="form-control" style="margin:0;background-color:#fff;border-radius:0 !important;"  >
								   </div>
								</div>
								<div class="clearfix"></div>
						   </div>
					      <?php elseif($post->hasVideos()) : ?>
					      <video width="100%" controls class="has-border" >
							  <source src="<?=$base.$post->getVideos(0,'link')?>" type="video/mp4" >
							  Your browser does not support HTML5 video.
						   </video>
						   <?php elseif ($post->hasImages()):?>
						   <img  src="<?=$base.$post->getImages(0,'link')?>" class="image show-in-modal has-border" alt="image post">
						   <?php endif;?>
					  </div>
					 
					 <?php if($post->hasMultibleFiles()):?>
					 <div class='multiple-files '>
					    <?php foreach ($post->getVideos() as $video) { ?>
					  	 	<a class='file-list video-list' link="<?=$video['link']?>" name="<?=$video['name']?>"  >
					  	 		<li class='fa fa-file-video-o'></li>
					  	 	</a>
					  	<?php }?>

					  	<?php foreach ($post->getImages() as $image) { ?>
					  	 	<a class='file-list image-list' link="<?=$image['link']?>" name="<?=$image['name']?>"  >
					  	 		<li class='fa fa-file-image-o'></li>
					  	 	</a>
					  	<?php }?>
					  	<?php foreach ($post->getFiles() as $file) { ?>
					  	 	<a class='file-list ffile-list' link="<?=$file['link']?>" name="<?=$file['name']?>" >
					  	 		<li class='fa fa-file-o'></li>
					  	 	</a>
					  	<?php }?>
					 </div>
					 <?php endif;?>
					  <div class="post-description <?=(!$post->hasImages()&&!$post->hasVideos())?"has-border-top":""?>" >
					  	 
					      
					      <div class="stats" >
					      <?php 
						      $cls = 'not-liked';
						      if ($post->getLikes('liked',$user->getId())) {
						      	$cls  = 'font-main-color';
						      }
					      ?>
					          <a href="#"  link="<?=$post->getId()?>"  class='<?=$cls?> stat-item like-stat'>
					              <i class="fa fa-thumbs-up icon"></i>
				
					              <span class='stats-num'><?=$post->getLikes('count')?></span>
			
					          </a>
					          <!--a href="#" class="stat-item">
					              <i class="fa fa-retweet icon"></i>
					              128
					          </a-->
					          <a href="" class="not-liked stat-item stat-com"   style='cursor:default;' >
					              <i class="fa fa-comments-o icon"></i>
					        
					              <span class='stats-num'><?=$post->getAllComments()?></span>
					     
					          </a>
					      </div>
					  </div>
					  <div class="post-footer" >
					      <?php include $this->partPath("frontend-parts/comment-view");?>
					  </div>
					</div><!-- first post-->
	<?php } ?>
