<?php
date_default_timezone_set('Asia/Taipei');
$date=date("Y.m.d");
function Q1_1($password,$answer,$link,$user_id,$reply_token)
{
	if($password=="[Q01]")
	{
		if($answer=="泡澡"||$answer=="沖澡")
		{
			$sql = "UPDATE user set question_num=1.5 where user_id='$user_id'";
			mysqli_query($link,$sql);
			$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "template",
				  "altText" => "Q1-1",
				  "template" => [
					"type" => "carousel",
					"actions" => [],
					"columns" => [
					  [
						"title" => "Q1-2",
						"text" => "在你洗澡的過程中，是否會覺得累或是感到喘?",
						"actions" => [
						  [
							"type" => "postback",
							"label" => "非常累或喘",
							"text" => "非常累或喘",
							"data" => "[Q01]非常累或喘"
						  ],
						  [
							"type" => "postback",
							"label" => "很累或喘",
							"text" => "很累或喘",
							"data" => "[Q01]很累或喘"
						  ],
						  [
							"type" => "postback",
							"label" => "相當累或喘",
							"text" => "相當累或喘",
							"data" => "[Q01]相當累或喘"
						  ]
						]
					  ],
					  [
						"title"=> "Q1-2",
						"text"=> "在你洗澡的過程中，是否會覺得累或是感到喘?",
						"actions"=> [
						  [
							"type" => "postback",
							"label" => "有點累或喘",
							"text" => "有點累或喘",
							"data" => "[Q01]有點累或喘"
						  ],
						  [
							"type" => "postback",
							"label"=> "一點都不累或喘",
							"text" => "一點都不累或喘",
							"data" => "[Q01]一點都不累或喘"
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
		else
		{
			$sql = "UPDATE user set question_num=2 where user_id='$user_id'";
			mysqli_query($link,$sql);
			$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q2-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q02]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q02]沒有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "因行動不便無法走路",
						"text"=> "因行動不便無法走路",
						"data"=> "[Q02]因行動不便無法走路"
					  ]
					],
					"title"=> "Q2-1",
					"text"=> "有沒有去便利商店買菜或散步"
				 ]
				]
			  ]
				
			  
			];
			return $post_data;
		}
	}
	
}
function Q1_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date)
{

	
	if($password=="[Q01]")
	{
		switch($answer)
		{
			
			case "非常累或喘":
				$point=1;
				$sql="UPDATE daily_ans set Q1="."$point"." where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				break;
			case "很累或喘":
				$point=2;
				$sql="UPDATE daily_ans set Q1="."$point"." where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				break;
			case "相當累或喘":
				$point=3;
				$sql="UPDATE daily_ans set Q1="."$point"." where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				break;
			case "有點累或喘":
				$point=4;
				$sql="UPDATE daily_ans set Q1="."$point"." where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				break;
			case "一點都不累或喘":
				$point=5;
				$sql="UPDATE daily_ans set Q1="."$point"." where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				break;
		}
		$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q2-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q02]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q02]沒有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "因行動不便無法走路",
						"text"=> "因行動不便無法走路",
						"data"=> "[Q02]因行動不便無法走路"
					  ]
					],
					"title"=> "Q2-1",
					"text"=> "有沒有去便利商店買菜或散步"
				 ]
				]
			  ]
				
			  
			];
			$sql = "UPDATE user set question_num=2 where user_id='$user_id'";//要改成第二題
			mysqli_query($link,$sql);
		return $post_data;
	}
}
?>