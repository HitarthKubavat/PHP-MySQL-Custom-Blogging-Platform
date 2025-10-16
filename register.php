<?php
require 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
            
            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
            } else {
                $error = "Username already taken.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="register.php" method="post">
            <h2>Register</h2>
            <?php if($error): ?>
                <p style="color:red;"><?= $error ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Register</button>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>