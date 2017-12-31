<!-- left content (detail, frields, photos) -->
	    			<!-- user detail -->
					
					<div class="panel panel-default panel-user-detail">
						<div class="panel-heading">
						  <h3 class="panel-title" style="text-align:center;">Info</h3>
						</div>
						<div class="panel-body">
						  <ul class="list-unstyled">
						<?php foreach ($course->getInstructors() as $id => $instructor) {?>
						    <a href='<?=$base?>profile?id=<?=$id?>'>
						    	<li style='color:black;'>
						    		
						    		<i class="fa fa-user"></i><?=$instructor->getFullName();?>
						    	</li>
						    </a>
						<?php }?>
						    <li><i class=""></i><strong>semester:</strong> <?=$course->getSemester().', '.$course->getYear()?></li>
						    <li><i class=""></i><strong>Department:</strong>  <?=$course->getDepartmentName();?></li>
						    <li><i class=""></i><strong>permission:</strong>  <?php echo ($course->getReadonly())?'Read Only':'Active';?></li>	
						    <li><i class=""></i><strong>Groups:</strong>  <?=count($course->getInstructors())?></li>

						  </ul>
						</div>
						<!--div class="panel-footer text-center">
						  <a href="#" class="btn btn-success">Read more...</a>
						</div-->
					</div><!-- end user detail -->
					<style type="text/css">
						
						
					</style>
					<div class="panel panel-default panel-user-detail" >
						<div class="panel-heading">
						  <h3 class="panel-title" style="text-align:center;">Events</h3>
						</div>
						<div class="panel-body" style="padding:0;margin:0;">
						  <ul class="list-unstyled event-ul">
						  <?php if (count($course->getEvents('active'))) foreach ($course->getEvents('active') as $event) {?>
						   <a href='#' >
						    <li>
						    	
						    		<p><i class="fa fa-bookmark-o"></i><?=$event['title']?></p>
						    		<p>
						    			<i class="fa fa-calendar" ></i> <?=$event['date']?> &nbsp;
						    			<i class="fa fa-clock-o"></i><?=substr($event['time'],0,5)?> &nbsp;
						    			<i class="fa fa-map-marker"></i><?=$event['place']?> 
						    		</p>
						    </li>
						    </a>
						    <?php }else {?>
						    	<li><p>No Active Events</p></li>
						    <?php }?>
						 
						  </ul>
						</div>
						<!--div class="panel-footer text-center">
						  <a href="#" class="btn btn-success">Read more...</a>
						</div-->
					</div><!-- end user detail -->
			

					<div class="panel panel-default panel-user-detail" >
						<div class="panel-heading">
						  <h3 class="panel-title" style="text-align:center;">Numbers</h3>
						</div>
						<div class="panel-body numbers-div" style="padding:0;margin:0;">
						  <div class="row">
						  	<div class="col-xs-6 r b">
						  		<h4>posts</h4>
						  		<p><?=$course->getNumbers('posts')?></p>
						  	</div>

						  	<div class="col-xs-6 b">
						  		<h4>Events</h4>
						  		<p><?=$course->getEvents('count')?></p>
						  	</div>
						  </div>


						  <div class="row">
						  	<div class="col-xs-6 r">
						  		<h4>Files</h4>
						  		<p><?=$course->getNumbers('files')?></p>
						  	</div>

						  	<div class="col-xs-6">
						  		<h4>Students</h4>
						  		<p><?=count($course->getStudents())?></p>
						  	</div>
						  </div>
						</div>
					</div>
						<!--div class="panel-footer text-center">
						  <a href="#" class="btn btn-success">Read more...</a>
						</div-->



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

			

             										
