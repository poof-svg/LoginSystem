<?php
include "db.php";

session_start();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username)){
        $errors[] = "Username is required"; 
    }

    $result = pg_query_params($conn,'SELECT *FROM users WHERE username = $1', [$username]);
    $user = pg_fetch_assoc($result);

    if($user){
        if(password_verify($password, $user['password'])){
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        }
         } 

         if (empty($user)){

         }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>
<body>
  <h3>Login System</h3>
    <form method="POST">
        <label for="Username">Enter your username
            <input type="text" name="username" required>
        </label>
        <br><br>
        <label for="Password">Enter your password
            <input type="password" name="password">
        </label>
         <br><br>
        <button type="submit">Login</button>
    </form>
    <p style="color:red">
        <?php 

            foreach($errors as $error){
                echo $error . "<br>";
            }
  
        ?>
    </p>

  
</body>
</html>