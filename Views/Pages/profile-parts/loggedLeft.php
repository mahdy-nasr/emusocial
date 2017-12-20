<!-- left content (detail, frields, photos) -->
	    		<div class="col-md-5 user-detail no-paddin-xs">
	    			<!-- user detail -->
					<div class="panel panel-default panel-user-detail">
						<div class="panel-body">
						  <ul class="list-unstyled">
						    
						    <li><i class="fa fa-user"></i><?=ucwords($user['title'].' '.$user['first_name'].' '.$user['last_name'])?></li>
						    <li><i class="fa fa-id-card-o"></i>Student Number: <?=$user['identification']?></li>
						    <li><i class="fa fa-university"></i>Department: <?=$user['department_name']?></li>
						    <li><i class="fa fa-transgender"></i>Gender: <?=ucfirst($user['gender'])?></li>
						    <?php if(strlen($user['date_of_birth'])>3):?>
						    <li><i class="fa fa-calendar"></i>Born on <?=$user['date_of_birth']?></li>
							<?php endif;?>
						  </ul>
						</div>
						<!--div class="panel-footer text-center">
						  <a href="#" class="btn btn-success">Read more...</a>
						</div-->
					</div><!-- end user detail -->
					<!-- groups -->
					<div class="panel panel-white panel-groups">
						<div class="panel-heading">
						  <h3 class="panel-title">My Courses</h3>
						</div>
						<div class="panel-body">
						  <ul class="list-group">
						  <?php foreach ($courses as $key => $course) {
						  	# code...
						  ?>
						    <li class="list-group-item link">
						    	<a href='#' >
						    		<div class="col-xs-12">
						        		<span class="name"><?=$course['code']?></span>
						      		</div>
						    		<div class='col-xs-12'>
						      			<h5><?=$course['name']?></h5>
						      		</div>
						      		<div class="clearfix"></div>
						    	</a>
						    </li>
						   <?php }?>
						    <!--li class="list-group-item">
						      <div class="col-xs-3 col-sm-6 col-md-3">
						          <img src="img/Likes/likes-1.png" alt="Group" class="img-responsive img-circle" />
						      </div>
						      <div class="col-xs-9 col-sm-6">
						          <span class="name">Git in action</span>
						      </div>
						      <div class="clearfix"></div>
						    </li-->
						  
						  </ul>
						</div>
					</div><!-- end groups--> 
					<!-- friends -->
					<?php if(count($friends)):?>
					<div class="panel panel-white panel-friends">
						<div class="panel-heading">
						  <a href="#" class="pull-right">View all&nbsp;<i class="fa fa-share-square-o"></i></a>
						  <h3 class="panel-title">Friends</h3>
						</div>
						<div class="panel-body text-center">
						  <ul class="friends">
						  <?php foreach ($friends as $friend) {
						  	if(empty($friend['profile_picture']))
						  		$friend['profile_picture'] = "img/Profile/".$friend['gender']."-avatar.png";
						  	$friend['name'] = $friend['first_name'].' '.$friend['last_name']
						  	?>
						    <li>
						        <a href="#">
						            <img src="<?=$base.$friend['profile_picture']?>"  title="<?=$friend['name']?>" class="img-responsive ">
						 
						        </a>
						        <h6 ><?=$friend['name']?></h6>
						    </li>
						    <?php }?>
						  </ul>

						</div>
					</div><!-- end friends --> 
				<?php endif;?>
					<!-- photos -->
					<!--div class="panel panel-white">
						<div class="panel-heading">
						  <a href="#" class="pull-right">View all&nbsp;<i class="fa fa-share-square-o"></i></a>
						  <h3 class="panel-title">Photos</h3>
						</div>
						<div class="panel-body text-center">
						  <ul class="photos">
						    <li>
						        <a href="#">
						          <img src="img/Photos/5.jpg" alt="photo 1" class="img-responsive show-in-modal">
						        </a>
						    </li>
						    <li>
						        <a href="#">
						            <img src="img/Photos/2.jpg" alt="photo 2" class="img-responsive show-in-modal">
						        </a>
						    </li>
						    <li>
						        <a href="#">
						            <img src="img/Photos/3.jpg" alt="photo 3" class="img-responsive show-in-modal">
						        </a>
						    </li>
						    <li>
						        <a href="#">
						            <img src="img/Photos/7.jpg" alt="photo 4" class="img-responsive show-in-modal">
						        </a>
						    </li>
						    <li>
						        <a href="#">
						            <img src="img/Photos/5.jpg" alt="photo 5" class="img-responsive show-in-modal">
						        </a>
						    </li>
						    <li>
						        <a href="#">
						            <img src="img/Photos/4.jpg" alt="photo 6" class="img-responsive show-in-modal">
						        </a>
						    </li>
						  </ul>
						</div>
					</div--><!-- end photos-->

			

             										
	    		</div><!-- end left content (detail, frields, photos) -->