<?php
require_once '../auth/session.php';
require_once '../config/db.php';

$id = $_GET['id'];
$gallery = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT g.*, w.title, w.id as wish_id FROM gallery g 
    JOIN wishes w ON g.wish_id = w.id 
    WHERE g.id = $id AND w.user_id = {$_SESSION['user_id']}
"));

// Ambil semua wish tercapai milik user
$wishes = mysqli_query($conn, "SELECT * FROM wishes WHERE user_id = {$_SESSION['user_id']} AND status = 'Tercapai'");

if (isset($_POST['update'])) {
    $wish_id = $_POST['wish_id'];
    $image_path = $gallery['image_path'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $new_path = time() . '-' . $image;

        move_uploaded_file($tmp, "../assets/uploads/$new_path");

        if (file_exists("../assets/uploads/$image_path")) {
            unlink("../assets/uploads/$image_path");
        }

        $image_path = $new_path;
    }

    mysqli_query($conn, "UPDATE gallery SET wish_id = $wish_id, image_path = '$image_path' WHERE id = $id");
    header('Location: view.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Pencapaian - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-indigo-300 to-purple-400 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-lg">
        <h1 class="text-3xl font-bold text-center mb-6 text-indigo-600">Edit Pencapaian</h1>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="font-semibold block mb-2">Pilih Wish</label>
                <select name="wish_id" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="<?= $gallery['wish_id']; ?>" selected><?= $gallery['title']; ?> (Dipilih)</option>
                    <?php while ($wish = mysqli_fetch_assoc($wishes)) : ?>
                        <?php if ($wish['id'] != $gallery['wish_id']) : ?>
                            <option value="<?= $wish['id']; ?>"><?= $wish['title']; ?></option>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="font-semibold block mb-2">Gambar Saat Ini:</label>
                <img src="../assets/uploads/<?= $gallery['image_path']; ?>" alt="Current Image" class="w-full h-48 object-cover rounded">
            </div>

            <div>
                <label class="font-semibold block mb-2">Ganti Gambar (Opsional)</label>
                <input type="file" name="image" accept="image/*" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            <button type="submit" name="update" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white p-3 rounded transition-all">
                Update
            </button>
            <a href="view.php" class="block text-center mt-4 text-indigo-500 hover:underline">⬅️ Kembali</a>
        </form>
    </div>
</body>

</html>
