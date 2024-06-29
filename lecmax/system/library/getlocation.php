<?php
function get_data($url) {
    $curl = curl_init($url); 
    curl_setopt($curl, CURLOPT_FAILONERROR, true); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   
    return curl_exec($curl); 
}

if(!isset($_POST['mylocation'])){
    die("0");
}
$str                = $_POST['mylocation'];
$str                = str_replace('TPHCM', 'TP HCM', $str);
$str                = preg_replace('/\s+/', '+', $str);
$api                = 'https://maps.googleapis.com/maps/api/geocode/json?&address='.$str;

$result             = json_decode(get_data($api));

if($result->status == "OK"){
    $info               = $result->results[0]->geometry->location;
    echo $info->lat.','.$info->lng;exit;    
} else {
    echo '';
}
