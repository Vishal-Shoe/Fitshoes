<?php
session_start();
if (isset($_SESSION["user"])) {                                                      /* LOG-OUT SESSION */
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up Form</title>
  <link rel="stylesheet" href="2login.css">
</head>
<body>

  <div class="login-container">

    <?php
        if (isset($_POST["submit"])) {
            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();

            if (empty($fullName) OR empty($email) OR empty($password)OR empty($passwordRepeat)) {
                array_push($errors,"All fields are required");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }
            if (strlen($password)<8) {
                array_push($errors,"Password must need 8 charechter");
            }
            if ($password!==$passwordRepeat) {                                                /* PHP CODE FOR REGISTRATION */
                array_push($errors,"Password not match");
            }
            require_once "0database.php";
            $sql = "SELECT * FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
              array_push($errors, "Email already exist");
            }
            if (count($errors)>0) {
                foreach ($errors as $error) {
                   echo "<div class='alert alert-danger'>$error</div>"; 
                }

            }else {
                $sql = "INSERT INTO user (full_name, email, password) VALUES ( ?, ?, ? )";
                $stmt = mysqli_stmt_init($conn);
                $preparestmt = mysqli_stmt_prepare($stmt,$sql);
                if ($preparestmt) {
                  mysqli_stmt_bind_param($stmt, "sss" ,$fullName, $email, $passwordHash);
                  mysqli_stmt_execute($stmt);
                  echo "Register Successfully";
                }
                else{
                  die("Someting went wrong");
                }
            }
        }
        ?>

    <h2>Sign Up</h2>
    <form action="3registration.php" method="post">

      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text"  name="fullname" placeholder="Full Name" >
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email"  name="email" placeholder="Email" >
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password"  name="password" placeholder="Password">
      </div>

      <div class="form-group">
        <label for="password">Confirm Password:</label>
        <input type="password"  name="repeat_password" placeholder="Confirm Password">
      </div>

      <div class="form-btn">
        <input type="submit" class="form-btn" value="Register" name="submit">
      </div>
      
    </form>

    <div>
      <p>
        Already have an Account
        <a href="1login.php">Log-In here</a>
      </p>
    </div>

  </div>
</body>
</html>
