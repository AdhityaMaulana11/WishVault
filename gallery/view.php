<?php
require_once '../auth/session.php';
require_once '../config/db.php';

$gallery = mysqli_query($conn, "
    SELECT g.*, w.title FROM gallery g 
    JOIN wishes w ON g.wish_id = w.id 
    WHERE w.user_id = {$_SESSION['user_id']}
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Galeri Pencapaian - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-purple-300 to-pink-300 min-h-screen p-6 flex flex-col items-center">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-6xl">
        <h1 class="text-4xl font-bold text-center mb-8 text-purple-600">Galeri Pencapaian</h1>
        <div class="flex justify-between mb-8">
            <a href="upload.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition-all">+ Upload Pencapaian</a>
            <a href="../dashboard.php" class="text-blue-600 hover:underline">⬅️ Kembali ke Dashboard</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($item = mysqli_fetch_assoc($gallery)) : ?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                    <img src="../assets/uploads/<?= $item['image_path']; ?>" alt="Wish Image" class="w-full h-64 object-cover hover:brightness-90 transition-all">
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-purple-700 mb-2"><?= $item['title']; ?></h2>
                        <p class="text-sm text-gray-500 mb-4">Diunggah pada <?= $item['uploaded_at']; ?></p>
                        <div class="flex justify-center gap-4">
                            <a href="edit.php?id=<?= $item['id']; ?>" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-1 rounded transition-all">Edit</a>
                            <a href="delete.php?id=<?= $item['id']; ?>" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded transition-all" onclick="return confirm('Yakin ingin menghapus foto ini?')">Hapus</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>
