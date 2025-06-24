<?php

include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Destinasi - Fajar Travel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Outfit', sans-serif;
        background-color: #121212;
        color: white;
    }

    .navbar {
        background-color: #1f1f1f;
    }

    .nav-link {
        color: #fff !important;
        padding: 6px;
    }

    .hero {
        background: url('img/loginhome.jpg') center center/cover no-repeat;
        height: 300px;
        position: relative;
    }

    .hero::before {
        content: "";
        background-color: rgba(0, 0, 0, 0.6);
        position: absolute;
        inset: 0;
    }

    .hero h1 {
        position: relative;
        z-index: 2;
        padding-top: 100px;
        text-align: center;
        font-size: 3rem;
    }

    .container-destinations {
        padding: 50px 20px;
    }

    .card-destination {
        background-color: #1e1e1e;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .card-destination:hover {
        transform: scale(1.02);
    }

    .card-destination img {
        height: 200px;
        object-fit: cover;
    }

    .card-body h5 {
        color: #00aeef;
    }

    .footer {
        background-color: #1f1f1f;
        color: #ccc;
        padding: 40px 20px;
        text-align: center;
    }

    p {
        margin-top: 0;
        margin-bottom: 1rem;
        color: #fff;
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg px-4">
        <a class="navbar-brand text-white" href="logout.php">
            <img src="img/logopw.png" alt="Logo" style="height: 40px;" class="me-2">
            Fajar Voyage
        </a>
        <div class="ms-auto">
            <a class="nav-link d-inline" href="dashboard.php">Beranda</a>
            <a class="nav-link d-inline" href="destinasi.php">Destinasi</a>
            <a class="nav-link d-inline" href="about.html">Tentang Kami</a>
            <a class="nav-link d-inline" href="kontak.php">Kontak</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero text-white">
        <h1>Jelajahi Destinasi Impianmu</h1>
    </div>

    <!-- Destinations -->
    <div class="container container-destinations">
        <div class="row g-4">
            <?php
            $query = "SELECT * FROM destinations";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
    echo '
        <div class="col-md-4">
            <div class="card card-destination">
                <img src="img/destinations/' . htmlspecialchars($row['image_path']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                    <p class="card-text">' . mb_strimwidth(htmlspecialchars($row['description']), 0, 100, '...') . '</p>
                    <button class="btn btn-sm btn-outline-info mt-2" data-bs-toggle="modal" data-bs-target="#destModal' . $row['id'] . '">Lihat Detail</button>
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


    } else {
    echo '<p class="text-center">Belum ada data destinasi.</p>';
    }
    ?>
        </div>
    </div>

    <!-- Footer -->
    <!-- Footer -->
    <div class="footer">
        &copy; <?= date('Y'); ?> Fajar Travel. All rights reserved.
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>