<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
        header('Location: login.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - WishVault</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-green-400 to-blue-500">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-96">
        <h2 class="text-3xl font-bold mb-6 text-center text-green-600">Register WishVault</h2>
        <?php if (isset($error)) : ?>
            <p class="text-red-500 mb-4 text-center"><?= $error; ?></p>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <input type="text" name="username" placeholder="Username" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
            <input type="password" name="password" placeholder="Password" required class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
            <button type="submit" name="register" class="w-full bg-green-500 hover:bg-green-600 text-white p-3 rounded transition-all">Register</button>
        </form>
        <p class="mt-4 text-center text-gray-600">Sudah punya akun? <a href="login.php" class="text-green-500 hover:underline">Login</a></p>
    </div>
</body>
</html>
