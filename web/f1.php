<?php
function f1($data,$user_id,$link,$access_token,$reply_token,$time)
{
	if($data=="[f01]記錄用藥")
	{
		$sql = "UPDATE user set function_num=1.1 where user_id='$user_id'";
		mysqli_query($link,$sql);
		$post_data = [
			"replyToken" => $reply_token,
			"messages" => [
				[ 
				  "type"=> "text",    
				  "text"=> "請輸入你的藥品 格式:#藥品/劑量/次數 \n 例如:#健安心/100/1天2次"
				]
			]
		];
		push($post_data,$access_token);
	}
	else if($data=="[f01]查詢藥品")
	{
		$sql = "UPDATE user set function_num=1.2 where user_id='$user_id'";
		mysqli_query($link,$sql);
		$post_data = [
			"replyToken" => $reply_token,
			"messages" => [
				[
				  "type"=> "text",
				  "text"=> "請輸入你想查詢的藥品喔!! 格式:#藥品名 例如:#健安心"
				]
			]
		];
		push($post_data,$access_token);
		
	}
	else if($data=="[f02]記錄下次門診時間")
	{
		$sql = "UPDATE user set function_num=2.1 where user_id='$user_id'";
		mysqli_query($link,$sql);
		$post_data = [
			"replyToken" => $reply_token,
			"messages" => [
				[
				  "type"=> "text",
				  "text"=> "下次門診時間為 $time:"
				]
			]
		];
		push($post_data,$access_token);
		
		
	}
	/*
	else if($data=="[f02]看診時間提醒")
	{
		$sql = "UPDATE user set function_num=0 where user_id='$user_id'";
		mysqli_query($link,$sql);
		$sql2 = "SELECT time FROM user WHERE user_id='$user_id'";
		$result=mysqli_query($link,$sql2);
		$row = mysqli_fetch_array($result);
		$post_data = [
			"replyToken" => $reply_token,
			"messages" => [
				[
				  "type"=> "text",
				  "text"=> "提醒你，你的門診時間為: $row[0] \n不要忘記了喔"
				]
			]
		];
		push($post_data,$access_token);
		
	}
	*/
	return 0;
}
?>
