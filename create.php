<?php
require 'db.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    if (!empty($title) && !empty($content)) {
        $sql = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "iss", $user_id, $title, $content);
            
            if (mysqli_stmt_execute($stmt)) {
                header("location: index.php");
            } else {
                echo "Error: Could not execute the query.";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <div id="branding"><h1><a href="index.php">HK Blogs</a></h1></div>
            <nav><ul><li><a href="index.php">Home</a></li><li><a href="logout.php">Logout</a></li></ul></nav>
        </div>
    </header>
    <div class="container">
        <form action="create.php" method="post">
            <h2>Create a New Post</h2>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" required></textarea>
            </div>
            <button type="submit" class="btn">Create Post</button>
        </form>
    </div>
</body>
</html>