<?php
require_once '../auth/session.php';
require_once '../config/db.php';

$categories = mysqli_query($conn, "SELECT * FROM categories WHERE user_id = {$_SESSION['user_id']}");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manajemen Kategori - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-yellow-300 to-pink-400 min-h-screen p-6 flex flex-col items-center">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-4xl">
        <h1 class="text-3xl font-bold text-center mb-6 text-yellow-600">Kategori Impian</h1>
        <div class="flex justify-between mb-6">
            <a href="add.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition-all">+ Tambah Kategori</a>
            <a href="../dashboard.php" class="text-blue-600 hover:underline">⬅️ Kembali ke Dashboard</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto bg-white rounded-lg shadow border">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="p-4 text-left">Nama Kategori</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cat = mysqli_fetch_assoc($categories)) : ?>
                        <tr class="border-b hover:bg-gray-50 transition-all">
                            <td class="p-4"><?= $cat['name']; ?></td>
                            <td class="p-4 flex justify-center gap-4">
                                <a href="edit.php?id=<?= $cat['id']; ?>" class="text-yellow-500 hover:text-yellow-600 font-semibold">Edit</a>
                                <a href="delete.php?id=<?= $cat['id']; ?>" class="text-red-500 hover:text-red-600 font-semibold" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
