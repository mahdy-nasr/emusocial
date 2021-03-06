<!-- left content (detail, frields, photos) -->
	    		<div class="col-md-5 user-detail no-paddin-xs">
	    			<!-- user detail -->
					<div class="panel panel-default panel-user-detail">
						<div class="panel-body">
						  <ul class="list-unstyled">
						    
						    <li><i class="fa fa-user"></i><?=ucwords($profile->getFullName())?></li>
						    <li><i class="fa fa-id-card-o"></i>Student Number: <?=$profile->getIdentification()?></li>
						    <li><i class="fa fa-university"></i>Department: <?=$profile->getDepartmentName()?></li>
						    <li><i class="fa fa-transgender"></i>Gender: <?=ucfirst($profile->getGender())?></li>
						    <?php if(strlen($profile->getDateOfBirth())>3):?>
						    <li><i class="fa fa-calendar"></i>Born on <?=$profile->getDateOfBirth()?></li>
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
						    	<a href="<?=$base."page/?page_id={$course['page_id']}"?>" >
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
						  <?php foreach ($friends as $friend) {?>
						    <li style="">
						        <a href="<?=$base.'profile/?id='.$friend->getId()?>">
						            <img style='' src="<?=$base.$friend->getProfilePicture()?>"  title="<?=$friend->getName()?>" class="img-responsive" >
						        </a>
						        <div class='cvr'>
						        	
						        </div>
						        <h6> <?=$friend->getName()?> </h6>
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