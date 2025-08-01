<?php
require_once '../auth/session.php';
require_once '../config/db.php';

if (isset($_POST['save'])) {
    $quote = mysqli_real_escape_string($conn, $_POST['quote']);
    mysqli_query($conn, "INSERT INTO quotes (quote) VALUES ('$quote')");
    header('Location: list.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tambah Kutipan - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-green-300 to-blue-300 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-lg">
        <h1 class="text-3xl font-bold mb-6 text-green-600 text-center">Tambah Kutipan Baru</h1>
        <form method="POST" class="space-y-4">
            <textarea name="quote" placeholder="Masukkan Kutipan" required class="w-full p-4 border rounded focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
            <button type="submit" name="save" class="w-full bg-green-500 hover:bg-green-600 text-white p-3 rounded transition-all">Simpan</button>
            <a href="list.php" class="block text-center mt-4 text-green-500 hover:underline">⬅️ Kembali</a>
        </form>
    </div>
</body>

</html>

