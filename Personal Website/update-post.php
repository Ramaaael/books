<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_signup";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $judul = $_POST['judul'];
    $rekomendasi = $_POST['rekomendasi'];

    $sql = "UPDATE rekomen SET nama=?, judul=?, rekomendasi=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nama, $judul, $rekomendasi, $id);

    if ($stmt->execute()) {
        echo "Rekomendasi berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui rekomendasi: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Permintaan tidak valid.";
}

$conn->close();
header("Location: admin.php");
exit();
?>
