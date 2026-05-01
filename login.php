<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['role'] = $user['role'];
        $_SESSION['department'] = $user['department'];
        $_SESSION['admin_name'] = $user['name'];
        header("Location: admin/dashboard.php");
    } else {
        echo "<script>alert('Invalid Credentials');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ConcernHub | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #000; color: #fff; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: #1a1a1a; border: 2px solid #d4af37; padding: 30px; border-radius: 10px; width: 350px; }
        .btn-gold { background: #d4af37; color: #000; font-weight: bold; }
    </style>
</head>
<body>
    <div class="login-card text-center">
        <h3 style="color:#d4af37">ADMIN LOGIN</h3>
        <form method="POST">
            <input type="email" name="email" class="form-control mb-3 bg-dark text-white border-secondary" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-3 bg-dark text-white border-secondary" placeholder="Password" required>
            <button type="submit" class="btn btn-gold w-100 mb-3">LOGIN</button>
        </form>
        <p class="small">No account? <a href="register.php" style="color:#d4af37">Register Staff</a></p>
    </div>
</body>
</html>