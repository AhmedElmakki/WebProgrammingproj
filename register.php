<?php
$conn = new mysqli("localhost", "root", "", "students_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL to insert user into database
        $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password_hash);

        // Execute and check for success
        if ($stmt->execute()) {
            $success_message = "User registered successfully. <a href='login.php'>Login here</a>";
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error_message = "Passwords do not match.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            width: 100%;
            background: linear-gradient(to right, #b39ddb, #8e44ad); 
            overflow: hidden; 
        }
        .header {
            width: 100%;
            text-align: left;
            background: linear-gradient(to right, #333333, #555555);
            color: white;
            padding: 50px 20px; 
            font-size: 36px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            top: 0;
            left: 0;
        }
        .contact-button {
            padding: 10px 20px;
            background-color: #9b59b6; 
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        .contact-button:hover {
            background-color: #8e44ad;
        }
        .container {
            text-align: center;
            padding: 50px 40px; 
            border: 1px solid #8e44ad;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px; 
            position: relative;
            top: 70px; 
        }
        .container h1 {
            margin-bottom: 25px; 
            color: #8e44ad;
        }
        .container input {
            width: calc(100% - 20px);
            margin-bottom: 20px; 
            padding: 15px; 
            border: 1px solid #8e44ad;
            border-radius: 5px;
            font-size: 14px;
        }
        .container button {
            padding: 15px 30px; 
            border: none;
            border-radius: 5px;
            background-color: #8e44ad;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        .container button:hover {
            background-color: #7d3c94;
        }
        .container a {
            color: #8e44ad;
            text-decoration: none;
            white-space: nowrap; 
        }
        .container a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function validateRegisterForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (password !== confirmPassword) {
                alert('Password and Confirm Password do not match.');
                return false; 
            }
            return true; 
        }
    </script>
</head>
<body>
    <div class="header">
        <div>Student Management System</div>
        <button class="contact-button" onclick="window.location.href='contactUs.html'">Contact Us</button>
    </div>

    <!-- Registration Form -->
    <div class="container">
        <form method="POST" action="register.php" onsubmit="return validateRegisterForm()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm_password" required>

            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php elseif (isset($success_message)): ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php endif; ?>

            <button type="submit">Register</button>
        </form>

        <p style="margin-top: 20px;">already have an account? <a href="login.php">Log In here</a></p>
    </div>
</body>
</html>