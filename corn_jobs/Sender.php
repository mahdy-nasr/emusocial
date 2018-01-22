<?php
// Server key from Firebase Console
class Sender
{
    const API_ACCESS_KEY = 'AAAA1Bl4GB8:APA91bFNzIysKhwYoorTIl8UYV_6QlVVA2kfO9zCnBt0Uhl3hFLP84N9m1HXPAuon-itjApSM535hyowZojxTQVK_uYTzDgKwfcpcLVZq4KMk_rnfGFlJsRSFfKbxsr66JVANFb0gPLI';
    private $ids;
    private $msg="try try";
    private $title = "EMU Social";
    private $icon = "icon.png";
    private $url = "https://fcm.googleapis.com/fcm/send";

    public function __construct($ids = null)
    {
        if ($ids){
            $this->ids = $ids;
        }
    }

    public function setDevices(array $ids)
    {
        $this->ids = $ids;
        return $this;
    }

    public function setMessage( $message)
    {
        $this->msg = $message;
        return $this;
    }

    public function setTitle( $str) 
    {
        $this->title = $str;
        return $this;
    }

    private  function generateJson()
    {
        $data = array( "title" => $this->title, "body" => $this->msg,'message'=>'dfd',"icon" => $this->icon);
        $data_string = json_encode(['registration_ids'=>$this->ids,'data'=>$data]); 
        return $data_string;
    }
    public function send()
    {
        $json = $this->generateJson();
        echo $json;
        $headers = 
        [
             'Authorization: key=' . self::API_ACCESS_KEY, 
             'Content-Type: application/json'
        ];                                                                                 
                                                                                                                             
        $ch = curl_init();  
        var_dump($this->url);
        curl_setopt( $ch, CURLOPT_URL, $this->url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        if($errno = curl_errno($ch)) {
    $error_message = curl_strerror($errno);
    echo "cURL error ({$errno}):\n {$error_message}";
}

        curl_close ($ch);
        $res_arr = json_decode($result,1);
        var_dump($result);
        return $res_arr['success']>0;
    }
}

$ids = ["dZ9-7IWy0_k:APA91bHmy29IC6Sx00AiG3coW3IdiBjAPplG9DUhsKum5e3razbEHuhGgiAQ_mMz-jwbu5rDji1pEyw3XDFFi0cfj46GfF35jhAKqvEWAGvCgDGgtDFjnw8ZoYqZ2uavOdEMFghhL590"];                                                          

var_dump($ids);
$snd = new \Sender($ids);

$res = $snd->setMessage("i like emu social")
            ->send();

var_dump($res);
echo "\n";
echo "The Result : ".$res;

