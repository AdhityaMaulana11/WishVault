<?php
require_once '../auth/session.php';
require_once '../config/db.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM quotes WHERE id=$id");
header('Location: list.php');
?>
