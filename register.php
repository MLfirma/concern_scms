<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $dept = $_POST['department'];
    $role = ($dept == 'system') ? 'admin' : 'staff';

    $sql = "INSERT INTO users (name, email, password, role, department) VALUES ('$name', '$email', '$password', '$role', '$dept')";
    if ($conn->query($sql)) {
        echo "<script>alert('Registration Successful!'); window.location.href='login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{background:#000; color:#fff; height:100vh; display:flex; align-items:center; justify-content:center;}</style>
</head>
<body>
    <div class="card bg-dark text-white p-4 border-warning" style="width: 400px;">
        <h4 class="text-center text-warning">REGISTER STAFF</h4>
        <form method="POST">
            <input type="text" name="name" class="form-control mb-2" placeholder="Full Name" required>
            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
            <select name="department" class="form-select mb-3" required>
                <option value="academic">Academic</option>
                <option value="finance">Finance</option>
                <option value="welfare">Welfare</option>
                <option value="system">Super Admin (System)</option>
            </select>
            <button type="submit" class="btn btn-warning w-100">CREATE ACCOUNT</button>
        </form>
    </div>
</body>
</html>