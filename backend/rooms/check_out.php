<?php
// Include the database connection script
include '../db_connection.php';

// Get room number from the request
$roomNumber = $_GET['room'];

// Fetch the current visitor id from the specified room
$sqlGetVisitorId = "SELECT current_visitor_id FROM rooms WHERE room_number = '$roomNumber'";
$result = $connection->query($sqlGetVisitorId);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentVisitorId = $row['current_visitor_id'];

    // Update the database to mark the room as empty and clear the current visitor id
    $sqlUpdateRoomStatus = "UPDATE rooms SET room_status = 'empty', current_visitor_id = NULL WHERE room_number = '$roomNumber'";
    $connection->query($sqlUpdateRoomStatus);

    // Additional check-out logic as needed

    echo 'Check-out successful';
} else {
    echo 'Room not found';
}
?>
