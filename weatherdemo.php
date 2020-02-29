<!doctype html>
<html>

<head>
    <title>Current Weather </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3600">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    <style>
        body {

            margin: 0;
            padding: 0;
        }

        b {
            font-size: 20px;
            color: black;
        }

        p {
            font-size: 20px;
            padding-top: 10px;
        }

        marquee {
            border-bottom: 3px solid red;
        }

       /* .myform {
            margin-left: 300px;
            margin-top: 5px;
        }*/

        .up{
            margin-left: 250px;
            font-size: 15px;
            font-weight: bold;
        }

        .weatherslider {
            margin-top: 20px;

        }

        .row {
            height: 700px;


        }

        table {
            height: 80%;
        }

        .weather-icon {
            width: 80px;
            height: 80px;
        }

        .time {
            float: right;
        }

        #error {
            display: none;
            position: fixed;
            z-index: 1;
            left: 30%;
            top: 20%;
            width: 100%;
            height: 100%;
            overflow: auto;
            padding-top: 60px;
        }
        @media screen and (max-width: 800px ){
            .up{
            display: none;
            
        }


        }
        @media screen and (max-width: 600px ){
            .input-group{
            margin-top: 10px;
            
        }
        

        }


    </style>
    <script>
        $(document).ready(function() {
            $(".up").click(function() {
                $("marquee").toggle(1000);
                if ($(".clock").hasClass('fa-arrow-alt-circle-up')) {
                    $(".clock").removeClass('fa-arrow-alt-circle-up');
                    $(".clock").addClass('fa-arrow-alt-circle-down');
                } else {
                    $(".clock").removeClass('fa-arrow-alt-circle-down');
                    $(".clock").addClass('fa-arrow-alt-circle-up');
                }
            });
        });

    </script>

</head>

<body>
    <?php
  include('weatherdata.php');
  include('geo.php');
  if(isset($_GET["city"]) && !empty($_GET["city"]) ){
  $weatherApiCityName= "http://api.openweathermap.org/data/2.5/weather?q=".htmlspecialchars(stripslashes($_GET["city"]))."&lang=fr&units=metric&APPID=1ab82ea1f4a73e07cd87e267c0cb7993";
  }
  else{
       //header('location: weathererror.php');
  $weatherApiCityName= "http://api.openweathermap.org/data/2.5/weather?q=".$data2->city."&lang=fr&units=metric&APPID=1ab82ea1f4a73e07cd87e267c0cb7993";
  }
  $chname= curl_init();
  curl_setopt($chname, CURLOPT_HEADER, 0);
  curl_setopt($chname, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($chname, CURLOPT_URL,$weatherApiCityName);
  curl_setopt($chname, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($chname, CURLOPT_VERBOSE, 0);
  curl_setopt($chname, CURLOPT_SSL_VERIFYPEER, false);
  $response1 = curl_exec($chname);
  curl_close($chname);
  $data1 = json_decode($response1);
  if($data1->cod == "404"){
   header('location: weathererror.php');
}

  else{
    $main=$data1->weather[0]->main;
    $description=$data1->weather[0]->description;
    $temp=$data1->main->temp;
    $temp_min= $data1->main->temp_min;
    $temp_max=$data1->main->temp_max;
    $humidity=$data1->main->humidity;
    $wind_speed=$data1->wind->speed;
    $lat=$data1->coord->lat;
    $lon=$data1->coord->lon;
    $cityname=$data1->name;
  }


  ?>
  
     <div class="bs-example">
     <nav class="navbar navbar-expand-sm navbar-light bg-warning">
        <a class="navbar-brand " href="#"><b><?php echo (isset($_GET["city"]))?$cityname:$data2->city;?> Weather</b></a>
         <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
             <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
             <div class="navbar-nav navbar-center">
               <form class="form-inline"  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                   <div class="input-group">
                       <input type="text" name="city" class="form-control" placeholder="Search">
                       <div class="input-group-append">
                           <button type="submit" class="btn btn-secondary" onclick="initMap()"><i class="fa fa-search"></i></button>
                       </div>
                   </div>
               </form>
     
              
             </div>
             <div class="navbar-nav">
                 <a href="#" class="nav-item nav-link"> <i class='fas fa-arrow-alt-circle-up up' style='font-size:36px'></i></a>
             </div>
         </div>
     </nav>
     </div>
    <div class="weatherslider">
        <marquee direction="left" bgcolor="white" style="align-item:center">
            <p><b>Casablanca:</b><span><img src="http://openweathermap.org/img/w/<?php echo $data->list[0]->weather[0]->icon; ?>.png"> </span>&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $data->list[0]->weather[0]->description.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Temperature:&nbsp;&nbsp;'.
  $data->list[0]->main->temp.'°C &nbsp;&nbsp;&nbsp;&nbsp;humidity :&nbsp;&nbsp;'.
 $data->list[0]->main->humidity."% &nbsp;&nbsp;&nbsp;&nbsp;wind speed :&nbsp;&nbsp; ".$data->list[0]->wind->speed."m/s&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;";?></span>
                <b>Agadir :</b><span><img src="http://openweathermap.org/img/w/<?php echo $data->list[1]->weather[0]->icon; ?>.png"> </span>&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $data->list[1]->weather[0]->description.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Temperature:&nbsp;&nbsp;'.
 $data->list[1]->main->temp.'°C &nbsp;&nbsp;&nbsp;&nbsp;humidity :&nbsp;&nbsp;'.
 $data->list[1]->main->humidity."% &nbsp;&nbsp;&nbsp;&nbsp;wind speed :&nbsp;&nbsp; ".$data->list[1]->wind->speed."m/s&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;";?></span>
                <b>El jadida :</b><span><img src="http://openweathermap.org/img/w/<?php echo $data->list[2]->weather[0]->icon; ?>.png"> </span>&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $data->list[2]->weather[0]->description.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Temperature:&nbsp;&nbsp;'.
 $data->list[2]->main->temp.'°C &nbsp;&nbsp;&nbsp;&nbsp;humidity :&nbsp;&nbsp;'.
 $data->list[2]->main->humidity."% &nbsp;&nbsp;&nbsp;&nbsp;wind speed :&nbsp;&nbsp; ".$data->list[2]->wind->speed."m/s&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;";?></span>
                <b>Lâayoune :</b><span><img src="http://openweathermap.org/img/w/<?php echo $data->list[3]->weather[0]->icon; ?>.png"> </span>&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $data->list[3]->weather[0]->description.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Temperature:&nbsp;&nbsp;'.
 $data->list[3]->main->temp.'°C &nbsp;&nbsp;&nbsp;&nbsp;humidity :&nbsp;&nbsp;'.
 $data->list[3]->main->humidity."% &nbsp;&nbsp;&nbsp;&nbsp;wind speed :&nbsp;&nbsp; ".$data->list[3]->wind->speed."m/s&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;";?></span>
                <b>Rabat :</b><span><img src="http://openweathermap.org/img/w/<?php echo $data->list[4]->weather[0]->icon; ?>.png"> </span>&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $data->list[4]->weather[0]->description.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Temperature:&nbsp;&nbsp;'.
 $data->list[4]->main->temp.'°C &nbsp;&nbsp;&nbsp;&nbsp;humidity :&nbsp;&nbsp;'.
 $data->list[4]->main->humidity."% &nbsp;&nbsp;&nbsp;&nbsp;wind speed :&nbsp;&nbsp; ".$data->list[4]->wind->speed."m/s&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;";?></span>
            </p>
        </marquee>
    </div>
    <div class="row container-fluid" style="margin-top:20px; " id="main">
        <div class="col-sm-4 col-md-6">
            <h1> <img class="weather-icon" src="http://openweathermap.org/img/w/<?php echo $data1->weather[0]->icon; ?>.png"> &nbsp;&nbsp;&nbsp; <?php echo (isset($_GET["city"]))?$cityname:$data2->city;?></h1>
            <table class="table table-striped table-light table-hover table-bordered">
                <tr>
                    <th>Main</th>
                    <td><?php  echo $main; ?></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><?php  echo $description; ?></td>
                </tr>
                <tr>
                    <th>Temperature</th>
                    <td><?php echo $temp." °C"; ?></td>
                </tr>
                <tr>
                    <th>Max Temperature</th>
                    <td><?php echo $temp_max." °C";?></td>
                </tr>
                <tr>
                    <th>Min Temperature</th>
                    <td><?php  echo $temp_min." °C"; ?></td>
                </tr>
                <tr>
                    <th>Wind Speed</th>
                    <td><?php echo $wind_speed." m/s"; ?></td>
                </tr>
                <tr>
                    <th>Humidity</th>
                    <td><?php  echo $humidity." %"; ?></td>
                </tr>
                <tr>
                    <th>Latitude</th>
                    <td><?php echo $lat; ?></td>
                </tr>
                <tr>
                    <th>Longitude</th>
                    <td><?php echo $lon; ?></td>
                </tr>

            </table>
        </div>
        <div class="col-sm-8 col-md-6" id="map" style="height:600px;margin-top:60px; ">
        </div>

        <script>
            // Initialize and add the map
            function initMap() {
                // The location of Uluru
                var uluru = {
                    lat: <?php echo $lat ; ?>,
                    lng: <?php echo $lon; ?>
                };
                // The map, centered at Uluru
                var map = new google.maps.Map(
                    document.getElementById('map'), {
                        zoom: 9,
                        center: uluru
                    });
                // The marker, positioned at Uluru
                var marker = new google.maps.Marker({
                    position: uluru,
                    map: map
                });

                google.maps.event.addListener(map, 'click', function(event) {
                    placeMarker(event.latLng);
                });
            }

        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcIWMsAYtYdBw1k-hwcN71OpI041xmuIY&callback=initMap">
        </script>


</body>

</html>
