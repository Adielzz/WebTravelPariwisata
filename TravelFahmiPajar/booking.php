<?php
require 'includes/db.php';

$dest_id = isset($_GET['dest_id']) ? (int)$_GET['dest_id'] : 0;
$destination = null;

if ($dest_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM destinations WHERE id = ?");
    $stmt->bind_param("i", $dest_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $destination = $result->fetch_assoc();
    } else {
        die("Destinasi tidak ditemukan.");
    }
    $stmt->close();
} else {
    die("ID destinasi tidak valid.");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Booking <?= htmlspecialchars($destination['name']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background: url('img/lombok.jpg') no-repeat center center/cover;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .booking-container {
        background: rgba(0, 0, 0, 0.08);
        backdrop-filter: blur(6px);
        padding: 30px;
        border-radius: 16px;
        max-width: 1000px;
        width: 95%;
        display: flex;
        flex-wrap: wrap;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .booking-left,
    .booking-right {
        flex: 1 1 300px;
        padding: 20px;
    }

    .ticket-info img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 12px;
    }

    .ticket-info h3 {
        color: #0b3d91;
        font-size: 1.5rem;
        margin-bottom: 8px;
    }

    .ticket-info p {
        color: #374151;
        font-size: 0.95rem;
    }

    form label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #111827;
    }

    form input,
    form select {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        margin-bottom: 16px;
        background-color: #f9fafb;
        font-size: 0.95rem;
    }

    form input:focus,
    form select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        outline: none;
    }

    .btn-order {
        width: 100%;
        background: linear-gradient(to right, #00c6ff, #0072ff);
        color: white;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 14px;
        font-size: 1rem;
        transition: background 0.3s ease;
    }

    .btn-order:hover {
        background: linear-gradient(to right, #0072ff, #00c6ff);
    }

    @media (max-width: 768px) {
        .booking-container {
            flex-direction: column;
            padding: 20px;
        }

        .booking-left,
        .booking-right {
            padding: 10px 0;
        }
    }
    </style>
</head>

<body>
    <div class="booking-container">
        <!-- KIRI: Informasi Destinasi -->
        <div class="booking-left">
            <div class="ticket-info">
                <img src="img/destinations/<?= htmlspecialchars($destination['image_path']) ?>"
                    alt="<?= htmlspecialchars($destination['name']) ?>">
                <h3><?= htmlspecialchars($destination['name']) ?></h3>
                <p><?= htmlspecialchars($destination['location']) ?><br>
                    Harga: <b>Rp <?= number_format($destination['price'], 0, ',', '.') ?></b></p>
            </div>
        </div>

        <!-- KANAN: Form Booking -->
        <div class="booking-right">
            <form action="process_order.php" method="POST">
                <input type="hidden" name="destination_id" value="<?= $destination['id'] ?>">

                <label for="fullname">Nama Lengkap</label>
                <input type="text" id="fullname" name="fullname" required placeholder="Nama lengkapmu">

                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" required placeholder="you@example.com">

                <label for="phone">Nomor Telepon</label>
                <input type="tel" id="phone" name="phone" required placeholder="08xxxxxxxx">

                <label for="quantity">Jumlah Orang</label>
                <select id="quantity" name="quantity" required>
                    <option value="" disabled selected>Pilih jumlah</option>
                    <?php for($i=1;$i<=10;$i++) echo "<option value='$i'>$i Orang</option>"; ?>
                </select>

                <label for="payment">Metode Pembayaran</label>
                <select id="payment" name="payment" required>
                    <option value="" disabled selected>Pilih metode</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="ewallet">E-Wallet (OVO, GoPay, DANA)</option>
                    <option value="credit">Kartu Kredit</option>
                </select>

                <button type="submit" class="btn-order">Pesan Sekarang</button>
            </form>
        </div>
    </div>
</body>

</html>