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

if (!empty($judul) && !empty($rekomendasi)) {
    $sql = "INSERT INTO rekomen (nama, judul, rekomendasi) VALUES ('$nama', '$judul', '$rekomendasi')";

    if ($conn->query($sql) === TRUE) {
        header("Location: add-post.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// $sql = "SELECT * FROM rekomen";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//         $nama_message = "<h2>" . $row["nama"] . "</h2>";
//         $judul_message = "<h3>" . $row["judul"] . "</h3>";
//         $rekom_message = "<p>" . $row["rekomendasi"] . "</p>";
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
    <title>Add Post - Bookshelf Website</title>
    <link rel="shortcut icon" href="img/icon-2.png" type="image/x-icon">

</head>
<body>
<?php include "page/header-ds.html"; ?>
<?php include "page/post.html"; ?>
</body>
</html>