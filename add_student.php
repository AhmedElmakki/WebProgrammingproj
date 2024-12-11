<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "students_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    if ($action === 'add') {
        $name = $_POST['name'];
        $role = $_POST['role'];
        $id = $_POST['id'];
        $hours = $_POST['hours'];
        $age = $_POST['age'];

        $stmt = $conn->prepare("INSERT INTO students (name, role, id, hours, age) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiii", $name, $role, $id, $hours, $age);

        if ($stmt->execute()) {
            echo "Student added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif ($action === 'remove') {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Student removed successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Invalid action.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add or Remove Student</title>
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
            height: 100%;
            width: 100%;
            background: linear-gradient(to right, #b39ddb, #8e44ad);
            color: white;
            text-align: center;
            padding: 0;
            overflow-x: hidden;
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
            position: sticky;
            top: 0;
            left: 0;
            z-index: 100;
        }
        .header .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 15px; 
        }
        .header button {
            padding: 10px 20px;
            background-color: #8e44ad;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .header button:hover {
            background-color: #7d3c94;
        }
        .main-content {
            text-align: left;
            padding: 50px 40px;
            color: white;
            width: 100%;
            display: flex;
            justify-content: space-between; 
            gap: 4%; 
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            width: 48%; 
            max-width: 1000px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .form-container label {
            display: block;
            font-size: 14px;
            margin-top: 10px;
            color: #333;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #8e44ad;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-container button:hover {
            background-color: #7d3c94;
        }

       
        .remove-container {
            display: flex;
            justify-content: center; 
            width: 48%; 
            max-width: 1000px; 
        }


        .remove-container .form-container {
            background-color: white; 
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 0; 
            height: auto; 
            max-height: 400px; 
        }

        .remove-container .form-container form {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .remove-container .form-container label {
            margin-bottom: 10px; 
        }

        .remove-container .form-container input,
        .remove-container .form-container button {
            margin-bottom: 10px
        }

    </style>

    <script>
        function validateAddStudentForm() {
            const name = document.getElementById('name').value;
            const role = document.getElementById('role').value;
            const id = document.getElementById('id').value;
            const hours = document.getElementById('hours').value;
            const age = document.getElementById('age').value;

            if (!name || !role || !id || !hours || !age) {
                alert('Please fill in all the fields to add the student');
                return false;
            }
            return true;
        }

        function validateRemoveStudentForm() {
            const id = document.getElementById('remove-id').value;

            if (!id) {
                alert('Please enter the student ID to remove');
                return false;
            }
            return true;
        }
    </script>
</head>
<body> 
    <div class="header">
        <div>Student Management System</div>
        <div class="button-container">
            <button onclick="window.location.href='homepage.php'">Homepage</button>
            <button onclick="window.location.href='list_students.php'">View Students</button>
            <button onclick="window.location.href='contactUs.html'">Contact Us</button>
            <button onclick="window.location.href='logout.php'">Log Out</button>
        </div>
    </div>


    <!-- Form Container for Add and Remove Forms -->
    <div class="main-content">
        <!-- Add Student Form -->
        <div class="form-container">
            
            <form id="addStudentForm" method="POST" action="add_student.php" onsubmit="return validateAddStudentForm();">
                <input type="hidden" name="action" value="add">

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="role">Role:</label>
                <input type="text" id="role" name="role" required>

                <label for="id">ID:</label>
                <input type="number" id="id" name="id" required step="1">

                <label for="hours">Hours:</label>
                <input type="number" id="hours" name="hours" required step="1">

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" min="18" required step="1">

                <button type="submit">Add Student</button>
            </form>
        </div>


        <!-- Remove Student Form -->
        <div class="remove-container">
            <div class="form-container">
                <h2>Remove Student</h2>
                <form id="removeStudentForm" method="POST" action="add_student.php" onsubmit="return validateRemoveStudentForm();">
                    <input type="hidden" name="action" value="remove">

                    label for="remove-id">Student ID:</label>
                <input type="number" id="remove-id" name="id" required step="1">

                <button type="submit">Remove Student</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
