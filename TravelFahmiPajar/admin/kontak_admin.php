<?php
session_start();
include '../includes/db.php';

// Cek login
if (!isset($_SESSION['users'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil semua pesan kontak
$result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pesan Kontak - Admin Fajar Voyage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #121212;
        color: #ffffff;
    }

    .sidebar {
        width: 240px;
        height: 100vh;
        background-color: #1f1f1f;
        position: fixed;
        padding: 30px 20px;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        display: block;
        margin: 10px 0;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: #00aaff;
        padding: 8px;
        border-radius: 8px;
    }

    .content {
        margin-left: 260px;
        padding: 40px;
    }

    .card-box {
        background-color: #1f1f1f;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .list-group-item {
        background-color: #2c2c2c;
        color: white;
        border: none;
    }

    .list-group-item .text-muted {
        color: #bbb !important;
    }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4>Admin Panel</h4>
        <a href="index.php">Dashboard</a>
        <a href="add_destination.php">Kelola Destinasi</a>
        <a href="kelola_pesanan.php">Kelola Pesanan</a>
        <a href="kontak_admin.php" class="active">Pesan Kontak</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="content">
        <h2>Pesan Kontak</h2>

        <div class="card-box">
            <?php if ($result->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($row = $result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($row['name']) ?></strong> (<?= htmlspecialchars($row['email']) ?>):<br>
                    <?= nl2br(htmlspecialchars($row['message'])) ?>
                    <div class="small text-muted">Dikirim pada: <?= $row['created_at'] ?></div>
                </li>
                <?php endwhile; ?>
            </ul>
            <?php else: ?>
            <p>Tidak ada pesan yang masuk.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>