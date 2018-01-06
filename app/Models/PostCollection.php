<?php
namespace App\Models;

class PostCollection extends \App\Base implements \JsonSerializable
{
    
    protected $posts;
    private $page_id;
    
    public function __construct($page_id = null)
    {
        parent::__construct();
        if ($page_id)
            $this->page_id = $page_id;
    }

    public function jsonSerialize() {
        return $this->posts;
    }

    public function setPageId($id)
    {
        $this->page_id = $id;
    }


    public function getData()
    {
        return $this->posts;
    }

    public function getPagePosts($start = 0,$limit = 10)
    {
        $res = $this->db->read("SELECT * from post where page_id = ? ORDER BY created_at DESC LIMIT $start,$limit ",[$this->page_id]);
        if (!$res)
            return;
        $posts = [];
        foreach ($res as $row) {
            $posts[] = new Post($row);
        }
        $this->posts = $posts;
        return $this->posts;
    }

    public function getPostsCount()
    {
         $sel = "count(DISTINCT id) as count ";
         return $this->db->readOne("SELECT $sel from post where page_id = {$this->page_id}")['count'];
    }

    public function getFilesCount() {
        
        $sel = "count(DISTINCT id) as count ";
        $post_ids = $this->db->read("SELECT id from post where page_id = {$this->page_id}");

        $post_ids = '('.trim(implode(',',array_column($post_ids,'id')), ",").')';
        if(strlen($post_ids)>2) {
            return $this->db->readOne("SELECT $sel from upload where post_id IN $post_ids")['count'];
        } else {
            return  0;
        }
    }

    public function getAllFiles()
    {
        $post_ids = $this->db->read("SELECT id from post where page_id = {$this->page_id}");

        $post_ids = '('.trim(implode(',',array_column($post_ids,'id')), ",").')';

        if(strlen($post_ids)<=2)
            return [];
        
        $res = $this->db->read("SELECT upload.* , user.id as user_id, CONCAT(user.first_name,' ',user.last_name) as username, user.title as user_title from upload left join post on upload.post_id = post.id left join user on post.user_id = user.id where post_id IN $post_ids ORDER BY created_at DESC");
       
     
        $files  = [];
        if ($res) {
            foreach ($res as $row) {
                $row['name'] = substr($row['link'],strpos($row['link'],'_')+1);
                $files[] = $row;
            }
        }
        return $files;
    }

    public function getInstructorFiles() 
    {
        $post_ids = $this->db->read("SELECT id from post where page_id = {$this->page_id}");

        $post_ids = '('.trim(implode(',',array_column($post_ids,'id')), ",").')';
        if(strlen($post_ids)<=2)
            return [];
        $res = $this->db->read("SELECT upload.* , user.id as user_id, CONCAT(user.first_name,' ',user.last_name) as username, user.title as user_title from upload left join post on upload.post_id = post.id left join user on post.user_id = user.id where post_id  IN $post_ids and user.type = 1 ORDER BY created_at DESC");
       
     
        $files  = [];
        if ($res) {
            foreach ($res as $row) {
                $row['name'] = substr($row['link'],strpos($row['link'],'_')+1);
                $files[] = $row;
            }
        }
        return $files;
    }

    public function getTimelinePosts($user_id, $start = 0, $limit = 10)
    {
        $friends_ids = "SELECT IF(from_id = {$user_id}, to_id, from_id) as user_id from friend where (from_id = {$user_id} or to_id = {$user_id} ) and accept = 1 ";
        $friends_pages_ids = "SELECT user.page_id from ($friends_ids) as fr left join user on user.id = fr.user_id";
  

        $courses_pages = "SELECT page_id from page_user where user_id = {$user_id}";

        $res = $this->db->read("SELECT post.* ,user.id as is_user from post left join user on user.page_id = post.page_id where post.page_id = {$this->page_id} or post.page_id IN ($friends_pages_ids) or post.page_id IN ($courses_pages) order by post.created_at DESC limit $start,$limit");


         if (!$res)
            return;
        $posts = [];
        foreach ($res as $row) {
            $posts[] = new Post($row);
        }
        return  $posts;
    }
    public function getEventPosts($start=0, $limit=10) 
    {
        // for event class
        $res = $this->db->read("SELECT post.* FROM `post` RIGHT JOIN `event` on post.id = event.post_id WHERE post.page_id = {$this->page_id} order by created_at DESC limit $start,$limit");
        if (!$res)
            return;
        $posts = [];
        foreach ($res as $row) {
            $posts[] = new Post($row);
        }
        return  $posts;

    }

    public function getAnnouncements($start=0,$limit=10) 
    {
        $res = $this->db->read("SELECT * FROM `post` WHERE announcement = 1 and post.page_id = {$this->page_id} order by created_at DESC limit $start,$limit");
        if (!$res)
            return;
        $posts = [];
        foreach ($res as $row) {
            $posts[] = new Post($row);
        }
        return  $posts;
    }
}