<?php
session_start();
include 'includes/db.php';

$full_name = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$people_count = $_POST['quantity'];
$payment_method = $_POST['payment'];
$destination_id = $_POST['destination_id'];

$user_email = $_SESSION['users']; // ambil dari session

// Ambil harga dari destinasi
$query = "SELECT * FROM destinations WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $destination_id);
$stmt->execute();
$result = $stmt->get_result();
$destination = $result->fetch_assoc();

$price_per_person = $destination['price'] ?? 0;
$total_price = $price_per_person * $people_count;

// Simpan ke database
$insert = $conn->prepare("INSERT INTO bookings (user_email, full_name, email, phone, quantity, destination_id, total_price, status, created_at, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW(), ?)");
$insert->bind_param("ssssiiis", $user_email, $full_name, $email, $phone, $people_count, $destination_id, $total_price, $payment_method);
$insert->execute();
$insert->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
    body {
        background-color: #121212;
        color: #ffffff;
        font-family: 'Outfit', sans-serif;
        margin: 0;
        padding: 0;
    }

    .confirmation-box {
        max-width: 720px;
        margin: 80px auto;
        padding: 40px 30px;
        background-color: #1e1e1e;
        border-radius: 16px;
        border: 1px solid #2a2a2a;
        text-align: center;
    }

    h2 {
        font-weight: 600;
        color: #00aeef;
        margin-bottom: 20px;
    }

    .details {
        font-size: 1.05rem;
        line-height: 1.7;
        color: #cccccc;
        margin-bottom: 16px;
    }

    .price {
        font-size: 1.4rem;
        font-weight: 600;
        color: #ffcc00;
        margin: 12px 0;
    }

    .btn-back {
        margin-top: 30px;
        background-color: #00aeef;
        color: #fff;
        padding: 10px 28px;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #008fc7;
    }
    </style>

<body>
    <div class="confirmation-box">
        <h2>✅ Pemesanan Berhasil!</h2>
        <p class="details">
            Terima kasih, <strong><?= htmlspecialchars($full_name) ?></strong> telah memesan perjalanan ke
            <strong><?= htmlspecialchars($destination['name'] ?? 'Destinasi Tidak Ditemukan') ?></strong>.
        </p>

        <p class="details">
            📧 Kami akan menghubungi Anda di <strong><?= htmlspecialchars($email) ?></strong><br>
            📱 atau di <strong><?= htmlspecialchars($phone) ?></strong> untuk konfirmasi lebih lanjut.
        </p>

        <p class="details">
            💳 Metode Pembayaran: <strong><?= htmlspecialchars($payment_method) ?></strong><br>
            👥 Jumlah Orang: <strong><?= htmlspecialchars($people_count) ?></strong><br>
            💰 Total Biaya:
        <div class="price">Rp <?= number_format($total_price, 0, ',', '.') ?></div>
        </p>

        <a href="dashboard.php" class="btn-back">← Kembali ke Beranda</a>
    </div>
</body>

</html>