<?php
function f1($data,$user_id,$link,$access_token,$reply_token)
{
	if($data=="[f1]記錄用藥")
	{
		$sql = "UPDATE user set function_num=1.1 where user_id='$user_id'";
		mysqli_query($link,$sql);
		$post_data = [
			"replyToken" => $reply_token,
			"messages" => [
				[ 
				  "type"=> "text",    
				  "text"=> "請入輸入你的藥品 格式:藥品/劑量/次數 \n 例如:健安心/100/1天2次"
				]
			]
		];
		push($post_data,$access_token);
	}
	else if($data=="[f1]查詢藥品")
	{
		$sql = "UPDATE user set function_num=1.2 where user_id='$user_id'";
		mysqli_query($link,$sql);
		$post_data = [
			"replyToken" => $reply_token,
			"messages" => [
				[
				  "type"=> "text",
				  "text"=> "請入輸入你想查詢的藥品喔!!"
				]
			]
		];
		push($post_data,$access_token);
		
	}
}
?>