<?php
namespace App\Models;

class EventCollection extends \App\Base 
{

    public function __construct()
    {
        parent::__construct();
        
    }


    public function getCoursePageEvents($page_id)
    {
        $res =  $this->db->read("SELECT * FROM `post` RIGHT JOIN `event` on post.id = event.post_id WHERE post.page_id = {$page_id} order by event.date ,event.time ASC");
        if (!$res) {
            return ['active'=>[], 'passed'=>[], 'count'=>0];
        }
        $new = [];
        $old = [];
        $now = time();
        foreach ($res as $row) {
            $event_time = strtotime($row['date'].' '.$row['time']);
            if ($event_time <= $now) {
                $old[] = $row;
            } else {
                $new[] = $row;
            }
        }

       return ['active'=>$new, 'passed'=>$old, 'count'=>count($res)];
    }

    public function getUserRunningEvents($user_id) 
    {
        $date_sql = "'".date('Y-m-d')."'"; 
        $time_sql = "'".substr(date('Y-m-d H:i:s'),11)."'";
    
        $res = $this->db->read("SELECT event.*, post.page_id as page_id from event left join post on post.id = event.post_id left join page on page.id = post.page_id left join course on course.id = page.course_id left join page_user on page_user.page_id = post.page_id where course.readonly = 0 and page_user.user_id = {$user_id} and event.date > {$date_sql} or (event.date = {$date_sql}  and event.time > {$time_sql} )order by event.date, event.time DESC");
        if(!$res)
            return [];
        return $res;
    }

    public function getUserAllEvents($user_id) 
    {
        $date_sql = "'".date('Y-m-d')."'"; 
        $time_sql = "'".substr(date('Y-m-d H:i:s'),11)."'";
      
        $res = $this->db->read("SELECT event.*, post.page_id as page_id from event left join post on post.id = event.post_id left join page on page.id = post.page_id left join course on course.id = page.course_id left join page_user on page_user.page_id = post.page_id where course.readonly = 0 and page_user.user_id = {$user_id} order by event.date, event.time DESC");
        if(!$res)
            return ['active'=>[], 'passed'=>[], 'count'=>0];
        
        $new = [];
        $old = [];
        $now = time();
        foreach ($res as $row) {
            $event_time = strtotime($row['date'].' '.$row['time']);
            if ($event_time <= $now) {
                $old[] = $row;
            } else {
                $new[] = $row;
            }
        }

       return ['active'=>$new, 'passed'=>$old, 'count'=>count($res)];
    }
}