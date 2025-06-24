<?php
// register/register_process.php
session_start();
include '../includes/db.php'; // sesuaikan path koneksi DB kamu

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password !== $password_confirm) {
        $_SESSION['error'] = "Password dan konfirmasi password tidak sama!";
        header("Location: register.php");
        exit();
    }

    // Cek username sudah ada atau belum
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Username sudah digunakan!";
        header("Location: register.php");
        exit();
    }

    $stmt->close();

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Simpan user baru
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password_hash);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        header("Location: ../index.html");
        exit();
    } else {
        $_SESSION['error'] = "Registrasi gagal, coba lagi.";
        header("Location: register.php");
        exit();
    }
}
?>