
          <style type="text/css">
            .sz{font-size: 24px;}
          </style>
          <!-- tabs user info -->
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-white panel-about">
              <div class="panel-heading">
                <h3 class="panel-title">About
                  
                </h3>
              </div>
              <div class="panel-body">
                <div class="col-md-12 col-sm-12 col-xs-12 about-tab-container">
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 about-tab-menu">
                    <div class="list-group">
                      <a href="#" class="list-group-item active text-center">
                        <h1 class="fa fa-child sz" "></h1><br/>Overview
                      </a>
                      <a href="#" class="list-group-item text-center">
                        <h4 class="fa fa-graduation-cap sz"></h4><br/>Running Courses
                      </a>
                      <a href="#" class="list-group-item text-center">
                        <h4 class="fa fa-calendar sz"></h4><br/>All Events
                      </a>
                      <a href="#" class="list-group-item text-center">
                        <h4 class="fa fa-university sz"></h4><br/>All Courses
                      </a>
                      <a href="#" class="list-group-item text-center">
                        <h4 class="fa fa-globe sz"></h4><br/>Notifications
                      </a>
                      <?php if ($profile->getId() == $user->getId()):?>
                      <a href="#" class="list-group-item text-center">
                        <h4 class="fa fa-wrench sz"></h4><br/>settings
                      </a>
                      <?php endif;?>
                      
                    </div>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 about-tab">
                    <!-- Overview section -->
                    <div class="about-tab-content active">
                      <?php include $this->partPath("profile-parts/about/overview");?>
                    </div>
                    <!-- running courses section -->
                    <div class="about-tab-content">
                       <?php include $this->partPath("profile-parts/about/running_courses");?>
                    </div>

                    <!-- running events search -->
                    <div class="about-tab-content">
                      <?php include $this->partPath("profile-parts/about/all_events");?>
                      
                    </div>
                    <!-- all courses section -->
                    <div class="about-tab-content">
                       <?php include $this->partPath("profile-parts/about/all_courses");?>
                    </div>
                    <!-- notification section-->
                    <div class="about-tab-content">
                      <?php include $this->partPath("profile-parts/about/notifications");?>
                    </div>
                    <?php if ($profile->getId() == $user->getId()):?>
                    <!-- settings section-->
                    <div class="about-tab-content">
                      <?php include $this->partPath("profile-parts/about/settings");?>
                    </div>
                    <?php endif;?>

                  </div>
                </div>
              </div>
            </div>
          </div><!-- end tabs user info -->
         