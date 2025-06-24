<?php
include '../includes/db.php';

$success = '';
$error = '';
$edit_mode = false;
$edit_data = null;

// Hapus destinasi
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    $conn->query("DELETE FROM destinations WHERE id = $delete_id");
    header("Location: add_destination.php");
    exit;
}

// Ambil data untuk edit
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = (int) $_GET['edit'];
    $res = $conn->query("SELECT * FROM destinations WHERE id = $edit_id");
    $edit_data = $res->fetch_assoc();
}

// Proses simpan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;

    // Upload gambar jika diisi
    $image_uploaded = false;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $target_dir = "../img/destinations/";
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $image_type = mime_content_type($tmp);

        if (in_array($image_type, $allowed_types)) {
            $new_filename = uniqid() . '_' . basename($image);
            if (move_uploaded_file($tmp, $target_dir . $new_filename)) {
                $image_uploaded = true;
            } else {
                $error = "Gagal upload gambar.";
            }
        } else {
            $error = "Format gambar tidak didukung.";
        }
    }

    // Simpan data
    if (!$error) {
        if ($id) {
            // Edit
            if ($image_uploaded) {
                $sql = "UPDATE destinations SET name=?, description=?, location=?, price=?, image_path=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssi", $name, $description, $location, $price, $new_filename, $id);
            } else {
                $sql = "UPDATE destinations SET name=?, description=?, location=?, price=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $name, $description, $location, $price, $id);
            }
            if ($stmt->execute()) {
                $success = "Destinasi berhasil diupdate!";
            } else {
                $error = "Gagal update: " . $conn->error;
            }
        } else {
            // Tambah
            if ($image_uploaded) {
                $query = "INSERT INTO destinations (name, description, location, price, image_path) 
                          VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssss", $name, $description, $location, $price, $new_filename);
                if ($stmt->execute()) {
                    $success = "Destinasi berhasil ditambahkan!";
                } else {
                    $error = "Gagal menyimpan: " . $conn->error;
                }
            } else {
                $error = "Gambar wajib diunggah.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin - Tambah/Edit Destinasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #121212;
        color: white;
    }

    .form-container {
        max-width: 700px;
        margin: auto;
        padding: 30px;
        background-color: #1e1e1e;
        border-radius: 15px;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
    }

    .form-label {
        font-weight: 500;
    }

    .btn-primary {
        background-color: #007bff;
        border-radius: 10px;
    }

    .alert {
        border-radius: 10px;
    }

    .table-container {
        max-width: 1000px;
        margin: 40px auto;
        background: #1e1e1e;
        padding: 20px;
        border-radius: 12px;
    }

    table img {
        height: 50px;
    }

    a.btn-sm {
        margin-right: 5px;
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="form-container">
            <h3 class="mb-4"><?= $edit_mode ? '✏️ Edit Destinasi' : '🗺️ Tambah Destinasi Baru' ?></h3>

            <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
            <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <?php if ($edit_mode): ?>
                <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Nama Destinasi</label>
                    <input type="text" name="name" class="form-control" value="<?= $edit_data['name'] ?? '' ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control"
                        required><?= $edit_data['description'] ?? '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="location" class="form-control" value="<?= $edit_data['location'] ?? '' ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" value="<?= $edit_data['price'] ?? '' ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Gambar <?= $edit_mode ? '(boleh dikosongkan)' : '' ?></label>
                    <input type="file" name="image" class="form-control" <?= $edit_mode ? '' : 'required' ?>>
                    <?php if ($edit_mode && $edit_data['image_path']): ?>
                    <img src="../img/destinations/<?= $edit_data['image_path'] ?>" alt="Preview" class="mt-2"
                        style="height: 80px;">
                    <?php endif; ?>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <?= $edit_mode ? 'Update Destinasi' : 'Tambah Destinasi' ?>
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Destinasi -->
        <div class="table-container mt-5">
            <h4 class="mb-3">📋 Daftar Destinasi</h4>
            <table class="table table-dark table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Lokasi</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $all = $conn->query("SELECT * FROM destinations ORDER BY id DESC");
                    while ($row = $all->fetch_assoc()):
                    ?>
                    <tr>
                        <td><img src="../img/destinations/<?= $row['image_path'] ?>" alt="img"></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['location'] ?></td>
                        <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                        <td>
                            <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus destinasi ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>