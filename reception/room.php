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
$requiredRole = 'receptionist';  // Change this to your required role
if ($_SESSION['role'] !== $requiredRole) {
    // Redirect to a forbidden page if the role is not correct
    header("Location: ../auth/login.php");
    exit();
}

// You can include additional checks based on user ID or any other criteria here

?>


<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Nyumbani Lodge</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="lodge, hotel, restaurant, motel, weekend getaway, relaxation, Dar es Salaam" name="keywords">
    <meta content="Discover tranquility at Nyumbani Lodge in Kivule, Dar es Salaam. A perfect blend of comfort and charm, offering a serene escape for weekends and relaxation." name="description">
   

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

    <style>
    .room-box {
        border: 1px solid #000;
        padding: 10px;
        margin-bottom: 10px;
        cursor: pointer; /* Change cursor to pointer for better UX */
        width: 100%;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .room-box-empty {
        background-color: #FEA116; /* Green for empty rooms */
    }

    .room-box-occupied {
        background-color: #ff0000; /* Red for occupied rooms */
    }
</style>

</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
        <?php
                    // Check if the username is set in the session
                    if (isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        echo '<span class="navbar-text d-flex align-items-center mx-2 my-2 my-lg-0">Welcome, ' . $username . '</span>';
                    }
                ?>
                <button class="btn btn-danger my-2 my-sm-0" onclick="logout()">Logout</button>
            
                </nav>

        <!-- Booking Start -->
        <div class="container-xxl py-5" id="booking">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">NYUMBANI LODGE</h6>
                    <h1 class="mb-5">Reception <span class="text-primary text-uppercase">Book</span></h1>
                </div>
                <div class="row g-5">

                    <div class="col-lg-6">
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                            <form action="../backend/rooms/room_booking.php" method='POST'>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" placeholder="Your Name" name='name'>
                                            <label for="name">Your Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="phone" class="form-control" id="phone" placeholder="Your Email" name='phone'>
                                            <label for="phone">Phone</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating date" id="date3" data-target-input="nearest">
                                            <input type="datetime-local" class="form-control datetimepicker-input" id="checkin" placeholder="Check In" data-target="#date3" data-toggle="datetimepicker"  name='checkin'/>
                                            <label for="checkin">Check In</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating date" id="date4" data-target-input="nearest">
                                            <input type="datetime-local" class="form-control datetimepicker-input" id="checkout" placeholder="Check Out" data-target="#date4" data-toggle="datetimepicker" name='checkout'/>
                                            <label for="checkout">Check Out</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <select class="form-select" id="select3" name='room'>
                                            <?php
                                                // Include the database connection script
                                                include '../backend/db_connection.php';
                                                 // Fetch rooms from the database where status is empty
                                                 $sqlSelectRooms = "SELECT room_number FROM rooms WHERE room_status = 'empty'";
                                                 $result = $connection->query($sqlSelectRooms);

                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                        $roomNumber = $row['room_number'];
                                                        echo "<option value='$roomNumber'>$roomNumber</option>";
                                                            }
                                                         } else {
                                                        echo "<option value='' disabled>No available rooms</option>";
                                                            }
                                              ?>                               
                                             </select>
                                            <label for="select3">Select A Room</label>
                                          </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <select class="form-select" id="select3" name='payment'>
                                                <option value="Short Time">Short Time</option>
                                                <option value="Full Time">Full Time</option>
                                            </select>
                                            <label for="select3">Payment Method</label>
                                          </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Special Request" id="message" style="height: 100px" name='message'></textarea>
                                            <label for="message">Special Note</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row g-3">
                        <?php
// Include the database connection script
include '../db_connection.php';

// Fetch room data to determine their status
$sqlFetchRooms = "SELECT room_number, room_status FROM rooms";
$result = $connection->query($sqlFetchRooms);

// Create an associative array to store room status
$roomStatus = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roomStatus[$row['room_number']] = $row['room_status'];
    }
}
?>

<div class="container">
    <h2 class="mt-5 mb-4">Rooms</h2>
    <div id="roomDetails"></div>
    <div class="row">
    
        <?php
        // Loop through each room and display the corresponding button
        foreach (array_keys($roomStatus) as $roomNumber) {
            $roomColorClass = ($roomStatus[$roomNumber] == 'empty') ? 'room-box-empty' : 'room-box-occupied';
        ?>
              <div class="col-lg-3 col-md-4 col-sm-6">
                <button class="room-box <?php echo $roomColorClass; ?>" onclick="handleRoomClick('<?php echo $roomNumber; ?>')">
                    <?php echo $roomNumber; ?>
                </button>
            </div>
        <?php
        }
        ?>
    </div>
</div>


    </div>
</div>

<!-- Add an empty div to display room details -->


<script>
    function handleRoomClick(roomNumber) {
        // Fetch room details using AJAX
        fetchRoomDetails(roomNumber);
    }

    function fetchRoomDetails(roomNumber) {
        // Use AJAX to fetch data from the server
        fetch(`../backend/rooms/get_room_details.php?room=${roomNumber}`)
            .then(response => response.json())
            .then(data => {
                // Display room details if the room is not empty
                if ('message' in data && data.message === 'This room is empty') {
                    alert('This room is empty');
                } else {
                    displayRoomDetails(data);
                }
            })
            .catch(error => {
                console.error('Error fetching room details:', error);
            });
    }

    function displayRoomDetails(roomDetails) {
        // Construct HTML for displaying room details
        const roomDetailsHtml = `
            <h2 class="text-primary text-uppercase">Visitor Details</h2>
            <p>Room Number: ${roomDetails.roomNumber}</p>
            <p>Visitor Name: ${roomDetails.visitorName}</p>
            <p>Check-in Date: ${roomDetails.checkInDate}</p>
            <p>Check-out Date: ${roomDetails.checkOutDate}</p>
            <button class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft" onclick="handleCheckOut('${roomDetails.roomNumber}')">Check Out</button>
        `;

        // Display room details in the designated div
        document.getElementById('roomDetails').innerHTML = roomDetailsHtml;
    }

    function handleCheckOut(roomNumber) {
        // Use AJAX to inform the server about the check-out
        fetch(`../backend/rooms/check_out.php?room=${roomNumber}`)
            .then(response => response.text())
            .then(message => {
                alert(message);
                // Reload the page or perform additional actions as needed
                location.reload();
            })
            .catch(error => {
                console.error('Error checking out:', error);
            });
    }
</script>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Booking End -->



        



        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>


    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkinInput = document.getElementById("checkin");
        const checkoutInput = document.getElementById("checkout");
        const form = document.querySelector("form");

        function validateDates() {
            const checkinDate = new Date(checkinInput.value);
            const checkoutDate = new Date(checkoutInput.value);

            if (checkinDate >= checkoutDate) {
                alert("Check-in date should be before Check-out date");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

        function handleSubmit(event) {
            if (!validateDates()) {
                event.preventDefault(); // Prevent form submission
            }
            // Additional form submission logic
        }

        checkinInput.addEventListener("change", validateDates);
        checkoutInput.addEventListener("change", validateDates);

        form.addEventListener("submit", handleSubmit);
    });

    function logout() {
        // Redirect to ../backend/logout.php
        window.location.href = '../backend/logout.php';
    }
</script>



</body>

</html>