<?php
date_default_timezone_set('Asia/Taipei');
function push($post_data,$access_token)
{
	//fwrite($file, json_encode($post_data)."\n");
	$ch = curl_init("https://api.line.me/v2/bot/message/reply");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Authorization: Bearer '.$access_token
		//'Authorization: Bearer '. TOKEN
	));
	$result = curl_exec($ch);

	curl_close($ch); 
}
function check_name($user_id,$link,$message,$reply_token,$access_token)
{
	$sql="SELECT user_id FROM user WHERE user_id='$user_id'";
$result= mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);
if($row[0]==null)
{
	$sql="insert into user(user_id) values ('$user_id')";
	mysqli_query($link,$sql);
	$sql2 = "SELECT user_name FROM user where user_id = '$user_id'";
	$result2 = mysqli_query($link,$sql2);
	$row = mysqli_fetch_array($result2);
	if($row['user_name']==NULL)
	{
		if(substr($message,0,7)=="姓名@")
		{
			$name=substr($message,7);
			$sql="UPDATE user set user_name='$name' where user_id='$user_id'";
			mysqli_query($link,$sql);
			$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "text",
				  "text" =>  "你好 $name  "."你可以使用其他功能了"
				]
			  ]
			];
			push($post_data,$access_token);
		}
		else
		{
			$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "text",
				  //"text" => "你好 $message \n哈哈 $message" ,
				  "text" =>  "姓名格式輸入錯誤喔 格式為:姓名@xxx"
				]
			  ]
			];
			push($post_data,$access_token);
		}
		
	}
	
}
$sql2 = "SELECT user_name FROM user where user_id = '$user_id'";
$result2 = mysqli_query($link,$sql2);
$row = mysqli_fetch_array($result2);
	if($row['user_name']==NULL)
	{
		if(substr($message,0,7)=="姓名@")
		{
			$name=substr($message,7);
			$sql="UPDATE user set user_name='$name' where user_id='$user_id'";
			mysqli_query($link,$sql);
			$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "text",
				  "text" =>  "你好 $name  "."你可以使用其他功能了"
				]
			  ]
			];
			push($post_data,$access_token);
		}
		else
		{
			$post_data = [
			  "replyToken" => $reply_token,
			  "messages" => [
				[
				  "type" => "text",
				  //"text" => "你好 $message \n哈哈 $message" ,
				  "text" =>  "姓名格式輸入錯誤喔 格式為:姓名@xxx"
				]
			  ]
			];
			push($post_data,$access_token);
		}
		
	}
}
include("mysql_connect.inc.php");
$access_token ='z8+Cz/5lm0NszzRXsCqI7pFHqfTpG0R1ui9+1qqjQpp6PqEG3NRodAqmy5Ak12bGf1rH2dE461YF4pmW+vH7f6RwWHwwkp5W0Hh6nQfD8aEyzJB+Cgw8MbZVIiDPVuwJ+VFFrA5iUq4a1dw2lq78XQdB04t89/1O/w1cDnyilFU=';

$json_string = file_get_contents('php://input');
$json_obj = json_decode($json_string);
$event = $json_obj->{"events"}[0];
$type  = $event->{"message"}->{"type"};
$message = $event->{"message"}->{"text"};
$data=$event->{"postback"}->{"data"};
$user_id  = $event->{"source"}->{"userId"};
$reply_token = $event->{"replyToken"};
//////////////////////////////////////////////////////////
check_name($user_id,$link,$message,$reply_token,$access_token);//檢查是否有輸入明子

$sql = "SELECT * FROM user where user_id = '$user_id'";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);
$question_num=$row["question_num"];
$user_name=$row["user_name"];
$date=date("Y.m.d");
/////////////////////////////////////////////////////////檢查第幾題了
include("f1.php");
f1($data,$user_id,$link,$access_token);

if($message=="@用藥紀錄")
{
	$sql="UPDATE user set function_num=1 where user_id='$user_id'";
	mysqli_query($link,$sql);
	$post_data = 
	[
		"replyToken" => $reply_token,
		"messages" => [
			[
			  "type"=> "template",
			  "altText"=> "this is a buttons template",
			  "template"=> [
			    "type"=> "buttons",
			    "actions"=> [
			      [
				"type"=> "postback",
				"label"=> "記錄用藥",
				"text"=> "記錄用藥",
				"data"=> "[f1]記錄用藥"
			      ],
			      [
				"type"=> "postback",
				"label"=> "查詢藥品",
				"text"=> "查詢藥品",
				"data"=> "[f1]查詢藥品"
			      ]
			    ],
			    "title"=> "用藥紀錄",
			    "text"=> "選擇功能"
			  ]
			]
				
		]
	];
	push($post_data,$access_token);
}
if($message=="@填寫問卷")//開始填寫問卷
{
	$sql = "UPDATE user set question_num=1 where user_id='$user_id'";//題號改為1開始
	mysqli_query($link,$sql);
	$sql2 ="INSERT INTO daily_ans (date,user_name) VALUES ('$date','$user_name')";//更新一天的資料表
	mysqli_query($link,$sql2);
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
						"title" => "Q1-1",
						"text" => "請問今天是洗澡，還是泡澡?",
						"actions" => [
						  [
							"type" => "postback",
							"label" => "泡澡",
							"text" => "泡澡",
							"data" => "[Q01]泡澡"
						  ],
						  [
							"type" => "postback",
							"label" => "沖澡",
							"text" => "沖澡",
							"data" => "[Q01]沖澡"
						  ],
						  [
							"type" => "postback",
							"label" => "擦澡",
							"text" => "擦澡",
							"data" => "[Q01]擦澡"
						  ]
						]
					  ],
					  [
						"title"=> "Q1-1",
						"text"=> "請問今天是洗澡，還是泡澡?",
						"actions"=> [
						  [
							"type" => "postback",
							"label" => "不想洗澡",
							"text" => "不想洗澡",
							"data" => "[Q01]不想洗澡"
						  ],
						  [
							"type" => "postback",
							"label"=> "因行動不便無法洗澡",
							"text" => "因行動不便無法洗澡",
							"data" => "[Q01]因行動不便無法洗澡"
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
			push($post_data,$access_token);
	$password=substr($data,0,5);
	$answer=substr($data,5);		
	switch($question_num)
	{
		case 1:
			include_once("Q1.php");
			$post_data=Q1_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 1.5:
			include_once("Q1.php");
			$post_data=Q1_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 2:
			include_once("Q2.php");
			$post_data=Q2_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 2.5:
			include_once("Q2.php");
			$post_data=Q2_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 3:
			include_once("Q3.php");
			$post_data=Q3_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 3.5:
			include_once("Q3.php");
			$post_data=Q3_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 4:
			include_once("Q4.php");
			$post_data=Q4_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;	
		case 5:
			include_once("Q5.php");
			$post_data=Q5_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 5.5:
			include_once("Q5.php");
			$post_data=Q5_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 6:
			include_once("Q6.php");
			$post_data=Q6_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 6.5:
			include_once("Q6.php");
			$post_data=Q6_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 7:
			include_once("Q7.php");
			$post_data=Q7_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 7.5:
			include_once("Q7.php");
			$post_data=Q7_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 8:
			include_once("Q8.php");
			$post_data=Q8_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 8.5:
			include_once("Q8.php");
			$post_data=Q8_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 9:
			include_once("Q9.php");
			$post_data=Q9_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 10:
			include_once("Q10.php");
			$post_data=Q10_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 10.5:
			include_once("Q10.php");
			$post_data=Q10_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 11:
			include_once("Q11.php");
			$post_data=Q11_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 11.5:
			include_once("Q11.php");
			$post_data=Q11_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 12:
			include_once("Q12.php");
			$post_data=Q12_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 12.5:
			include_once("Q12.php");
			$post_data=Q12_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 13:
			include_once("Q13.php");
			$post_data=Q13_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 13.5:
			include_once("Q13.php");
			$post_data=Q13_2($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
		case 14:
			include_once("Q14.php");
			$post_data=Q14_1($password,$answer,$link,$user_id,$user_name,$reply_token,$date);
			push($post_data,$access_token);
			break;
	}
}



mysqli_close($link);
?>
