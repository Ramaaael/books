<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_signup";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nama = isset($_POST['nama']) ? $_POST['nama'] : '';
$judul = isset($_POST['judul']) ? $_POST['judul'] : '' ;
$rekomendasi = isset($_POST['rekomendasi']) ? $_POST['rekomendasi'] : '';


$sql = "SELECT * FROM rekomen";
$result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//         echo "<h2>" . $row["nama"] . "</h2>";
//         echo "<h3>" . $row["judul"] . "</h3>";
//         echo "<p>" . $row["rekomendasi"] . "</p>";
//     }
// } else {
//     echo "";
// }
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post - Bookshelf Website</title>
    <link rel="stylesheet" href="layout/admin.css">
    <link rel="shortcut icon" href="img/icon-2.png" type="image/x-icon">

</head>
<body>
<?php include "page/admin-header.html";?>
<form action="" class="form-add">
<?php 

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<label class='head-nama';> Nama : "  . $row["nama"] . "</label>";
        echo "<label class='head-judul';> <br> Judul : " . $row["judul"] . "</label>";
        echo "<p class='head-rekom';>Tanggapan :  " . $row["rekomendasi"] . "</p>" . "<hr>";

        echo "<div class='btn'>";
        echo "<a href='edit-post.php?id=" . $row["id"] . "' class='edit-btn'>Edit</a>";
        echo "<a href='delete-post.php?id=" . $row["id"] . "' class='delete-btn'>Delete</a>";
        echo "</div>";
        echo "<hr>";
    }
} else {
    echo "Tidak ada data rekomendasi.";
}
?>
</form>
</body>
</html>