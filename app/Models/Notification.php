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
    	$courses_posts = $this->db->read("SELECT post.*,course.code from (select * from notification where entity_name = 'post') as noti left join post on post.id = noti.entity_id left join page on page.id = post.page_id left join course on course.id = page.course_id left join page_user on page_user.page_id = post.page_id where page_user.user_id = {$this->user->getId()} ORDER By noti.created_at DESC LIMIT {$this->start},{$this->limit}");
    	return $courses_posts;
    }

    private function loadRelatedComments()
    {
    	$noti = "SELECT * from notification where entity_name = 'comment' order by created_at";
    	$comments = $this->db->read("SELECT noti.* from ($noti) as noti left join comment on comment.id  = noti.entity_id left join post on post.id = comment.post_id where comment.user_id != {$this->user->getId()} and ( (post.user_id = {$this->user->getId()}) or (EXISTS (select id from like_post where like_post.user_id = {$this->user->getId()} and like_post.post_id = post.id)) or (EXISTS (select id from comment where comment.user_id = {$this->user->getId()} and comment.post_id = post.id)) ) order by noti.created_at desc  LIMIT {$this->start},{$this->limit}");
    	return $comments;
    }

    private function loadRelatedPostLikes()
    {
    	$noti = "SELECT * from notification where entity_name = 'like_post' order by created_at";

    	$likes = $this->db->read("SELECT noti.* from ($noti) as noti left join like_post on like_post.id = noti.entity_id left join post on post.id = like_post.post_id where post.user_id = {$this->user->getId()} and like_post.user_id != {$this->user->getId()}");
    	return $likes;
    }

    private function loadFriendsNotifications()
    {
    	$noti = "SELECT * from notification where entity_name = 'like_post' order by created_at";

    	$likes = $this->db->read("SELECT noti.* from ($noti) as noti left join like_post on like_post.id = noti.entity_id left join post on post.id = like_post.post_id where post.user_id = {$this->user->getId()} and like_post.user_id != {$this->user->getId()}");
    	return $likes;
    }


    public function getAllNotification($start=0,$limit=10)
    {
    	$this->start = $start;
    	$this->limit = $limit;
    	$data = [];
    	$data['posts'] = $this->loadNewPosts();
    	$data['comments'] = $this->loadRelatedComments();
    	$data['likes'] = $this->loadRelatedPostLikes();

    	// all co
    	var_dump($data['likes']);die;
    }
}