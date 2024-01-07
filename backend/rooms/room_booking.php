<?php

// Include the database connection script
include '../db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form data
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $phone = htmlspecialchars(strip_tags(trim($_POST['phone'])));
    $checkInDate = htmlspecialchars(strip_tags(trim($_POST['checkin'])));
    $checkOutDate = htmlspecialchars(strip_tags(trim($_POST['checkout'])));
    $roomNumber = htmlspecialchars(strip_tags(trim($_POST['room'])));
    $paymentMethod = htmlspecialchars(strip_tags(trim($_POST['payment'])));
    $specialNotes = htmlspecialchars(strip_tags(trim($_POST['message'])));

    // Check if the room is empty
    $sqlCheckRoomStatus = "SELECT room_id FROM rooms WHERE room_number = '$roomNumber' AND room_status = 'empty'";
    $result = $connection->query($sqlCheckRoomStatus);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $roomId = $row['room_id'];

        // Insert data into the visitors table
        $sqlInsertVisitor = "INSERT INTO visitors (visitor_name, visitor_phone, check_in_date, check_out_date, room_id, payment_method, message)
                             VALUES ('$name', '$phone', '$checkInDate', '$checkOutDate', $roomId, '$paymentMethod', '$specialNotes')";

        // Update room status to 'occupied'
        $sqlUpdateRoomStatus = "UPDATE rooms SET room_status = 'occupied', current_visitor_id = LAST_INSERT_ID() WHERE room_id = $roomId";

        // Execute the queries
        if ($connection->query($sqlInsertVisitor) === TRUE && $connection->query($sqlUpdateRoomStatus) === TRUE) {
            // Display success message using JavaScript
            // Display success message in a pop-up
            echo "<script>alert('Visitor data inserted successfully');</script>";

            // Redirect to room.php
            echo "<script>window.location.href = '../../reception/room.php';</script>";
            exit(); // Ensure script execution stops after the redirect
        } else {
            echo "Error inserting visitor data: " . $connection->error;
        }
    } else {
        echo "Error: Room is not empty or does not exist.";
    }
}

// Close the connection (optional, as PHP automatically closes it when the script ends)

?>
