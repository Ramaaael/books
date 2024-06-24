CREATE DATABASE users_signup;

USE users_signup;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mobile_or_email VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    ussername VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM(admin,user) DEFAULT user,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    date date NOT NULL UNIQUE,
    is_complete boolean NOT NULL,
     FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE users_img (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_file VARCHAR(255) NOT NULL,
   tipe_file VARCHAR(255) NOT NULL,
    ukuran_file INT NOT NULL UNIQUE,
    data_gambar longblob NOT NULL,
    tanggal_upload datetime CURRENT_TIMESTAMP ADJUST
);
