<?php
session_start();

if (!isset($_SESSION['users'])) {
    header("Location: ../login.php");
    exit;
}

require 'includes/db.php';

$has_booking = false;

if (isset($_SESSION['users'])) {
    $user_email = $_SESSION['users'];
    $stmt = $conn->prepare("SELECT id FROM bookings WHERE user_email = ? LIMIT 1");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $has_booking = true;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fajar Travel - Jelajahi Destinasi Impianmu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">
    <style>
    body,
    html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Outfit', sans-serif;
        position: relative;
        background: url('img/lombok.jpg') no-repeat center center / cover;
        background-attachment: fixed;
        /* agar tetap saat scroll (opsional) */
        position: relative;
    }

    /* Overlay transparan */
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        /* warna + transparansi */
        z-index: -1;
        /* di bawah konten */
    }

    .hero-wrapper {
        position: relative;
        height: 100vh;
        background: url('img/loginhome.jpg') no-repeat center center/cover;
    }

    .hero-wrapper::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding-top: 20vh;
    }

    .hero-content h1 {
        color: #ffffff;
        font-size: 4rem;
        font-weight: 700;
    }

    .hero-content p {
        font-size: 1.5rem;
        color: #ccc;
    }

    .btn-primary {
        background-color: #00AEEF;
        border: none;
        padding: 0.75rem 2rem;
        font-size: 1rem;
        border-radius: 999px;
        margin-top: 2rem;
        transition: background 0.3s;
    }

    .btn-primary:hover {
        background-color: #008fcc;
    }

    .navbar {
        background-color: transparent !important;
        z-index: 10;
    }

    .nav-link {
        color: white !important;
        font-weight: 500;
        margin-left: 1rem;
    }

    .card {
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: scale(1.03);
    }

    .card img {
        height: 200px;
        object-fit: cover;
    }

    .login-indikator {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 20px;
        color: #ffffff;
        background: linear-gradient(135deg, #00b4db, #0083b0);
        padding: 6px 12px;
        border-radius: 6px;
        text-align: center;
        animation: fadeSlideIn 1s ease-out, pulse 2s infinite;
        box-shadow: 0 0 10px rgba(0, 180, 219, 0.5);
        transition: transform 0.3s ease;
    }

    .login-indikator:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(0, 180, 219, 0.7);
    }

    /* Animasi masuk (fade + geser dari bawah) */
    @keyframes fadeSlideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Animasi denyut (pulse) */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 10px rgba(0, 180, 219, 0.5);
        }

        50% {
            box-shadow: 0 0 20px rgba(0, 180, 219, 0.9);
        }

        100% {
            box-shadow: 0 0 10px rgba(0, 180, 219, 0.5);
        }
    }



    .footer-animated {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.9)),
            url('/img/footer-bg.jpg') no-repeat center center/cover;
        color: white;
        padding: 60px 20px;
        text-align: center;
        position: relative;
        animation: fadeInFooter 2s ease-in-out;
    }

    .footer-content {
        max-width: 800px;
        margin: auto;
        animation: slideUp 1.5s ease;
    }

    .footer-title {
        font-size: 2rem;
        margin-bottom: 10px;
        animation: glow 2s infinite alternate;
    }

    .footer-text {
        font-size: 1rem;
        margin-bottom: 20px;
        color: #ccc;
    }

    .footer-links a {
        margin: 0 10px;
        text-decoration: none;
        color: #00bcd4;
        font-weight: 500;
        transition: color 0.3s, transform 0.3s;
    }

    .footer-title {
        width: 40px;
        /* atur lebar sesuai kebutuhan */
        height: auto;
        /* agar proporsional */
    }

    .footer-links a:hover {
        color: #ffffff;
        transform: scale(1.1);
    }

    .footer-credit {
        margin-top: 30px;
        font-size: 0.9rem;
        color: #aaa;
    }

    /* Animasi */
    @keyframes fadeInFooter {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            transform: translateY(40px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes glow {
        from {
            text-shadow: 0 0 10px #00bcd4;
        }

        to {
            text-shadow: 0 0 20px #00bcd4, 0 0 30px #00bcd4;
        }
    }
    </style>
</head>

<body>
    <div class="hero-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg position-absolute top-0 w-100">
            <div class="container-fluid justify-content-between align-items-center px-4">
                <a class="navbar-brand d-flex align-items-center text-white fw-bold" href="logout.php">
                    <img src="img/logopw.png" alt="Logo" style="height: 40px;" class="me-2">
                    Fajar Voyage
                </a>

                <div>

                    <a class="nav-link d-inline text-white mx-2" href="dashboard.php">Beranda</a>
                    <a class="nav-link d-inline text-white mx-2" href="destinasi.php">Destinasi</a>
                    <a class="nav-link d-inline text-white mx-2" href="about.html">Tentang Kami</a>
                    <a class="nav-link d-inline text-white mx-2" href="kontak.php">Kontak</a>
                    <?php if ($has_booking): ?>
                    <a class="nav-link d-inline text-white mx-2" href="cekpesanan.php">Cek Pesanan</a>
                    <?php endif; ?>




                    <div class="nav-link d-inline login-indikator">Halo, <?= htmlspecialchars($_SESSION['users']) ?> 👋
                    </div>
                </div>
            </div>
        </nav>


        <!-- Hero Content -->
        <div class="hero-content">
            <h1>Fajar Travel</h1>
            <p>Temukan destinasi terbaikmu bersama kami</p>
            <a href="destinasi.php" class="btn btn-primary login-indikator">Jelajahi Sekarang</a>
        </div>
    </div>
    <!-- Section: Rekomendasi Destinasi -->
    <div class="container my-5">
        <h2 class="text-center text-light mb-4">Rekomendasi Destinasi</h2>
        <div class="row">
            <!-- Bromo -->
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-lg">
                    <img src="/img/bromo.jpg" class="card-img-top" alt="Bromo">
                    <div class="card-body">
                        <h5 class="card-title">Bromo</h5>
                        <p class="card-text">Nikmati keindahan matahari terbit dari Gunung Bromo yang menakjubkan.</p>
                    </div>
                </div>
            </div>
            <!-- Bali -->
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-lg">
                    <img src="img/bali.jpg" class="card-img-top" alt="Bali">
                    <div class="card-body">
                        <h5 class="card-title">Bali</h5>
                        <p class="card-text">Surga tropis dengan pantai eksotis dan budaya yang kaya.</p>
                    </div>
                </div>
            </div>
            <!-- Jogja -->
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-lg">
                    <img src="img/jogja.jpg" class="card-img-top" alt="Jogja">
                    <div class="card-body">
                        <h5 class="card-title">Jogja</h5>
                        <p class="card-text">Kota budaya dengan warisan sejarah dan kuliner lezat.</p>
                    </div>
                </div>
            </div>
            <!-- Lombok -->
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-lg">
                    <img src="img/lombok.jpg" class="card-img-top" alt="Lombok">
                    <div class="card-body">
                        <h5 class="card-title">Lombok</h5>
                        <p class="card-text">Pulau cantik dengan pantai perawan dan Gunung Rinjani yang megah.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Section: Rekomendasi Destinasi -->
    <div class="container my-5">
        <h2 class="text-center text-white mb-4">Destinasi Tersedia</h2>
        <div class="row">

            <?php

include 'includes/db.php';
$result = $conn->query("SELECT * FROM destinations");
while ($row = $result->fetch_assoc()) {
  echo '
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-lg">
        <img src="img/destinations/' . $row['image_path'] . '" class="card-img-top" alt="' . $row['name'] . '" style="height: 200px; object-fit: cover;">
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <h5 class="card-title">' . $row['name'] . '</h5>
            <p class="card-text">' . substr($row['description'], 0, 100) . '...</p>
          </div>
          <div class="mt-3">
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#destModal' . $row['id'] . '">Lihat Detail</button>
<a href="booking.php?dest_id=' . $row['id'] . '" class="btn btn-success btn-sm">Booking</a>

          </div>
        </div>
      </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="destModal' . $row['id'] . '" tabindex="-1" aria-labelledby="destModalLabel' . $row['id'] . '" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark text-white">
          <div class="modal-header">
            <h5 class="modal-title" id="destModalLabel' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <img src="img/destinations/' . htmlspecialchars($row['image_path']) . '" class="img-fluid rounded mb-3" alt="' . htmlspecialchars($row['name']) . '">
            <p>' . nl2br(htmlspecialchars($row['description'])) . '</p>
<a href="booking.php?dest_id=' . $row['id'] . '" class="btn btn-success mt-3">Booking Sekarang</a>

          </div>
        </div>
      </div>
    </div>
  ';
}
?>

        </div>
    </div>

    </div>
    </div>
    <!-- Destinasi Cards -->
    <footer class="footer-animated">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="img/logopw.png" alt="Logo" class="footer-title" />
            </div>

            <h2>Fajar Voyage</h2>
        </div>
        <p class="footer-text">Temukan keindahan Indonesia bersama kami.</p>
        <div class="footer-links">
            <a href="#">Beranda</a>
            <a href="#">Destinasi</a>
            <a href="#">Tentang Kami</a>
            <a href="#">Kontak</a>
        </div>
        <p class="footer-credit">© 2025 Fajar Voyages. All rights reserved.</p>
        </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>