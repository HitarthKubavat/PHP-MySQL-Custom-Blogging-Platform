<?php
require 'db.php';

// Check if ID is set
if (!isset($_GET['id'])) {
    header("location: index.php");
    exit;
}

$id = $_GET['id'];
$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?";
$post = null;

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $post = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if (!$post) {
    echo "Post not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
             <div id="branding"><h1><a href="index.php">HK Blogs</a></h1></div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="create.php">Create Post</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <article class="post">
            <h1><?= htmlspecialchars($post['title']) ?></h1>
            <p class="post-meta">
                By <?= htmlspecialchars($post['username']) ?> on <?= date('F j, Y', strtotime($post['created_at'])) ?>
            </p>
            <div class="post-content">
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </div>

            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
                <div class="post-actions">
                    <a href="edit.php?id=<?= $post['id'] ?>" class="btn btn-edit">Edit</a>
                    <a href="delete.php?id=<?= $post['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                </div>
            <?php endif; ?>
        </article>
    </div>
    
    <footer><p>HK Blogs &copy; 2025</p></footer>
</body>
</html>