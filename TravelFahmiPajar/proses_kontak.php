<?php
session_start();
require 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dari form
    $name = htmlspecialchars(trim($_POST['nama']));      // disesuaikan
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['pesan']));  // disesuaikan

    // Validasi sederhana
    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Pesan berhasil dikirim.";
        } else {
            $_SESSION['error'] = "Terjadi kesalahan saat mengirim pesan: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Semua kolom wajib diisi.";
    }

    header("Location: kontak.php");
    exit;
} else {
    header("Location: kontak.php");
    exit;
}