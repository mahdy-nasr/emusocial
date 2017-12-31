
	    <!-- cover content -->
	    <div class="row">
	      <div class="col-md-10 no-paddin-xs">
	      	<!-- cover and profile image-->
	        <div class="col-md-12 col-sm-12 col-xs-12 cover-content">
				<div class="cover-container-course" >
					<div class="col-xs-3">
						<img src="<?=$base?>img/emu-logo.png" >
					</div>
					<div class="col-xs-9">
						<h2 class='cover-title'>CMPE462</h2>	

						<h2 class='cover-title'>Functional and logic programming</h2>	
					</div>
				</div>
	        </div><!-- end cover and profile image-->
	        <!-- cover menu -->
	        <div class="col-md-12  col-sm-12 col-xs-12">
	          <div class="panel-options">
	            <div class="navbar navbar-default navbar-cover">
	              <div class="container-fluid" style="padding:0;">
	                <div class="navbar-header" >
	                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#profile-opts-navbar">
	                    <span class="sr-only">Toggle navigation</span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                  </button>
	                </div>

	                <div class="collapse navbar-collapse" id="profile-opts-navbar" style="padding:0;">
	                  <ul class="nav navbar-nav navbar-right" style="margin:0;">
	                    <li class="<?=($sub_page=='timeline')?'active':''?>">
	                    	<a href="<?=$base?>page/?page_id=<?=$post_page_id?>"><i class="fa fa-tasks"></i>&nbsp;Timeline</a>
	                    </li>
	                    <li class="<?=($sub_page=='announcements')?'active':''?>">
	                    	<a href="<?=$base?>page/announcements/?page_id=<?=$post_page_id?>"><i class="fa fa-bullhorn"></i>Announcments</a>
	                    </li>
	                    <li class="<?=($sub_page=='events')?'active':''?>">
	                    	<a href="<?=$base?>page/events/?page_id=<?=$post_page_id?>"><i class="fa fa-calendar"></i>Events</a>
	                    </li>
	                    <li class="<?=($sub_page=='instructorFiles')?'active':''?>">
	                    	<a href="<?=$base?>page/instructorFiles/?page_id=<?=$post_page_id?>"><i class="fa  fa-files-o"></i>Instructor Files</a>
	                    </li>
	                    <li class="<?=($sub_page=='all_files')?'active':''?>">
	                    	<a href="<?=$base?>page/allfiles/?page_id=<?=$post_page_id?>"><i class="fa fa-files-o"></i>Files</a>
	                    </li>
	                    <li class="<?=($sub_page=='grades')?'active':''?>">
	                    	<a href="<?=$base?>page/grades/?page_id=<?=$post_page_id?>"><i class="fa fa-percent"></i>Grades</a>
	                    </li>
	                    <li><a href="photos.html"><i class="fa fa-info-circle"></i>Broadcast&nbsp;</a></li>
	                    <li><a href="messages.html"><i class="fa fa-users"></i>Students</a></li>

	                  </ul>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div><!-- cover menu -->
	      </div>
	    </div><!-- cover content -->