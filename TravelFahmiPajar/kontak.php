<?php
session_start();
if (!isset($_SESSION['users'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kontak Kami - Fajar Travel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">
    <style>
    html,
    body {
        margin: 0;
        padding: 0;
        font-family: 'Outfit', sans-serif;
        background: url('img/loginhome.jpg') no-repeat center center/cover;
        background-attachment: fixed;
        min-height: 100%;
        position: relative;
        color: white;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(10, 10, 10, 0.85);
        z-index: -1;

        /* dorong seluruh isi body agar tidak ketimpa navbar */
    }

    .navbar {
        background-color: transparent !important;
    }

    .nav-link {
        color: white !important;
        font-weight: 500;
        padding: 5px;
    }

    .login-indikator {
        font-size: 16px;
        background: linear-gradient(135deg, #00b4db, #0083b0);
        padding: 5px 10px;
        border-radius: 6px;
        color: #fff;
    }

    .kontak-section {
        padding: 40px 20px;
        max-width: 600px;
        margin: auto;
        background-color: rgba(255, 255, 255, 0.07);
        backdrop-filter: blur(6px);
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
        animation: fadeIn 1.2s ease;

    }

    .main-wrapper {
        padding-top: 120px;
        /* Dorong turun agar tidak tertimpa navbar */
        padding-bottom: 60px;
        /* Spasi ke footer */
    }

    .kontak-section {
        padding: 40px 20px;
        max-width: 600px;
        margin: auto;
        background-color: rgba(255, 255, 255, 0.07);
        backdrop-filter: blur(6px);
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
        animation: fadeIn 1.2s ease;
    }

    .kontak-section h2 {
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
    }

    .form-control::placeholder {
        color: #ccc;
    }

    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.15);
        border-color: #00bcd4;
        color: white;
    }

    .btn-primary {
        background-color: #00bcd4;
        border: none;
        border-radius: 10px;
        transition: 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #009bb5;
    }

    footer {
        margin-top: 100px;
    }

    .footer-animated {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.9)),
            url('/img/footer-bg.jpg') no-repeat center center / cover;
        color: white;
        padding: 60px 20px;
        text-align: center;
    }

    .footer-links a {
        margin: 0 10px;
        text-decoration: none;
        color: #00bcd4;
    }

    .footer-links a:hover {
        color: white;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg position-absolute top-0 w-100">
        <div class="container-fluid justify-content-between px-4">
            <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="logout.php">
                <img src="img/logopw.png" alt="Logo" style="height: 40px;" class="me-2">
                Fajar Voyage
            </a>
            <div>
                <a class="nav-link d-inline" href="dashboard.php">Beranda</a>
                <a class="nav-link d-inline" href="destinasi.php">Destinasi</a>
                <a class="nav-link d-inline" href="about.html">Tentang Kami</a>
                <a class="nav-link d-inline" href="kontak.php">Kontak</a>

            </div>
        </div>
    </nav>

    <!-- Kontak Form -->
    <div class="main-wrapper">
        <div class="kontak-section mt-5">
            <h2>Hubungi Kami</h2>
            <form action="proses_kontak.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Alamat Email" required>
                </div>
                <div class="mb-4">
                    <textarea name="pesan" class="form-control" rows="5" placeholder="Tulis pesan kamu di sini..."
                        required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
            </form>
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer-animated">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="img/logopw.png" alt="Logo" style="width: 40px;">
            </div>
            <h2>Fajar Voyage</h2>
        </div>
        <p class="footer-text">Temukan keindahan Indonesia bersama kami.</p>
        <div class="footer-links">
            <a href="index.php">Beranda</a>
            <a href="destinasi.php">Destinasi</a>
            <a href="about.html">Tentang Kami</a>
            <a href="kontak.php">Kontak</a>
        </div>
        <p class="footer-credit">© 2025 Fajar Voyage. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>