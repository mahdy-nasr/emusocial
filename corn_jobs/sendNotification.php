<?php
// Server key from Firebase Console
define( 'API_ACCESS_KEY', 'AAAA1Bl4GB8:APA91bFNzIysKhwYoorTIl8UYV_6QlVVA2kfO9zCnBt0Uhl3hFLP84N9m1HXPAuon-itjApSM535hyowZojxTQVK_uYTzDgKwfcpcLVZq4KMk_rnfGFlJsRSFfKbxsr66JVANFb0gPLI' );

$data = array("to" => "cg1Y32a94t4:APA91bGr-AQ1ud3MgxabHy7Wl8VB_TV04gG0UwMel3kxUAf68Ds7Z288mqnaXqOyZVKI5aaO-xKDEl3q66ueYIJ2QNFQGSIWG7qiaTiMOIkhMUe1AwBaejZ_rftMbkWlKXO5NGkESl5s",
              "notification" => array( "title" => "emusocial", "body" => "ALSO emu social","icon" => "icon.png"));                                                                    
$data_string = json_encode($data); 

echo "The Json Data : ".$data_string; 

$headers = array
(
     'Authorization: key=' . API_ACCESS_KEY, 
     'Content-Type: application/json'
);                                                                                 
                                                                                                                     
$ch = curl_init();  

curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );                                                                  
curl_setopt( $ch,CURLOPT_POST, true );  
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);                                                                  
                                                                                                                     
$result = curl_exec($ch);

curl_close ($ch);

echo "<p>&nbsp;</p>";
echo "The Result : ".$result;