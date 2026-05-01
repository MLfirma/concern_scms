<?php
include 'config.php';

$message = "";
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $message = "<div class='alert alert-success bg-dark text-success border-success text-center small'>Concern submitted successfully! Please check your email for updates.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConcernHub | Submit Your Concern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0b0b0b;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .submit-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }
        .card-custom {
            background-color: #1a1a1a;
            border: 2px solid #d4af37;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .gold-text {
            color: #d4af37;
            letter-spacing: 2px;
            font-weight: bold;
        }
        .form-control, .form-select {
            background-color: #262626 !important;
            border: 1px solid #444 !important;
            color: white !important;
            margin-bottom: 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #d4af37 !important;
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.5);
        }
        .btn-submit {
            background-color: #d4af37;
            color: #000;
            font-weight: bold;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn-submit:hover {
            background-color: #b8962d;
            transform: translateY(-2px);
        }
        .link-footer {
            color: #888;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }
        .link-footer:hover {
            color: #d4af37;
        }
        ::placeholder {
            color: #666 !important;
        }
    </style>
</head>
<body>

<div class="submit-container">
    <?php echo $message; ?>
    
    <div class="card-custom">
        <h2 class="text-center gold-text mb-4">CONCERNHUB</h2>
        
        <form action="submit_save.php" method="POST">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Gmail Address (e.g. name@gmail.com)" required>
            </div>
            
            <div class="mb-3">
                <select name="category" class="form-select" required>
                    <option value="" disabled selected>Select Category</option>
                    <option value="Academic">Academic</option>
                    <option value="Financial">Financial</option>
                    <option value="Welfare">Student Welfare</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            
            <div class="mb-3">
                <input type="text" name="program" class="form-control" placeholder="Program (e.g. BSIT)" required>
            </div>
            
            <div class="mb-3">
                <textarea name="description" class="form-control" rows="4" placeholder="Describe your concern briefly..." required></textarea>
            </div>
            
            <button type="submit" name="submit_concern" class="btn-submit">SUBMIT CONCERN</button>
        </form>

        <div class="mt-4 text-center">
            <!-- Link para sa Track Status -->
            <a href="track_status.php" class="link-footer d-block mb-2">Track your existing request status</a>
            <hr style="border-color: #333;">
            <a href="login.php" class="link-footer">Admin Login</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>