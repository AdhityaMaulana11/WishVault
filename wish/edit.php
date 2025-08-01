<?php
require_once '../auth/session.php';
require_once '../config/db.php';

$id = $_GET['id'];
$wish = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM wishes WHERE id=$id AND user_id={$_SESSION['user_id']}"));
$categories = mysqli_query($conn, "SELECT * FROM categories WHERE user_id = {$_SESSION['user_id']}");

if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category_id = $_POST['category'];
    $target_date = $_POST['target_date'];
    $status = $_POST['status'];
    $is_public = $_POST['is_public'];

    mysqli_query($conn, "UPDATE wishes SET title='$title', description='$description', category_id=$category_id, target_date='$target_date', status='$status', is_public=$is_public WHERE id=$id");
    header('Location: list.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Wish - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-green-400 to-blue-500 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-lg">
        <h1 class="text-3xl font-bold text-center mb-6 text-green-600">Edit Wish</h1>
        <form method="POST" class="space-y-4">
            <input type="text" name="title" value="<?= $wish['title']; ?>" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
            <textarea name="description" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-400"><?= $wish['description']; ?></textarea>
            <select name="category" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
                <?php while ($cat = mysqli_fetch_assoc($categories)) : ?>
                    <option value="<?= $cat['id']; ?>" <?= ($cat['id'] == $wish['category_id']) ? 'selected' : ''; ?>><?= $cat['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <input type="date" name="target_date" value="<?= $wish['target_date']; ?>" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
            <select name="status" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
                <option value="Belum Mulai" <?= ($wish['status'] == 'Belum Mulai') ? 'selected' : ''; ?>>Belum Mulai</option>
                <option value="Dalam Proses" <?= ($wish['status'] == 'Dalam Proses') ? 'selected' : ''; ?>>Dalam Proses</option>
                <option value="Tercapai" <?= ($wish['status'] == 'Tercapai') ? 'selected' : ''; ?>>Tercapai</option>
            </select>
            <label class="block mb-1 font-semibold">Public Mode:</label>
            <select name="is_public" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
                <option value="0" <?= ($wish['is_public'] == 0) ? 'selected' : ''; ?>>Private</option>
                <option value="1" <?= ($wish['is_public'] == 1) ? 'selected' : ''; ?>>Public</option>
            </select>
            <button type="submit" name="update" class="w-full bg-green-500 hover:bg-green-600 text-white p-3 rounded transition-all">Update Wish</button>
            <a href="list.php" class="block text-center mt-4 text-green-500 hover:underline">⬅️ Kembali</a>
        </form>
    </div>
</body>

</html>
