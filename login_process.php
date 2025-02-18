<?php
session_start();
$host = 'localhost'; // Change if necessary
$db = 'news_management';
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];

// SQL query to check if the user exists
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // If user exists, set session and redirect based on role
    $row = $result->fetch_assoc();
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];
    
    if ($row['role'] == 'admin') {
        header("Location: pages/admin_page/admin_page.php");
    } else {
        header("Location: pages/home_page/home.php");
    }
} else {
    echo "<script>
            alert('Invalid username or password.!');
        </script>";
}

$conn->close();
?>
