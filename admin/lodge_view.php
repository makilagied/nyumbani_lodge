<?php
$host = 'localhost';
$username = 'makilagied';
$password = 'Edick@7266';
$database = 'nyumbani_lodge';

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle filter submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filterType = $_POST["filterType"];
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];

    // Apply filters to SQL query based on user's selections
    if ($filterType == "current") {
        $sql = "SELECT * FROM rooms JOIN visitors ON rooms.current_visitor_id = visitors.visitor_id WHERE rooms.room_status = 'occupied'";
    } else {
        $sql = "SELECT * FROM visitors";
        if ($filterType == "daily") {
            $sql .= " WHERE DATE(check_in_date) = '$startDate'";
        } elseif ($filterType == "weekly") {
            $sql .= " WHERE check_in_date BETWEEN '$startDate' AND '$endDate'";
        } elseif ($filterType == "monthly") {
            $sql .= " WHERE DATE(check_in_date) = '$startDate'";
        }
    }

    $result = $connection->query($sql);

    if ($result === FALSE) {
        $response = array("status" => "error", "message" => "Error executing query: " . $connection->error);
    } else {
        // Fetch data and store it in an array
        $filteredData = array();
        while ($row = $result->fetch_assoc()) {
            $filteredData[] = array(
                "room_id" => $row['room_id'],
                "visitor_name" => $row['visitor_name'],
                "payment_method" => $row['payment_method'],
                "check_in_date" => $row['check_in_date'],
                "check_out_date" => $row['check_out_date']
            );
        }

        $response = array("status" => "success", "data" => $filteredData);
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

$connection->close();
?>
