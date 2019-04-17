<?php

function Q7_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函示要改
{
	if($password=="[Q07]")//換密碼
	{
		if($answer=="好")//換回答
		{
			$sql = "UPDATE user set question_num=7.5 where user_id='$user_id'";//更換題號.5
			mysqli_query($link,$sql);
			//要換表格
			$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q7-2",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q07]有"
					  ],

					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q07]沒有"
					  ]
					  
				
					],
					"title"=> "Q7-2",
					"text"=> "是否因為呼吸急促而造成你睡不好?"
				 ]
				]
			  ]
			];
			return $post_data;
			
		}
		else if($answer=="不好")//Miss了 換下一提
		{
			$sql = "UPDATE user set question_num=8 where user_id='$user_id'";//改題號
			mysqli_query($link,$sql);
			$sql="UPDATE daily_ans set Q7=-1 where user_name='$user_name' and date='$date'";//miss了改成-1 Q幾要改
			mysqli_query($link,$sql);
			//要改內容
			$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q8-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q08]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q08]沒有"
					  ]
				
					],
					"title"=> "Q8-1",
					"text"=> "是否因為呼吸急促而造成你睡不好?"
				 ]
				]
			  ]
			];
			return $post_data;
		}
	}
	
}
function Q7_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函式明子要改
{
	//複製上一個miss的表格
	$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q8-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q08]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q08]沒有"
					  ]
				
					],
					"title"=> "Q8-1",
					"text"=> "是否因為呼吸急促而造成你睡不好?"
				 ]
				]
			  ]
			];
	
	if($password=="[Q07]")//密碼要換
	{
		switch($answer)
		{
			
			case "有":
				$sql="UPDATE daily_ans set Q7=1 where user_name='$user_name' and date='$date'";//題號要改
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=8 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "沒有":
				$sql="UPDATE daily_ans set Q7=0 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=8 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;

		
		}
		
		return false;
	}
}

?>