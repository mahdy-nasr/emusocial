<!-- left content (detail, frields, photos) -->
	    		<div class="col-md-5 user-detail no-paddin-xs" >
	    		<div style="height: 600px; overflow-y: auto;position: fixed;">
	    			<!-- user detail -->
					<!-- groups -->
					<div class="panel panel-white panel-groups" >
						<div class="panel-heading">
						  <h3 class="panel-title">My Courses</h3>
						</div>
						<div class="panel-body no-padding-margin">
						  <ul class="list-group no-margin">
						  <?php foreach ($courses as $key => $course) {
						  	# code...
						  ?>
						    <li class="list-group-item link no-margin" style="padding:0 15px;border-radius:0;">
						    	<a href="<?=$base."page/?page_id={$course['page_id']}"?>" >
						    		<div class="col-xs-12 no-padding-margin">
						        		<span class="name"><?=$course['code']?></span>
						      		</div>
						    		<div class='col-xs-12 no-padding-margin'>
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


					<div class="panel panel-default panel-user-detail" >
						<div class="panel-heading">
						  <h3 class="panel-title" style="text-align:center;">Events</h3>
						</div>
						<div class="panel-body" style="padding:0;margin:0;">
						  <ul class="list-unstyled event-ul">
						  <?php if (count($events)) foreach ($events as $event) {?>
						   <a href='<?=$base."page/viewPost/?post_id={$event['post_id']}&page_id={$event['page_id']}"?>' >
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
			</div>
             										
	    		</div><!-- end left content (detail, frields, photos) -->