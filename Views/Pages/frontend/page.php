<script type="text/javascript">
	$base = '<?=$base?>';
	$page_id = '<?=$course->getPageId()?>';
</script>
<!-- Modal -->
<div id="file-preview" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

    <!-- Timeline content -->
    <div class="container">

        <?php include $this->partPath("page-parts/heading");?>

	    <div class="row">
	    	<div class="col-md-10 no-paddin-xs">

	    		<div class="col-md-4 user-detail no-paddin-xs">
	    			<?php include $this->partPath("page-parts/loggedLeft");?>
	    		</div>

	    		<!-- right content-->
	    		<div class="col-md-8 no-paddin-xs">
	    			 
	    			<?php include($file2);?>



	    		

			        


			        <!-- third post -->
					<!--div class="panel panel-white post panel-shadow">
					  <div class="post-heading">
					      <div class="pull-left image">
					          <img src="img/Friends/guy-3.jpg" class="avatar" alt="user profile image">
					      </div>
					      <div class="pull-left meta">
					          <div class="title h5">
					              <a href="#" class="post-user-name">Nickson Bejarano</a>
					              made a post.
					          </div>
					          <h6 class="text-muted time">1 minute ago</h6>
					      </div>
					  </div> 
					  <div class="post-image">
					      <img src="img/Post/young-couple-in-love.jpg" class="image show-in-modal" alt="image post">
					  </div>					      
					  <div class="post-description"> 
					      <p>This is my new awesome photo, ok relax with my style, so cray</p>
					      <div class="stats">
					          <a href="#" class="stat-item">
					              <i class="fa fa-thumbs-up icon"></i>2
					          </a>
					          <a href="#" class="stat-item">
					              <i class="fa fa-retweet icon"></i>12
					          </a>
					          <a href="#" class="stat-item">
					              <i class="fa fa-comments-o icon"></i>3
					          </a>
					      </div>
					  </div>
					  <div class="post-footer">
					      <input class="form-control add-comment-input" placeholder="Add a comment..." type="text">
					      <ul class="comments-list">
					          <li class="comment">
					              <a class="pull-left" href="#">
					                  <img class="avatar" src="img/Friends/guy-8.jpg" alt="avatar">
					              </a>
					              <div class="comment-body">
					                  <div class="comment-heading">
					                      <h4 class="comment-user-name"><a href="#">Gavhin dahg martb</a></h4>
					                      <h5 class="time">5 minutes ago</h5>
					                  </div>
					                  <p>This is a first comment</p>
					              </div>
					              <ul class="comments-list">
					                  <li class="comment">
					                      <a class="pull-left" href="#">
					                          <img class="avatar" src="img/Friends/woman-5.jpg" alt="avatar">
					                      </a>
					                      <div class="comment-body">
					                          <div class="comment-heading">
					                              <h4 class="comment-user-name"><a href="#">Ryanah Haywofd</a></h4>
					                              <h5 class="time">3 minutes ago</h5>
					                          </div>
					                          <p>Relax my friend</p>
					                      </div>
					                  </li> 
					                  <li class="comment">
					                      <a class="pull-left" href="#">
					                          <img class="avatar" src="img/Friends/woman-7.jpg" alt="avatar">
					                      </a>
					                      <div class="comment-body">
					                          <div class="comment-heading">
					                              <h4 class="comment-user-name"><a href="#">Maria dh heart</a></h4>
					                              <h5 class="time">3 minutes ago</h5>
					                          </div>
					                          <p>Ok, cool.</p>
					                      </div>
					                  </li> 
					              </ul>
					          </li>
					      </ul>
					  </div>
					</div--><!-- end third post -->
					
	    		</div><!-- end right content-->	
	    	</div>
	    </div>   
    </div>


