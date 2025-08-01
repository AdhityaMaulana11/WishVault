<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header('Location: ../dashboard.php');
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 to-purple-500">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-96">
        <h2 class="text-3xl font-bold mb-6 text-center text-blue-600">Login WishVault</h2>
        <?php if (isset($error)) : ?>
            <p class="text-red-500 mb-4 text-center"><?= $error; ?></p>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <input type="text" name="username" placeholder="Username" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <input type="password" name="password" placeholder="Password" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button type="submit" name="login" class="w-full bg-blue-500 hover:bg-blue-600 text-white p-3 rounded transition-all">Login</button>
        </form>
        <p class="mt-4 text-center text-gray-600">Belum punya akun? <a href="register.php" class="text-blue-500 hover:underline">Register</a></p>
    </div>
</body>
</html>
