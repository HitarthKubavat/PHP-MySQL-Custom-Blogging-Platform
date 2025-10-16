<?php
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("location: index.php");
    exit;
}

$id = $_GET['id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssii", $title, $content, $id, $_SESSION['user_id']);
            if(mysqli_stmt_execute($stmt)){
                header("location: post.php?id=" . $id);
            } else {
                echo "Error updating record.";
            }
            mysqli_stmt_close($stmt);
        }
    }
}

// Fetch the post data
$sql = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
$post = null;
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "ii", $id, $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $post = mysqli_fetch_assoc($result);
    if (!$post) {
        // Post doesn't exist or doesn't belong to the user
        header("location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
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
        <form action="edit.php?id=<?= $id ?>" method="post">
            <h2>Edit Post</h2>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" required><?= htmlspecialchars($post['content']) ?></textarea>
            </div>
            <button type="submit" class="btn">Update Post</button>
        </form>
    </div>
</body>
</html>