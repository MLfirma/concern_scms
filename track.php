<?php
include 'config.php';

$concern = null;
$error = "";

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM concerns WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $concern = $result->fetch_assoc();
    } else {
        $error = "Reference ID not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track Status | ConcernHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #121212; color: white; font-family: 'Poppins', sans-serif; display: flex; align-items: center; min-height: 100vh; }
        .track-card { background: #1e1e1e; border: 1px solid #d4af37; border-radius: 20px; padding: 30px; margin: auto; max-width: 500px; width: 100%; }
        .progress { height: 10px; background: #333; border-radius: 5px; }
        .progress-bar { background: #d4af37; }
    </style>
</head>
<body>

<div class="track-card shadow">
    <h2 class="text-center fw-bold mb-4" style="color: #d4af37;">TRACK STATUS</h2>
    
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="id" class="form-control bg-dark text-white border-secondary" placeholder="Enter Reference ID" required>
            <button class="btn btn-warning fw-bold" type="submit">SEARCH</button>
        </div>
    </form>

    <?php if ($error): ?>
        <div class="alert alert-danger text-center small"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($concern): ?>
        <div class="p-3 border border-secondary rounded">
            <h6 class="text-white-50">Department: <span class="text-white"><?php echo $concern['department']; ?></span></h6>
            <h5 class="fw-bold">Status: <span class="text-warning"><?php echo $concern['status']; ?></span></h5>
            
            <div class="mt-4">
                <div class="progress mb-2">
                    <?php 
                        $p = 20; // Submitted
                        if($concern['status'] == 'Routed') $p = 40;
                        if($concern['status'] == 'Read') $p = 60;
                        if($concern['status'] == 'Screened') $p = 80;
                        if($concern['status'] == 'Resolved') $p = 100;
                    ?>
                    <div class="progress-bar" style="width: <?php echo $p; ?>%"></div>
                </div>
                <div class="d-flex justify-content-between small text-white-50">
                    <span>Submitted</span>
                    <span>Read</span>
                    <span>Resolved</span>
                </div>
            </div>

            <hr class="border-secondary">
            <p class="small mb-1 text-white-50">Action Taken:</p>
            <p class="small"><?php echo $concern['action_taken'] ?: 'Admin is currently reviewing your concern.'; ?></p>
        </div>
    <?php endif; ?>
    
    <div class="text-center mt-4">
        <a href="index.php" class="text-white-50 small text-decoration-none">← Back to Home</a>
    </div>
</div>

</body>
</html>