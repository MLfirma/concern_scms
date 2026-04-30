<?php 
session_start();
include 'config.php'; 

$error = "";

// Kapag pinindot ang Log In button
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Hahanapin ang user sa database base sa email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // I-verify ang password gamit ang password_verify (dahil naka-hash ito sa register)
        if (password_verify($password, $user['password'])) {
            // I-save ang user info sa Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect sa admin dashboard
            header("Location: admin/dashboard.php");
            exit();
        } else {
            $error = "Maling password. Pakisubukang muli.";
        }
    } else {
        $error = "Hindi mahanap ang email na iyan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ConcernHub</title>
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
        .login-card {
            background-color: #1e1e1e;
            border: 1px solid #d4af37;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }
        .form-control {
            background-color: #2a2a2a;
            border: 1px solid #444;
            color: #fff;
            border-radius: 10px;
            padding: 12px;
        }
        .form-control:focus {
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
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <h2 class="fw-bold" style="color: #d4af37;">CONCERNHUB</h2>
        <p class="text-white-50">Admin & Staff Access</p>
    </div>

    <?php if($error != ""): ?>
        <div class="alert alert-danger py-2 small text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label small text-white-50">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="admin@example.com" required>
        </div>
        <div class="mb-4">
            <label class="form-label small text-white-50">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        
        <button type="submit" class="btn btn-gold">LOG IN</button>
        
        <div class="text-center mt-4">
            <a href="index.php" class="text-white-50 small text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i> Back to Home
            </a>
        </div>
    </form>
</div>

</body>
</html>