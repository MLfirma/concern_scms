<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Default filter (ipakita lahat)
$filter = isset($_GET['status']) ? $_GET['status'] : 'All';

if ($filter == 'All') {
    $sql = "SELECT * FROM concerns ORDER BY created_at DESC";
} else {
    $sql = "SELECT * FROM concerns WHERE status = '$filter' ORDER BY created_at DESC";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Concerns | ConcernHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { background: #121212; font-family: 'Poppins', sans-serif; color: white; display: flex; }
        .sidebar { width: 250px; background: #1a1a1a; height: 100vh; position: fixed; border-right: 1px solid #d4af37; padding: 20px; }
        .sidebar h2 { color: #d4af37; font-weight: 700; text-align: center; margin-bottom: 40px; }
        .sidebar a { color: #888; text-decoration: none; display: block; padding: 12px; border-radius: 10px; margin-bottom: 10px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: rgba(212, 175, 55, 0.1); color: #d4af37; }
        .main-content { margin-left: 250px; padding: 40px; width: 100%; }
        .filter-btn { border-radius: 20px; padding: 5px 20px; font-size: 0.9rem; margin-right: 10px; border: 1px solid #444; color: #888; text-decoration: none; }
        .filter-btn.active { background: #d4af37; color: #000; border-color: #d4af37; }
        .table-container { background: #ffffff; border-radius: 15px; padding: 20px; margin-top: 20px; color: #333; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>CONCERNHUB</h2>
    <a href="dashboard.php"><i class="fas fa-th-large me-2"></i> Dashboard</a>
    <a href="manage_concerns.php" class="active"><i class="fas fa-tasks me-2"></i> Manage Concerns</a>
    <a href="export.php"><i class="fas fa-file-export me-2"></i> Export Reports</a>
    <hr style="border-color: #333;">
    <a href="../logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
</div>

<div class="main-content">
    <h1 class="fw-bold">Manage Concerns</h1>
    <div class="mt-4 mb-4">
        <a href="manage_concerns.php?status=All" class="filter-btn <?php echo ($filter == 'All') ? 'active' : ''; ?>">All</a>
        <a href="manage_concerns.php?status=Submitted" class="filter-btn <?php echo ($filter == 'Submitted') ? 'active' : ''; ?>">Submitted</a>
        <a href="manage_concerns.php?status=Pending" class="filter-btn <?php echo ($filter == 'Pending') ? 'active' : ''; ?>">Pending</a>
        <a href="manage_concerns.php?status=Resolved" class="filter-btn <?php echo ($filter == 'Resolved') ? 'active' : ''; ?>">Resolved</a>
    </div>

    <div class="table-container shadow">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Student Email</th>
                    <th>Status</th>
                    <th>Action Taken</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="fw-bold text-warning">#<?php echo $row['id']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td class="small"><?php echo $row['student_email']; ?></td>
                    <td><span class="badge bg-dark"><?php echo $row['status']; ?></span></td>
                    <td class="small text-muted"><?php echo $row['action_taken'] ?: 'No action yet'; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>