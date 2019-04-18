<?php

function Q8_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函示要改
{
	if($password=="[Q08]")//換密碼
	{
		if($answer=="有")//換回答
		{
			$sql = "UPDATE user set question_num=8.5 where user_id='$user_id'";//更換題號.5
			mysqli_query($link,$sql);
			//要換表格
			$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q8-2",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "",
						"text"=> "需要",
						"data"=> "[Q08]需要"
					  ],

					  [
						"type"=> "postback",
						"label"=> "不需要",
						"text"=> "不需要",
						"data"=> "[Q08]不需要"
					  ]
					  
				
					],
					"title"=> "Q8-2",
					"text"=> "是否需要坐著或是墊高頭部才能改善?"
				 ]
				]
			  ]
			];
			return $post_data;
			
		}
		else if($answer=="沒有")//Miss了 換下一提
		{
			$sql = "UPDATE user set question_num=9 where user_id='$user_id'";//改題號
			mysqli_query($link,$sql);
			$sql="UPDATE daily_ans set Q8=-1 where user_name='$user_name' and date='$date'";//miss了改成-1 Q幾要改
			mysqli_query($link,$sql);
			//要改內容
			$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q9-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q09]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q09]沒有"
					  ]
				
					],
					"title"=> "Q9-1",
					"text"=> "昨天有沒有因為心臟衰竭的症狀影響你享受生活呢?"
				 ]
				]
			  ]
			];
			return $post_data;
		}
	}
	
}
function Q8_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函式明子要改
{
	//複製上一個miss的表格
	$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q9-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q09]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q09]沒有"
					  ]
				
					],
					"title"=> "Q9-1",
					"text"=> "昨天有沒有因為心臟衰竭的症狀影響你享受生活呢?"
				 ]
				]
			  ]
			];
	
	if($password=="[Q08]")//密碼要換
	{
		switch($answer)
		{
			
			case "需要":
				$sql="UPDATE daily_ans set Q8=1 where user_name='$user_name' and date='$date'";//題號要改
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=9 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "不需要":
				$sql="UPDATE daily_ans set Q8=0 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=9 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;

		
		}
		
		return false;
	}
}

?>