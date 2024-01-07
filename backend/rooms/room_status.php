<?php

// Include the database connection script
include '../db_connection.php';

// Fetch live room status with visitor details from the database
$sql = "SELECT r.room_number, r.room_status, v.visitor_name, v.check_in_date, v.check_out_date
        FROM rooms r
        LEFT JOIN visitors v ON r.current_visitor_id = v.visitor_id";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // Store room status with visitor details in an array
    $roomStatus = [];
    while ($row = $result->fetch_assoc()) {
        $roomStatus[] = [
            'roomNumber' => $row['room_number'],
            'status' => $row['room_status'],
            'visitorName' => $row['visitor_name'],
            'checkInDate' => $row['check_in_date'],
            'checkOutDate' => $row['check_out_date']
        ];
    }

    // Send room status with visitor details as JSON
    header('Content-Type: application/json');
    echo json_encode($roomStatus);
} else {
    echo 'No room status found';
}

// Close the database connection
$connection->close();

?>
