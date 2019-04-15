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

/*if($type == "text"){
	
	$sql="insert into user(user_id) values ('$user_id')";
	mysqli_query($link,$sql);
	
	$sql9 = "SELECT * FROM user where user_id = '$user_id'";
	$result2 = mysqli_query($link,$sql9);
	$row = mysqli_fetch_array($result2);
	
	if($row['user_name']==NULL)
	{
		if(substr($message,0,7)=="姓名@")
		{
			$name=substr($message,7);
			$sql="UPDATE user set user_name='$name' where user_id='$user_id'";
			mysqli_query($link,$sql);
			$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "text",
				  "text" =>  "你好 $name  "."你可以使用其他功能了"
				]
			  ]
			];
			push($post_data,$access_token);
		}
		else
		{
			$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "text",
				  //"text" => "你好 $message \n哈哈 $message" ,
				  "text" =>  "姓名格式輸入錯誤喔 格式為:姓名@xxx"
				]
			  ]
			];
			push($post_data,$access_token);
		}
		
	}
	else
	{
		switch ($message)
		{
			
			  case "@空氣品質":
				$sql="SELECT * FROM air_information ORDER BY ID DESC LIMIT 1";//選擇最新的空氣資訊
				$result=mysqli_query($link,$sql);
				$row = mysqli_fetch_array($result);
				$replymessage='現在的溫度是'.(string)$row['Temperature']."°C\n"
				.'濕度是'.(string)$row['Humidity']."%\n"
				.'Co濃度是'.(string)$row['Co']."%\n"
				.'PM2.5是'.(string)$row['PM25'];//回傳給使用者之資訊 \n要用""
				$post_data = [
				  "replyToken" => $reply_token,
				  "messages" => [
					[
					  "type" => "text",
					  "text" => $replymessage
					]
				  ]
				]; 
				push($post_data,$access_token);
				break;
			  case "@關閉提醒":
				$sql="UPDATE close_reminder set reminder=0 where only=1";//選擇最新的空氣資訊
				$result=mysqli_query($link,$sql);
				$replymessage='已關閉提醒5分鐘';//回傳給使用者之資訊 \n要用""
				$post_data = [
				  "replyToken" => $reply_token,
				  "messages" => [
					[
					  "type" => "text",
					  "text" => $replymessage
					]
				  ]
				]; 
				push($post_data,$access_token);
				break;
		} 
	}
}
*/


?>
