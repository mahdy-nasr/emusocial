
	    <!-- cover content -->
	    <div class="row">
	      <div class="col-md-10 no-paddin-xs">
	      	<!-- cover and profile image-->
	        <div class="col-md-12 col-sm-12 col-xs-12 cover-content">
				<div class="cover-container" style="background-image:url(<?=$base.$page->getCoverPicture()?>);">
					<div class="social-avatar" >
						
					   <img class="img-avatar" src="<?=$base.$profile->getProfilePicture()?>" height="100" width="100">
					   <h4 class="fg-white text-center text-shadow"><?=$profile->getFullName()?></h4>
					   <h5 class="fg-white text-center" style="opacity:0.8;"></h5>
					   <hr class="border-black75 text-shadow" style="border-width:2px;" >
					   <?php $diff = ($profile->getId() != $user->getId()); 
					   $friend_status = $friend->getUserStatus($profile->getId()); ?>
					   
					   <div class="text-center">
					   <?php if ($diff && $friend_status == $friend::IS_NOT_FRIEND):?>
					    <a href="<?=$base?>Profile/addFriend?id=<?=$profile->getId()?>" role="button" class="btn btn-inverse btn-outlined btn-retainBg btn-brightblue" type="button">
					      <span>Add Friend</span>
					    </a>

					     <?php elseif ($diff && $friend_status == $friend::IS_FRIEND):?>
				     	<a href="<?=$base?>Profile/removeRequest?id=<?=$profile->getId()?>" role="button" class="btn btn-inverse btn-outlined btn-retainBg btn-brightblue font-main-color" type="button">
				      		<i class="fa fa-check"></i> <span> Friend</span>
				    	</a>

						<?php elseif ($diff && $friend_status == $friend::IS_FRIEND_R_FROM_ME):?>
					    	<a href="<?=$base?>Profile/removeRequest?id=<?=$profile->getId()?>" role="button" class="btn btn-inverse btn-outlined btn-retainBg btn-brightblue font-main-color" type="button">
				      			 <span> Remove Requeste</span>
				    		</a>

				    	<?php elseif ($diff && $friend_status == $friend::IS_FRIEND_R_TO_ME):?>
					    	<a href="<?=$base?>Profile/acceptRequest?id=<?=$profile->getId()?>" role="button" class="btn btn-inverse btn-outlined btn-retainBg btn-brightblue font-main-color" type="button">
				      			<span> Accept Requeste</span>
				    		</a>
					    <?php endif;?>
					   </div>
					
					</div>
				</div>
	        </div><!-- end cover and profile image-->
	        <!-- cover menu -->
	        <div class="col-md-12  col-sm-12 col-xs-12">
	          <div class="panel-options">
	            <div class="navbar navbar-default navbar-cover">
	              <div class="container-fluid">
	                <div class="navbar-header">
	                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#profile-opts-navbar">
	                    <span class="sr-only">Toggle navigation</span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                  </button>
	                </div>

	                <div class="collapse navbar-collapse" id="profile-opts-navbar">
	                  <ul class="nav navbar-nav navbar-right">
	                    <li class="active"><a href="#"><i class="fa fa-tasks"></i>Timeline</a></li>
	                    <li><a href="about.html"><i class="fa fa-info-circle"></i>About</a></li>
	                    <li><a href="friends.html"><i class="fa fa-users"></i>Friends</a></li>
	                    <li><a href="photos.html"><i class="fa fa-file-image-o"></i>Photos</a></li>
	                    <li><a href="messages.html"><i class="fa fa-comment"></i>Messages</a></li>
	                  </ul>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div><!-- cover menu -->
	      </div>
	    </div><!-- cover content -->