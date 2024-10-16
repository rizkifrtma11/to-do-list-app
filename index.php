<?php
session_start();
include 'connect.php'; // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Password salah!</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Username tidak ditemukan!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .login-form {
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
        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }
        .login-form label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #495057;
        }
        .login-form input {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .login-form button {
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-form button:hover {
            background-color: #0056b3;
        }
        .login-form p {
            text-align: center;
            margin-top: 15px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-form">
    <h2>Login</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="mb-3">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>

    <p>
        Belum punya akun? <a href="register.php">Daftar</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
