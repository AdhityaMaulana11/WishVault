<?php
require_once '../auth/session.php';
require_once '../config/db.php';

$id = $_GET['id'];
$cat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM categories WHERE id=$id AND user_id={$_SESSION['user_id']}"));

if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    mysqli_query($conn, "UPDATE categories SET name='$name' WHERE id=$id");
    header('Location: list.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Kategori - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-green-400 to-blue-500 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-lg">
        <h1 class="text-3xl font-bold text-center mb-6 text-green-600">Edit Kategori</h1>
        <form method="POST" class="space-y-4">
            <input type="text" name="name" value="<?= $cat['name']; ?>" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
            <button type="submit" name="update" class="w-full bg-green-500 hover:bg-green-600 text-white p-3 rounded transition-all">Update Kategori</button>
            <a href="list.php" class="block text-center mt-4 text-green-500 hover:underline">⬅️ Kembali</a>
        </form>
    </div>
</body>

</html>
