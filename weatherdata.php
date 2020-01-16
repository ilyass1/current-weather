<?php
/* 
you can change the ids depending on the cities you want to show 
please refer to (http://bulk.openweathermap.org/sample/) 
*/
//2553604->casablanca ,2561668->agadir , 2550078 ->eljadida , 2636177->tangier,2462881->laayoune,2538474->rabat
$weatherApiId = "http://api.openweathermap.org/data/2.5/group?id=2553604,2561668,2550078,2462881,2538474&lang=fr&units=metric&APPID=YOUR API KEY";
$chid = curl_init();
curl_setopt($chid, CURLOPT_HEADER, 0);
curl_setopt($chid, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($chid, CURLOPT_URL, $weatherApiId);
curl_setopt($chid, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($chid, CURLOPT_VERBOSE, 0);
curl_setopt($chid, CURLOPT_SSL_VERIFYPEER, false);
$response= curl_exec($chid);

curl_close($chid);
$data = json_decode($response);






?>
