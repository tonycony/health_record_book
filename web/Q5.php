<?php

function Q5_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函示要改
{
	if($password=="[Q05]")//換密碼
	{
		if($answer=="有")//換回答
		{
			$sql = "UPDATE user set question_num=5.5 where user_id='$user_id'";//更換題號.5
			mysqli_query($link,$sql);
			//要換表格
			$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q5-2",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "整天都累",
						"text"=> "整天都累",
						"data"=> "[Q05]整天都累"
					  ],
					  [
						"type"=> "postback",
						"label"=> "好多次",
						"text"=> "好多次",
						"data"=> "[Q05]好多次"
					  ],
					  [
						"type"=> "postback",
						"label"=> "1~3次",
						"text"=> "1~3次",
						"data"=> "[Q05]1~3次"
					  ]
					  
				
					],
					"title"=> "Q5-2",
					"text"=> "昨天大概有幾次因為疲憊(累)而去影響你去做你想做的事情呢?"
				 ]
				]
			  ]
			];
			return $post_data;
			
		}
		else if($answer=="沒有")//Miss了 換下一提
		{
			$sql = "UPDATE user set question_num=6 where user_id='$user_id'";//改題號
			mysqli_query($link,$sql);
			$sql="UPDATE daily_ans set Q5=-1 where user_name='$user_name' and date='$date'";//miss了改成-1 Q幾要改
			mysqli_query($link,$sql);
			//要改內容
			$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q6-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q06]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q06]沒有"
					  ]
				
					],
					"title"=> "Q6-1",
					"text"=> "昨天有沒有因為呼吸急促(喘)而去影響你去做你想做的事情呢?"
				 ]
				]
			  ]
			];
			return $post_data;
		}
	}
	
}
function Q5_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函式明子要改
{
	//複製上一個miss的表格
	$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q6-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q06]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q06]沒有"
					  ]
				
					],
					"title"=> "Q6-1",
					"text"=> "昨天有沒有因為呼吸急促(喘)而去影響你去做你想做的事情呢?"
				 ]
				]
			  ]
			];
	
	if($password=="[Q05]")//密碼要換
	{
		switch($answer)
		{
			
			case "整天都累":
				$sql="UPDATE daily_ans set Q5=1 where user_name='$user_name' and date='$date'";//題號要改
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=6 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "好多次":
				$sql="UPDATE daily_ans set Q5=2 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=6 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "1~3次":
				$sql="UPDATE daily_ans set Q5=3 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=6 where user_id='$user_id'";//要改成下一題
				mysqli_query($link,$sql);
				return $post_data;
				break;
		
		}
		
		return false;
	}
}

?>