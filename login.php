<?php
session_start();
$conn = new mysqli("localhost", "root", "", "students_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;
            header("Location: homepage.php");
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "User not found.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        function validateLoginForm() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (!username || !password) {
                alert('Please enter your username and password!');
                return false; 
                // Form submission is blocked.
            }
            return true;
            // Form submission is allowed. 
        }
    </script>
</head>
<body>
    <div class="header">
        <div>Student Management System</div>
        <button class="contact-button" onclick="window.location.href='contact.html'">Contact Us</button>
    </div>

    <!-- Login Form -->
    <div class="container">
        <form method="POST" action="login.php" onsubmit="return validateLoginForm();">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <button type="submit">Login</button>
        </form>
        <p style="margin-top: 20px;">Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
