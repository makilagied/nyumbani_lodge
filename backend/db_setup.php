<?php

$host = 'localhost';
$username = 'makilagied';
$password = 'Edick@7266';
$database = 'nyumbani_lodge';

// Create a connection
$connection = new mysqli($host, $username, $password);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Create the database
$sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS $database";
if ($connection->query($sqlCreateDatabase) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $connection->error . "\n";
}

// Use the database
$connection->select_db($database);

// Create the visitors table
$sqlCreateVisitorsTable = "
    CREATE TABLE IF NOT EXISTS visitors (
        visitor_id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        phone VARCHAR(255) NOT NULL,
        check_in_date DATETIME NOT NULL,
        check_out_date DATETIME,
        room_number VARCHAR(10),
        payment_method VARCHAR(50) NOT NULL,
        special_notes TEXT
    )
";
$connection->query($sqlCreateVisitorsTable);

// Create the rooms table
$sqlCreateRoomsTable = "
    CREATE TABLE IF NOT EXISTS rooms (
        room_number VARCHAR(10) PRIMARY KEY,
        room_status ENUM('empty', 'occupied') DEFAULT 'empty'
    )
";
$connection->query($sqlCreateRoomsTable);

// Create the users table
$sqlCreateUsersTable = "
    CREATE TABLE IF NOT EXISTS users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('receptionist', 'admin') DEFAULT 'receptionist'
    )
";
$connection->query($sqlCreateUsersTable);

// Insert sample data for users
$sqlInsertSampleUsers = "
    INSERT INTO users (username, password, role) VALUES
    ('admin', 'admin_password', 'admin'),
    ('receptionist', 'receptionist_password', 'receptionist')
";
$connection->query($sqlInsertSampleUsers);

// Insert sample data for rooms
$sqlInsertSampleRooms = "
    INSERT INTO rooms (room_number, room_status) VALUES
    ('DP 101', 'empty'),
    ('DP 102', 'empty'),
    ('DP 103', 'empty'),
    ('DP 104', 'empty'),
    ('DP 105', 'empty'),
    ('KP 106', 'empty'),
    ('DP 107', 'empty'),
    ('DP 108', 'empty'),
    ('DP 109', 'empty'),
    ('DP 110', 'empty'),
    ('DP 111', 'empty')
";
$connection->query($sqlInsertSampleRooms);

// Close the connection
$connection->close();

?>
