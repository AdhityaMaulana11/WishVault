<?php
require_once '../auth/session.php';
require_once '../config/db.php';

$quotes = mysqli_query($conn, "SELECT * FROM quotes");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manajemen Kutipan - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-purple-300 to-indigo-300 min-h-screen p-6">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-4xl font-bold text-center mb-6 text-purple-700">💬 Manajemen Kutipan</h1>

        <div class="flex justify-between items-center mb-6">
            <a href="add.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow transition-all">+ Tambah Kutipan</a>
            <a href="../dashboard.php" class="text-blue-500 hover:underline">🏠 Kembali ke Dashboard</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($quote = mysqli_fetch_assoc($quotes)) : ?>
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition-all flex flex-col justify-between">
                    <p class="italic text-gray-700 mb-4">"<?= $quote['quote']; ?>"</p>
                    <a href="delete.php?id=<?= $quote['id']; ?>" class="text-red-500 hover:underline self-end" onclick="return confirm('Yakin hapus?')">🗑️ Hapus</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>

