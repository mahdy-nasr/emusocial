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

    public function getEventPosts()
    {
        // for event class
    }

    public function getAnnouncements()
    {
        
    }
}