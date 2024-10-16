<?php
$host = 'localhost';
$username = 'root';
$password = 'Rizki2024@@';
$database = 'todolistapp';

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
