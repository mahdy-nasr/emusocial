<?php
namespace App\Models;

class Like extends \App\Base implements \JsonSerializable
{
    protected $entity_id;
    protected $entity_name;
    protected $table_name;
    protected $data;
    public function __construct($entity_name,$entity_id)
    {
        parent::__construct();
        $this->entity_id = $entity_id;
        $name = strtolower(str_replace('like_','',$entity_name));
        $this->entity_name = $name.'_id';
        $this->table_name = 'like_'.$name;
        $this->loadLikes();
    }
    
    public function jsonSerialize() {
        return $this->data;
    }

    private function loadLikes()
    {
        $res = $this->db->read("SELECT {$this->table_name}.* from {$this->table_name}  where {$this->entity_name} = {$this->entity_id}");
        if (!$res)
            $this->data = [];
        else
            $this->data = $res;
    }

    public function getCount()
    {
        return count($this->data);
    }
    public function liked($user_id)
    {
        //var_dump($user_id);die;
        $arr = array_column($this->data,'user_id');
        return in_array($user_id,$arr);
    }

    public function doLike($user_id)
    {
        if($this->liked($user_id))
            return false;

        $res = $this->db->write("INSERT into {$this->table_name} (`{$this->entity_name}`,`user_id`) VALUES ($this->entity_id,?)",[$user_id]);
        $this->loadLikes();
        if ($res)
            return $this->db->last_id();
        return false;

    }

    public function removeLike($user_id)
    {

        if(!$this->liked($user_id))
            return false;

        $res = $this->db->write("DELETE from {$this->table_name} where {$this->entity_name} = {$this->entity_id} and user_id = ?",[$user_id]);
       $this->loadLikes();
        if ($res)
            return true;
        return false;
    }
    public function getUsersId($start=0,$limit=10,$as_string = true)
    {
        $arr = array_column($this->data,'user_id');
    
        return trim(implode(', ',$arr)," ,");

    }


}