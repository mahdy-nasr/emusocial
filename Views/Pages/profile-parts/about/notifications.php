<div class="col-md-12 no-paddin-xs">
			<?php foreach ($notifications as $noti) {?>
				<div class="panel panel-white post panel-shadow">
				  <div class="post-heading">
				      <div class="pull-left image">
				          <img src="<?=$base.$noti['user']->getProfilePicture()?>" class="avatar" alt="user profile image">
				      </div>
				      <div class="pull-left meta">
				          <div class="title h5">
				              <a href="<?=$base.$noti['link']?>" class="post-user-name"> <?=$noti['title']?></a>
				              <!--liked your <a href="#">Post</a>-->
				          </div>
				          <h6 class="text-muted time"><?=$noti['passed']?> ago</h6>
				      </div>
				  </div>
				</div>
				<?php }?>

				


				<div class="panel panel-white post-load-more panel-shadow text-center">
					<button class="btn btn-success">
						<i class="fa fa-refresh"></i>Load More...
					</button>
				</div>				
    		</div><!-- notification list-->