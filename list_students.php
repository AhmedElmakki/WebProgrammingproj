<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "students_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch students data
$result = $conn->query("SELECT * FROM students");

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            height: 100%;
            width: 100%;
            background: linear-gradient(to right, #b39ddb, #8e44ad);
            overflow: auto;
            padding-top: 100px; 
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
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            transition: top 0.3s;
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
        .buttons {
            display: flex;
            gap: 20px;
        }
        .buttons button {
            padding: 10px 20px;
            background-color: #9b59b6;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        .buttons button:hover {
            background-color: #8e44ad;
        }
        table {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            margin-top: 5px; 
        }
        table, th, td {
            border: 1px solid #8e44ad;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #8e44ad;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        .table-container {
            height: calc(100vh - 150px); 
            overflow-y: auto; 
        }
        
        /* Centering container for the search bar */
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        /* Search bar styling */
        #search-input {
            width: 300px;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #8e44ad;
            border-radius: 5px;
            outline: none;
            background-color: #f9f9f9;
            transition: box-shadow 0.3s, border-color 0.3s;
            color: #333;
            }

        #search-input:focus {
            box-shadow: 0 0 10px rgba(142, 68, 173, 0.5);
            border-color: #7d3c94;
        }

        #search-input::placeholder {
            color: #aaa;
        }

    </style>
    <script>
        function searchTable() {
            const input = document.getElementById('search-input').value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(input));
                row.style.display = match ? '' : 'none';
            });
        }
    </script>
</head>
<body>
    <div class="header">
        <div>Student Management System</div>
        <div class="button-container">
            <button onclick="window.location.href='homepage.php'">Homepage</button>
            <button onclick="window.location.href='add_student.php'">Manage Students</button>
            <button onclick="window.location.href='contactUs.html'">Contact Us</button>
            <button onclick="window.location.href='logout.php'">Log Out</button>
        </div>
    </div>

    <!-- Page Header -->
    <div>
        <h1>Students List</h1>
        <div class="search-container">
        <input type="text" id="search-input" onkeyup="searchTable()" placeholder="Search for students...">
</div>

    </div>

    

    <div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>ID</th>
                <th>Hours</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are any students to display
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['role']}</td>
                            <td>{$row['id']}</td>
                            <td>{$row['hours']}</td>
                            <td>{$row['age']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No students found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>

</body>
</html>
