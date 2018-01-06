<?php
namespace App\APIs;

class timelineApi extends API
{
    public function __construct($request, $response, $params)
    {
        parent::__construct($request, $response, $params);
    }

    public function getUserTimeline()
    {
    	if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }
 
       
        /*$data = [];
        $data['user'] = $this->user;
        $data['page'] = $page->getUserPage($this->user->getId());
        $data['type'] = 'profile';
        $data['post_page_id'] = $this->user->getPageId();*/

        $posts_collection = new \App\Models\PostCollection($user->getPageId());
        
        $start = $this->request->getQueryParam('start', 0);
        $limit = $this->request->getQueryParam('limit', 10);

        $data = $posts_collection->getTimelinePosts($user->getId(), $start, $limit);

        return $this->json(['RC'=>200,"posts"=>$data], 200);

    }//

    
}