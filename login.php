 <?php

    session_start();
    $con = mysqli_connect("localhost","root","","php_login");
    if(!$con)
        die("Connection Failed : " . mysqli_connect_errno());

?> 
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>َLogin Form</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

  <?php

$email = $passwd = $error = "";
$errorflag = false;

$erroremail = "<h3 class = 'erroremail'>E-mail Required.</h3>";
$errorpasswd = "<h3 class = 'errorpasswd'>Password Required.</h3>";

if( isset($_POST["submit"])){
    if(empty($_POST["email"])){
        echo $erroremail;
        $errorflag = false;
    }elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
        $erroremail = "<h3 class = 'erroremail'>Invalid E-mail.</h3>";
        echo $erroremail;
        $errorflag = false;
    }else{
        $email = validation_input($_POST["email"]);
        $errorflag = true;
    }

    if(empty($_POST["passwd"])){
        echo $errorpasswd;
        $errorflag = false;
    }else{
        $len = strlen($_POST["passwd"]);
        if($len < 6){
            $errorpasswd = "<h3 class = 'errorpasswd'>Password must be 6 characters long.</h3>";
            echo $errorpasswd;
           
            $errorflag = false;
        }else{
            $passwd = validation_input($_POST["passwd"]);
            $errorflag = true;
        }
       
    }

    if($errorflag == true){

        $query = "SELECT * FROM log WHERE uname = '$_POST[email]' AND passwd = '$_POST[passwd]'";
        $result = mysqli_query($con,$query);
        $row = mysqli_fetch_array($result);
        if ($row > 0){
            $_SESSION["user_id"] = $row["id"];
            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/Home.php';
            header('Location: '. $home_url);
        }else {
            $error = "Username or Password is not correct!";
            echo $error;
        }
        

    }

}

function validation_input($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


  ?>

    <div id="bg">
      <img src="img/bg.jpg" alt="">
    </div>

<form class="box" action="login.php" method="post">
  <h1>Login</h1>
  <input type="text" name="email" placeholder="E-mail" required>
  
  <input type="password" name="passwd" placeholder="Password" required>

  <span style="color: red"><?php echo $error; ?></span>
  

  <input type="submit" name="submit" value="Login">
  <h4>Don't have an account?<a href = "signup.php"> Sign Up </a></h4>

</form>


  </body>
</html>
