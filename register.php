<?php
include 'connect.php'; // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO users (full_name, email, username, password) VALUES ('$full_name', '$email', '$username', '$password')";
    if ($conn->query($query)) {
        echo "Registrasi berhasil! <a href='login.php'>Login sekarang</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .registration-form {
            display: flex;
            flex-direction: column;
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px; /* Memberikan jarak dari atas halaman */
        }
        .registration-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }
        .registration-form label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #495057;
        }
        .registration-form input {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .registration-form button {
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .registration-form button:hover {
            background-color: #0056b3;
        }
        .registration-form p {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="registration-form">
    <h2>Registrasi</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="full_name">Nama Lengkap:</label>
            <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Nama Lengkap" required>
        </div>

        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
        </div>

        <div class="mb-3">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="mb-3">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        </div>

        <div class="text-center"> <!-- Membungkus tombol dengan div untuk memusatkannya -->
            <button type="submit" class="btn btn-success">Registrasi</button>
        </div>
    </form>

    <p>
        Sudah punya akun? <a href="login.php">Login</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
