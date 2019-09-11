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
$time=$event->{"postback"}->{"params"}->{"datetime"};
$user_id  = $event->{"source"}->{"userId"};
$reply_token = $event->{"replyToken"};
//////////////////////////////////////////////////////////
check_name($user_id,$link,$message,$reply_token,$access_token);//檢查是否有輸入明子
$sql = "SELECT * FROM user where user_id = '$user_id'";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);
$question_num=$row["question_num"];
$user_name=$row["user_name"];
$function_num=$row["function_num"];
$date=date("Y.m.d");
$function_password=substr($message,0,1);
/////////////////////////////////////////////////////////檢查第幾題了
include("f1.php");
include("check_function.php");
if($data!="")
{
	f1($data,$user_id,$link,$access_token,$reply_token);
	return 0;
}
else if($data=="")
{
	switch($function_password)
	{
		case '@':
                if($message=="@門診紀錄")
				{
					$sql="UPDATE user set function_num=2 where user_id='$user_id'";
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
								"type"=> "datetimepicker",
								"label"=> "記錄下次門診時間",
								"data"=> "[f02]記錄下次門診時間",
								"mode"=> "datetime",
								"initial"=> "2019-07-31T09:53",
								"max"=> "2020-07-31T09:53",
								"min"=> "2018-07-31T09:53"
								  ]
								],
								"text"=> "紀錄"
							  ]
							]
								
						]
					];
					push($post_data,$access_token);
				}				
				else if($message=="@用藥紀錄")
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
								"data"=> "[f01]記錄用藥"
								  ],
								  [
								"type"=> "postback",
								"label"=> "查詢藥品",
								"text"=> "查詢藥品",
								"data"=> "[f01]查詢藥品"
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
				else if($message=="@填寫問卷")//開始填寫問卷
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
				else if($message=="@衛教區")
				{
					$post_data = [
							  "replyToken" => $reply_token,
							  "messages" => [
												[
												  "type"=> "flex",
												  "altText"=> "Flex Message",
												  "contents"=> [
													"type"=> "bubble",
													"header"=> [
													  "type"=> "box",
													  "layout"=> "horizontal",
													  "contents"=> [
														[
														  "type"=> "text",
														  "text"=> "最新資訊",
														  "margin"=> "md",
														  "size"=> "xl",
														  "align"=> "start",
														  "gravity"=> "center",
														  "weight"=> "bold",
														  "color"=> "#073594",
														  "wrap"=> false
														]
													  ]
													],
													"hero"=> [
													  "type"=> "image",
													  "url"=> "https://i.ibb.co/hRmKyyG/0703-soliantorange.jpg",
													  "flex"=> 3,
													  "size"=> "full",
													  "aspectRatio"=> "20:13",
													  "aspectMode"=> "cover",
													  "action"=> [
														"type"=> "uri",
														"label"=> "Action",
														"uri"=> "https://linecorp.com/"
													  ]
													],
													"body"=> [
													  "type"=> "box",
													  "layout"=> "horizontal",
													  "spacing"=> "md",
													  "contents"=> [
														[
														  "type"=> "box",
														  "layout"=> "vertical",
														  "flex"=> 1,
														  "contents"=> [
															[
															  "type"=> "image",
															  "url"=> "https://scdn.line-apps.com/n/channel_devcenter/img/fx/02_1_news_thumbnail_1.png",
															  "size"=> "full",
															  "aspectRatio"=> "20:13",
															  "aspectMode"=> "fit",
															  "backgroundColor"=> "#FFFFFF"
															],
															[
															  "type"=> "image",
															  "url"=> "https://scdn.line-apps.com/n/channel_devcenter/img/fx/02_1_news_thumbnail_2.png",
															  "margin"=> "md",
															  "size"=> "sm",
															  "aspectRatio"=> "4:3",
															  "aspectMode"=> "cover"
															]
														  ]
														],
														[
														  "type"=> "box",
														  "layout"=> "vertical",
														  "flex"=> 2,
														  "contents"=> [
															[
															  "type"=> "text",
															  "text"=> "認識心臟衰竭",
															  "flex"=> 1,
															  "size"=> "lg",
															  "gravity"=> "top",
															  "weight"=> "bold",
															  "color"=> "#1865BF",
															  "action"=> [
																"type"=> "uri",
																"uri"=> "https://www.tahsda.org.tw/departments/files/CardiovascularCenter/認識心臟衰竭.pdf"
															  ]
															],
															[
															  "type"=> "separator"
															],
															[
															  "type"=> "text",
															  "text"=> "低鹽飲食",
															  "flex"=> 2,
															  "size"=> "lg",
															  "gravity"=> "center",
															  "weight"=> "bold",
															  "color"=> "#1865BF",
															  "action"=> [
																"type"=> "uri",
																"uri"=> "https://www.ymuh.ym.edu.tw/tw/departments/dep-support/nutrition/health-education/5915-%E4%BD%8E%E9%88%89%E9%A3%B2%E9%A3%9F%E5%8E%9F%E5%89%87.html"
															  ]
															],
															[
															  "type"=> "separator"
															],
															[
															  "type"=> "text",
															  "text"=> "林口長庚網路掛號",
															  "flex"=> 2,
															  "size"=> "lg",
															  "gravity"=> "center",
															  "weight"=> "bold",
															  "color"=> "#1865BF",
															  "action"=> [
																"type"=> "uri",
																"uri"=> "https://register.cgmh.org.tw/RMSTimeTable.aspx?dpt=32200A32220A"
															  ]
															],
															[
															  "type"=> "separator"
															],
															[
															  "type"=> "text",
															  "text"=> "勞保傷病補助",
															  "flex"=> 2,
															  "size"=> "lg",
															  "gravity"=> "bottom",
															  "weight"=> "bold",
															  "color"=> "#1865BF",
															  "action"=> [
																"type"=> "uri",
																"uri"=> "https://www.bli.gov.tw/0004837.html"
															  ]
															]
														  ]
														]
													  ]
													]
												  ]
												]
							  ]
					];
					push($post_data,$access_token);
				}
			break;
			
		case '#':
			check_function($function_num,$message,$user_id,$link,$access_token,$reply_token);
			break;
	}
	
	
}
else if($time!="")
{
	$post_data = [
					"replyToken" => $reply_token,
					"messages" => [
						[
						  "type"=> "text",
						  "text"=> "你所記錄的時間為:$time"
						]
				]
	];
	push($post_data,$access_token);
}


mysqli_close($link);
return 0;
?>
