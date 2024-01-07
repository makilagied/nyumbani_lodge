<?php
// Include the database connection script
include 'db_connection.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate user credentials (replace this with your actual validation logic)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database to check user credentials
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect to the dashboard or another secured page
            header("Location: ../reception/room.php");
            exit();
        } else {
            // Invalid username or password
            echo "<script>alert('Invalid username'); window.location.href = '../reception/room.php';</script>";
        }
    } else {
        // Invalid username or password
        echo "<script>alert('User not found'); window.location.href = '../reception/room.php';</script>";
    }
}
?>
