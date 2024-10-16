<?php
session_start();
include 'connect.php'; // Menghubungkan ke database

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Menambahkan to-do baru ke tabel pending
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['todo_text'])) {
    $todo_text = $_POST['todo_text'];
    $deadline = $_POST['deadline'];

    // Simpan to-do dengan deadline ke database
    $query = "INSERT INTO pending_todos (user_id, todo_text, deadline) VALUES ('$user_id', '$todo_text', '$deadline')";
    $conn->query($query);

    // Redirect ke halaman yang sama
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Memindahkan to-do dari tabel pending ke tabel complete
if (isset($_POST['todo_id'])) {
    $todo_id = $_POST['todo_id'];

    // Mengambil data to-do dari tabel pending
    $query = "SELECT * FROM pending_todos WHERE id='$todo_id' AND user_id='$user_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $todo = $result->fetch_assoc();

        // Memasukkan ke tabel completed
        $insert_query = "INSERT INTO completed_todos (user_id, todo_text) VALUES ('$user_id', '{$todo['todo_text']}')";
        $conn->query($insert_query);

        // Menghapus dari tabel pending
        $delete_query = "DELETE FROM pending_todos WHERE id='$todo_id'";
        $conn->query($delete_query);
    }

    // Redirect ke halaman yang sama
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Menghapus to-do yang sudah selesai satu per satu
if (isset($_POST['delete_todo_id'])) {
    $delete_todo_id = $_POST['delete_todo_id'];

    // Menghapus dari tabel completed
    $delete_query = "DELETE FROM completed_todos WHERE id='$delete_todo_id' AND user_id='$user_id'";
    $conn->query($delete_query);

    // Redirect ke halaman yang sama
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Menghapus semua to-do yang sudah selesai
if (isset($_POST['delete_all_completed'])) {
    // Menghapus semua data dari tabel completed untuk user saat ini
    $delete_all_query = "DELETE FROM completed_todos WHERE user_id='$user_id'";
    $conn->query($delete_all_query);

    // Redirect ke halaman yang sama
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Mengambil to-do list yang masih pending
$pending_query = "SELECT * FROM pending_todos WHERE user_id='$user_id'";
$pending_todos = $conn->query($pending_query);

// Mengambil to-do list yang sudah selesai
$completed_query = "SELECT * FROM completed_todos WHERE user_id='$user_id'";
$completed_todos = $conn->query($completed_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Link ke file CSS eksternal -->
</head>
<body>
    <div class="container mt-5">
        <h1>Dashboard</h1>

        <!-- Form untuk menambahkan to-do baru -->
        <form action="" method="POST" class="mb-4">
            <div class="mb-3">
                <label for="todo_text" class="form-label">To-Do:</label>
                <input type="text" name="todo_text" id="todo_text" class="form-control" placeholder="Masukkan to-do" required>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline:</label>
                <input type="date" name="deadline" id="deadline" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>

        <h2>To-Do List Anda (Pending)</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>To-Do List</th>
                    <th>Deadline</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; ?>
                <?php while ($todo = $pending_todos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td style="word-wrap: break-word; max-width: 200px;">
                            <?php echo htmlspecialchars($todo['todo_text']); ?>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($todo['deadline'])); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
                                <button type="submit" class="btn btn-success btn-sm">Selesai</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Completed To-Do List</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>To-Do List</th>
                    <th>Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; ?>
                <?php while ($todo = $completed_todos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td style="word-wrap: break-word; max-width: 200px;">
                            <span style="text-decoration: line-through;"><?php echo htmlspecialchars($todo['todo_text']); ?></span>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($todo['completed_at'])); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_todo_id" value="<?php echo $todo['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Tombol untuk menghapus semua to-do yang sudah selesai -->
        <form method="POST" class="mt-3">
            <button type="submit" name="delete_all_completed" class="btn btn-danger">Delete All Completed</button>
        </form>

        <a href="logout.php" class="btn btn-secondary mt-3">Logout</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
