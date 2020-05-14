<?php

function Q13_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函示要改
{
	if($password=="[Q13]")//換密碼
	{
		if($answer=="有")//換回答
		{
			$sql = "UPDATE user set question_num=13.5 where user_id='$user_id'";//更換題號.5
			mysqli_query($link,$sql);
			//要換表格
			$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "template",
				  "altText" => "Q13-2",
				  "template" => [
					"type" => "carousel",
					"actions" => [],
					"columns" => [
					  [
						"title" => "Q13-2",
						"text" => "請問你覺得影響程度如何呢?",
						"actions" => [
						  [
							"type" => "postback",
							"label" => "嚴重受到影響",
							"text" => "嚴重受到影響",
							"data" => "[Q13]嚴重受到影響"
						  ],
						  [
							"type" => "postback",
							"label" => "相當受到影響",
							"text" => "相當受到影響",
							"data" => "[Q13]相當受到影響"
						  ],
						  [
							"type" => "postback",
							"label" => "中度受到影響",
							"text" => "中度受到影響",
							"data" => "[Q13]中度受到影響"
						  ]
						]
					  ],
					  [
						"title"=> "Q13-2",
						"text"=> "請問你覺得影響程度如何呢?",
						"actions"=> [
						  [
							"type" => "postback",
							"label" => "稍微受到影響",
							"text" => "稍微受到影響",
							"data" => "[Q13]稍微受到影響"
						  ],
						  [
							"type" => "postback",
							"label"=> "並沒有受到影響",
							"text" => "並沒有受到影響",
							"data" => "[Q13]並沒有受到影響"
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
			$sql = "UPDATE user set question_num=14 where user_id='$user_id'";//改題號
			mysqli_query($link,$sql);
			$sql="UPDATE daily_ans set Q13=-1 where user_name='$user_name' and date='$date'";//miss了改成-1 Q幾要改
			mysqli_query($link,$sql);
			//要改內容
			$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "template",
				  "altText" => "Q14-1",
				  "template" => [
					"type" => "carousel",
					"actions" => [],
					"columns" => [
					  [
						"title" => "Q14-1",
						"text" => "請問你對目前心臟衰竭治療的改善情況，能不能接受?",
						"actions" => [
						  [
							"type" => "postback",
							"label" => "一點也不能接受",
							"text" => "一點也不能接受",
							"data" => "[Q14]一點也不能接受"
						  ],
						  [
							"type" => "postback",
							"label" => "大部分不能接受",
							"text" => "大部分不能接受",
							"data" => "[Q14]大部分不能接受"
						  ],
						  [
							"type" => "postback",
							"label" => "尚可接受",
							"text" => "尚可接受",
							"data" => "[Q14]尚可接受"
						  ]
						]
					  ],
					  [
						"title"=> "Q14-1",
						"text"=> "請問你對目前心臟衰竭治療的改善情況，能不能接受?",
						"actions"=> [
						  [
							"type" => "postback",
							"label" => "大部分能接受",
							"text" => "大部分能接受",
							"data" => "[Q14]大部分能接受"
						  ],
						  [
							"type" => "postback",
							"label"=> "完全沒影響生活",
							"text" => "完全沒影響生活",
							"data" => "[Q14]完全沒影響生活"
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
	}
	
}
function Q13_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函式明子要改
{
	//複製上一個miss的表格
	$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "template",
				  "altText" => "Q14-1",
				  "template" => [
					"type" => "carousel",
					"actions" => [],
					"columns" => [
					  [
						"title" => "Q14-1",
						"text" => "請問你對目前心臟衰竭治療的改善情況，能不能接受?",
						"actions" => [
						  [
							"type" => "postback",
							"label" => "一點也不能接受",
							"text" => "一點也不能接受",
							"data" => "[Q14]一點也不能接受"
						  ],
						  [
							"type" => "postback",
							"label" => "大部分不能接受",
							"text" => "大部分不能接受",
							"data" => "[Q14]大部分不能接受"
						  ],
						  [
							"type" => "postback",
							"label" => "尚可接受",
							"text" => "尚可接受",
							"data" => "[Q14]尚可接受"
						  ]
						]
					  ],
					  [
						"title"=> "Q14-1",
						"text"=> "請問你對目前心臟衰竭治療的改善情況，能不能接受?",
						"actions"=> [
						  [
							"type" => "postback",
							"label" => "大部分能接受",
							"text" => "大部分能接受",
							"data" => "[Q14]大部分能接受"
						  ],
						  [
							"type" => "postback",
							"label"=> "完全沒影響生活",
							"text" => "完全沒影響生活",
							"data" => "[Q14]完全沒影響生活"
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
	
	if($password=="[Q13]")//密碼要換
	{
		switch($answer)
		{
			
			case "嚴重受到影響":
				$sql="UPDATE daily_ans set Q13=1 where user_name='$user_name' and date='$date'";//題號要改
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=14 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "相當受到影響":
				$sql="UPDATE daily_ans set Q13=2 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=14 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "中度受到影響":
				$sql="UPDATE daily_ans set Q13=3 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=14 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "稍微受到影響":
				$sql="UPDATE daily_ans set Q13=4 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=14 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "並沒有受到影響":
				$sql="UPDATE daily_ans set Q13=5 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=14 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;

		
		}
		
		return false;
	}
}

?>