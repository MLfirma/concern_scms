<?php
session_start();
include '../config.php'; 

// Query para makuha ang lahat ng concerns
$sql = "SELECT * FROM concerns ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | ConcernHub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #121212; color: white; font-family: 'Segoe UI', sans-serif; }
        .sidebar { width: 250px; height: 100vh; background: #000; position: fixed; border-right: 1px solid #d4af37; }
        .main-content { margin-left: 250px; padding: 20px; }
        .card-table { background: #1e1e1e; border: 1px solid #333; border-radius: 10px; padding: 20px; }
        .table { color: white; }
        .table thead { background: #000; color: #d4af37; border-bottom: 2px solid #d4af37; }
        .btn-gold { background: #d4af37; color: black; font-weight: bold; border: none; }
        .btn-gold:hover { background: #b8962e; }
        .modal-content { background: #1e1e1e; color: white; border: 1px solid #d4af37; }
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; }
    </style>
</head>
<body>

<div class="sidebar p-3">
    <h3 class="text-center" style="color: #d4af37;">CONCERN<span style="color:white;">HUB</span></h3>
    <hr style="background: #d4af37;">
    <ul class="nav flex-column">
        <li class="nav-item"><a href="dashboard.php" class="nav-link text-white">Dashboard</a></li>
        <li class="nav-item"><a href="manage_concerns.php" class="nav-link text-white">Manage</a></li>
        <li class="nav-item mt-5"><a href="../logout.php" class="nav-link text-danger">Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>SLA Monitoring Dashboard</h2>
        <span class="badge bg-success">System Active</span>
    </div>

    <div class="card-table">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Dept / Program</th>
                    <th>Student Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td><b><?php echo $row['department']; ?></b><br><small><?php echo $row['program']; ?></small></td>
                    <td><?php echo $row['student_email']; ?></td>
                    <td><span class="status-badge bg-secondary"><?php echo $row['status']; ?></span></td>
                    <td>
                        <button class="btn btn-sm btn-gold" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $row['id']; ?>">Update</button>
                    </td>
                </tr>

                <div class="modal fade" id="updateModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Concern Details #<?php echo $row['id']; ?></h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>From:</strong> <?php echo $row['student_email']; ?></p>
                                <p><strong>Concern:</strong></p>
                                <div style="background: #2a2a2a; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                                    <?php echo nl2br($row['description']); ?>
                                </div>

                                <form action="update_status.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Update Status:</label>
                                        <select name="status" class="form-select">
                                            <option value="Submitted" <?php if($row['status']=='Submitted') echo 'selected'; ?>>Submitted</option>
                                            <option value="Routed" <?php if($row['status']=='Routed') echo 'selected'; ?>>Routed</option>
                                            <option value="Resolved" <?php if($row['status']=='Resolved') echo 'selected'; ?>>Resolved</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Action Taken:</label>
                                        <textarea name="action_taken" class="form-control" rows="3" placeholder="Isulat ang hakbang na ginawa..."><?php echo $row['action_taken']; ?></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-gold w-100 mb-2">Save Changes</button>
                                </form>

                                <hr style="background: #444;">
                                <form action="delete_concern.php" method="POST" onsubmit="return confirm('Sigurado ka bang i-re-reject at buburahin ang concern na ito?');">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger w-100">Reject / Delete Concern</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>