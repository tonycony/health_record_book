<?php

function Q2_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函示要改
{
	if($password=="[Q02]")//換密碼
	{
		if($answer=="有")//換回答
		{
			$sql = "UPDATE user set question_num=2.5 where user_id='$user_id'";//更換題號.5
			mysqli_query($link,$sql);
			//要換表格
			$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "template",
				  "altText" => "Q2-2",
				  "template" => [
					"type" => "carousel",
					"actions" => [],
					"columns" => [
					  [
						"title" => "Q2-2",
						"text" => "在你走路的過程中，是否有覺得累或是感到喘?",
						"actions" => [
						  [
							"type" => "postback",
							"label" => "非常累或喘",
							"text" => "非常累或喘",
							"data" => "[Q02]非常累或喘"
						  ],
						  [
							"type" => "postback",
							"label" => "很累或喘",
							"text" => "很累或喘",
							"data" => "[Q02]很累或喘"
						  ],
						  [
							"type" => "postback",
							"label" => "相當累或喘",
							"text" => "相當累或喘",
							"data" => "[Q02]相當累或喘"
						  ]
						]
					  ],
					  [
						"title"=> "Q2-2",
						"text"=> "在你走路的過程中，是否會覺得累或是感到喘?",
						"actions"=> [
						  [
							"type" => "postback",
							"label" => "有點累或喘",
							"text" => "有點累或喘",
							"data" => "[Q02]有點累或喘"
						  ],
						  [
							"type" => "postback",
							"label"=> "一點都不累或喘",
							"text" => "一點都不累或喘",
							"data" => "[Q02]一點都不累或喘"
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
		else if($answer=="沒有"||$answer=="因行動不便無法走路")//Miss了 換下一提
		{
			$sql = "UPDATE user set question_num=3 where user_id='$user_id'";//改題號2
			mysqli_query($link,$sql);
			$sql="UPDATE daily_ans set Q2=-1 where user_name='$user_name' and date='$date'";//miss了改成-1 Q幾要改
			mysqli_query($link,$sql);
			//要改內容
			$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q3-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q03]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q03]沒有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "因行動不便無法走路",
						"text"=> "因行動不便無法走路",
						"data"=> "[Q03]因行動不便無法走路"
					  ]
					],
					"title"=> "Q3-1",
					"text"=> "有沒有急著做一件事情(ex.趕時間、接小孩、關瓦斯爐...)而有快走或是小跑步?"
				 ]
				]
			  ]
				
			  
			];
			return $post_data;
		}
	}
	
}
function Q2_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函式明子要改
{
	//複製上一個miss的表格
	$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q3-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q03]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q03]沒有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "因行動不便無法走路",
						"text"=> "因行動不便無法走路",
						"data"=> "[Q03]因行動不便無法走路"
					  ]
					],
					"title"=> "Q3-1",
					"text"=> "有沒有急著做一件事情(ex.趕時間、接小孩、關瓦斯爐...)而有快走或是小跑步?"
				 ]
				]
			  ]
				
			];
	
	if($password=="[Q02]")//密碼要換
	{
		switch($answer)
		{
			
			case "非常累或喘":
				$sql="UPDATE daily_ans set Q2=1 where user_name='$user_name' and date='$date'";//題號要改
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=3 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "很累或喘":
				$sql="UPDATE daily_ans set Q2=2 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=3 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "相當累或喘":
				$sql="UPDATE daily_ans set Q2=3 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=3 where user_id='$user_id'";//要改成下一題
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "有點累或喘":
				$sql="UPDATE daily_ans set Q2=4 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=3 where user_id='$user_id'";//要改成下一題
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "一點都不累或喘":
				$sql="UPDATE daily_ans set Q2=5 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=3 where user_id='$user_id'";//要改成下一題
				mysqli_query($link,$sql);
				return $post_data;
				break;
		}
		
		return false;
	}
}

?>