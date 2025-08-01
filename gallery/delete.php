<?php
require_once '../auth/session.php';
require_once '../config/db.php';

$id = $_GET['id'];

$gallery = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT g.*, w.user_id FROM gallery g 
    JOIN wishes w ON g.wish_id = w.id 
    WHERE g.id = $id AND w.user_id = {$_SESSION['user_id']}
"));

if ($gallery) {
    // Hapus file gambar
    if (file_exists("../assets/uploads/" . $gallery['image_path'])) {
        unlink("../assets/uploads/" . $gallery['image_path']);
    }

    mysqli_query($conn, "DELETE FROM gallery WHERE id = $id");
}

header('Location: view.php');
?>
