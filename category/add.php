<?php
require_once '../auth/session.php';
require_once '../config/db.php';

if (isset($_POST['save'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    mysqli_query($conn, "INSERT INTO categories (name, user_id) VALUES ('$name', {$_SESSION['user_id']})");
    header('Location: list.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tambah Kategori - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-indigo-500 to-purple-500 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-lg">
        <h1 class="text-3xl font-bold text-center mb-6 text-indigo-600">Tambah Kategori</h1>
        <form method="POST" class="space-y-4">
            <input type="text" name="name" placeholder="Nama Kategori" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <button type="submit" name="save" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white p-3 rounded transition-all">Simpan Kategori</button>
            <a href="list.php" class="block text-center mt-4 text-indigo-500 hover:underline">⬅️ Kembali</a>
        </form>
    </div>
</body>

</html>
