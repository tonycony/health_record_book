<?php
function f1($data)
{
	if(data=="[f1]記錄用藥")
	{
		$post_data = [
			"replyToken" => $reply_token,
			"messages" => [
				[ 
				  "type"=> "text",    
				  "text"=> "請入輸入你的藥品 格式:藥品/克數/次數 \n 例如:健安心/100/1天2次"
				]
			]
		];
		return $post_data;
	}
	else if(data=="[f1]查詢藥品")
	{
		$post_data = [
			"replyToken" => $reply_token,
			"messages" => [
				[
				  "type"=> "text",
				  "text"=> "請入輸入你想查詢的藥品喔!!"
				]
			]
		];
		return $post_data;
		
	}
}
?>