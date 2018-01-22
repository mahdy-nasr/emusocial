<?php
namespace App\Models;

class Notification extends \App\Base
{
	private $user;
	private $start;
	private $limit;

    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    private function loadNewPosts()
    {
        $noti = "SELECT * from notification where entity_name = 'post' order by created_at";
    	return "SELECT noti.id from ($noti) as noti left join post on post.id = noti.entity_id where post.page_id IN (SELECT page_user.page_id from page_user where page_user.user_id = {$this->user->getId()}) and post.user_id != {$this->user->getId()} LIMIT {$this->start},{$this->limit}";
  
    }

    private function loadRelatedComments()
    {
    	$noti = "SELECT * from notification where entity_name = 'comment' order by created_at";
    	return "SELECT noti.id from ($noti) as noti left join comment on comment.id  = noti.entity_id left join post on post.id = comment.post_id where comment.user_id != {$this->user->getId()} and ( (post.user_id = {$this->user->getId()}) or (EXISTS (select id from like_post where like_post.user_id = {$this->user->getId()} and like_post.post_id = post.id)) or (EXISTS (select id from comment where comment.user_id = {$this->user->getId()} and comment.post_id = post.id)) ) order by noti.created_at desc  LIMIT {$this->start},{$this->limit}";
    }
    private function loadRelatedCommentLikes()
    {
        $noti = "SELECT * from notification where entity_name = 'like_comment' order by created_at";

        return "SELECT noti.id from ($noti) as noti left join like_comment on like_comment.id = noti.entity_id left join comment on comment.id = like_comment.comment_id where comment.user_id = {$this->user->getId()} and like_comment.user_id != {$this->user->getId()}";
    }

    private function loadRelatedPostLikes()
    {
    	$noti = "SELECT * from notification where entity_name = 'like_post' order by created_at";

    	return "SELECT noti.id from ($noti) as noti left join like_post on like_post.id = noti.entity_id left join post on post.id = like_post.post_id where post.user_id = {$this->user->getId()} and like_post.user_id != {$this->user->getId()}";
    }

    private function loadFriendsNotifications()
    {
    	$noti = "SELECT * from notification where entity_name = 'like_post' order by created_at";

    	return "SELECT noti.id from ($noti) as noti left join like_post on like_post.id = noti.entity_id left join post on post.id = like_post.post_id where post.user_id = {$this->user->getId()} and like_post.user_id != {$this->user->getId()}";
 
    }


    public function getAllNotification($start=0,$limit=10)
    {
    	$this->start = $start;
    	$this->limit = $limit;

    	$select = "user.*, noti.entity_id as noti_entity_id, noti.entity_name as noti_entity_name ,noti.info as noti_info ,noti.created_at as noti_created_at ";
        $from = "notification as noti left join user on user.id = noti.user_id";
        $wr = "({$this->loadFriendsNotifications()}) union ({$this->loadRelatedComments()}) union ({$this->loadNewPosts()}) union ({$this->loadRelatedPostLikes()}) union ({$this->loadRelatedCommentLikes()})";
      //  echo "SELECT $select from $from where noti.id IN (select DISTINCT temp.id from ($wr) as temp) order by noti.created_at limit $start,$limit"; die;
        $res = $this->db->read("SELECT $select from $from where noti.id IN (select DISTINCT temp.id from ($wr) as temp) order by noti.created_at limit $start,$limit");
        if(!$res)
            return [];
        $noti=[];
        foreach ($res as $row) {
            # code...
            $title = "";
            $user= new User($row);
            $link="profile/?id={$user->getId()}";
            $passed = passedTime($row['noti_created_at']);
            switch ($row['noti_entity_name']) {
                case 'post':
                $title = "{$user->getFulName()} publish a new post on his course page";
                    break;
                case 'comment':
                $title = "{$user->getFullName()} made a new comment";
                    break;
                case 'like_post':
                $title = "{$user->getFullName()} like your post";
                    break;
                case 'like_comment':
                $title = "{$user->getFullName()} like your comment";
                    break;
                case 'friend':
                    if ($row['noti_info'] == 'accept')
                        $title = "{$user->getFullName()} accept your friend request";
                    else
                        $title = "{$user->getFullName()} made a friend request";
                    break;


            }
            $noti[] = [
                        "title" => $title,
                        "link" => $link,
                        "user" => $user,
                        'passed' =>$passed,
                        'created_at'=>$row['noti_created_at']
                    ];
        }

    	// all co
    	return $noti;
    }
}