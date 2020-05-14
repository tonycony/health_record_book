<?php

function Q11_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函示要改
{
	if($password=="[Q11]")//換密碼
	{
		if($answer=="有")//換回答
		{
			$sql = "UPDATE user set question_num=11.5 where user_id='$user_id'";//更換題號.5
			mysqli_query($link,$sql);
			//要換表格
			$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "template",
				  "altText" => "Q11-2",
				  "template" => [
					"type" => "carousel",
					"actions" => [],
					"columns" => [
					  [
						"title" => "Q11-2",
						"text" => "請問你覺得影響程度如何呢?",
						"actions" => [
						  [
							"type" => "postback",
							"label" => "嚴重受到影響",
							"text" => "嚴重受到影響",
							"data" => "[Q11]嚴重受到影響"
						  ],
						  [
							"type" => "postback",
							"label" => "相當受到影響",
							"text" => "相當受到影響",
							"data" => "[Q11]相當受到影響"
						  ],
						  [
							"type" => "postback",
							"label" => "中度受到影響",
							"text" => "中度受到影響",
							"data" => "[Q11]中度受到影響"
						  ]
						]
					  ],
					  [
						"title"=> "Q11-2",
						"text"=> "請問你覺得影響程度如何呢?",
						"actions"=> [
						  [
							"type" => "postback",
							"label" => "稍微受到影響",
							"text" => "稍微受到影響",
							"data" => "[Q11]稍微受到影響"
						  ],
						  [
							"type" => "postback",
							"label"=> "並沒有受到影響",
							"text" => "並沒有受到影響",
							"data" => "[Q11]並沒有受到影響"
						  ],
						  [
							"type" => "message",
							"label" => "-",
							"text" => "-"
						  ]
						]
					  ]
					]
				  ]
				]
			  ]
			];		
			return $post_data;
			
		}
		else if($answer=="沒有"||$answer=="無法執行")//Miss了 換下一提
		{
			$sql = "UPDATE user set question_num=12 where user_id='$user_id'";//改題號
			mysqli_query($link,$sql);
			$sql="UPDATE daily_ans set Q11=-1 where user_name='$user_name' and date='$date'";//miss了改成-1 Q幾要改
			mysqli_query($link,$sql);
			//要改內容
			$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q12-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q12]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q12]沒有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "無法執行",
						"text"=> "無法執行",
						"data"=> "[Q12]無法執行"
					  ]
				
					],
					"title"=> "Q12-1",
					"text"=> "你昨天有因為心臟不舒服而影響你從事外出，拜訪朋友嗎?"
				 ]
				]
			  ]
			];
			return $post_data;
		}
	}
	
}
function Q11_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函式明子要改
{
	//複製上一個miss的表格
	$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q12-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q12]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q12]沒有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "無法執行",
						"text"=> "無法執行",
						"data"=> "[Q12]無法執行"
					  ]
				
					],
					"title"=> "Q12-1",
					"text"=> "你昨天有因為心臟不舒服而影響你從事外出，拜訪朋友嗎?"
				 ]
				]
			  ]
			];
	
	if($password=="[Q11]")//密碼要換
	{
		switch($answer)
		{
			
			case "嚴重受到影響":
				$sql="UPDATE daily_ans set Q11=1 where user_name='$user_name' and date='$date'";//題號要改
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=12 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "相當受到影響":
				$sql="UPDATE daily_ans set Q11=2 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=12 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "中度受到影響":
				$sql="UPDATE daily_ans set Q11=3 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=12 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "稍微受到影響":
				$sql="UPDATE daily_ans set Q11=4 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=12 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "並沒有受到影響":
				$sql="UPDATE daily_ans set Q11=5 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=12 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;

		
		}
		
		return false;
	}
}

?>