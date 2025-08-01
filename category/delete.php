<?php
require_once '../auth/session.php';
require_once '../config/db.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM categories WHERE id=$id AND user_id={$_SESSION['user_id']}");
header('Location: list.php');
?>
