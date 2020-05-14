<?php

function Q9_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函式明子要改
{
	//複製上一個miss的表格
	$post_data=[
				"replyToken" => $reply_token,
			  "messages" => [
				[
						"type"=> "template",
				  "altText"=> "Q10-1",
				  "template"=> [
					"type"=> "buttons",
					"actions"=> [
					  [
						"type"=> "postback",
						"label"=> "有",
						"text"=> "有",
						"data"=> "[Q10]有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "沒有",
						"text"=> "沒有",
						"data"=> "[Q10]沒有"
					  ],
					  [
						"type"=> "postback",
						"label"=> "無法執行",
						"text"=> "無法執行",
						"data"=> "[Q10]無法執行"
					  ]
				
					],
					"title"=> "Q10-1",
					"text"=> "昨天有因為心臟不舒服而去影響你從事興趣?"
				 ]
				]
			  ]
			];
	
	if($password=="[Q09]")//密碼要換
	{
		switch($answer)
		{
			
			case "有":
				$sql="UPDATE daily_ans set Q9=1 where user_name='$user_name' and date='$date'";//題號要改
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=10 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "沒有":
				$sql="UPDATE daily_ans set Q9=0 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=10 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
		
		}
		
		return false;
	}
}

?>