<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ConcernHub | Submit Concern</title>
    <style>
        body { font-family: sans-serif; background-color: #121212; color: white; padding: 20px; }
        .container { max-width: 500px; margin: auto; background: #1e1e1e; padding: 20px; border: 1px solid #d4af37; border-radius: 10px; }
        h2 { color: #d4af37; text-align: center; }
        input, select, textarea { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #d4af37; background: #2a2a2a; color: white; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #d4af37; border: none; color: black; font-weight: bold; cursor: pointer; border-radius: 5px; }
        button:hover { background: #b8962e; }
    </style>
</head>
<body>
    <div class="container">
        <h2>CONCERN<span style="color:white">HUB</span></h2>
        <form action="submit_save.php" method="POST">
            <input type="email" name="student_email" placeholder="Your Gmail Address" required>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="Academic">Academic</option>
                <option value="Financial">Financial</option>
                <option value="Welfare">Welfare</option>
            </select>
            <input type="text" name="program" placeholder="Program (e.g. BSIT)" required>
            <input type="text" name="department" placeholder="Department" required>
            <textarea name="description" placeholder="Describe your concern..." required></textarea>
            <button type="submit">SUBMIT CONCERN</button>
        </form>
    </div>
</body>
</html>