<?php

session_start();
$con = mysqli_connect("localhost","root","","php_login");
if(!$con)
    die("Connection Failed : " . mysqli_connect_errno());

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<div id="bg">
      <img src="img/bg.jpg" alt="">
    </div>

    <?php
$query = "SELECT * FROM log WHERE id = '$_SESSION[user_id]'";
$result = mysqli_query($con,$query);
$row = mysqli_fetch_array($result);
?>


<form class="box" action="Home.php" method="post">


  <h1><?php echo $row['uname']; ?>!</h1>
  <?php
    if(!empty($_POST['logout'])){
       // session_start();
        session_destroy();
        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
        header('Location: '. $home_url);

    }
    ?>
  <input type="submit" id="#logout" name="logout" value="Logout">

</form>




</body>
</html>