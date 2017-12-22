

<ul class="comments-list" id="comments_<?=$post->getId()?>">

	<li class="comment">
		<a class="pull-left" href="#">
			<img class="avatar" src="<?=$user->getProfilePicture()?>" alt="avatar">
		</a>
		<form class="comment-body" onsubmit="return false;">
			<input type="text"   name="comment" class="form-control add-comment-input" placeholder="Add a comment...">
			<input type='hidden' name="post_id"    value="<?=$post->getId()?>" >
		    <input type='hidden' name="parent_id"  value="0">
		</form>
	</li>
	<?php if($post->getAllComments()>count($post->getComments()) ):?>
	<li class="comment">
		<a href="#"  link="<?=$post->getId()?>" class='refresh-all-comments' >load more <?=($post->getAllComments()-3)?> comments</a>
	 </li>
	<?php endif;?>

      <?php foreach ($post->getComments() as $comment) {?>
      <li class="comment">
          <a class="pull-left" href="#">
              <img class="avatar" src="<?=$comment->getUser('profile_picture')?>" alt="avatar">
          </a>
          <div class="comment-body">
              <div class="comment-heading" style='position: relative;'>
                  <h4 class="comment-user-name"><a href="#"><?=$comment->getUser('name')?></a></h4>
                  <h5 class="time"><?=passedTime($comment->getCreatedAt()).' ago'?></h5>
                  <?php if($user->getId() == $comment->getUser('id')):?>
                  <a class='del-com'  href='#' >...</a>
                  <?php endif;?>
                  <ul class='opt-del'>
					<a href='#'  class="com" link="<?=$comment->getId();?>" ><li>delete the Comment!</li></a>
				  </ul>
              </div>
              <p><?=htmlentities($comment->getComment())?></p>
              <div class="comment-footer" >
             	<?php 

			      $cls = 'not-liked';
			      if ($comment->getLikes('liked',$user->getId())) {
			      	$cls  = 'liked';
			      }
				?>
              	<a href='#'  link="<?=$comment->getId()?>" class="<?=$cls?> like-part" >
              		<span><?=($comment->getLikes('count')) ? $comment->getLikes('count') : ''?></span> Likes 
              	</a>

           

              	<a href='#'   class="reply-sec <?=($comment->hasReplies())?'liked':'not-liked'?>"> 
              		<?=count($comment->getReplies())?count($comment->getReplies()):''?> Replies
              	</a>

              </div>

               <ul class="comments-list reply" style='display: none;'>
  	  
		      	  <li class="comment">
		              <a class="pull-left" href="#">
		                  <img class="avatar" src="<?=$user->getProfilePicture();?>" alt="avatar">
		              </a>
		              <form class="comment-body" onSubmit="return false;" >

		                  <input type="text"   name="comment" class="form-control add-comment-input" placeholder="Add a reply..." >
		                  <input type='hidden' name="post_id"    value="<?=$post->getId()?>" >
		                  <input type='hidden' name="parent_id"  value="<?=$comment->getId()?>">
		    
		              </form>
		          </li>
		          <?php if ($comment->hasReplies()): foreach ($comment->getReplies() as $reply) {?>

		          <li class="comment">
			          	<a class="pull-left" href="#">
			              	<img class="avatar" src="<?=$reply->getUser('profile_picture')?>" alt="avatar">
			          	</a>
			          	<div class="comment-body">
				              <div class="comment-heading" style='position: relative;'>
				                  <h4 class="comment-user-name"><a href="#"><?=$reply->getUser('name')?></a></h4>
				                  <h5 class="time"><?=passedTime($reply->getCreatedAt()).' ago'?></h5>
				                  <?php if($user->getId() == $reply->getUser('id')):?>
				                  <a class='del-com'  href='#' >...</a>
				                  <?php endif;?>
				                  <ul class='opt-del'>
									<a href='#' class="com" link='<?=$reply->getId();?>' ><li>delete the Reply!</li></a>
								  </ul>
				              </div>
				              <p><?=htmlentities($reply->getComment())?></p>
				              <div class="comment-footer" >
				              <?php 
							      $cls = 'not-liked';
							      if ($reply->getLikes('liked',$user->getId())) {
							      	$cls  = 'liked';
							      }
								?>
				              	<a href='#' link='<?=$reply->getId()?>' class="like-part <?=$cls?>" >
				              		<span><?=($reply->getLikes('count'))? $reply->getLikes('count'):''?></span> Like
				              	</a>
				              </div>
			               

			         	</div>
      				</li>

      				<?php }endif;?>
      				
		        </ul>

          </div>
      </li>

      <?php }?>

      
</ul>
