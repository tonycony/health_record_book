<?php

function Q14_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date)//函式明子要改
{
	//複製上一個miss的表格
	$post_data = [
      "replyToken" => $reply_token,
      "messages" => [
        [
          "type" => "text",
          "text" => "感謝你填寫完今日的問卷，提供我們做持續的追蹤"
        ]
      ]
    ]; 
	
	if($password=="[Q14]")//密碼要換
	{
		switch($answer)
		{
			
			case "一點也不能接受":
				$sql="UPDATE daily_ans set Q14=1 where user_name='$user_name' and date='$date'";//題號要改
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=0 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "大部分不能接受":
				$sql="UPDATE daily_ans set Q14=2 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=0 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "尚可接受":
				$sql="UPDATE daily_ans set Q14=3 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=0 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "大部分能接受":
				$sql="UPDATE daily_ans set Q14=4 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=0 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
			case "完全沒影響生活":
				$sql="UPDATE daily_ans set Q14=5 where user_name='$user_name' and date='$date'";
				mysqli_query($link,$sql);
				$sql = "UPDATE user set question_num=0 where user_id='$user_id'";//要改成下一提
				mysqli_query($link,$sql);
				return $post_data;
				break;
		
		}
		
		return false;
	}
}

?>