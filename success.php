<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Berhasil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(135deg, #56ccf2, #2f80ed); color: white; text-align: center; }
        .container { background: rgba(255, 255, 255, 0.2); padding: 40px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); width: 350px; }
        h2 { margin-bottom: 20px; }
        a { display: inline-block; padding: 10px 20px; margin-top: 20px; background: white; color: #2f80ed; border-radius: 6px; text-decoration: none; font-weight: bold; }
        a:hover { background: #dfe6e9; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Selamat, login Anda berhasil!</h2>
        <p>Halo, <strong><?php echo $_SESSION['username']; ?></strong>! Anda berhasil login.</p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
