<ul class="comments-list">

	<li class="comment">
		<a class="pull-left" href="#">
			<img class="avatar" src="<?=$profilePic?>" alt="avatar">
		</a>
		<div class="comment-body">
			<input class="form-control add-comment-input" placeholder="Add a comment..." type="text">
		</div>
	</li>

      <?php foreach ($post->getComments() as $comment) {
      	$userCommentPic = $base."img/Profile/".$comment->getUser('gender')."-avatar.png";
      	if (!empty($comment->getUser('profile_picture')))
      		$userCommentPic = $base.$comment->getUser('profile_picture');
      	?>
      <li class="comment">
          <a class="pull-left" href="#">
              <img class="avatar" src="<?=$userCommentPic?>" alt="avatar">
          </a>
          <div class="comment-body">
              <div class="comment-heading">
                  <h4 class="comment-user-name"><a href="#"><?=$comment->getUser('first_name').' '.$comment->getUser('last_name')?></a></h4>
                  <h5 class="time"><?=passedTime($comment->getCreatedAt()).' ago'?></h5>
              </div>
              <p><?=$comment->getComment()?></p>
              <div class="comment-footer" >
              	<a href='#' ><span></span> Likes </a>
              	<a href='#' onclick='return openReply(this);' > <?=count($comment->getReplies())?count($comment->getReplies()):''?> Replys</a>
              </div>

               <ul class="comments-list reply" style='display: none;'>
  	  
		      	  <li class="comment">
		              <a class="pull-left" href="#">
		                  <img class="avatar" src="<?=$profilePic?>" alt="avatar">
		              </a>
		              <div class="comment-body">
		                  <input class="form-control add-comment-input" placeholder="Add a reply..." type="text">
		              </div>
		          </li>
		          <?php if ($comment->hasReplies()): foreach ($comment->getReplies() as $reply) {
		          	$userReplyPic = $base."img/Profile/".$reply->getUser('gender')."-avatar.png";
			      	if (!empty($reply->getUser('profile_picture')))
			      		$userReplyPic = $base.$reply->getUser('profile_picture');
		          	?>
		          <li class="comment">
			          	<a class="pull-left" href="#">
			              	<img class="avatar" src="<?=$userReplyPic?>" alt="avatar">
			          	</a>
			          	<div class="comment-body">
				              <div class="comment-heading">
				                  <h4 class="comment-user-name"><a href="#"><?=$reply->getUser('first_name').' '.$reply->getUser('last_name')?></a></h4>
				                  <h5 class="time"><?=passedTime($reply->getCreatedAt()).' ago'?></h5>
				              </div>
				              <p><?=$reply->getComment()?></p>
				              <div class="comment-footer" >
				              	<a href='#' >Like</a>
				              </div>
			               

			         	</div>
      				</li>

      				<?php }endif;?>

		        </ul>

          </div>
      </li>
      <?php }?>
</ul>