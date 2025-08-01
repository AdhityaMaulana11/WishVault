<?php
require_once '../auth/session.php';
require_once '../config/db.php';

$id = $_GET['id'];
$wish = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM wishes WHERE id=$id AND user_id={$_SESSION['user_id']}"));

if (isset($_POST['update'])) {
    $progress = $_POST['progress'];

    // Update progress
    mysqli_query($conn, "UPDATE wishes SET progress=$progress WHERE id=$id");

    // Otomatis update status jika progress = 100
    if ($progress == 100) {
        mysqli_query($conn, "UPDATE wishes SET status='Tercapai' WHERE id=$id");
    } elseif ($progress > 0) {
        mysqli_query($conn, "UPDATE wishes SET status='Dalam Proses' WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE wishes SET status='Belum Mulai' WHERE id=$id");
    }

    header('Location: list.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Progress - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-300 to-purple-300 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-lg text-center">
        <h1 class="text-3xl font-bold mb-6 text-blue-600">Update Progress</h1>
        <h2 class="text-xl font-semibold mb-4 text-gray-700"><?= $wish['title']; ?></h2>
        <form method="POST" class="space-y-4">
            <label class="block mb-1 font-semibold text-left">Progress: <span id="progressValue"><?= $wish['progress']; ?></span>%</label>
            <input type="range" name="progress" min="0" max="100" value="<?= $wish['progress']; ?>" class="w-full accent-blue-500" oninput="document.getElementById('progressValue').innerText = this.value">
            <button type="submit" name="update" class="w-full bg-blue-500 hover:bg-blue-600 text-white p-3 rounded transition-all">Simpan Progress</button>
            <a href="list.php" class="block text-center mt-4 text-blue-500 hover:underline">⬅️ Kembali</a>
        </form>
    </div>
</body>

</html>
