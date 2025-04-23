<?php 
session_start();
$conn = new mysqli('localhost', 'root', '', 'login_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menambahkan variabel untuk menyimpan percobaan login
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

$error = ''; // Variabel untuk pesan kesalahan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Harap isi username dan password";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($user['password'] == $password) {
                $_SESSION['username'] = $username;
                header('Location: success.php');
                exit();
            } else {
                $error = "Password salah";
                $_SESSION['login_attempts']++;
            }
        } else {
            $error = "Username salah";
            $_SESSION['login_attempts']++;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(135deg,rgb(0, 183, 255),rgb(0, 119, 255)); }
        .login-container { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); width: 320px; text-align: center; }
        h2 { margin-bottom: 20px; color: #333; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; }
        button { width: 100%; padding: 10px; background:rgb(0, 204, 255); color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; }
        button:hover { background:rgb(0, 195, 255); }
        .error { color: red; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class='login-container'>
        <h2>Login</h2>
        <?php if(isset($error) && $error != ''): ?>
            <p class='error' id='error-message'><?php echo $error; ?></p>
        <?php endif; ?>
        <form method='POST'>
    <div style="text-align: left;">
        <label for="username">Username</label>
        <input type='text' name='username' id='username' placeholder='Masukkan username' 
               value="<?php echo htmlspecialchars($username ?? ''); ?>" 
               onfocus="clearInputAndError('username')" oninput="clearError()">

        <label for="password">Password</label>
        <input type='password' name='password' id='password' placeholder='Masukkan password' 
               onfocus="clearInputAndError('password')" oninput="clearError()">
    </div>
    <button type='submit'>Login</button>
</form>

    </div>

    <script>
        // Fungsi untuk menghapus pesan kesalahan
        function clearError() {
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }

        // Fungsi untuk mengosongkan input ketika diklik
        function clearInputAndError(inputType) {
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }

            if (inputType === 'username') {
                document.getElementById('username').value = ''; // Kosongkan kolom username
            } else if (inputType === 'password') {
                document.getElementById('password').value = ''; // Kosongkan kolom password
            }
        }

        // Menampilkan password yang telah dimasukkan sebelumnya
        <?php if (isset($password) && !empty($password)): ?>
            document.getElementById('password').value = "<?php echo htmlspecialchars($_POST['password']); ?>";
        <?php endif; ?>
    </script>
</body>
</html>
