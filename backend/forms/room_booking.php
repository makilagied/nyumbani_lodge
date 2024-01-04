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

    // Insert data into the visitors table
    $sqlInsertVisitor = "INSERT INTO visitors (name, phone, check_in_date, check_out_date, room_number, payment_method, special_notes)
                         VALUES ('$name', '$phone', '$checkInDate', '$checkOutDate', '$roomNumber', '$paymentMethod', '$specialNotes')";

    // Update room status to 'occupied'
    $sqlUpdateRoomStatus = "UPDATE rooms SET room_status = 'occupied' WHERE room_number = '$roomNumber'";

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
}

// Close the connection (optional, as PHP automatically closes it when the script ends)

?>
