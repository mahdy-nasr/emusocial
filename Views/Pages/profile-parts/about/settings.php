<!-- Timeline content -->
<style type="text/css">
	
</style>
<div class="col-md-12 no-padding-margin">
<form action="<?=$base?>profile/editProfile" method='post' enctype="multipart/form-data">
    <!-- update cover and profile image-->
		<div class="panel panel-white post panel-shadow" style="padding:10px;">
		  <div class="post-heading">
		      <div class="pull-left image">
		          <img src="<?=$base.$user->getProfilePicture()?>" class="avatar" alt="user profile image">
		      </div>
		      <div class="pull-left meta">
				<input type="file" accept=".jpg, .jpeg,.png" name="profile_picture" />
		      </div>
		  </div>
		  <div class="post-image">
		      <img src="<?=$base.$user->getCoverPicture()?>" class="image show-in-modal" alt="image post" style='max-height: 200px;'>
		  </div>
		  <div class="post-description" style="margin-top:10px;">
		  	<input type="file" accept=".jpg, .jpeg,.png" name="cover_picture"/>
		  </div>
		</div><!-- end update cover and profile image-->
    <!-- update info -->
    <style type="text/css">
    	#inputs-text div.form-group {
    		margin: 5px 0;
    	}
    </style>
		<div class="panel panel-white post panel-shadow" id="inputs-text" style="padding:10px;">
		  <div class="panel-body">
			<div class="form-group dd">
			    <label class="col-md-3 control-label">Birth Date</label>
			    <div class="col-md-8">
			      <input class="form-control" type="date" name="date_of_birth">
			    </div>
			  </div>
			  <div class="clearfix"></div>
			  <div class="form-group dd" style="margin-top:10px !important;">
			    <label class="col-md-3 control-label">phone number</label>
			    <div class="col-md-8">
			      <input class="form-control" type="phone" placeholder="your local phone number" name='phone_number'>
			    </div>
			  </div>
			  <div class="clearfix"></div>

			  <div class="form-group">
			    <label class="col-md-3 control-label">website</label>
			    <div class="col-md-8">
			      <input class="form-control" type="text" value="" placeholder="http://www.your_website.com/" name='website'>
			    </div>
			  </div>
			  <div class="clearfix"></div>
			  <?php if ($user->getUserType()=='student'):?>
			  <div class="form-group">
			    <label class="col-md-3 control-label">Email</label>
			    <div class="col-md-8">
			      <input class="form-control" type="email" placeholder="your@email.com" name='email' autocomplete="off">
			    </div>
			  </div>
			  <div class="clearfix"></div>
			<?php endif;?>
			<?php if ($user->getUserType()=='instructor'):?>
			  <div class="form-group">
			    <label class="col-md-3 control-label">Office</label>
			    <div class="col-md-8">
			      <input class="form-control" type="text" placeholder="CMPE-XXX" name='office'>
			    </div>
			  </div>
			  <div class="clearfix"></div>
			 <?php endif;?>

			  <div class="form-group">
			    <label class="col-md-3 control-label">new password</label>
			    <div class="col-md-8">
			      <input class="form-control" type="password" placeholder="change your password" name='password' autocomplete="new-password">
			    </div>
			  </div>
			  <div class="clearfix"></div>
		  </div>
		</div><!-- end update info-->

		<div class="panel panel-white post-load-more panel-shadow text-center " style='padding-top: 15px; padding-bottom: 0;'>
			<button class="btn btn-primary " style='width: 70%;'>
				Save
			</button>
		</div>				
	</form>
</div>
