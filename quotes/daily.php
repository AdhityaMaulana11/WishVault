<?php
require_once '../auth/session.php';
require_once '../config/db.php';

// Ambil kutipan berdasarkan hari
$today = date('z'); // Hari ke- (0 - 365)
$quotes = mysqli_query($conn, "SELECT * FROM quotes");
$quotesArray = [];

while ($row = mysqli_fetch_assoc($quotes)) {
    $quotesArray[] = $row['quote'];
}

if (count($quotesArray) == 0) {
    $dailyQuote = "Belum ada kutipan yang ditambahkan.";
} else {
    $index = $today % count($quotesArray);
    $dailyQuote = $quotesArray[$index];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kutipan Harian - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-yellow-300 to-pink-300 min-h-screen flex flex-col items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-lg max-w-xl text-center">
        <h1 class="text-3xl font-bold mb-4 text-yellow-600">Kutipan Harian</h1>
        <p class="italic text-lg text-gray-700 mb-6">"<?= $dailyQuote; ?>"</p>
        <a href="../dashboard.php" class="text-blue-500 hover:underline mb-2">🏠 Kembali ke Dashboard</a>
        <a href="list.php" class="text-purple-500 hover:underline">💬 Kelola Kutipan</a>
    </div>
</body>

</html>
