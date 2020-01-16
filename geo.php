<?php
// $_SERVER['REMOTE_ADDR'] will render users ip address that we will use to detect his location 
$geolocation = 'https://api.ipgeolocation.io/ipgeo?apiKey=YOUR_API_KEY&ip='.$_SERVER['REMOTE_ADDR'];
 $geo = curl_init();
curl_setopt($geo, CURLOPT_HEADER, 0);
curl_setopt($geo, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($geo, CURLOPT_URL,$geolocation);
curl_setopt($geo, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($geo, CURLOPT_VERBOSE, 0);
curl_setopt($geo, CURLOPT_SSL_VERIFYPEER, false);
$response2 = curl_exec($geo);
curl_close($geo);
$data2= json_decode($response2);



 ?>
