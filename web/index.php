<?php
function push($post_data,$access_token)
{
	//fwrite($file, json_encode($post_data)."\n");
	$ch = curl_init("https://api.line.me/v2/bot/message/reply");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Authorization: Bearer '.$access_token
		//'Authorization: Bearer '. TOKEN
	));
	$result = curl_exec($ch);

	curl_close($ch); 
}

//include("mysql_connect.inc.php");
$access_token ='z8+Cz/5lm0NszzRXsCqI7pFHqfTpG0R1ui9+1qqjQpp6PqEG3NRodAqmy5Ak12bGf1rH2dE461YF4pmW+vH7f6RwWHwwkp5W0Hh6nQfD8aEyzJB+Cgw8MbZVIiDPVuwJ+VFFrA5iUq4a1dw2lq78XQdB04t89/1O/w1cDnyilFU=';

$json_string = file_get_contents('php://input');
$json_obj = json_decode($json_string);
$event = $json_obj->{"events"}[0];
$type  = $event->{"message"}->{"type"};
$message = $event->{"message"}->{"text"};
$user_id  = $event->{"source"}->{"userId"};
$reply_token = $event->{"replyToken"};
$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "text",
				  "text" =>  "你好 你可以使用其他功能了"
				]
			  ]
			];
push($post_data,$access_token);
