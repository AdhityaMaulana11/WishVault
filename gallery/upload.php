<?php
require_once '../auth/session.php';
require_once '../config/db.php';

// Ambil wish dengan status tercapai milik user login
$wishes = mysqli_query($conn, "SELECT * FROM wishes WHERE user_id = {$_SESSION['user_id']} AND status = 'Tercapai'");

if (isset($_POST['upload'])) {
    $wish_id = $_POST['wish_id'];
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $path = time() . '-' . $image;
    move_uploaded_file($tmp, "../assets/uploads/$path");

    mysqli_query($conn, "INSERT INTO gallery (wish_id, image_path) VALUES ($wish_id, '$path')");
    header('Location: view.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Upload Pencapaian - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-200 to-indigo-300 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-lg">
        <h1 class="text-3xl font-bold text-center mb-6 text-indigo-600">Upload Pencapaian</h1>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="font-semibold block mb-2">Pilih Wish yang Tercapai</label>
                <select name="wish_id" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="">-- Pilih Wish --</option>
                    <?php if (mysqli_num_rows($wishes) > 0) : ?>
                        <?php while ($wish = mysqli_fetch_assoc($wishes)) : ?>
                            <option value="<?= $wish['id']; ?>"><?= $wish['title']; ?></option>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <option value="" disabled>Tidak ada wish yang tercapai</option>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label class="font-semibold block mb-2">Upload Gambar</label>
                <input type="file" name="image" accept="image/*" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            <button type="submit" name="upload" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white p-3 rounded transition-all">
                Upload
            </button>
            <a href="view.php" class="block text-center mt-4 text-indigo-500 hover:underline">⬅️ Kembali</a>
        </form>
    </div>
</body>

</html>
