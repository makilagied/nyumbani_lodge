<?php
// Include the database connection script
include '../db_connection.php';

// Get room number from the request
$roomNumber = $_GET['room'];

// Fetch details for the current visitor in the specified room
$sql = "SELECT r.room_number, v.visitor_name, v.check_in_date, v.check_out_date
        FROM visitors v
        JOIN rooms r ON v.room_id = r.room_id
        WHERE r.room_number = '$roomNumber' AND v.visitor_id = r.current_visitor_id";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $roomDetails = [
        'roomNumber' => $row['room_number'],
        'visitorName' => $row['visitor_name'],
        'checkInDate' => $row['check_in_date'],
        'checkOutDate' => $row['check_out_date']
    ];

    // Send room details as JSON
    header('Content-Type: application/json');
    echo json_encode($roomDetails);
} else {
    // Room has no current visitor
    $emptyRoomMessage = [
        'message' => 'This room is empty'
    ];

    // Send message as JSON
    header('Content-Type: application/json');
    echo json_encode($emptyRoomMessage);
}
?>
