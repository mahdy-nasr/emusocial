<?php
namespace App\APIs;

class uploadApi extends API
{
    public function __construct($request, $response, $params)
    {
        parent::__construct($request, $response, $params);
    }

    public function run()
    {

        if (!$this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!in_array($this->args['type'], ['file','image','video'])) {
             return $this->response->withJson(['RC'=>400,'msg'=>'the upload type is not specified'], 200);
        }

        $upload =  new \App\Helpers\Upload($this->args['type']);
        
        $result = [];
        if(! $upload->uploadAll(['postfile']))
            $result['errors'] = $upload->getErrors();
        
        $result['RC'] = 200;
        $result['records'] = $upload->getResult();
       // $result['records'] = [ 'access_token'=> $token, 'profile' => $student->getUserData(), 'courses'=>$courses ];

        return $this->response->withJson($result, 200);
    }

   
    


}