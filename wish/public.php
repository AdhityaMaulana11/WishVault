<?php
require_once '../config/db.php';

$id = $_GET['id'];
$wish = mysqli_fetch_assoc(mysqli_query($conn, "SELECT w.*, u.username FROM wishes w JOIN users u ON w.user_id = u.id WHERE w.id = $id AND w.is_public = 1"));

if (!$wish) {
    echo "Wish tidak ditemukan atau tidak publik.";
    exit();
}

// Ambil komentar
$comments = mysqli_query($conn, "SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.wish_id = $id ORDER BY c.created_at DESC");

session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (isset($_POST['comment']) && $user_id) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    mysqli_query($conn, "INSERT INTO comments (wish_id, user_id, comment) VALUES ($id, $user_id, '$comment')");
    header("Location: public.php?id=$id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wish Public - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="public_list.php" class="text-blue-500 hover:underline">⬅️ Kembali ke Wish Public</a>
        </div>
        <h1 class="text-3xl font-bold mb-4 text-indigo-600"><?= htmlspecialchars($wish['title']); ?></h1>
        <p class="mb-4 text-gray-700"><?= htmlspecialchars($wish['description']); ?></p>
        <p class="text-gray-500 mb-6">Diposting oleh: <span class="font-semibold"><?= htmlspecialchars($wish['username']); ?></span></p>

        <h2 class="text-2xl font-semibold mb-4 text-purple-600">Komentar</h2>

        <?php if (mysqli_num_rows($comments) == 0) : ?>
            <p class="text-gray-500 mb-4">Belum ada komentar.</p>
        <?php else : ?>
            <div class="mb-6">
                <?php while ($comment = mysqli_fetch_assoc($comments)) : ?>
                    <div class="mb-3 p-3 border rounded-lg bg-gray-50">
                        <strong class="text-indigo-600"><?= htmlspecialchars($comment['username']); ?>:</strong>
                        <p class="text-gray-700"><?= htmlspecialchars($comment['comment']); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <?php if ($user_id) : ?>
            <form method="POST" class="flex gap-2">
                <input type="text" name="comment" placeholder="Tulis komentar" required class="flex-1 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 rounded">Kirim</button>
            </form>
        <?php else : ?>
            <p class="text-red-500">Login untuk memberikan komentar.</p>
        <?php endif; ?>
    </div>

</body>
</html>
