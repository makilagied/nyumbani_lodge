<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Your existing CSS styles */
        :root {
            --primary: #FEA116;
            --light: #F1F8FF;
            --dark: #0F172B;
        }

        .fw-medium {
            font-weight: 500 !important;
        }

        .fw-semi-bold {
            font-weight: 600 !important;
        }

        /* Additional styles for the admin panel */
        body {
            background-color: var(--light);
        }

        .admin-container {
            margin-top: 50px;
        }

        .admin-box {
            max-width: 800px;
            margin: auto;
            background: #FFFFFF;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .admin-box h2 {
            text-align: center;
            color: var(--dark);
        }

        .admin-item {
            margin-bottom: 20px;
        }

        .admin-item h4 {
            color: var(--dark);
        }

        .admin-item p {
            color: var(--dark);
        }

        .admin-item .btn {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .admin-item .btn:hover {
            background-color: var(--dark);
            border-color: var(--dark);
        }

        .filter-container {
            margin-top: 20px;
            text-align: center;
        }

        .filter-container label {
            margin-right: 10px;
        }

        .room-status-container {
            margin-top: 20px;
            text-align: center;
        }

        .room-status-box {
            display: inline-block;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            cursor: pointer;
        }

        .report-container {
            margin-top: 20px;
            text-align: center;
        }

        .report-container label {
            margin-right: 10px;
        }

        .report-container select {
            margin-right: 10px;
        }

        /* New styles for the report */
        @media print {
            body {
                visibility: hidden;
            }

            .report-container {
                visibility: visible;
            }

            .report {
                width: 210mm;
                height: 297mm;
                margin: auto;
                padding: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                background-color: #FFFFFF;
            }

            .report h5 {
                text-align: center;
                margin-bottom: 20px;
            }

            .report ul {
                list-style: none;
                padding: 0;
            }

            .report li {
                margin-bottom: 10px;
            }
        }
    </style>
    <title>Admin Panel</title>
</head>
<body>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Nyumbani Lodge</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="navbar-text mx-2 my-2 my-lg-0">Welcome, [Username]</span> <!-- Replace [Username] with the actual username -->
            </li>
            <li class="nav-item">
                <button class="btn btn-danger my-2 my-sm-0" onclick="logout()">Logout</button>
            </li>
        </ul>
    </div>
</nav>

<div class="container admin-container">
    <div class="row">
        <div class="col-md-8 offset-md-2 admin-box">
            <h2>Admin Panel</h2>

            <div class="room-status-container">
                <h4>Live Room Status</h4>
                <div id="roomStatus"></div>
            </div>

            <div class="admin-item">
                <h4>Room Report</h4>
                <label for="roomSelector">Select Room:</label>
                <select id="roomSelector">
                    <option value="1">Room 1</option>
                    <option value="2">Room 2</option>
                    <option value="3">Room 3</option>
                    <!-- Add more room options as needed -->
                </select>
                <label for="timeFilter">Select Time Range:</label>
                <select id="timeFilter">
                    <option value="day">Day</option>
                    <option value="week">Week</option>
                    <option value="month">Month</option>
                </select>
                <button class="btn btn-primary" onclick="generateRoomReport()">Generate Report</button>

                <div id="roomReportContainer" class="report-container">
                    <!-- Room report content will be displayed here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Simulated room data
    var rooms = Array.from({ length: 11 }, (_, index) => ({ id: index + 1, visits: [] }));

    function updateRoomStatus() {
        var roomStatusHTML = rooms.map(room => {
            var lastVisit = room.visits.length > 0 ? room.visits[room.visits.length - 1] : null;
            var statusColor = lastVisit && lastVisit.status === 'occupied' ? 'red' : 'green';
            return `<div class="room-status-box" style="border-color: ${statusColor};" onclick="showRoomReport(${room.id})">
                        Room ${room.id}: ${lastVisit ? lastVisit.status : 'empty'}
                    </div>`;
        }).join('');

        document.getElementById('roomStatus').innerHTML = roomStatusHTML;
    }

    function showRoomReport(roomId) {
        // Display the selected room in the report container
        var reportContainer = document.getElementById('roomReportContainer');
        reportContainer.innerHTML = `<h5>Room Details for Room ${roomId}</h5>`;

        // Save the selected room ID in a data attribute for later use
        reportContainer.setAttribute('data-room-id', roomId);
    }

    function generateRoomReport() {
        // Get the selected room ID from the data attribute
        var roomId = document.getElementById('roomReportContainer').getAttribute('data-room-id');

        // Simulate data generation (replace with actual server-side logic)
        var reportData = generateSampleData(roomId);

        // Filter the report data based on the selected time range
        var selectedFilter = document.getElementById('timeFilter').value;
        var filteredReportData = reportData.filter(roomReport => {
            var currentDate = new Date();
            var reportDate = new Date(roomReport.date);
            if (selectedFilter === 'day') {
                return currentDate.toDateString() === reportDate.toDateString();
            } else if (selectedFilter === 'week') {
                var startOfWeek = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate() - currentDate.getDay());
                var endOfWeek = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate() + (6 - currentDate.getDay()));
                return reportDate >= startOfWeek && reportDate <= endOfWeek;
            } else if (selectedFilter === 'month') {
                return currentDate.getMonth() === reportDate.getMonth();
            }
            return false;
        });

        // Display the filtered report in the report container
        var reportResult = `
            <div class="report">
                <h5>Room Details for Room ${roomId} (${selectedFilter} filter)</h5>
                <ul>
                    ${filteredReportData.map(roomReport => `
                        <li>
                            <strong>Date:</strong> ${roomReport.date}
                            <strong>Status:</strong> ${roomReport.status}
                        </li>
                    `).join('')}
                </ul>
            </div>
        `;
        document.getElementById('roomReportContainer').innerHTML = reportResult;
    }

    // Initial update of room status
    updateRoomStatus();

    // Simulated function to generate sample data for a room
    function generateSampleData(roomId) {
        var currentDate = new Date();
        var startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);

        // Generate sample data for the past month
        var reportData = [];
        for (var i = 0; i < 30; i++) {
            var date = new Date(startDate);
            date.setDate(startDate.getDate() + i);

            var status = 'empty';
            if (Math.random() > 0.5) {
                status = 'occupied';
            }

            reportData.push({
                date: date.toLocaleDateString(),
                status: status
            });
        }

        // Update the room visits with the sample data
        var room = rooms.find(room => room.id === parseInt(roomId));
        room.visits = reportData;

        // Update room status display
        updateRoomStatus();

        return reportData;
    }
</script>

</body>
</html>
