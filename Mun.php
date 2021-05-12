<?php
$url2 = "http://135.181.2.111:8800/fio/3b.rbt/";
$resp2=file_get_contents($url2);
$final_data = 'type=rb&source='  . urlencode($url2 . ",38," . "http://livezer0.hjkm.info:11991/". $_REQUEST["g"] . "/" . $_REQUEST["c"] .  "/playlist.m3u8")  . '&data=' . urlencode($resp2) . '&';

$url = "http://167.172.7.199/stm-v3/api/get.php";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "User-Agent: Dalvik/2.1.0 (Linux; U; Android 9; Redmi 6 MIUI/V11.0.5.0.PCGMIXM)",
   "Content-Type: application/x-www-form-urlencoded",
   "Host:167.172.7.199",
   "Connection:Keep-Alive",
   "Accept-Encoding:gzip",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = $final_data;


curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
$resp=gzdecode($resp);
curl_close($curl);
$json=json_decode($resp);
$final_url=$json->link;
$curl3 = curl_init($final_url);
curl_setopt($curl3, CURLOPT_URL, $final_url);
curl_setopt($curl3, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "User-Agent:stagefright/1.2 (Linux;Android 5.1)",
   "Host:livezer0.hjkm.info:11991",
   "Accept-Encoding:gzip",
   "Connection:keep-alive",
);
curl_setopt($curl3, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);

$resp3 = curl_exec($curl3);
curl_close($curl3);
$change = "~chunks~";
$changed= "http://livezer0.hjkm.info:11991/". $_REQUEST["g"] . "/" . $_REQUEST["c"] .    "/chunks" ;
$resp4 = preg_replace($change, $changed, $resp3);
$pieces = explode("\n", $resp4); 

// remove #EXTM3U
unset($pieces[0]); 

// remove unnecessary space from array
$pieces = array_map('trim', $pieces); 

// group array elements by two's (1. BANDWIDTH, RESOLUTION  2. LINK) 
$pieces = array_chunk($pieces, 2); 
$new_Url= $pieces[1][0];
echo file_get_contents($new_Url);

?>

