<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Use your MySQL password
$dbname = 'students_db';

// Connect to MySQL
$conn = new mysqli($host, $user, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the database exists
$db_check_query = "SHOW DATABASES LIKE '$dbname'";
$result = $conn->query($db_check_query);

if ($result->num_rows == 0) {
    // Database doesn't exist, run the SQL script
    $sql_file = 'students_db.sql'; // Path to your SQL file
    $sql_content = file_get_contents($sql_file);

    if ($sql_content === false) {
        die("Failed to read the SQL file.");
    }

    // Execute each SQL command
    $sql_commands = explode(';', $sql_content);
    foreach ($sql_commands as $command) {
        $command = trim($command);
        if (!empty($command)) {
            if ($conn->query($command) === false) {
                die("Error executing query: " . $conn->error);
            }
        }
    }
    echo "Database and tables initialized successfully.";
} else {
    echo "Database already exists.";
}

// Close the connection
$conn->close();
?>
