<?php
session_start();
include "conn.php";
if(isset($_POST['submit'])){
$sql="select * from covid_users";

$myresults=mysqli_query($conn,$sql);


    while (($row = mysqli_fetch_assoc($myresults))){

        $id=$row['id'];
        $name=$row['name'];
        $username=$row['username'];
        $password=$row['password'];
        $email=$row['email'];
        $activation_link=$row['activation_link'];
    }

$f_email=$_POST['email'];
$f_password=$_POST['password'];

if(($f_email==$email)&&($f_password==$password)){
    $_SESSION['role']="Admin";
    header("Location:covid.php");
}
else{
    echo "Invalid Credentials";
}

}

?>
<!DOCTYPE html>
<html>
<head>
    <title>AekpaniNetworks </title>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <link rel="stylesheet" href="css/mystyles.css">
    
</head>
<body>


<div class="container login-container ok">
            
                <div class="login-form-1">
                    <h3>AekpaniNetworks login</h3>
                    <form action="" method="POST">
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Your Email *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Your Password *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btnSubmit" value="Login" />
                        </div>
                        <div class="form-group">
                            <a href="#" class="ForgetPwd">Forget Password?</a>
                        </div>
                    </form>
                </div>
                
          
        </div>



</body>
</html>