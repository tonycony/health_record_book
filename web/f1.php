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
	
	else if($data=="[f03]每日記錄")
	{
		$post_data = 
		[
			"replyToken" => $reply_token,
			"messages" => [
				[
					  "type"=> "template",
					  "altText"=> "this is a buttons template",
					  "template"=> [
						"type"=> "buttons",
						"actions"=> [
						  [
							"type"=> "postback",
							"label"=> "脈搏",
							"text"=> "脈搏",
							"data"=> "[f03]脈搏"
						  ],
						  [
							"type"=> "postback",
							"label"=> "血壓",
							"text"=> "血壓",
							"data"=> "[f03]血壓"
						  ],
						  [
							"type"=> "postback",
							"label"=> "體重",
							"text"=> "體重",
							"data"=> "[f03]體重"
						  ],
						  [
							"type"=> "postback",
							"label"=> "血糖",
							"text"=> "血糖",
							"data"=> "[f03]血糖"
						  ]
						],
						"title"=> "每日記錄",
						"text"=> "選擇紀錄事項"
					  ]
				]

			]
		];
		push($post_data,$access_token);
		
	}
	
	return 0;
}
?>
