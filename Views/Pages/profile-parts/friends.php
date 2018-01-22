
          <div class="col-md-12">
            <!-- panel friends -->
            <div class="panel panel-white panel-list-friends">
              <div class="panel-heading">
                <h3 class="panel-title">Friends</h3>
              </div>
              <div class="panel-body panel-white" style="background:#fff;">
              <?php foreach ($all_friends as $friend) {?>
                <div class="col-md-4">
                    <div class="g-hover-card" style="box-shadow: 0 0 10px gray; ">
                        <img src="<?=$base.$friend->getCoverPicture()?>" alt="">
                        <div class="user-avatar">
                            <img src="<?=$base.$friend->getProfilePicture()?>" alt="">
                        </div>
                        <div class="info">
                            <div class="title">
                                <a href="<?=$base."profile/?id={$friend->getId()}"?>"><?=$friend->getName()?></a>
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="#" class="btn btn-info btn-xs">
                                <i class="fa fa-user-plus"></i>
                            </a>
                            <a href="<?=$base."chat/?id={$friend->getId()}"?>" class="btn btn-primary btn-xs">
                                <i class="fa fa-envelope"></i>
                            </a>
                            <a href="#" class="btn btn-success btn-xs">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php }?>


                
                <div class="col-md-12 panel-white post-load-more panel-shadow text-center" style="margin-top:10px;">
                  <button class="btn btn-success">
                    <i class="fa fa-refresh"></i>Load More...
                  </button>
                </div>
              </div>
            </div><!-- end panel friends -->
          </div>
        