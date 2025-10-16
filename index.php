<?php
require 'db.php';

// Fetch all posts with author username
$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & MySQL Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1><a href="index.php">HK Blogs</a></h1>
            </div>
            <nav>
                <ul>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="create.php">Create Post</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1>Latest Posts</h1>
        <?php while ($post = mysqli_fetch_assoc($result)): ?>
            <article class="post">
                <h2><a href="post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
                <p class="post-meta">
                    Posted by <?= htmlspecialchars($post['username']) ?> on <?= date('F j, Y', strtotime($post['created_at'])) ?>
                </p>
                <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?>...</p>
                <a href="post.php?id=<?= $post['id'] ?>" class="btn">Read More</a>
            </article>
        <?php endwhile; ?>
    </div>

    <footer>
        <p>HK Blogs&copy; 2025</p>
    </footer>
</body>
</html>