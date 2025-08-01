<?php
require_once '../auth/session.php';
require_once '../config/db.php';

// Ambil kategori
$categories = mysqli_query($conn, "SELECT * FROM categories WHERE user_id = {$_SESSION['user_id']}");

// Filter
$filter = "";
if (isset($_GET['category']) && $_GET['category'] != '') {
    $filter = " AND category_id = " . intval($_GET['category']);
}
if (isset($_GET['duration']) && $_GET['duration'] == 'short') {
    $filter .= " AND DATEDIFF(target_date, CURDATE()) <= 365";
} elseif (isset($_GET['duration']) && $_GET['duration'] == 'long') {
    $filter .= " AND DATEDIFF(target_date, CURDATE()) > 365";
}

// Ambil wish
$wishes = mysqli_query($conn, "SELECT w.*, c.name as category FROM wishes w 
    LEFT JOIN categories c ON w.category_id = c.id 
    WHERE w.user_id = {$_SESSION['user_id']} $filter ORDER BY target_date ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Daftar Wish - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-center mb-6 text-blue-600">🎯 Daftar Wish Kamu</h1>
        <div class="flex justify-between items-center mb-4">
            <a href="add.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow transition-all">+ Tambah Wish</a>
            <a href="../dashboard.php" class="text-blue-500 hover:underline">🏠 Kembali ke Dashboard</a>
        </div>

        <!-- Filter -->
        <form method="GET" class="mb-6 flex flex-wrap gap-4">
            <select name="category" class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Semua Kategori</option>
                <?php while ($cat = mysqli_fetch_assoc($categories)) : ?>
                    <option value="<?= $cat['id']; ?>" <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : ''; ?>><?= $cat['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <select name="duration" class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Semua Jangka</option>
                <option value="short" <?= (isset($_GET['duration']) && $_GET['duration'] == 'short') ? 'selected' : ''; ?>>Jangka Pendek</option>
                <option value="long" <?= (isset($_GET['duration']) && $_GET['duration'] == 'long') ? 'selected' : ''; ?>>Jangka Panjang</option>
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow transition-all">Filter</button>
        </form>

        <!-- Tabel Wish -->
        <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
            <table class="w-full table-auto">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="p-3 text-left">Judul</th>
                        <th class="p-3 text-left">Kategori</th>
                        <th class="p-3 text-left">Target Waktu</th>
                        <th class="p-3 text-left">Progres</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($wish = mysqli_fetch_assoc($wishes)) :
                        $days_left = (strtotime($wish['target_date']) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);
                        $highlight = ($days_left <= 7 && $wish['status'] !== 'Tercapai') ? 'bg-red-50' : '';
                        $statusColor = match ($wish['status']) {
                            'Belum Mulai' => 'bg-gray-300 text-gray-700',
                            'Dalam Proses' => 'bg-yellow-300 text-yellow-800',
                            'Tercapai' => 'bg-green-300 text-green-800',
                            default => 'bg-gray-200 text-gray-700'
                        };
                    ?>
                        <tr class="border-b hover:bg-gray-50 <?= $highlight; ?>">
                            <td class="p-3"><?= $wish['title']; ?></td>
                            <td class="p-3"><?= $wish['category']; ?></td>
                            <td class="p-3">
                                <?= $wish['target_date']; ?>
                                <?php if ($days_left <= 7 && $wish['status'] !== 'Tercapai') : ?>
                                    <span class="text-red-500 text-sm font-semibold"> (<?= ceil($days_left); ?> hari lagi)</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-3"><?= $wish['progress']; ?>%</td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded-full text-sm <?= $statusColor; ?>"><?= $wish['status']; ?></span>
                            </td>
                            <td class="p-3 flex flex-wrap justify-center gap-2 text-sm">
                                <a href="edit.php?id=<?= $wish['id']; ?>" class="text-yellow-500 hover:underline">✏️ Edit</a>
                                <a href="delete.php?id=<?= $wish['id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Yakin hapus?')">🗑️ Hapus</a>
                                <a href="progress.php?id=<?= $wish['id']; ?>" class="text-green-500 hover:underline">📈 Update Progress</a>
                                <?php if ($wish['is_public']) : ?>
                                    <a href="public.php?id=<?= $wish['id']; ?>" class="text-blue-500 hover:underline" target="_blank">🔗 Lihat Publik</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
