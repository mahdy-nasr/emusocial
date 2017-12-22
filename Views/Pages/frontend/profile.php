<script type="text/javascript">
	$base = '<?=$base?>';
	$profile_id = '<?=$profile->getId()?>';
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

        <?php include $this->partPath("profile-parts/heading");?>

	    <div class="row">
	    	<div class="col-md-10 no-paddin-xs">

	    		<?php include $this->partPath("profile-parts/loggedLeft");?>

	    		<!-- right content-->
	    		<div class="col-md-7 no-paddin-xs">
	    			 
	    			 <?php 
	    			 if ($profile->getId() == $user->getId()) {
	    			 	include $this->partPath("frontend-parts/post-form");
	    			 }
	    			 ?>
	    			 <div id='post-cont'>

	    			 <?php include $this->partPath("frontend-parts/post-view");?>
	    			 </div>



	    			 <script type="text/javascript" src="<?=$base?>js/post-view.js"></script>
	    			 <script type="text/javascript" src="<?=$base?>js/comment-view.js"></script>
	    			 
	    			 <script type="text/javascript">
	    			 	post.init({
	    			 		base:'<?=$base?>',
	    			 		profile_id:'<?=$profile->getId()?>'
	    			 	});

	    			 	post.run();

	    			 	comment.init({base:'<?=$base?>'});

	    			 	comment.run();
	    			 </script>

			        


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
					<div class="panel panel-white post-load-more panel-shadow text-center" id='id-post-load-more'>
						<img src="<?=$base?>img/loading-posts.gif" style="max-width:100%;max-height:50px;">
					</div>
	    		</div><!-- end right content-->	
	    	</div>
	    </div>   
    </div>


