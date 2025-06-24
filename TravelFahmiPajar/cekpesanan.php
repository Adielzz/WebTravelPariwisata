<?php
session_start();
require 'includes/db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['users'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['users'];

// Ambil data pesanan user
$stmt = $conn->prepare("SELECT b.*, d.name AS destination_name FROM bookings b
                        JOIN destinations d ON b.destination_id = d.id
                        WHERE b.user_email = ?
                        ORDER BY b.created_at DESC");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pesanan Saya - Fajar Travel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(to right, rgb(104, 114, 197), rgba(248, 0, 0, 0.9));
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .container {
        background-color: #fff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        animation: fadeIn 0.8s ease-in-out;
        max-width: 1000px;
        width: 100%;
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

    h2 {
        margin-bottom: 30px;
        color: #333;
        font-weight: 700;
    }

    .table {
        border-radius: 10px;
        overflow: hidden;
    }

    .table thead {
        background-color: #343a40;
        color: white;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .badge {
        padding: 8px 12px;
        font-size: 0.9rem;
        border-radius: 12px;
        text-transform: capitalize;
    }

    .badge.pending {
        background-color: #ffc107;
        color: #000;
    }

    .badge.approved {
        background-color: #28a745;
    }

    .badge.rejected {
        background-color: #dc3545;
    }

    .back-btn {
        margin-top: 30px;
    }

    @media (max-width: 768px) {
        .container {
            padding: 20px;
        }

        .table-responsive {
            font-size: 0.9rem;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>🧾 Daftar Pesanan Anda</h2>

        <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead>
                    <tr>
                        <th>Destinasi</th>
                        <th>Tanggal Pesan</th>
                        <th>Jumlah Orang</th>
                        <th>Total Biaya</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['destination_name']) ?></td>
                        <td><?= date('d M Y H:i', strtotime($row['created_at'])) ?></td>
                        <td><?= $row['quantity'] ?> org</td>
                        <td>Rp <?= number_format($row['total_price'], 0, ',', '.') ?></td>
                        <td><?= ucwords(htmlspecialchars($row['payment_method'])) ?></td>
                        <td><span
                                class="badge <?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-muted">Anda belum memiliki pesanan.</p>
        <?php endif; ?>

        <a href="dashboard.php" class="btn btn-dark back-btn">← Kembali ke Dashboard</a>
    </div>
</body>

</html>