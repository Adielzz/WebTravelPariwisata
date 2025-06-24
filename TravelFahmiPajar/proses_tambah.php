<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "wisata";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

$name = $_POST['name'];
$description = $_POST['description'];

$imagePath = "";
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
  $fileTmpPath = $_FILES['image']['tmp_name'];
  $fileName = $_FILES['image']['name'];
  $destination = 'img/' . $fileName;

  if (move_uploaded_file($fileTmpPath, $destination)) {
    $imagePath = $destination;
  } else {
    die("Gagal mengunggah gambar.");
  }
} else {
  die("Gambar belum diunggah atau terjadi kesalahan.");
}

$sql = "INSERT INTO destinations (name, description, image_path) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $description, $imagePath);

if ($stmt->execute()) {
  echo "<script>alert('Destinasi berhasil ditambahkan!'); window.location.href='admin_tambah.html';</script>";
} else {
  echo "Gagal menambahkan destinasi: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>