<?php
session_start();
include '../includes/db.php';

// Statistik total
$total_dest = $conn->query("SELECT COUNT(*) as total FROM destinations")->fetch_assoc()['total'] ?? 0;
$total_booking = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'] ?? 0;

// Statistik destinasi populer
$popular = $conn->query("SELECT d.name, COUNT(b.id) as total FROM bookings b JOIN destinations d ON b.destination_id = d.id GROUP BY d.id ORDER BY total DESC LIMIT 5");
$labels = [];
$values = [];
while ($row = $popular->fetch_assoc()) {
    $labels[] = $row['name'];
    $values[] = $row['total'];
}

// Data kontak
$contacts = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Fajar Voyage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    canvas {
        background-color: #1e1e1e;
        padding: 20px;
        border-radius: 10px;
    }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4>Admin Panel</h4>
        <a href="#" class="active">Dashboard</a>
        <a href="add_destination.php">Kelola Destinasi</a>
        <a href="admin_pesanan.php">Kelola Pesanan</a>
        <a href="kontak_admin.php">Pesan Kontak</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="content">
        <h2>Selamat Datang, Admin!</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card-box">
                    <h3><?= $total_dest ?></h3>
                    <p>Total Destinasi</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-box">
                    <h3><?= $total_booking ?></h3>
                    <p>Total Booking</p>
                </div>
            </div>
        </div>

        <div class="card-box">
            <h4>Statistik Destinasi Populer</h4>
            <canvas id="popularChart" height="100"></canvas>
        </div>

        <div class="card-box">
            <h4>Pesan Kontak Terbaru</h4>
            <ul class="list-group">
                <?php while ($msg = $contacts->fetch_assoc()): ?>
                <li class="list-group-item bg-dark text-white">
                    <strong><?= htmlspecialchars($msg['name']) ?></strong> (<?= htmlspecialchars($msg['email']) ?>):
                    <?= nl2br(htmlspecialchars($msg['message'])) ?>
                    <div class="small text-muted">Dikirim pada: <?= $msg['created_at'] ?></div>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <script>
    const ctx = document.getElementById('popularChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Jumlah Booking',
                data: <?= json_encode($values) ?>,
                backgroundColor: 'rgba(0, 170, 255, 0.7)',
                borderColor: '#00aaff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#fff'
                    },
                    grid: {
                        color: '#444'
                    }
                },
                x: {
                    ticks: {
                        color: '#fff'
                    },
                    grid: {
                        color: '#444'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#fff'
                    }
                }
            }
        }
    });
    </script>
</body>

</html>