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

// Create the users table
$sqlCreateUsersTable = "
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('receptionist', 'admin') DEFAULT 'receptionist'
)";
if ($connection->query($sqlCreateUsersTable) === TRUE) {
    echo "Users table created successfully\n";
} else {
    echo "Error creating users table: " . $connection->error . "\n";
}

// Create the visitors table
$sqlCreateVisitorsTable = "
CREATE TABLE IF NOT EXISTS visitors (
    visitor_id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT,
    visitor_name VARCHAR(255),
    visitor_phone VARCHAR(20),
    check_in_date DATETIME,
    check_out_date DATETIME,
    payment_method VARCHAR(50),
    message TEXT
)";
if ($connection->query($sqlCreateVisitorsTable) === TRUE) {
    echo "Visitors table created successfully\n";
} else {
    echo "Error creating visitors table: " . $connection->error . "\n";
}

// Create the rooms table
$sqlCreateRoomsTable = "
CREATE TABLE IF NOT EXISTS rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(50) NOT NULL UNIQUE,
    room_status ENUM('empty', 'occupied') NOT NULL DEFAULT 'empty',
    current_visitor_id INT,
    FOREIGN KEY (current_visitor_id) REFERENCES visitors(visitor_id) ON DELETE SET NULL
)";
if ($connection->query($sqlCreateRoomsTable) === TRUE) {
    echo "Rooms table created successfully\n";
} else {
    echo "Error creating rooms table: " . $connection->error . "\n";
}



// Insert sample data for users (if not already inserted)
$sqlInsertSampleUsers = "
INSERT IGNORE INTO users (username, password_hash, role) VALUES
('admin', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', 'admin'),
('reception', '" . password_hash('reception123', PASSWORD_DEFAULT) . "', 'receptionist')
";
if ($connection->query($sqlInsertSampleUsers) === TRUE) {
    echo "Sample users inserted successfully\n";
} else {
    echo "Error inserting sample users: " . $connection->error . "\n";
}

// Insert sample data for rooms (if not already inserted)
$sqlInsertSampleRooms = "
INSERT IGNORE INTO rooms (room_number) VALUES
('DP 101'),
('DP 102'),
('DP 103'),
('DP 104'),
('DP 105'),
('KP 106'),
('DP 107'),
('DP 108'),
('DP 109'),
('DP 110'),
('DP 111')
";
if ($connection->query($sqlInsertSampleRooms) === TRUE) {
    echo "Sample rooms inserted successfully\n";
} else {
    echo "Error inserting sample rooms: " . $connection->error . "\n";
}

// Close the connection
$connection->close();

?>
