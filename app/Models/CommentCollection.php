<?php
namespace App\Models;

class CommentCollection extends \App\Base
{
    private $post_id;
    private $id;
    protected $comments = null;
    public function __construct($post_id = null)
    {
        parent::__construct();
        if ($post_id)
        	$this->post_id = $post_id;
    }

    public function getComments($start = 0, $limit = 10)
    {
        if ($this->comments)
            return $this->comments;
    	$data = $this->db->read("SELECT user.*,comment.* from comment left join user  on user.id = comment.user_id  where post_id = {$this->post_id} and parent_id = 0 ORDER BY comment.created_at DESC LIMIT $start,$limit");
       // var_dump($data[0]);die;
        $res = [];
        if ($data) {
            foreach ($data as $row) {
                $res[] =  new Comment($row);
            }
        }
    	$this->comments = $res;
    	return $this->comments;
    }

}