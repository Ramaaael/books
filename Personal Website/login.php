<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_signup";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ussername = $_POST['ussername'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE ussername = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ussername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['ussername'] = $user['ussername'];
            $_SESSION['full_name'] = $user['full_name'];
            
            $user_id = $user['id'];
            $_SESSION['user_id'] = $user_id;

            if ($user['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: profile.php");
            }
            exit();
        } else {
            $message = "Password salah.";
        }
    } else {
        $message = "Nama pengguna tidak ditemukan.";
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
    <title>Login - Bookshelf Website</title>
    <link rel="shortcut icon" href="img/icon-2.png" type="image/x-icon">
</head>
<body>
<?php include "page/header.html";?>
<?php include "page/login.html";?>
<?php include "page/footer.html";?>
</body>
</html>
