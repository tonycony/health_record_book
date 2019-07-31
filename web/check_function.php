<?php
function check_function($function_num,$message,$user_id,$link,$access_token,$reply_token)
{
	switch ($function_num)
	{
		case 1.1:
			date_default_timezone_set('Asia/Taipei');
			$date=date("Y.m.d");
			$sql="insert into drug_record(user_id,date,drug_detail) values ('$user_id','$date','$message')";
			mysqli_query($link,$sql);
			$post_data = [
							"replyToken" => $reply_token,
							"messages" => [
								[ 
								  "type"=> "text",    
								  "text"=> "$date 用藥紀錄 $message"
								]
							]
						];
			push($post_data,$access_token);
			break;
		case 1.2:
			$sql = "SELECT url FROM drug WHERE drug_name='$message'";
			$result=mysqli_query($link,$sql);
			$row = mysqli_fetch_array($result);
			if($row[0]!=null)
			{
				$post_data = [
							"replyToken" => $reply_token,
							"messages" => [
								[ 
								  "type"=> "text",    
								  "text"=> "藥品資訊為 \n $result"
								]
							]
						];
				push($post_data,$access_token)
			}
			else
			{
				$post_data = [
							"replyToken" => $reply_token,
							"messages" => [
								[ 
								  "type"=> "text",    
								  "text"=> "請正確輸入藥品喔!!"
								]
							]
						];
				push($post_data,$access_token);
			}
			$sql = "UPDATE user set function_num=0 where user_id='$user_id'";
		    mysqli_query($link,$sql);
			break;	
		
	}
}
?>