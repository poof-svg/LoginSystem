<?php


include("db.php");

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($username)) {
        $errors[] = "Username is required";
    } else if (strlen($username) < 8) {
        $errors[] = "Username must be 8 characters or more";
    }

    $usernamePattern = '/^(?=.*[\S])(?=.*[\s]).+$/';

    if (preg_match($usernamePattern, $username)) {
        $errors[] = "Username must not have white space";
    }

    // " ynzon salas "

    $result = pg_query_params($conn, 'SELECT username FROM users WHERE username = $1', [$username]);

    if (pg_fetch_assoc($result)) {
        $errors[] = "Username already exist";
    }

    if ($password != $confirmPassword) {
        $errors[] = "Password did not match";
    }

    if (empty($password) || empty($confirmPassword)) {
        $errors[] = "Please provide a passsword";
    }

    $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\W_]).+$/';

    if (!preg_match($pattern, $password)) {
        $errors[] = "password must contain lower, upper case and special characters";
    }

    if (strlen($password) < 8) {
        $errors[] = "password must be 8 or more characters long";
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    if (empty($errors)) {
        pg_query_params(
            $conn,
            'INSERT INTO users (username, password) VALUES ($1, $2)',
            [$username, $passwordHash]
        );

        echo "Registered Successfully";

        if($result){
            header("Location: index.php");
            exit();
        }
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h3>Register</h3>
    <form method="POST">
        <label for="Username">Enter your username
            <input type="text" name="username" required>
        </label>
        <br><br>
        <label for="Password">Enter your password
            <input type="password" name="password">
        </label>
         <br><br>
        <label for="Confirm Password">Confirm your password
            <input type="password" name="confirm_password">
        </label>
        <br><br>
        <button type="submit">Register</button>
    </form>
    <p style="color:red">
        <?php 

            foreach($errors as $error){
                echo $error . "<br>";
            }
  
        ?>
    </p>

<p> May account kna? t mayo 
    <a href="login.php">Login here.</a>
</p>
</body>
</html>