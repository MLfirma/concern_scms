<?php
session_start();
include '../config.php';

// Proteksyon sa Access
if (!isset($_SESSION['role'])) { header("Location: ../login.php"); exit(); }

$role = $_SESSION['role'];
$dept = mysqli_real_escape_string($conn, $_SESSION['department']);
$admin_name = $_SESSION['admin_name'];

// --- 1. STATISTICS COUNTERS ---
$count_academic = $conn->query("SELECT id FROM concerns WHERE assigned_department = 'academic'")->num_rows;
$count_welfare  = $conn->query("SELECT id FROM concerns WHERE assigned_department = 'welfare'")->num_rows;
$count_finance  = $conn->query("SELECT id FROM concerns WHERE assigned_department = 'finance'")->num_rows;

$count_pending  = $conn->query("SELECT id FROM concerns WHERE status = 'Submitted'")->num_rows;
$count_resolved = $conn->query("SELECT id FROM concerns WHERE status = 'Resolved'")->num_rows;
$count_rejected = $conn->query("SELECT id FROM concerns WHERE status = 'Rejected'")->num_rows;

// --- 2. SQL QUERY BASED ON ROLE ---
if ($role == 'admin') {
    $sql = "SELECT * FROM concerns ORDER BY created_at DESC";
} else {
    $sql = "SELECT * FROM concerns WHERE assigned_department LIKE '%$dept%' ORDER BY created_at DESC";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConcernHub | Admin Dashboard</title>
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

    <style>
        body { background: #0b0b0b; color: #ffffff; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #1a1a1a; border-bottom: 2px solid #d4af37; padding: 1rem 2rem; }
        .gold-text { color: #d4af37; }
        .stat-card { background: #161616; border: 1px solid #333; border-radius: 12px; padding: 15px; transition: 0.3s; }
        .stat-card:hover { border-color: #d4af37; }
        .btn-gold { background: #d4af37 !important; color: #000 !important; font-weight: bold !important; border: none !important; }
        .btn-outline-gold { border: 1px solid #d4af37 !important; color: #d4af37 !important; background: transparent; }
        .btn-outline-gold:hover { background: #d4af37; color: #000; }
        
        /* DataTables Custom Gold Theme */
        .dt-buttons .btn { background: #d4af37 !important; color: #000 !important; font-weight: bold; margin-right: 5px; border-radius: 5px; font-size: 12px; }
        .dataTables_filter input { background: #262626 !important; color: white !important; border: 1px solid #444 !important; border-radius: 5px; }
        .table-dark { background: #1a1a1a !important; border: 1px solid #333; }
        
        /* Modal & History Styles */
        .modal-content { background: #1a1a1a; border: 2px solid #d4af37; color: white; border-radius: 15px; }
        .history-box { background: #000; padding: 15px; border-radius: 8px; border: 1px solid #333; max-height: 250px; overflow-y: auto; }
        .history-line { border-left: 2px solid #d4af37; padding-left: 15px; position: relative; margin-bottom: 20px; }
        .history-line::before { content: ''; position: absolute; left: -6px; top: 0; width: 10px; height: 10px; background: #d4af37; border-radius: 50%; }
        .form-control, .form-select { background: #262626 !important; color: white !important; border: 1px solid #444 !important; }
    </style>
</head>
<body>

<nav class="navbar d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-0 gold-text"><?php echo ($role == 'admin') ? "SUPER ADMIN PANEL" : strtoupper($dept) . " PANEL"; ?></h4>
        <small class="text-secondary"><?php echo date('l, F j, Y'); ?></small>
    </div>
    <div class="text-end">
        <span class="d-block small">Welcome, <strong><?php echo $admin_name; ?></strong></span>
        <a href="../logout.php" class="btn btn-outline-danger btn-sm mt-1">Logout</a>
    </div>
</nav>

<div class="container-fluid px-4 mt-4">
    <!-- STATS CARDS -->
    <div class="row g-3 mb-4 text-center">
        <div class="col-md-3">
            <div class="stat-card">
                <small class="text-secondary text-uppercase">Routing Status</small>
                <div class="d-flex justify-content-around mt-2 small">
                    <span>ACAD: <strong><?php echo $count_academic; ?></strong></span>
                    <span>WELF: <strong><?php echo $count_welfare; ?></strong></span>
                    <span>FIN: <strong><?php echo $count_finance; ?></strong></span>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card border-warning text-warning">
                <small class="text-uppercase">Pending</small>
                <h3><?php echo $count_pending; ?></h3>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card border-success text-success">
                <small class="text-uppercase">Resolved</small>
                <h3><?php echo $count_resolved; ?></h3>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stat-card border-danger text-danger">
                <small class="text-uppercase">Rejected</small>
                <h3><?php echo $count_rejected; ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-warning text-dark">
                <small class="text-uppercase fw-bold">Grand Total</small>
                <h3><?php echo ($count_pending + $count_resolved + $count_rejected); ?></h3>
            </div>
        </div>
    </div>

    <!-- MAIN TABLE -->
    <div class="table-responsive bg-dark p-4 rounded border border-secondary shadow">
        <table id="reportsTable" class="table table-dark table-hover align-middle mb-0">
            <thead class="text-secondary small">
                <tr>
                    <th>ID</th>
                    <th>DATE SUBMITTED</th>
                    <th>CATEGORY</th>
                    <th>STATUS</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="fw-bold gold-text">#<?php echo $row['id']; ?></td>
                    <td class="small"><?php echo date('M d, Y | h:i A', strtotime($row['created_at'])); ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td>
                        <?php 
                            $badge = "bg-warning text-dark";
                            if($row['status'] == 'Resolved') $badge = "bg-success";
                            if($row['status'] == 'Rejected') $badge = "bg-danger";
                        ?>
                        <span class="badge <?php echo $badge; ?>"><?php echo strtoupper($row['status']); ?></span>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-outline-gold btn-sm me-1" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $row['id']; ?>">VIEW</button>
                        <button class="btn btn-gold btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $row['id']; ?>">UPDATE</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODALS GENERATOR -->
<?php 
$result->data_seek(0);
while($row = $result->fetch_assoc()): 
?>

<!-- 1. VIEW HISTORY MODAL -->
<div class="modal fade" id="viewModal<?php echo $row['id']; ?>" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-secondary">
                <h5 class="modal-title gold-text">Ticket Information: #<?php echo $row['id']; ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4 text-center small">
                    <div class="col-4 border-end border-secondary"><span class="text-secondary">Office</span><br><strong><?php echo strtoupper($row['assigned_department'] ?? 'TBD'); ?></strong></div>
                    <div class="col-4 border-end border-secondary"><span class="text-secondary">Current Status</span><br><strong class="gold-text"><?php echo $row['status']; ?></strong></div>
                    <div class="col-4"><span class="text-secondary">Date Filed</span><br><strong><?php echo date('M d, Y', strtotime($row['created_at'])); ?></strong></div>
                </div>
                
                <h6 class="gold-text mb-3">Timeline of Activity</h6>
                <div class="history-box">
                    <div class="history-line">
                        <small class="text-warning fw-bold">STUDENT FILING</small>
                        <p class="mb-0 small"><?php echo $row['description']; ?></p>
                    </div>

                    <?php if(!empty($row['admin_remarks'])): ?>
                    <div class="history-line">
                        <small class="text-warning fw-bold">ADMIN INSTRUCTIONS</small>
                        <p class="mb-0 small italic">"<?php echo $row['admin_remarks']; ?>"</p>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($row['action_taken'])): ?>
                    <div class="history-line" style="border-color: #0dcaf0;">
                        <small class="text-info fw-bold">OFFICE RESOLUTION</small>
                        <p class="mb-0 small"><?php echo $row['action_taken']; ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close View</button>
            </div>
        </div>
    </div>
</div>

<!-- 2. UPDATE MODAL -->
<div class="modal fade" id="updateModal<?php echo $row['id']; ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <form action="update_status.php" method="POST">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title gold-text">Update Concern #<?php echo $row['id']; ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    
                    <?php if($role == 'admin'): ?>
                        <div class="mb-3">
                            <label class="form-label small">Route To Office:</label>
                            <select name="assigned_department" class="form-select">
                                <option value="academic" <?php echo ($row['assigned_department'] == 'academic') ? 'selected' : ''; ?>>Academic</option>
                                <option value="finance" <?php echo ($row['assigned_department'] == 'finance') ? 'selected' : ''; ?>>Finance</option>
                                <option value="welfare" <?php echo ($row['assigned_department'] == 'welfare') ? 'selected' : ''; ?>>Student Welfare</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Admin Remarks:</label>
                            <textarea name="admin_remarks" class="form-control" rows="2"><?php echo $row['admin_remarks']; ?></textarea>
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <label class="form-label small text-info">Official Action Taken:</label>
                            <textarea name="action_taken" class="form-control" rows="3" required><?php echo $row['action_taken']; ?></textarea>
                        </div>
                    <?php endif; ?>

                    <div class="mb-2">
                        <label class="form-label small">Final Status:</label>
                        <select name="status" class="form-select">
                            <option value="Submitted" <?php echo ($row['status'] == 'Submitted') ? 'selected' : ''; ?>>Submitted</option>
                            <option value="Routed" <?php echo ($row['status'] == 'Routed') ? 'selected' : ''; ?>>Routed</option>
                            <option value="Resolved" <?php echo ($row['status'] == 'Resolved') ? 'selected' : ''; ?>>Resolved</option>
                            <option value="Rejected" <?php echo ($row['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="submit" class="btn btn-gold w-100">SAVE UPDATES</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endwhile; ?>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables Core & Extensions -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#reportsTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csvHtml5',
                text: 'EXPORT CSV',
                className: 'btn btn-gold btn-sm',
                exportOptions: { columns: [0, 1, 2, 3] }
            },
            {
                extend: 'pdfHtml5',
                text: 'EXPORT PDF',
                className: 'btn btn-gold btn-sm',
                exportOptions: { columns: [0, 1, 2, 3] },
                customize: function (doc) {
                    doc.content[1].table.widths = ['10%', '35%', '35%', '20%'];
                }
            },
            {
                extend: 'print',
                text: 'PRINT',
                className: 'btn btn-gold btn-sm',
                exportOptions: { columns: [0, 1, 2, 3] }
            }
        ],
        "order": [[ 0, "desc" ]],
        "pageLength": 10
    });
});
</script>

</body>
</html>