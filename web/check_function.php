<?php
function check_function($function_num,$message,$user_id,$link,$access_token,$reply_token)
{
	$ps=substr($message,0,1);
	$message=substr($message,1);
	if($ps=='#')
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
				$sql = "UPDATE user set function_num=0 where user_id='$user_id'";
				mysqli_query($link,$sql);
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
									  "text"=> "藥品資訊為 \n $row[0]"
									]
								]
							];
					push($post_data,$access_token);
					$sql = "UPDATE user set function_num=0 where user_id='$user_id'";
					mysqli_query($link,$sql);
				}
				
				else
				{
					$post_data = [
								"replyToken" => $reply_token,
								"messages" => [
									[ 
									  "type"=> "text",    
									  "text"=> "查無此藥品，請正確輸入藥品喔!!"
									]
								]
							];
					push($post_data,$access_token);
				}
				
				break;	
			case 2.1:
				$sql2 = "UPDATE user set time='$message' where user_id='$user_id'";
				$result=mysqli_query($link,$sql2);
					$post_data = [
						"replyToken" => $reply_token,
						"messages" => [
							[
							  "type"=> "template",
							  "altText"=> "this is a buttons template",
							  "template"=> [
								"type"=> "buttons",
								"actions"=> [
								  [
								"type"=> "datetimepicker",
								"label"=> "記錄下次門診時間",
								"data"=> "記錄下次門診時間",
								"mode"=> "date",
								"initial"=> "2019-07-31",
								"max"=> "2020-07-31",
								"min"=> "2018-07-31"
								  ]
								],
								"text"=> "紀錄"
							  ]
							]
								
						]
					];
					push($post_data,$access_token);					
				break;
		}
	}
	else
	{
			$post_data = [
								"replyToken" => $reply_token,
								"messages" => [
									[ 
									  "type"=> "text",    
									  "text"=> "!格式錯誤喔!，請在前方加上#喔"
									]
								]
							];
					push($post_data,$access_token);
	}
	return 0;
}
?>