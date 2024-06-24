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

    $sql = "SELECT * FROM rekomen WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $judul = $row['judul'];
        $rekomendasi = $row['rekomendasi'];
    } else {
        echo "Rekomendasi tidak ditemukan.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - Bookshelf Website</title>
    <link rel="stylesheet" href="layout/edit-post.css">
    <link rel="shortcut icon" href="img/icon-2.png" type="image/x-icon">
</head>
<body>
    <?php include "page/admin-header.html";?>
    <form action="update-post.php" method="POST"  class="form-1">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label class="tag-profile">Nama :</label>
        <input type="text" name="nama" class="inpt-profile" value="<?php echo $nama; ?>"><br>
        <label class="tag-profile">Judul :</label>
        <input type="text" name="judul" class="inpt-profile" value="<?php echo $judul; ?>"><br>
        <label class="tag-profile">Tanggapan :</label>
        <textarea name="rekomendasi" cols="30" rows="10" class="text-profile"><?php echo $rekomendasi; ?></textarea><br>
        <input type="submit" value="Update" class="btn-profile">
    </form>
</body>
</html>
