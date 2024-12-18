<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Homepage</title>
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
            text-align: center;
            padding: 50px 40px;
            color: white;
        }
        .main-content h1 {
            font-size: 30px; 
            margin-bottom: 20px; 
        }
        .main-content h2 {
            font-size: 60px; 
            margin-bottom: 10px;
        }
        .main-content p {
            font-size: 28px; 
            line-height: 1.5;
        }
        .bottom-section {
            padding: 40px 20px;
            text-align: center;
            background-color: #4a148c;
        }
        .bottom-section h3 {
            font-size: 32px;
            margin-bottom: 20px;
        }
        .video-container {
            margin: 20px 0;
        }
        .slider-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            overflow-x: auto;
        }
        .slider-container img {
            width: 200px;
            height: 150px;
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .slider-container img:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

    <div class="header">
        <div>Student Management System</div>
        <div class="button-container">
            <button onclick="window.location.href='list_students.php'">View Students</button>
            <button onclick="window.location.href='add_student.php'">Add Students</button>
            <button onclick="window.location.href='contactUs.html'">Contact Us</button>
            <button onclick="window.location.href='logout.php'">Log Out</button>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="main-content">
        <h2>hello, <?php echo $_SESSION['username']; ?>!</h2>
        <h1>Welcome to the Student Management System</h1>
        <p>Easily manage and view student records securely.</p>
    </div>

    <!-- Bottom Section -->
    <div class="bottom-section">
        <h3>Explore More Features</h3>

        <!-- Video Section -->
        <div class="video-container">
            <video controls width="600">
                <source src="media/sample-video.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- Image Slider -->
        <div class="slider-container">
            <img src="media/image1.jpg" alt="Image 1">
            <img src="media/image2.jpg" alt="Image 2">
            <img src="media/image3.jpg" alt="Image 3">
            <img src="media/image4.jpg" alt="Image 4">
        </div>
    </div>


    <script>
        // Scroll effect for the header
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) { // Adjust the scroll value to your preference
                header.classList.add('hidden');
            } else {
                header.classList.remove('hidden');
            }
        });
    </script>

</body>
</html>



