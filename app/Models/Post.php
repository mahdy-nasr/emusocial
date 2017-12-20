<?php
namespace App\Models;

class Post extends \App\Base
{
    private $user_id = null;
    private $page_id = null;
    private $files_table = 'upload';
    private $id;

    public function __construct($user,$page)
    {
        parent::__construct();
        $this->user_id = $user->getId();
        $this->page_id = $page->getId();
    }
    private function arrayToStr($array)
    {
    	return "( ".trim(implode(',', $array), " ,")." )";
    }
    private function associateFiles($files_ids)
    {
    	return $this->db->write("UPDATE {$this->files_table} set `post_id` = {$this->id} where id in {$files_ids}");
    }

    private function deleteFiles($files_ids)
    {
    	return $this->db->write("DELETE from {$this->files_table} where id in {$files_ids}");
    }

    private function addEvent($data,$post_id)
    {

    }


    public function createPost($data)
    {
    	if (!$this->page_id||!$this->user_id)
    		return false;
    	$files = json_decode($data['files'],1);
    	$deleted = json_decode($data['deleted'],1);

    	$text = $data['text'];
    	$announcement = $data['announcement'];
    	$date = $data['date'];

    	if(!$files && !$text)
    		return false;
    	$insert = [];
    	$insert[':page_id'] =  $this->page_id;
    	$insert[':user_id'] =  $this->user_id;
    	$insert[':txt'] =  empty($text) ? null: $text;
    	$insert[':announcement'] =  empty($announcement) ? '0': $announcement;

    	$res = $this->db->write("INSERT into post (`user_id`,`page_id`,`text`,`announcement`) VALUES (:user_id , :page_id , :txt , :announcement )", $insert);
    	if (!$res)
    		return false;
    	$this->id = $this->db->last_id();

    	if (count($files)) {
	    	$this->associateFiles($this->arrayToStr($files));
    	}

    	if (count($deleted)) {
	    	$this->deleteFiles($this->arrayToStr($deleted));
	    }


    	return true;
    }

    public function getPostById($id)
    {

    }

    public function editPost($data)
    {

    }

    public function getProfilePosts()
    {

    }

    public function getCoursePosts()
    {

    }

    public function getEventPosts()
    {
    	// for event class
    }

    public function getAnnouncements()
    {
    	
    }


}