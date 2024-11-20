<?php
session_start();
if (isset($_SESSION["user"])) {                                                             /* LOG-OUT SESSION */     
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="2login.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .heading{
  color: #d1650c;
  margin-right: 50px;
  font-size: x-large;
  padding-left: 470px;
}
.heading span{
  color: #fff;
}
nav a{
  color : #ffff;
  
text-decoration: none;
font-size: x-large;
}
nav{
    text-align: left;
}
</style>
        

</head>
<body>
<header>
    <nav class="navbar">
     

<div class="heading">
<b><h1>Shoe <span>Portal</span></h1></b>
<!-- <a href="cart.php">Cart</a>
<a href="like.php">Like</a> -->
</div>
</nav>

  </header>

  
  <nav>
      <a href="admin/adminlogin.php">Admin Login</a>

</nav>

    <div class="login-container">
        
        <?php
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once "0database.php";
            $sql = "SELECT * FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);                                                        /* PHP CODE FOR LOGIN */
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])){
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    die();
                }else {
                    echo "<div class='alert alert-danger'>Password does not match<div>";
                }
            }else{
                echo "<div class='alert alert-danger'>Email does not match<div>";
            }
        }
        ?>


        <h2> User Login</h2>
        <form action="1login.php" method="post">

            <div class="form-group">
                <label for="username">Email:</label>
                <input type="email" name="email" placeholder="Enter Email" class="form-control">
            </div> 

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" placeholder="Enter Password" class="form-control">
            </div>

            <div class="form-btn">
                <input type="submit" value="login" name="login" class="form-btn">
            </div>

        </form>

        <div>
            <p>
                Don't have an Account
                <a href="3registration.php">Sign-Up here</a>
            </p>
        </div>
    </div>
    
</body>
</html>
