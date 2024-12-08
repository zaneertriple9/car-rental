<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FritzAnn Shuttle Services | Booking Summary</title>
    <style>
        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            background-color: #000;
            color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 2px solid red;
            width: 30%;
            font-family: 'Courier New', Courier, monospace;
            text-shadow: 0 0 10px red;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 2px solid red;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .customer-info,
        .booking-details {
            margin-bottom: 20px;
        }

        .customer-info h3,
        .booking-details h3 {
            border-bottom: 1px solid red;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .customer-info p,
        .booking-details p {
            margin: 5px 0;
        }

        button {
            background-color: red;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-family: 'Courier New', Courier, monospace;
            text-shadow: 0 0 5px black;
        }

        button:hover {
            background-color: #fff;
            color: red;
            text-shadow: 0 0 5px red;
        }
    </style>
</head>
<body>
    <button onclick="openModal()">View Booking Summary</button>
    <div id="myModal" class="modal">
        <div class="modal-content">

            <?php
            // Include necessary PHP files and start session
            session_start();
            include('includes/config.php'); // Assuming this file contains your database connection details

            try {
                // Retrieve the last inserted ID from the database
                $stmt = $dbh->prepare("SELECT MAX(noaccbooking_ID) AS last_inserted_id FROM tblnoaccbooking");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $lastInsertedId = $row['last_inserted_id'];

                if ($lastInsertedId) {
                    // Fetch booking information for the last inserted ID
                    $stmt = $dbh->prepare("SELECT a.*, b.*, v.VehiclesTitle, v.VehiclesBrand, v.Vimage1, br.BrandName
                                           FROM tblnoaccbooking a 
                                           LEFT JOIN tblnoaccbookinginformation b 
                                           ON a.noaccbooking_ID = b.noaccbooking_ID 
                                           LEFT JOIN tblvehicles v 
                                           ON a.VehicleId = v.Vehicle_id 
                                           LEFT JOIN tblbrands br
                                           ON v.VehiclesBrand = br.brand_id
                                           WHERE a.noaccbooking_ID = :booking_id");
                    $stmt->bindParam(':booking_id', $lastInsertedId);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        echo "<div class='receipt-header'><h1>TAKE A SCREENSHOT OF YOUR BOOKING SUMMARY</h1></div>";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<div class='customer-info'>";
                            echo "<h3>Customer Information</h3>";
                            echo "<p><strong>Full Name:</strong> {$row['fullname']}</p>";
                            echo "<p><strong>Address:</strong> {$row['address']}</p>";
                            echo "<p><strong>Gender:</strong> {$row['gender']}</p>";
                            echo "<p><strong>Age:</strong> {$row['age']}</p>";
                            echo "<p><strong>Phone:</strong> {$row['phone']}</p>";
                            echo "<p><strong>Selected Location:</strong> {$row['selectedLocation']}</p>";
                            echo "</div>";

                            echo "<div class='booking-details'>";
                            echo "<h3>Booking Details</h3>";
                            
                            // Display vehicle image, brand, and title instead of ID
                            echo "<p><strong>Car:</strong></p>";
                            echo "<p><img src='admin/img/vehicleimages/{$row['Vimage1']}' alt='{$row['VehiclesTitle']}' style='max-width:200px;'></p>";
                            echo "<p>{$row['BrandName']} - {$row['VehiclesTitle']}</p>";

                            echo "<p><strong>From Date:</strong> {$row['FromDate']}</p>";
                            echo "<p><strong>Pickup Time:</strong> {$row['PickupTime']}</p>";
                            echo "<p><strong>To Date:</strong> {$row['ToDate']}</p>";
                            echo "<p><strong>Return Time:</strong> {$row['ReturnTime']}</p>";
                            echo "<p><strong>Booking Duration:</strong> {$row['BookingDuration']} days</p>";
                            echo "<p><strong>Created At:</strong> {$row['CreatedAt']}</p>";
                            echo "<p><strong>Total Price:</strong> {$row['TotalPrice']}</p>";
                            echo "</div>";
                        }

                    } else {
                        echo "<p>No bookings found for ID: $lastInsertedId</p>";
                    }
                } else {
                    echo "<p>No booking ID specified.</p>";
                }
            } catch (PDOException $e) {
                echo "Error fetching booking information: " . $e->getMessage();
            }
            ?>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }
    </script>

</body>
</html>
