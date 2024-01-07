<!DOCTYPE html>
<?php
// Include the database connection script
include '../backend/db_connection.php';

// Start a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    // Redirect to the login page if not logged in
    header("Location: ../auth/login.php");
    exit();
}

// Check if the logged-in user has the required role
$requiredRole = 'admin';  // Change this to your required role
if ($_SESSION['role'] !== $requiredRole) {
    // Redirect to a forbidden page if the role is not correct
    header("Location: ../auth/login.php");
    exit();
}

// You can include additional checks based on user ID or any other criteria here

?>

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS link (make sure to include this in your project) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
    body {
        font-family: 'Open Sans', sans-serif;
        margin: 0;
        padding: 0;
    }

    #navbar {
        background-color: #333;
        color: #fff;
        height: 100vh;
        width: 200px;
        position: fixed;
        top: 0;
        left: 0;
        overflow-x: hidden;
        padding-top: 20px;
    }

    #navbar a {
        padding: 15px;
        text-decoration: none;
        font-size: 18px;
        color: #fff;
        display: block;
        transition: background-color 0.3s ease;
    }

    #navbar a:hover {
        background-color: #555;
    }

    #topbar {
        background-color: #555;
        color: #fff;
        padding: 10px;
        position: fixed;
        top: 0;
        right: 0;
        left: 200px;
        display: flex;
        justify-content: space-between;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #topbar:hover {
        background-color: #777;
    }

    #topbar span {
        margin-right: 20px;
    }

    #content {
        margin-top: 60px;
        margin-left: 200px;
        padding: 20px;
        width: calc(100% - 200px); /* Adjust the width to leave space for the sidebar */
        box-sizing: border-box;
        overflow: hidden; /* Prevent scrolling */
    }

    .content-section {
        display: none; /* Hide all content sections by default */
    }

    .content-section.active {
        display: block; /* Display the active content section */
    }

    iframe {
        width: 100%;
        height: 100%;
        border: 0; /* Remove iframe border */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    .no-data {
        text-align: center;
        margin-top: 20px;
        color: #999;
    }

    #lodgeView {
        display: none;
        padding: 20px;
        border: 1px solid #ddd;
        margin-top: 20px;
    }

    #lodgeView.active {
        display: block;
    }

    #filterForm {
        margin-bottom: 20px;
    }

    label {
        margin-right: 10px;
    }

    input, select, button {
        margin-bottom: 10px;
    }

    button {
        padding: 10px 15px;
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    #loadingOverlay {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100px;
        background-color: rgba(255, 255, 255, 0.8);
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
    }

    #loadingText {
        font-size: 18px;
        font-weight: bold;
    }

    #filteredData {
        margin-top: 20px;
    }

    .no-data {
        text-align: center;
        margin-top: 20px;
        color: #999;
    }

    /* Form Container */
#filterForm {
    max-width: 600px;
    margin: 0 auto;
}

/* Form Heading */
h1 {
    text-align: center;
    color: #007bff;
}

/* Form Labels */
label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

/* Form Select */
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    transition: border-color 0.3s;
}

/* Form Date Filters Container */
#dateFilters {
    display: flex;
    justify-content: space-between;
}

/* Form Date Input */
input[type="date"] {
    width: 48%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    transition: border-color 0.3s;
}

/* Form Submit Button */
button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

</style>

</head>
<body>

<div id="topbar" class="bg-dark text-light p-2" onclick="loadContent('home')">
    <span class="mr-4">NYUMBANI BUSINESS INFORMATION SYSTEM</span>
    <div>
        <span><i class="bi bi-person"></i> Profile</span>
        <span><i class="bi bi-gear"></i> Settings</span>
        <span><i class="bi bi-person-plus"></i> Manage Users</span>
        <button class="btn btn-danger my-2 my-sm-0" onclick="logout()">Logout</button>
    </div>
</div>

<div id="navbar" class="bg-dark text-light">
    <a href="#" onclick="loadContent('lodge')">Lodge</a>
    <a href="#" onclick="loadContent('bar')">Bar</a>
    <a href="#" onclick="loadContent('dukani')">Dukani</a>
    <a href="#" onclick="loadContent('barbershop')">Barbershop</a>
    <a href="#" onclick="loadContent('saloon')">Saloon</a>
</div>

<div id="content">

    <div id="lodgeView" class="content-section active">
        <!-- Lodge View content -->
        <h1>Nyumbani Lodge Reports</h1>
        <form id="filterForm">
            <label for="filterType">Filter Type:</label>
            <select name="filterType" id="filterType">
                <option value="current">Current Occupied Rooms</option>
                <option value="daily">Daily</option>
                <option value="weekly">In date range</option>
                <option value="monthly">From Date to Today</option>
            </select>

            <div id="dateFilters">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date">

                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date">
            </div>

            <button type="submit">Apply Filters</button>
        </form>
        <div id="loadingOverlay" style="display:none;">
            <span id="loadingText">Loading...</span>
        </div>
        <div id="filteredData"></div>
    </div>

    <div id="barView" class="content-section">
        <!-- Bar View content -->
        <!-- ... -->
    </div>

    <div id="dukaniView" class="content-section">
        <!-- Dukani View content -->
        <!-- ... -->
    </div>

    <div id="barbershopView" class="content-section">
        <!-- Barbershop View content -->
        <!-- ... -->
    </div>

    <div id="saloonView" class="content-section">
        <!-- Saloon View content -->
        <!-- ... -->
    </div>

</div>

<!-- Bootstrap JS and Popper.js (make sure to include these in your project) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    function loadContent(category) {
        // Hide all content sections
        document.querySelectorAll('.content-section').forEach(function(section) {
            section.classList.remove('active');
        });

        // Show the selected content section
        document.getElementById(`${category}View`).classList.add('active');
    }

    document.getElementById('filterForm').addEventListener('submit', function (event) {
        event.preventDefault();
        showLoadingOverlay();

        // Make an AJAX request to the PHP script using Fetch API
        var formData = new FormData(this);
        fetch('lodge_view.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoadingOverlay();

            if (data.status === 'success') {
                displayFilteredData(data.data);
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => {
            hideLoadingOverlay();
            console.error('Error:', error);
        });
    });

    function showLoadingOverlay() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    }

    function hideLoadingOverlay() {
        document.getElementById('loadingOverlay').style.display = 'none';
    }

    function displayFilteredData(data) {
    var tableHtml = "<h2>Filtered Data</h2>";

    if (data.length > 0) {
        tableHtml += "<table border='1'>" +
            "<tr><th>Room Number</th><th>Visitor Name</th><th>Payment</th><th>Check-in Date</th><th>Check-out Date</th></tr>";

        data.forEach(function (row) {
            tableHtml += "<tr>" +
                "<td>" + row.room_id + "</td>" +
                "<td>" + row.visitor_name + "</td>" +
                "<td>" + row.payment_method + "</td>" +
                "<td>" + row.check_in_date + "</td>" +
                "<td>" + row.check_out_date + "</td>" +
                "</tr>";
        });

        tableHtml += "</table>";
    } else {
        tableHtml += "<p>No data found.</p>";
    }

    document.getElementById('filteredData').innerHTML = tableHtml;
}

function logout() {
        // Redirect to ../backend/logout.php
        window.location.href = '../backend/logout.php';
    }
</script>

</body>
</html>

