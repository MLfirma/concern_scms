<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Concern | ConcernHub</title>
    <!-- Google Fonts & Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #121212; /* Deep Black Background */
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .card {
            background-color: #1e1e1e; /* Dark Gray Card */
            border: 1px solid #d4af37; /* Gold Border */
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .card-header {
            background: linear-gradient(45deg, #000000, #1a1a1a);
            border-bottom: 2px solid #d4af37;
            text-align: center;
            padding: 20px;
            border-radius: 15px 15px 0 0 !important;
        }
        .card-header h2 {
            color: #d4af37; /* Luxury Gold */
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .form-label {
            color: #d4af37;
            font-weight: 500;
        }
        .form-control, .form-select {
            background-color: #2a2a2a;
            border: 1px solid #444;
            color: white;
        }
        .form-control:focus, .form-select:focus {
            background-color: #2a2a2a;
            border-color: #d4af37;
            color: white;
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.5);
        }
        .btn-submit {
            background: linear-gradient(45deg, #d4af37, #f2d06b);
            border: none;
            color: black;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            transition: 0.3s;
        }
        .btn-submit:hover {
            background: linear-gradient(45deg, #b8860b, #d4af37);
            transform: translateY(-2px);
        }
        .form-check-input:checked {
            background-color: #d4af37;
            border-color: #d4af37;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>ConcernHub</h2>
            <p class="text-white-50 m-0">Submit Your Concern</p>
        </div>
        <div class="card-body p-4">
            <form action="submit_save.php" method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select" required>
                        <option value="Academic">Academic</option>
                        <option value="Financial">Financial</option>
                        <option value="Welfare">Welfare</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Program (e.g., BSIT)</label>
                    <input type="text" name="program" class="form-control" placeholder="Enter your course" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Describe your concern..." required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Attachments (Optional)</label>
                    <input type="file" name="attachment" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="student_email" class="form-control" placeholder="email@example.com" required>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" name="is_anonymous" class="form-check-input" id="anon">
                    <label class="form-check-label text-white-50" for="anon">Submit as Anonymous</label>
                </div>

                <button type="submit" class="btn btn-submit">SUBMIT CONCERN</button>
            </form>
        </div>
    </div>
    <div class="text-center mt-4 mb-5">
        <small class="text-white-50">&copy; 2026 ConcernHub System</small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>