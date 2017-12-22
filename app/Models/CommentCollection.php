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

    public function countAllComments()
    {
        return  count($this->db->read("SELECT comment.id from comment  where post_id = {$this->post_id} and parent_id = 0"));
    }

    public function getComments($all)
    {
        if ($this->comments)
            return $this->comments;
        $limit = "";
        if (!$all) {
            $limit = "LIMIT 0,3";
        }

    	$data = $this->db->read("SELECT user.*,comment.* from comment left join user  on user.id = comment.user_id  where post_id = {$this->post_id} and parent_id = 0 ORDER BY comment.created_at DESC ".$limit);
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