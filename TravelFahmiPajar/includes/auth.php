<?php
require '../includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['users'] = $user['username']; // bisa juga simpan seluruh array $user kalau perlu

            // ✅ Cek role untuk redirect
            if ($user['role'] === 'admin') {
                header("Location: ../admin/index.php");
            } else {
                header("Location: ../dashboard.php");
            }
            exit();
        }
    }

    echo "Login gagal. <a href='../index.html'>Coba lagi</a>";
} else {
    echo "Akses tidak sah. <a href='../index.html'>Kembali ke login</a>";
}