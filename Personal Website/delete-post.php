<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_signup";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM rekomen WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Rekomendasi berhasil dihapus.";
    } else {
        echo "Gagal menghapus rekomendasi: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Permintaan tidak valid.";
}

$conn->close();
header("Location: admin.php");
exit();
?>
