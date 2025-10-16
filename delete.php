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
$user_id = $_SESSION['user_id'];

// Delete post only if it belongs to the logged-in user
$sql = "DELETE FROM posts WHERE id = ? AND user_id = ?";

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("location: index.php");
    } else {
        echo "Error deleting record.";
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>