<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <div class="jumbotron">
    <h1> <img  src="error.png" width="100px" height="100px" /> OOPS SOMETHING WENT WRONG </h1>      
    <p>PLEASE VERIFY THAT THE YOU SPELLED THE CITY CORRECLTY.</p>
  </div>
    <div class="input-group mb-3">
        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Search for a city " name="city">
    <div class="input-group-append">
    <button class="btn btn-success" type="submit" name="search">Search</button>
     </div>
        </form>
  </div>
</div>

</body>
</html>
<?php
if(isset($_GET['search']) && !empty($_GET['city'])){
    header('location:weatherdemo.php?city='.htmlspecialchars($_GET['city']));
           
    
}


?>