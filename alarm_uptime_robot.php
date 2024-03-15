<?php
$message = $_GET['monitorFriendlyName'].'
網址：'.$_GET['monitorURL'].'
問題：'.$_GET['alertDetails'].'
時間：'.date('Y-m-d H:i:s', $_GET['alertDateTime']);

if(empty($_GET['alertFriendlyDuration']) == false)
{
$message .= '
告警持續時間：'.$_GET['alertFriendlyDuration'];	
}

$curl_data['message'] = '
>> 站台異常通知 <<
'.$message;

// $data = json_encode( $post_data, JSON_UNESCAPED_UNICODE );

$header_data['Authorization'] = 'Bearer pVzas8HRtJKbxMYvKr4UDMaN12mkLmvJiOEQkWgWLVB';
// $header_data['Authorization'] = 'Bearer CJZmZSthAxjBxSmq3kYCzHt4i0K96ujjf4cfExEm5vh';

$url = 'https://notify-api.line.me/api/notify';

$res = curl_url_res($url, $curl_data, $header_data);

//輸出 
file_put_contents('log.txt', json_encode($_GET, JSON_UNESCAPED_UNICODE)); 
		
function curl_url_res($url,$data = null,$header_data = null)       
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	if(is_array($header_data) == true)
	{
		foreach($header_data as $key => $row)
		{
			$http_header[] = $key.':'.$row;
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	if(empty($data) == false)
	{
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}
	$res_str = curl_exec($ch);
	curl_close($ch);
	
	return $res_str;
}

?>
