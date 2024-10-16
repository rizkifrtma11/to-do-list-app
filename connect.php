<?php
$host = 'yourdbserver';
$username = 'yourusername';
$password = 'yourpassword';
$database = 'yourdb';

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
