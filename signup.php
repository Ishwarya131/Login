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
    <title>SignUp</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>



<?php

$email = $passwd = $error = $msg = "";
$errorflag = false;



if( isset($_POST["submit"])){
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["email"])){
        
        $errorflag = false;
    }
else if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
       
        echo '<script>alert("Invalid E-mail")</script>';
        $errorflag = false;
    }else{
        $email = validation_input($_POST["email"]);
        $errorflag = true;
    }

    if(empty($_POST["passwd"])){
        
        $errorflag = false;
    }else{
        $len = strlen($_POST["passwd"]);
        if($len < 6){
            
            echo '<script>alert("Password must be 6 characters long.")</script>';
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

        $email = $_POST['email'];
        $passwd = $_POST['passwd'];
        $name = $_POST['name'];

        if ($row > 0){
            $_SESSION["user_id"] = $row["id"];
            $error = "Account already exists!";
            echo $error;
            
        }else {
            $saveaccount="insert into log (name,uname,passwd) VALUE ('$name','$email','$passwd')";
            mysqli_query($con,$saveaccount);

            echo '<script>alert("Successfully registered,you may now login!")</script>';

           
            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
            header('Location: '. $home_url);
        }
        

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

<form class="box" action="signup.php" method="post">
  <h1>Sign Up</h1>
  <input type="text" name="name" placeholder="name" required>
  <input type="text" name="email" placeholder="E-mail" required>
  <input type="password" name="passwd" placeholder="Password" required>

  <span style="color: red"><?php echo $error; ?></span>

  <span style="color: red"><?php echo $msg; ?></span>


  <input type="submit" name="submit" value="Sign Up">
  <h4>Already have an account?<a href = "login.php"> Login </a></h4>


</form>
</body>
</html>



















