<?php
require __DIR__."/../bootstrap.php";
require __DIR__."/Sender.php";
$db = \App\Helpers\DB::getInstance();

while(1) {

$res = $db->read("SELECT distinct(token) from broadcast left join page_user on page_user.page_id = broadcast.page_id left join user on page_user.user_id = user.id where broadcast.pushed = 0");
$ids = [];
foreach ($res as $key => $arr) {
	# code...
	$ids[]=$arr['token'];
}


$snd = new \Sender($ids);

$res = $snd->setMessage("you have a new Broadcast!")
            ->send();

$db->write("UPDATE broadcast set pushed = 1 where 1");

echo "\n";
echo "The Result : ".$res;
var_dump($ids);die;
sleep(2);
}
//event reminder 
//broadcast per each user via schadular and 
//ack per each broadcast
//braodcast reminder 
//schadular for notification per user 
//api get notification all
//api get new notification not saw.