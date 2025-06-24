<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - Wisata Nusantara</title>
    <link rel="stylesheet" href="../style/register.css" />
</head>

<body>
    <div class="background-image"></div>

    <div class="login-container">
        <div class="login-box">
            <div class="welcome-section">
                <img src="../img/logopw.png" alt="Logo Wisata" class="welcome-img" />
                <h2>Daftar Akun Baru</h2>
                <p>Mulai petualanganmu dengan membuat akun.</p>
            </div>
            <form action="register_process.php" method="POST">
                <input type="text" name="username" placeholder="Username" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="password" name="password_confirm" placeholder="Konfirmasi Password" required />
                <button type="submit">Daftar</button>
            </form>
            <p class="register-text">
                Sudah punya akun? <a href="../index.html">Login di sini</a>
            </p>
        </div>
    </div>
</body>

</html>