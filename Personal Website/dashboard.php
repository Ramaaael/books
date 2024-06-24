<?php
session_start();

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

$message_succes = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $is_complete = isset($_POST['is_complete']) ? 1 : 0; // Jika checkbox checked, set is_complete ke 1, jika tidak set ke 0

    // Mendapatkan user_id dari sesi
    $user_id = $_SESSION['user_id'];

    if (!empty($title) && !empty($date)) {
        $sql = "INSERT INTO books (title, author, date, is_complete, user_id) VALUES ('$title', '$author', '$date', '$is_complete', '$user_id')";

        if ($conn->query($sql) === TRUE) {
            $message_succes = "Buku berhasil ditambahkan.";
        } else {
            echo  "Error: " . $sql . "<br>" . $conn->error;
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
    <title>Dashboard - Bookshelf Website</title>
    <link rel="stylesheet" href="layout/dashboard.css">
    <link rel="shortcut icon" href="img/icon-2.png" type="image/x-icon">

</head>
<body>
    <?php include "page/header-ds.html"; ?>
    <main class="main">
    <form action="" method="POST" class="form-3">
        <h2 class="tag-form2">Fill the Bookshelf</h2>
        <div class="form-isi">
            <label for="title">Judul</label>
            <input type="text" name="title" class="input" required>
            <label for="author">Penulis</label>
            <input type="text" name="author" class="input" required>
            <label for="date">Tanggal</label>
            <input type="date" name="date" class="input" required>
        </div>
        <div class="inline-btn">
            <label for="is_complete">Complate</label>
            <input type="checkbox" name="is_complete">
        </div>
        <center><button type="submit" class="btn-fill">add books to the Bookshelf</button></center>
        <center> <?php if (!empty($message_succes)): ?>
        <p style="color: #4D869C; font-size:14px;"><?php echo $message_succes; ?></p>
        <?php endif; ?></center>
    </form>
</main>
    
</body>
</html>