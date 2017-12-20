<?php   
		$coverPic = \App\Helpers\Config::get("picture/profile_cover");
		if(!empty($page['cover_picture'])) {
			$coverPic = $page['cover_picture'];
		}
?>
	    <!-- cover content -->
	    <div class="row">
	      <div class="col-md-10 no-paddin-xs">
	      	<!-- cover and profile image-->
	        <div class="col-md-12 col-sm-12 col-xs-12 cover-content">
				<div class="cover-container" style="background-image:url(<?=$base.$coverPic?>);">
					<div class="social-avatar" >
						
					   <img class="img-avatar" src="<?=$profilePic?>" height="100" width="100">
					   <h4 class="fg-white text-center text-shadow"><?=$user['title'].' '.$user['first_name'].' '.$user['last_name']?></h4>
					   <h5 class="fg-white text-center" style="opacity:0.8;"></h5>
					   <hr class="border-black75 text-shadow" style="border-width:2px;" >
					   <div class="text-center">
					    <button role="button" class="btn btn-inverse btn-outlined btn-retainBg btn-brightblue" type="button">
					      <span>Add Friend</span>
					    </button>
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