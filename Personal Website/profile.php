<?php
session_start();

if (!isset($_SESSION['ussername'])) {
    header("Location: login.php");
    exit();
}

$full_name = $_SESSION['full_name'];
$ussername = $_SESSION['ussername'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_signup";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fungsi untuk menghapus buku
if(isset($_POST['delete_book'])) {
    $book_id = $_POST['delete_book'];
    $delete_sql = "DELETE FROM books WHERE id = '$book_id' AND user_id = '$user_id'";
    if ($conn->query($delete_sql) === TRUE) {
        // Redirect untuk memuat kembali halaman setelah menghapus buku
        header("Location: profile.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fungsi untuk memindahkan buku ke daftar selesai atau belum selesai
if(isset($_POST['move_book'])) {
    $book_id = $_POST['move_book'];
    $is_complete = $_POST['is_complete'];
    $move_sql = "UPDATE books SET is_complete = '$is_complete' WHERE id = '$book_id' AND user_id = '$user_id'";
    if ($conn->query($move_sql) === TRUE) {
        // Redirect untuk memuat kembali halaman setelah memindahkan buku
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fungsi untuk menghapus semua buku
if(isset($_POST['delete_all_books'])) {
    $delete_all_sql = "DELETE FROM books WHERE user_id = '$user_id'";
    if ($conn->query($delete_all_sql) === TRUE) {
        // Redirect untuk memuat kembali halaman setelah menghapus semua buku
        header("Location: profile.php");
        exit();
    } else {
        echo "Error deleting all records: " . $conn->error;
    }
}

$sql = "SELECT * FROM books WHERE user_id = '$user_id'";
$result = $conn->query($sql);

$complete_books = array();
$not_complete_books = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['is_complete'] == 1) {
            $complete_books[] = $row;
        } else {
            $not_complete_books[] = $row;
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
    <title>Profile - Bookshelf Website</title>
    <link rel="stylesheet" href="layout/profile.css">
    <link rel="shortcut icon" href="img/icon-2.png" type="image/x-icon">
</head>
<body>
    <?php include "page/header-ds.html"; ?>
    <section class="sec-1">
        <h2 class="p-dash">Selamat datang, <?php echo htmlspecialchars($full_name); ?>!</h2>
        <form action="" class="form-1">
            <center><h2>Dashboard <span class="head-pos">Bookshelf</span></h2></center>
            <div class="book-list-container">
                <div class="form-finish">
                    <h4 class="tag-books">Selesai</h4>
                    <div id="complete-books" class="book-list">
                        <?php foreach ($complete_books as $book) : ?>
                            <div class="book-item">
                                <h3> Judul : <?php echo htmlspecialchars($book['title']); ?> </h3>
                                <p>Penulis : <?php echo htmlspecialchars($book['author']); ?></p>
                                <p>Tanggal : <?php echo htmlspecialchars($book['date']); ?></p>
                                <!-- Tombol untuk menghapus buku -->
                                <div class="btn"> 
                                <form action="" method="post">
                                    <input type="hidden" name="delete_book" value="<?php echo $book['id']; ?>">
                                    <input type="submit" value="Hapus" class="btn-remove">
                                </form>
                                <!-- Tombol untuk memindahkan buku ke belum selesai -->
                                <form action="" method="post">
                                    <input type="hidden" name="move_book" value="<?php echo $book['id']; ?>">
                                    <input type="hidden" name="is_complete" value="0">
                                    <input type="submit" value="Belum Selesai" class="btn-move">
                                </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="form-not">
                    <h4 class="tag-books">Belum Selesai</h4>
                    <div id="not-complete-books" class="book-list">
                        <?php foreach ($not_complete_books as $book) : ?>
                            <div class="book-item">
                                <h3> Judul : <?php echo htmlspecialchars($book['title']); ?> </h3>
                                <p>Penulis : <?php echo htmlspecialchars($book['author']); ?></p>
                                <p>Tanggal : <?php echo htmlspecialchars($book['date']); ?></p>
                                <!-- Tombol untuk menghapus buku -->
                                <div class="btn"> 
                                <form action="" method="post" class="form-btn">
                                    <input type="hidden" name="delete_book" value="<?php echo $book['id']; ?>">
                                    <input type="submit" value="Hapus" class="btn-remove">
                                </form>
                                <!-- Tombol untuk memindahkan buku ke selesai -->                                   
                                    <form action="" method="post" class="form-btn">
                                    <input type="hidden" name="move_book" value="<?php echo $book['id']; ?>">
                                    <input type="hidden" name="is_complete" value="1">
                                    <input type="submit" value="Selesai" class="btn-move">
                                </form>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </form>

    <!-- Tombol untuk menghapus semua buku -->
    <center>
    <form action="" method="post">
        <input type="hidden" name="delete_all_books">
        <input type="submit" value="Hapus Semua Buku" class="remove-all">
    </form>
    </center>

    </section>
</body>
</html>
