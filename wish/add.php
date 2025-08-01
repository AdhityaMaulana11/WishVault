<?php
require_once '../auth/session.php';
require_once '../config/db.php';

$categories = mysqli_query($conn, "SELECT * FROM categories WHERE user_id = {$_SESSION['user_id']}");

if (isset($_POST['save'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category_id = $_POST['category'];
    $target_date = $_POST['target_date'];

    mysqli_query($conn, "INSERT INTO wishes (user_id, category_id, title, description, target_date) 
        VALUES ({$_SESSION['user_id']}, $category_id, '$title', '$description', '$target_date')");

    header('Location: list.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tambah Wish - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-400 to-purple-500 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-lg">
        <h1 class="text-3xl font-bold text-center mb-6 text-blue-600">Tambah Wish</h1>
        <form method="POST" class="space-y-4">
            <input type="text" name="title" placeholder="Judul Wish" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <textarea name="description" placeholder="Deskripsi Wish" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
            <select name="category" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Pilih Kategori</option>
                <?php while ($cat = mysqli_fetch_assoc($categories)) : ?>
                    <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <input type="date" name="target_date" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button type="submit" name="save" class="w-full bg-blue-500 hover:bg-blue-600 text-white p-3 rounded transition-all">Simpan Wish</button>
            <a href="list.php" class="block text-center mt-4 text-blue-500 hover:underline">⬅️ Kembali</a>
        </form>
    </div>
</body>

</html>
