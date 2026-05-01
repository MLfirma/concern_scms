<?php
include 'config.php';

$search_results = null;
$email_input = "";

if (isset($_POST['track'])) {
    $email_input = mysqli_real_escape_string($conn, $_POST['email']);
    $sql = "SELECT * FROM concerns WHERE email = '$email_input' ORDER BY created_at DESC";
    $search_results = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ConcernHub | Track My Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0b0b0b; color: white; font-family: 'Segoe UI', sans-serif; }
        .container { max-width: 900px; margin-top: 50px; }
        .card-track { background: #1a1a1a; border: 2px solid #d4af37; border-radius: 15px; padding: 30px; }
        .gold-text { color: #d4af37; }
        .table-dark { background: #1a1a1a !important; }
        .btn-gold { background: #d4af37; color: black; font-weight: bold; border: none; }
        .modal-content { background: #1a1a1a; border: 1px solid #d4af37; color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="card-track shadow-lg">
        <h2 class="text-center gold-text mb-4">TRACK YOUR CONCERN</h2>
        
        <form method="POST" class="mb-5">
            <div class="input-group">
                <input type="email" name="email" class="form-control bg-dark text-white border-secondary" 
                       placeholder="Enter your registered Gmail address" value="<?php echo $email_input; ?>" required>
                <button class="btn btn-gold px-4" type="submit" name="track">TRACK NOW</button>
            </div>
        </form>

        <?php if ($search_results): ?>
            <?php if ($search_results->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr class="text-secondary small">
                                <th>TICKET ID</th>
                                <th>CATEGORY</th>
                                <th>STATUS</th>
                                <th>DATE</th>
                                <th class="text-end">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $search_results->fetch_assoc()): ?>
                            <tr>
                                <td class="gold-text fw-bold">#<?php echo $row['id']; ?></td>
                                <td><?php echo $row['category']; ?></td>
                                <td>
                                    <?php 
                                        $badge = "bg-warning text-dark";
                                        if($row['status'] == 'Resolved') $badge = "bg-success";
                                        if($row['status'] == 'Rejected') $badge = "bg-danger";
                                        if($row['status'] == 'Cancelled') $badge = "bg-secondary";
                                    ?>
                                    <span class="badge <?php echo $badge; ?>"><?php echo strtoupper($row['status']); ?></span>
                                </td>
                                <td class="small"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                <td class="text-end">
                                    <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $row['id']; ?>">VIEW</button>
                                    
                                    <?php if($row['status'] == 'Submitted'): ?>
                                        <a href="cancel_request.php?id=<?php echo $row['id']; ?>&email=<?php echo $email_input; ?>" 
                                           class="btn btn-outline-danger btn-sm" 
                                           onclick="return confirm('Are you sure you want to cancel this request?')">CANCEL</a>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- VIEW MODAL FOR STUDENT -->
                            <div class="modal fade" id="viewModal<?php echo $row['id']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title gold-text">Request Details #<?php echo $row['id']; ?></h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong class="text-secondary">Your Message:</strong><br><?php echo $row['description']; ?></p>
                                            <hr class="border-secondary">
                                            <p><strong class="text-info">Office Update:</strong><br>
                                            <?php echo !empty($row['action_taken']) ? $row['action_taken'] : "Waiting for office response..."; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-danger bg-dark text-danger border-danger text-center">No concerns found for this email.</div>
            <?php endif; ?>
        <?php endif; ?>
        
        <div class="text-center mt-4">
            <a href="index.php" class="text-secondary small">Back to Submission Form</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>