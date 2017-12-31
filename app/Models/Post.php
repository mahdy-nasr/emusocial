<?php
namespace App\Models;

class Post extends \App\Base implements \JsonSerializable
{
    private $user_id = null;
    private $page_id = null;
    private $files_table = 'upload';
    private $id;
    private $allComments = 0;
    protected $data;
    const IMAGE_TYPE = 'image';
    const VIDEO_TYPE = 'video';
    const FILE_TYPE = 'file';

    public function __construct($data = null,$allComments=0)
    {
        parent::__construct();
        
        $this->allComments = $allComments;    

        if ($data && is_array($data))
            $this->getFullPost($data);
        else if ($data)
        {
            $this->loadPostById($data);
        }

    }

    public function jsonSerialize() {
        return $this->data;
    }

    public function setAllComments()
    {
        $this->allComments = 1;
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

    private function addEvent($data)
    {
        $event_data =   [
                            'eDate'      => $data['event_date'], 
                            'eTime'      => $data['event_time'],
                            'ePlace'     => $data['event_place'],
                            'eTitle'     =>  $data['event_name'],
                            'ePost_id'   => $this->id
                            ];

        foreach ($event_data as $key => $value) {
            if (empty($value))
                return false;
        }


        return $this->db->write("INSERT into event (`date`,`time`,`place`,`title`,`post_id`) VALUES (:eDate, :eTime, :ePlace, :eTitle, :ePost_id)",$event_data);
    }

    public function setUserAndPage($user_id,$page_id)
    {
        $this->user_id = $user_id;
        $this->page_id = $page_id;
    }

    public function createPost($data)
    {
    	if (!$this->page_id||!$this->user_id)
    		return false;
    	$files = json_decode($data['files'],1);
    	$deleted = json_decode($data['deleted'],1);

    	$text = $data['text'];
    	$announcement = $data['announcement'];
    	$event = isset($data['event_date'])?$data['event_date']:'';

    	if(!$files && !$text)
    		return false;
    	$insert = [];
    	$insert[':page_id'] =  $this->page_id;
    	$insert[':user_id'] =  $this->user_id;
    	$insert[':txt'] =  empty($text) ? null: $text;
    	$insert[':announcement'] =  empty($announcement) ? '0': $announcement;
        $insert[':created_at'] = date('Y-m-d H-i-s');

    	$res = $this->db->write("INSERT into post (`user_id`,`page_id`,`text`,`announcement`,`created_at`) VALUES (:user_id , :page_id , :txt , :announcement,:created_at )", $insert);
    	if (!$res)
    		return false;

    	$this->id = $this->db->last_id();

        if(!empty($event) && !$this->addEvent($data)) {
            return false;
        }
    	if (count($files)) {
	    	$this->associateFiles($this->arrayToStr($files));
    	}

    	if (count($deleted)) {
	    	$this->deleteFiles($this->arrayToStr($deleted));
	    }


    	return $this->id;
    }

    public function deletePost($post_id, $user_id)
    {
        $res = $this->db->readOne("SELECT * from post where id = ?",[$post_id]);
        $type = $this->db->readOne("SELECT type from user where id = ?",[$user_id])['type'];

        if (!$res || ($res['user_id'] != $user_id && $type == 2)) {
            return false;
        }


        $res = $this->db->read("SELECT * from upload where post_id = ?",[$post_id]);
       //    var_dump($res);die;
        if ($res) {
            foreach ($res as $row) {
                $path = dirname($this->Config::get('base/document')).'/public/'.$row['link'];
                if(file_exists($path))
                    unlink($path);
            }
        }
     
      
        $queries = [
                        ["DELETE from upload where post_id = ?",[$post_id]],
                        ["DELETE from event where post_id = ?",[$post_id]],
                        ["DELETE from like_post where post_id = ?",[$post_id]],
                        ["DELETE from post where id = ?",[$post_id]]
                    ];
        return $this->db->runTransaction($queries);
    
    }

    public function hasMultibleFiles()
    {
        return count($this->data['files'])||((  count($this->data['videos']) +  count($this->data['images'])) > 1 );
    }

    private function loadEvent()
    {
        $res = $this->db->readOne("SELECT event.* from event where post_id = {$this->id}");
        if ($res)
            $this->data['event'] = $res;
        else 
            $this->data['event'] = null;
        return true;
    }
    private function loadFiles()
    {
        $res = $this->db->read("SELECT * from upload where post_id = {$this->id}");
       
        $images = [];
        $videos = [];
        $files  = [];
        if ($res) {
            foreach ($res as $row) {
                $row['name'] = substr($row['link'],strpos($row['link'],'_')+1);
                if ($row['type'] == self::IMAGE_TYPE )
                    $images[] = $row;
                else if ($row['type'] == self::VIDEO_TYPE)
                    $videos[] = $row;
                else
                    $files[] = $row;


            }
        }

        $this->data['images'] = $images;
        $this->data['videos'] = $videos;
        $this->data['files']  = $files;
        return ;
    }

    private function loadComments()
    {
        $comments = new CommentCollection($this->id);
        $this->data['comments'] = $comments->getComments($this->allComments); 
        $this->data['all_comments'] = $comments->countAllComments();
    }

    public function loadPostById($id)
    {
        $res = $this->db->readOne("SELECT post.* from post where post.id = ?",[$id]);
        if (!$res)
            return fasle;
        $this->data = $res;
        $this->id = $this->data['id'];

        $this->loadEvent();
        $this->loadFiles();
        $this->loadComments();
        $this->loadLikes();
        $this->loadUser();
        return ;
    }

    public function isAnnouncement()
    {
        return $this->data['announcement'];
    }

    public function hasComments()
    {
        return count($this->data['comments']);
    }

    public function hasImages()
    {
        return count($this->data['images']);
    }

    public function hasVideos()
    {
        return count($this->data['videos']);
    }

    public function hasFiles()
    {
        return count($this->data['files']);
    }

    private function loadLikes()
    {
        
       $this->data['likes'] = new Like('post',$this->getId());
       return;
    }

    private function loadUser()
    {
        $data = $this->db->readOne("SELECT user.* from user where id = {$this->data['user_id']}");
        if (!$data)
            $this->data['user'] = [];
        else 
            $this->data['user'] = new User($data);
        return true;
    }

    public function getFullPost($data)
    {

        $this->data = $data;
        $this->id = $this->data['id'];

        $this->loadEvent();
        $this->loadFiles();
        $this->loadComments();
        $this->loadLikes();
        $this->loadUser();
        return ;
    }

    public function getData()
    {
        return $this->data;
    }

    


}