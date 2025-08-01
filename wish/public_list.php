<?php
require_once '../config/db.php';
session_start();

$wishes = mysqli_query($conn, "SELECT w.*, u.username FROM wishes w JOIN users u ON w.user_id = u.id WHERE w.is_public = 1 ORDER BY target_date ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Wish Public - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-center mb-6 text-indigo-600">🌐 Wish Public</h1>
        <div class="text-center mb-6">
            <a href="../dashboard.php" class="text-blue-500 hover:underline">🏠 Kembali ke Dashboard</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($wish = mysqli_fetch_assoc($wishes)) : ?>
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all flex flex-col justify-between" style="min-height: 350px;">
                    <div>
                        <h2 class="text-xl font-bold mb-2"><?= htmlspecialchars($wish['title']); ?></h2>
                        <p class="mb-2 text-gray-700 line-clamp-3 overflow-hidden" id="desc-<?= $wish['id']; ?>">
                            <?= htmlspecialchars($wish['description']); ?>
                        </p>
                        <button onclick="toggleDesc(<?= $wish['id']; ?>)" class="text-blue-500 hover:underline text-sm mb-2" id="btn-<?= $wish['id']; ?>">Lihat Selengkapnya</button>
                        <p class="text-sm text-gray-500 mb-2">Diposting oleh: <span class="font-semibold"><?= htmlspecialchars($wish['username']); ?></span></p>
                        <p class="text-sm text-gray-500 mb-4">Target: <?= htmlspecialchars($wish['target_date']); ?> | Progres: <?= $wish['progress']; ?>%</p>
                    </div>
                    <div class="mt-auto">
                        <a href="public.php?id=<?= $wish['id']; ?>" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded block text-center">🔗 Lihat & Komentar</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function toggleDesc(id) {
            const desc = document.getElementById('desc-' + id);
            const btn = document.getElementById('btn-' + id);

            if (desc.classList.contains('line-clamp-3')) {
                desc.classList.remove('line-clamp-3');
                btn.innerText = 'Sembunyikan';
            } else {
                desc.classList.add('line-clamp-3');
                btn.innerText = 'Lihat Selengkapnya';
            }
        }
    </script>
</body>

</html>
