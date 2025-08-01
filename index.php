<?php
session_start();

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WishVault - Selamat Datang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-indigo-400 to-purple-500 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-10 rounded-3xl shadow-xl max-w-lg w-full text-center">
        <h1 class="text-4xl font-bold mb-4 text-indigo-700">Selamat Datang di WishVault</h1>
        <p class="text-gray-600 mb-8">Capai impianmu dengan rencana terukur, dukungan komunitas, dan galeri penuh kenangan.</p>
        <div class="space-y-4">
            <a href="auth/login.php" class="block w-full bg-indigo-500 hover:bg-indigo-600 text-white py-3 rounded-xl font-semibold transition-all">
                🚪 Login
            </a>
            <a href="auth/register.php" class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-xl font-semibold transition-all">
                ✍️ Daftar Akun Baru
            </a>
        </div>
    </div>
</body>

</html>
