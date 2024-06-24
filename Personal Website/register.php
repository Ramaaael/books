<?php
// Menghubungkan ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_signup";

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile_or_email = $_POST['mobile_or_email'];
    $full_name = $_POST['full_name'];
    $ussername = $_POST['ussername'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing dengan bcrypt

    // Memeriksa apakah username sudah ada
    $check_sql = "SELECT id FROM users WHERE ussername = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $ussername);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $error_message = "Username sudah terdaftar. Silakan gunakan username lain.";
    } else {
        // Menyimpan data baru
        $sql = "INSERT INTO users (mobile_or_email, full_name, ussername, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssss", $mobile_or_email, $full_name, $ussername, $password);

            if ($stmt->execute() === TRUE) {
                $success_message = "Pendaftaran berhasil!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Bookshelf Website</title>
    <link rel="shortcut icon" href="img/icon-2.png" type="image/x-icon">

</head>
<body>
    <?php include "page/header.html"?>
    <?php include "page/register.html";?>
    <?php include "page/footer.html";?>

</body>
</html>