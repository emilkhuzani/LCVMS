<?php
/* 
IDP demo rest api example emil khuzani pretbn fgdg dfgd

input: associative array containing following keys  
	token : token to access 
	scope : 'location' to access the location history, 'event' to access event like tamper,geofence,text,catch,panic
	start_time	: start time of search  YYYY-MM-DD HH:MM:SS
	end_time	: end time of search    YYYY-MM-DD HH:MM:SS
	
return format:
json string with following structure:

if success :
	 {"status":true,"text":"query success","data":}
if failed :
	{"status":false,"text":"reason"}
*/


function IDPRest($data){
	$data_string = json_encode($data);                                                                                                                                                                                                   
	$ch = curl_init('http://35.198.220.23/idp2/api.php');                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($data_string))                                                                       
	);                                                                                                                   
                                                                                                                     
	$result = curl_exec($ch);
	return json_decode($result,true);
}

/* location */
$data = array("token" => "1609c743dbd0e94ef07895733c3844dd", "scope" => "location", "start_time"=>"2019-03-21 06:47:42","end_time"=>"2019-03-29 06:47:42"); 
$result = IDPRest($data);
//echo "<pre>";
//print_r ($result['data']);
$mydata=$result['data'];
foreach($mydata as $item){
	//echo $item['device_id']."<br>";
}
//echo "<pre>";
//print_r ($result['data']);
/* event */
$data = array("token" => "1609c743dbd0e94ef07895733c3844dd", "scope" => "event", "start_time"=>"2019-03-21 06:47:42","end_time"=>"2019-03-29 06:47:42"); 
$result = IDPRest($data);
echo "<pre>";
print_r($result );   

?>