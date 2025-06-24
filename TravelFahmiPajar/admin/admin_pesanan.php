<?php
session_start();
require '../includes/db.php';

// (Opsional) Bisa tambahkan validasi session admin di sini

$query = "SELECT b.*, d.name AS destination_name FROM bookings b 
          JOIN destinations d ON b.destination_id = d.id 
          ORDER BY b.created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Pesanan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f5f5f5;
        padding: 40px;
    }

    h2 {
        margin-bottom: 25px;
    }

    .status-select {
        width: 150px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>📋 Daftar Pesanan Pengguna</h2>

        <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Destinasi</th>
                    <th>Jumlah Orang</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['destination_name']) ?></td>
                    <td><?= $row['quantity'] ?> orang</td>
                    <td>Rp <?= number_format($row['total_price'], 0, ',', '.') ?></td>
                    <td><?= ucfirst($row['payment_method']) ?></td>
                    <td><?= ucfirst($row['status']) ?></td>
                    <td>
                        <form action="update_status.php" method="POST" class="d-flex">
                            <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                            <select name="status" class="form-select form-select-sm me-2 status-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Ubah</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Tidak ada pesanan saat ini.</p>
        <?php endif; ?>
    </div>
</body>

</html>