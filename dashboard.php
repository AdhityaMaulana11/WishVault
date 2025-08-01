<?php
require_once 'auth/session.php';
require_once 'config/db.php';

$username = $_SESSION['username'];

$wishes = mysqli_query($conn, "SELECT * FROM wishes WHERE user_id = {$_SESSION['user_id']}");

$total = 0;
$completed = 0;
$inProgress = 0;
$notStarted = 0;

while ($wish = mysqli_fetch_assoc($wishes)) {
    $total++;
    if ($wish['status'] === 'Tercapai') {
        $completed++;
    } elseif ($wish['status'] === 'Dalam Proses') {
        $inProgress++;
    } else {
        $notStarted++;
    }
}

$quotesQuery = mysqli_query($conn, "SELECT quote FROM quotes");
$dbQuotes = [];
while ($row = mysqli_fetch_assoc($quotesQuery)) {
    $dbQuotes[] = $row['quote'];
}

$dummyQuotes = [
    "Tidak ada mimpi yang terlalu besar jika kamu mau berusaha.",
    "Setiap langkah kecil membawa kamu lebih dekat ke tujuan.",
    "Jangan takut gagal, takutlah jika kamu berhenti mencoba.",
    "Impian tanpa aksi hanyalah khayalan.",
    "Hari ini adalah waktu terbaik untuk memulai."
];

$allQuotes = array_merge($dummyQuotes, $dbQuotes);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-indigo-600 text-white p-4 flex justify-between items-center shadow-lg">
        <h1 class="text-2xl font-bold">WishVault Dashboard</h1>
        <div class="flex items-center gap-4">
            <span>Hallo👋 <?= $username; ?></span>
            <a href="auth/logout.php" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-white">Logout</a>
        </div>
    </header>

    <!-- Quotes Banner -->
    <div class="bg-purple-200 text-purple-700 text-center py-4 text-xl italic" id="quoteText">
        "<?= $allQuotes[0]; ?>"
    </div>

    <!-- Content -->
    <main class="max-w-7xl mx-auto p-6 space-y-8">
        <!-- Menu -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="wish/list.php" class="flex items-center bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-xl shadow-lg transition-all text-lg font-semibold">
                🎯 <span class="ml-4">Manajemen Wish</span>
            </a>
            <a href="category/list.php" class="flex items-center bg-green-500 hover:bg-green-600 text-white p-6 rounded-xl shadow-lg transition-all text-lg font-semibold">
                📂 <span class="ml-4">Manajemen Kategori</span>
            </a>
            <a href="quotes/list.php" class="flex items-center bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-xl shadow-lg transition-all text-lg font-semibold">
                💬 <span class="ml-4">Manajemen Quotes</span>
            </a>
            <a href="gallery/view.php" class="flex items-center bg-yellow-500 hover:bg-yellow-600 text-white p-6 rounded-xl shadow-lg transition-all text-lg font-semibold">
                🖼️ <span class="ml-4">Galeri Pencapaian</span>
            </a>
            <a href="quotes/daily.php" class="flex items-center bg-pink-500 hover:bg-pink-600 text-white p-6 rounded-xl shadow-lg transition-all text-lg font-semibold">
                🌅 <span class="ml-4">Kutipan Harian</span>
            </a>
            <a href="wish/public_list.php" class="flex items-center bg-indigo-500 hover:bg-indigo-600 text-white p-6 rounded-xl shadow-lg transition-all text-lg font-semibold">
                🌐 <span class="ml-4">Wish Public</span>
            </a>
        </div>

        <!-- Chart -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold mb-4 text-center text-indigo-600">Statistik Progress Impian</h2>
            <canvas id="wishChart" class="mx-auto"></canvas>
        </div>
    </main>

    <script>
        // Chart setup
        const ctx = document.getElementById('wishChart').getContext('2d');
        const wishChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Tercapai', 'Dalam Proses', 'Belum Mulai'],
                datasets: [{
                    data: [<?= $completed; ?>, <?= $inProgress; ?>, <?= $notStarted; ?>],
                    backgroundColor: ['#34D399', '#FBBF24', '#D1D5DB'],
                    borderColor: ['#10B981', '#F59E0B', '#9CA3AF'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // Quotes rotator
        const quotes = <?= json_encode($allQuotes); ?>;
        let quoteIndex = 0;

        setInterval(() => {
            quoteIndex = (quoteIndex + 1) % quotes.length;
            document.getElementById('quoteText').innerText = `"${quotes[quoteIndex]}"`;
        }, 5000);
    </script>
</body>

</html>
