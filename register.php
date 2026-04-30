<?php 
include 'config.php'; 

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    // Hashing the password for security
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role = $_POST['role'];
    $department = $_POST['department'];

    // SQL query para ipasok ang data sa 'users' table mo
    $sql = "INSERT INTO users (name, email, password, role, department) 
            VALUES ('$name', '$email', '$password', '$role', '$department')";

    if ($conn->query($sql) === TRUE) {
        $message = "success";
    } else {
        $message = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | ConcernHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at center, #1a1a1a 0%, #000000 100%);
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .register-card {
            background-color: #1e1e1e;
            border: 1px solid #d4af37;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }
        .form-label { color: #d4af37; font-weight: 500; }
        .form-control, .form-select {
            background-color: #2a2a2a;
            border: 1px solid #444;
            color: #fff;
            border-radius: 10px;
        }
        .form-control:focus, .form-select:focus {
            background-color: #2a2a2a;
            color: #fff;
            border-color: #d4af37;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
        }
        .btn-gold {
            background: linear-gradient(45deg, #d4af37, #f2d06b);
            color: #000;
            font-weight: 700;
            border: none;
            padding: 12px;
            border-radius: 10px;
            width: 100%;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn-gold:hover {
            background: linear-gradient(45deg, #b8860b, #d4af37);
            transform: translateY(-2px);
        }
        .alert { border-radius: 10px; }
    </style>
</head>
<body>

<div class="register-card">
    <div class="text-center mb-4">
        <h2 class="fw-bold" style="color: #d4af37;">CONCERNHUB</h2>
        <p class="text-white-50">Create Admin or Staff Account</p>
    </div>

    <?php if($message == "success"): ?>
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle me-2"></i> Account Created! <a href="index.php" class="fw-bold">Login here</a>
        </div>
    <?php elseif($message == "error"): ?>
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-triangle me-2"></i> Error: <?php echo $conn->error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" placeholder="Juan Dela Cruz" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="juan@example.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Department</label>
                <input type="text" name="department" class="form-control" placeholder="IT Dept" required>
            </div>
        </div>
        <button type="submit" class="btn btn-gold text-uppercase">Register Account</button>
        <div class="text-center mt-3">
            <a href="index.php" class="text-white-50 small text-decoration-none">Already have an account? Back to Home</a>
        </div>
    </form>
</div>

</body>
</html>