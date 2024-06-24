<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "users_signup";

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Variabel untuk menyimpan data gambar yang diambil dari database
$currentImage = null;

// Cek apakah formulir telah disubmit
if (isset($_POST['submit'])) {
    // Ambil data file
    $namaFile = $_FILES['file']['name'];
    $tipeFile = $_FILES['file']['type'];
    $ukuranFile = $_FILES['file']['size'];
    $dataGambar = file_get_contents($_FILES['file']['tmp_name']);
    
    // Cek apakah gambar dengan nama yang sama sudah ada
    $stmt = $conn->prepare("SELECT id FROM users_img WHERE nama_file = ?");
    $stmt->bind_param("s", $namaFile);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Jika ada, update gambar
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $conn->prepare("UPDATE users_img SET tipe_file = ?, ukuran_file = ?, data_gambar = ?, tanggal_upload = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->bind_param("sibi", $tipeFile, $ukuranFile, $dataGambar, $id);
        $stmt->send_long_data(2, $dataGambar);
        
        if ($stmt->execute()) {

        } else {
            echo "Gagal memperbarui gambar: " . $stmt->error;
        }
    } else {
        // Jika tidak ada, masukkan gambar baru
        $stmt->close();
        
        $stmt = $conn->prepare("INSERT INTO users_img (nama_file, tipe_file, ukuran_file, data_gambar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $namaFile, $tipeFile, $ukuranFile, $dataGambar);
        $stmt->send_long_data(3, $dataGambar);
        
        if ($stmt->execute()) {
            "Gambar berhasil diunggah.";
        } else {
            echo "Gagal mengunggah gambar: " . $stmt->error;
        }
    }
    
    // Tutup statement
    $stmt->close();
}

// Mengambil gambar terakhir yang diunggah dari database untuk ditampilkan di form
$result = $conn->query("SELECT nama_file, tipe_file, data_gambar FROM users_img ORDER BY tanggal_upload DESC LIMIT 1");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentImage = 'data:' . $row['tipe_file'] . ';base64,' . base64_encode($row['data_gambar']);
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="layout/upload.css">
    <link rel="stylesheet" href="layout/profile.css">
    <link rel="shortcut icon" href="img/icon-2.png" type="image/x-icon">
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data" class="img-user">
        <?php if ($currentImage): ?>
            <img src="<?= $currentImage ?>" alt="Gambar" style="max-width: 200px; max-height:200px; border-radius:50%;">
        <?php endif; ?>
        <p>Pilih gambar:</p>
        <input type="file" name="file" required>
        <input type="submit" name="submit" value="Unggah">
    </form>
</body>
</html>