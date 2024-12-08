<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_id = $_POST['vehicle_id'];
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $pickuptime = date("H:i:s", strtotime($_POST['pickuptime'])); 
    $returntime = date("H:i:s", strtotime($_POST['returntime'])); 
    $bookingprice = $_POST['bookingprice'];

    $fromdatetime = $fromdate . ' ' . $pickuptime;
    $todatetime = $todate . ' ' . $returntime;

    try {
        $dbh->beginTransaction();

        $check_status_sql = "SELECT Status FROM friztann_vehicles WHERE vehicle_id = :vehicle_id";
        $check_status_query = $dbh->prepare($check_status_sql);
        $check_status_query->bindParam(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
        $check_status_query->execute();

        if ($check_status_query->rowCount() == 0) {
            $dbh->rollBack(); 
            echo "<script>
                    alert('Please select a car for your booking.');
                    window.history.back(); // Return the user to the previous page
                  </script>";
            exit; 
        }
        

        $vehicle_status = $check_status_query->fetchColumn();
        if ($vehicle_status == 'MAINTENANCE') {
            throw new Exception("The car is currently under maintenance.");
        }

        $check_sql = "SELECT * FROM friztann_booking
                      WHERE vehicle_id = :vehicle_id 
                      AND ((FromDate < :fromdate AND ToDate > :fromdate)
                      OR (FromDate < :todate AND ToDate > :todate)
                      OR (FromDate >= :fromdate AND ToDate <= :todate)
                      OR (ToDate = :fromdate AND ReturnTime > :pickuptime))";
        $check_query = $dbh->prepare($check_sql);
        $check_query->bindParam(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
        $check_query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $check_query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $check_query->bindParam(':pickuptime', $pickuptime, PDO::PARAM_STR);
        $check_query->execute();

        $check_noacc_sql = "SELECT * FROM friztann_noaccbooking
                            WHERE vehicle_id = :vehicle_id 
                            AND (:fromdatetime < CONCAT(ToDate, ' ', ReturnTime) 
                            AND :todatetime > CONCAT(FromDate, ' ', PickupTime))";
        $check_noacc_query = $dbh->prepare($check_noacc_sql);
        $check_noacc_query->bindParam(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
        $check_noacc_query->bindParam(':fromdatetime', $fromdatetime, PDO::PARAM_STR);
        $check_noacc_query->bindParam(':todatetime', $todatetime, PDO::PARAM_STR);
        $check_noacc_query->execute();

        $check_admin_sql = "SELECT * FROM friztann_walkin
                            WHERE vehicle_id = :vehicle_id 
                            AND (:fromdatetime < CONCAT(ToDate, ' ', ReturnTime) 
                            AND :todatetime > CONCAT(FromDate, ' ', PickupTime))";
        $check_admin_query = $dbh->prepare($check_admin_sql);
        $check_admin_query->bindParam(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
        $check_admin_query->bindParam(':fromdatetime', $fromdatetime, PDO::PARAM_STR);
        $check_admin_query->bindParam(':todatetime', $todatetime, PDO::PARAM_STR);
        $check_admin_query->execute();

        if ($check_query->rowCount() == 0 && $check_noacc_query->rowCount() == 0 && $check_admin_query->rowCount() == 0) {
            $booking_days = floor((strtotime($todate) - strtotime($fromdate)) / (60 * 60 * 24));

            $sql = "INSERT INTO friztann_noaccbooking (vehicle_id, FromDate, PickupTime, ToDate, ReturnTime, BookingDuration, bookingprice)
                    VALUES (:vehicle_id, :fromdate, :pickuptime, :todate, :returntime, :bookingduration, :bookingprice)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
            $query->bindParam(':fromdate', $fromdate);
            $query->bindParam(':pickuptime', $pickuptime);
            $query->bindParam(':todate', $todate);
            $query->bindParam(':returntime', $returntime);
            $query->bindParam(':bookingduration', $booking_days, PDO::PARAM_INT);
            $query->bindParam(':bookingprice', $bookingprice, PDO::PARAM_STR);

            $insert = $query->execute();

            if ($insert) {
                $dbh->commit();
                echo "<div id='myModal' style='display: block; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);'>
                        <div style='background-color: #fefefe; margin: auto; padding: 20px; border: 1px solid #ddd; width: 60%; text-align: center; border-radius: 10px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);'>
                            <p style='font-size: 24px; color: #333; margin-bottom: 20px;'>Booking Successful</p>
                            <p style='font-size: 18px; color: #666; margin-bottom: 30px;'>Thank you for choosing our service.</p>
                            <div style='text-align: center;'>
                                <a href='Reservation-Form.php' onclick=\"document.getElementById('myModal').style.display='none';\" style='font-size: 18px; color: #fff; background-color: #ab0101; border: none; padding: 10px 20px; border-radius: 5px; text-decoration: none;'>Proceed</a>
                            </div>
                        </div>
                      </div>";
            } else {
                $dbh->rollBack();
                $errorInfo = $query->errorInfo();
                echo "Error: " . $errorInfo[2];
            }
        } else {
            $dbh->rollBack();
            echo "<script>alert('The car is already booked for the selected dates..');</script>";
        }
    } catch (Exception $e) {
        $dbh->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>FritzAnn Shuttle Services  | No account booking</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/mybooking.css" rel="stylesheet">
    <link href="assets/css/noaccount.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    
</head>
<style>
.booking-form-container {
    width: 100%;
    padding: 20px;
    background-color: #1a1a1a; 
    border-radius: 10px; 
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
}

.booking-form {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.form-row {
    display: flex;
    width: 100%;
    justify-content: space-between;
    margin-bottom: 15px; 
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-right: 20px; 
    flex: 1; 
    min-width: 200px; 
}

.form-group:last-child {
    margin-right: 0;
}

.form-group label {
    margin-bottom: 5px;
    font-weight: bold; 
    color: #fff; 
}

.form-group input {
    padding: 10px;
    border: 1px solid #000;
    border-radius: 5px; 
    font-size: 16px; 
    outline: none; 
    transition: border-color 0.3s; 
}

.form-group input:focus {
    border-color: #ff0000;
}

#submitBtn {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #ff0000; 
    color: #fff; 
    border: none;
    border-radius: 5px; 
    cursor: pointer; 
    font-size: 16px; 
    transition: background-color 0.3s; 
}

#submitBtn:hover {
    background-color: #cc0000; 
}

@media (max-width: 768px) {
    .form-row {
        flex-direction: column; 
    }

    .form-group {
        margin-right: 0;
        margin-bottom: 15px; 
    }

    #submitBtn {
        width: 100%; 
    }
}
/* Mobile View */
@media (max-width: 768px) {
    .car-details {
        flex-direction: column;
        align-items: flex-start;
    }

    .car-details li {
        margin-bottom: 10px; /* Adjust spacing between items */
        display: block;
    }

    .car-details svg {
        width: 20px; /* Smaller icons for mobile */
        height: 20px;
    }

    .car-details .fuel-icon path {
        fill: #82aec0;
    }

    .car-details .body-type path {
        fill: #e00000;
    }

    .car-details .engine-type path {
        stroke: #e00000;
        stroke-width: 1.5;
    }

    .car-details .other-icon path {
        fill: #c20f0f;
    }
}

@media (max-width: 768px) { /* Adjust breakpoint as needed */
    li.no-wrap {
      white-space: nowrap;
      display: flex;
    }
  }
        </style>
<body>

<?php include('includes/header.php'); ?>
    <div class="progress-container">
        <div class="progress-bar" style="width: 10%;">10% Complete</div>
    </div>
    <div class="booking-form-container">
        
    <form class="booking-form" method="post" id="bookingForm">
        <div class="form-row">
            <div class="form-group">
                <label for="fromdate">Pick Up Date:</label>
                <input type="date" name="fromdate" id="fromdate" onchange="calculateDurationAndPrice()" required>
            </div>
            <div class="form-group">
                <label for="pickuptime">Pick-Up Time:</label>
                <input type="time" class="form-control" name="pickuptime" id="pickuptime" required>
            </div>
            <div class="form-group">
                <label for="todate">Return Date:</label>
                <input type="date" name="todate" id="todate" onchange="calculateDurationAndPrice()" required>
            </div>
            <div class="form-group">
                <label for="returntime">Return Time:</label>
                <input type="time" class="form-control" name="returntime" id="returntime" required>
            </div>
        </div>
        
        <input type="hidden" id="vehicle_id" name="vehicle_id">
        <input type="hidden" id="pricePerDay" name="pricePerDay">
        <input type="hidden" id="bookingprice" name="bookingprice"> 

        <div id="selectedCar"></div>
        <div id="bookingDuration"></div>
        <div id="bookingPrice"></div>

        <button type="submit" id="submitBtn">Submit</button>


            <div class="car-list-container">
            <?php
    $sql = "SELECT friztann_vehicles.VehiclesTitle, 
                   friztann_brands.BrandName, 
                   friztann_brands.BrandLogo, 
                   friztann_vehicles.PricePerDay, 
                   friztann_vehicles.FuelType, 
                   friztann_vehicles.TransmissionType, 
                   friztann_vehicles.vehicle_id, 
                   friztann_vehicles.bodytype, 
                   friztann_vehicles.SeatingCapacity, 
                   friztann_vehicles.Vimage0
            FROM friztann_vehicles 
            JOIN friztann_brands ON friztann_brands.brand_id = friztann_vehicles.VehiclesBrand
            WHERE friztann_vehicles.STATUS != 'MAINTENANCE'";

    $query = $dbh->prepare($sql);

    $query->execute();

    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            ?>
                <div class="car-item">
                    <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage0); ?>" alt="Car Image">
                    <img src="admin/img/brand/<?php echo htmlentities($result->BrandLogo);?>" class="brand-logo" alt="brand-logo">
                    <div class="car-info">
                    <div class="car-details">
    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
    <li style="display: flex; align-items: center; margin-right: 0; color: white; font-size: 12px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 128 128" aria-hidden="true" style="margin-right: 5px;">
            <path fill="none" stroke="#616161" stroke-miterlimit="10" stroke-width="6" d="M79.69 62.69c7.36 15.65 30.45 32.94 32.41 42.77c1.34 6.7-3.33 12.26-9.19 11.2c-6.6-1.19-6.91-10.69-4.31-17.99c6.54-18.38 8.79-28.99 6.53-38.95l-1.08-4.68"/>
            <path fill="#82aec0" d="M80.82 56.1c-1.87 0-1.14-1.61-1.14-3.6V25.92c0-1.99-.73-3.6 1.14-3.6s5.12 1.11 5.12 3.6V52.5c0 1.99-3.25 3.6-5.12 3.6"/>
            <path fill="#f44336" d="M82.1 113.93V27.96C82.1 14.73 71.37 4 58.14 4H34.96C21.72 4 11 14.73 11 27.96v85.97c-3.3.97-5.71 4.02-5.71 7.63v.3c0 1.18.96 2.14 2.14 2.14h78.24c1.18 0 2.14-.96 2.14-2.14v-.3a7.95 7.95 0 0 0-5.71-7.63"/>
            <path fill="#fff" d="M65.68 56.57H26.93c-1.77 0-3.21-1.44-3.21-3.21V22.42c0-1.77 1.44-3.21 3.21-3.21h38.75c1.77 0 3.21 1.44 3.21 3.21v30.93a3.21 3.21 0 0 1-3.21 3.22"/>
            <path fill="#9e9e9e" d="M32.22 29.6h29.31v7.64H32.22zm0 11.76h29.31V49H32.22z"/>
            <path fill="#82aec0" d="M24.13 47c-.05.52-.81.52-.86.01c-.74-7.27-1.16-14.55-1.48-21.82c-.47-4.02 2.63-7.49 6.78-7.21c11.79-.35 23.64-.35 35.43-.01c4.14-.28 7.27 3.19 6.79 7.21c-.32 7.28-.75 14.57-1.49 21.85c-.05.52-.81.52-.86 0c-.77-7.53-1.19-15.07-1.53-22.59a2 2 0 0 0-.09-.45c-.25-.9-1.12-1.65-2.02-1.56c-.48.02-36.58.01-37.04-.01c-.9-.09-1.77.66-2.02 1.57q-.06.225-.09.45c-.34 7.51-.75 15.04-1.52 22.56"/>
            <ellipse cx="46.31" cy="84.08" fill="#f5f5f5" rx="16.79" ry="17.89"/>
            <path fill="#212121" d="M38.87 86.6c0-4.37 7.43-12.95 7.43-12.95s7.43 8.58 7.43 12.95s-3.33 7.92-7.43 7.92s-7.43-3.55-7.43-7.92"/>
            <path fill="#c62828" d="M11 110.03h71.1v3.89H11z"/>
            <path fill="none" stroke="#ff7555" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5" d="M17.45 22.04c.88-4.96 5.2-11.1 14.13-11.1"/>
            <path fill="#9e9e9e" d="m108.06 58.98l-5.796 1.472l-.955-3.76l5.795-1.473zm-3.29-29.13l6.73-12.2c.5-.9 1.16-1.7 1.95-2.35c2.46-2.02 7.97-6.58 9.13-7.84c1.51-1.64-1.29-5.1-3.28-3.73c-1.56 1.08-7.3 6.12-9.69 8.23c-.7.61-1.28 1.34-1.73 2.16l-7.07 12.82z"/>
            <path fill="#757575" d="m100.66 37.73l9.42-1.95l3.32 11.82c.53 2.08-.43 2.68-2.27 3.15l-6.66 1.85m-5.22-15.27l8.05 18.35l7.62-2.13c3.19-.93 3.1-3.53 2.61-5.46l-3.93-14.4z"/>
            <path fill="#f44336" d="m103.82 21.12l4.87 2.74c.65.36.89 1.17.56 1.83l-.97 1.94l2.25 1.7a8.57 8.57 0 0 1 3.16 4.77l.27 1.05l-6.96 1.79a2.74 2.74 0 0 0-1.95 3.34l3.21 12.63c.32 1.36.4 2.48-.97 2.78l-5.55 1.38c-1.32.29-2.63-.52-2.96-1.83L94.9 39.95c-1.74-6.85.94-9.17 1.5-10.3s3.5-4.21 3.5-4.21l2.01-3.76c.37-.69 1.23-.94 1.91-.56"/>
            <path fill="none" stroke="#ff7555" stroke-linecap="round" stroke-miterlimit="10" stroke-width="4" d="m106.8 29.34l-4.83-2.42"/>
        </svg>
        <?php echo htmlentities($result->FuelType); ?>
    </li>
    
<li style="display: flex; align-items: center; margin-right: 0; color: white; white-space: nowrap; font-size: 12px;"> 
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" style="margin-right: 5px;">
        <path fill="#e00000" d="M21.907 9.641a1.1 1.1 0 0 0-.088-1.05c-.27-.519-2.14-.647-2.056-.033c.034.248.1.416-.206.446a2.4 2.4 0 0 1-.137-.317l-.53-1.627a2.65 2.65 0 0 0-1.282-1.5l-.373-.2A3.9 3.9 0 0 0 15.4 4.9H8.605a3.9 3.9 0 0 0-1.837.457l-.372.2a2.65 2.65 0 0 0-1.282 1.5L4.58 8.682A2.4 2.4 0 0 1 4.444 9c-.308-.03-.241-.2-.207-.446c.084-.614-1.786-.486-2.056.033a1.1 1.1 0 0 0-.088 1.05a2.16 2.16 0 0 0 1.721.287l-1.079 1.317a2.1 2.1 0 0 0-.578 1.459l.029 5.364A1.083 1.083 0 0 0 3.3 19.1h1.644a.5.5 0 0 0 .516-.475v-.021L5.432 17.4h13.142l-.029 1.21a.5.5 0 0 0 .5.5h1.664a1.083 1.083 0 0 0 1.116-1.04l.03-5.364a2.1 2.1 0 0 0-.578-1.459l-1.091-1.324a2.16 2.16 0 0 0 1.721-.282M5.388 8.9a3.18 3.18 0 0 1 3.279-3.07h6.666a3.183 3.183 0 0 1 3.281 3.076v.45a.125.125 0 0 1-.125.124H5.512a.124.124 0 0 1-.124-.124Zm1.393 4.029a.25.25 0 0 1-.205.115h-3.06c-.136 0-.418-.062-.418-.475l.207-1.069c.071-.372.806-.351 1.133-.156L6.7 12.591a.25.25 0 0 1 .081.342zM20.7 11.5l.207 1.073c0 .413-.282.475-.418.475h-3.06a.247.247 0 0 1-.124-.457l2.266-1.247c.318-.195 1.053-.218 1.129.156"/>
    </svg>
    <?php echo htmlentities($result->bodytype); ?>
</li>


<li class="custom-vehicle-item" style="display: flex; align-items: center; margin-right: 0; color: white; font-size: 12px;">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" style="margin-right: 5px;">
        <g fill="none" stroke="#e00000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3">
            <path fill="#e00000" fill-opacity="0" stroke-dasharray="48" stroke-dashoffset="48" d="M11 9h6v10h-6.5l-2 -2h-2.5v-6.5l1.5 -1.5Z">
                <animate fill="freeze" attributeName="fill-opacity" begin="1.95s" dur="0.75s" values="0;1"/>
                <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.9s" values="48;0"/>
            </path>
            <path fill="#e00000" fill-opacity="0" d="M17 13h0v-3h0v8h0v-3h0z" opacity="0">
                <animate fill="freeze" attributeName="d" begin="0.9s" dur="0.3s" values="M17 13h0v-3h0v8h0v-3h0z;M17 13h4v-3h1v8h-1v-3h-4z"/>
                <set fill="freeze" attributeName="fill-opacity" begin="1.2s" to="1"/>
                <set fill="freeze" attributeName="opacity" begin="0.9s" to="1"/>
            </path>
            <path d="M6 14h0M6 11v6" opacity="0">
                <animate fill="freeze" attributeName="d" begin="1.2s" dur="0.3s" values="M6 14h0M6 11v6;M6 14h-4M2 11v6"/>
                <set fill="freeze" attributeName="opacity" begin="1.2s" to="1"/>
            </path>
            <path d="M11 9v0M8 9h6" opacity="0">
                <animate fill="freeze" attributeName="d" begin="1.5s" dur="0.3s" values="M11 9v0M8 9h6;M11 9v-4M8 5h6"/>
                <set fill="freeze" attributeName="opacity" begin="1.5s" to="1"/>
            </path>
        </g>
    </svg>
    <?php echo htmlentities($result->TransmissionType); ?>
</li>




<li style="display: flex; align-items: center; margin-right: 0; color: white; white-space: nowrap; font-size: 12px;">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="#f50000" d="M12 2a2 2 0 0 1 2 2c0 1.11-.89 2-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m.39 12.79a34 34 0 0 1 4.25.25c.06-2.72-.18-5.12-.64-6.04c-.13-.27-.31-.5-.5-.7l-8.07 6.92c1.36-.22 3.07-.43 4.96-.43M7.46 17c.13 1.74.39 3.5.81 5h2.07c-.29-.88-.5-1.91-.66-3c0 0 2.32-.44 4.64 0c-.16 1.09-.37 2.12-.66 3h2.07c.44-1.55.7-3.39.83-5.21a35 35 0 0 0-4.17-.25c-1.93 0-3.61.21-4.93.46M12 7S9 7 8 9c-.34.68-.56 2.15-.63 3.96l6.55-5.62C12.93 7 12 7 12 7m6.57-1.33l-1.14-1.33l-3.51 3.01c.55.19 1.13.49 1.58.95zm2.1 10.16c-.09-.03-1.53-.5-4.03-.79c-.01.57-.04 1.16-.08 1.75c2.25.28 3.54.71 3.56.71zm-13.3-2.87l-3.94 3.38l.89 1.48c.02-.01 1.18-.46 3.14-.82c-.11-1.41-.14-2.8-.09-4.04"/>
    </svg>
    <?php echo htmlentities($result->SeatingCapacity); ?> seats
</li>




    </ul>
</div>
                        <div class="car-title"><?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?></div>
                        <div class="price">₱<?php echo htmlentities($result->PricePerDay); ?> /Day</div>
                        <button type="button" class="btn btn-primary select-car-btn" data-id="<?php echo htmlentities($result->vehicle_id); ?>" data-name="<?php echo htmlentities($result->BrandName . ' ' . $result->VehiclesTitle); ?>" data-price="<?php echo htmlentities($result->PricePerDay); ?>" required>BOOK</button>
                    </div>
                </div>
                <?php
                    }
                }
                ?>
            </div>
        </form>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const pickUpTimeInput = document.getElementById("pickuptime");
        const returnTimeInput = document.getElementById("returntime");

        pickUpTimeInput.addEventListener("change", function() {
            const pickUpTime = pickUpTimeInput.value;

            if (pickUpTime) {
                const pickUpDate = new Date(`2023-01-01T${pickUpTime}`);

                pickUpDate.setHours(pickUpDate.getHours() + 24);

                const returnHours = ('0' + pickUpDate.getHours()).slice(-2);
                const returnMinutes = ('0' + pickUpDate.getMinutes()).slice(-2);
                const returnTime = `${returnHours}:${returnMinutes}`;

                returnTimeInput.value = returnTime;
            }
        });
    });
</script>
    <script>

(function() {
    function calculateDurationAndPrice() {
        var progress = 0;
        var filledFields = document.querySelectorAll('input[type="date"]:valid, input[type="time"]:valid').length;
        var totalFields = document.querySelectorAll('input[type="date"], input[type="time"]').length;

        if (totalFields > 0) {
            progress = (filledFields / totalFields) * 80;
        }

        var selectedCar = document.querySelector('.car-item.selected');
        if (selectedCar) {
            progress += 20;
        }

        var progressBar = document.querySelector('.progress-bar');
        if (progressBar) {
            progressBar.style.width = progress + '%';
            progressBar.innerText = progress.toFixed(0) + '% Complete';
        }

        var fromDate = new Date(document.getElementById('fromdate').value);
        var toDate = new Date(document.getElementById('todate').value);

        if (isNaN(fromDate.getTime()) || isNaN(toDate.getTime())) {
            document.getElementById('bookingDuration').innerText = 'Please select valid dates';
            document.getElementById('bookingPrice').innerText = '';
            return;
        }

        var duration = toDate.getTime() - fromDate.getTime();
        var days = Math.ceil(duration / (1000 * 60 * 60 * 24));

        var pricePerDayInPHP = parseFloat(document.getElementById('pricePerDay').value);
        if (isNaN(pricePerDayInPHP)) {
            document.getElementById('bookingDuration').innerText = 'Booking Duration: ' + days + ' days';
            document.getElementById('bookingPrice').innerText = 'Please select a car to see the price';
            return;
        }

        var bookingpriceInPHP = days * pricePerDayInPHP;

        document.getElementById('bookingDuration').innerText = 'Booking Duration: ' + days + ' days';
        document.getElementById('bookingPrice').innerText = 'Booking Price: ₱' + bookingpriceInPHP.toFixed(2);
        document.getElementById('bookingprice').value = bookingpriceInPHP.toFixed(2);
    }

    function redirectToPage() {
        window.location.href = "Reservation-Form.php";
    }

    document.querySelectorAll('.select-car-btn').forEach(function(element) {
        element.addEventListener('click', function() {
            document.querySelectorAll('.car-item.selected').forEach(function(item) {
                item.classList.remove('selected');
            });

            this.closest('.car-item').classList.add('selected');

            var vehicle_idInput = document.getElementById('vehicle_id');
            var pricePerDayInput = document.getElementById('pricePerDay');
            if (vehicle_idInput && pricePerDayInput) {
                vehicle_idInput.value = this.dataset.id;
                pricePerDayInput.value = this.dataset.price;
            }

            document.getElementById('selectedCar').innerText = 'Selected Car: ' + this.dataset.name;
            calculateDurationAndPrice();
        });
    });

    document.querySelectorAll('input[type="date"], input[type="time"]').forEach(function(element) {
        element.addEventListener('input', calculateDurationAndPrice);
    });

    var proceedButton = document.getElementById('proceedButton');
    if (proceedButton) {
        proceedButton.addEventListener('click', function() {
            redirectToPage();
        });
    }
})();
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Get today's date
    const today = new Date();
    
    // Format today's date as YYYY-MM-DD for the input min attribute
    const formattedDate = today.toISOString().split('T')[0];
    
    // Get the date input element
    const dateInput = document.getElementById('fromdate');
    
    // Set the minimum date to today
    dateInput.min = formattedDate;
    
    // Add event listener to validate date selection
    dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        if (selectedDate < today) {
            alert('Please select a future date');
            this.value = '';
        }
        calculateDurationAndPrice(); // Keep your existing calculation function
    });
});
    </script>
    <script>
 document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];

    const pickupDate = document.getElementById('fromdate');
    const returnDate = document.getElementById('todate');

    // Set today's date as the default for pickup date
    pickupDate.value = formattedDate;

    // Set minimum date for both inputs to today
    pickupDate.min = formattedDate;
    returnDate.min = formattedDate;

    // Update return date minimum when pickup date changes
    pickupDate.addEventListener('change', function() {
        if (this.value) {
            // Calculate the next day after pickup
            const nextDay = new Date(this.value);
            nextDay.setDate(nextDay.getDate() + 1);
            const formattedNextDay = nextDay.toISOString().split('T')[0];

            // Set minimum return date to the day after pickup
            returnDate.min = formattedNextDay;

            // If return date is earlier than or equal to pickup date, clear it
            if (returnDate.value && returnDate.value <= this.value) {
                returnDate.value = '';
                alert('Return date must be at least one day after pickup date');
            }
        }
        calculateDurationAndPrice();
    });

    // Validate return date
    returnDate.addEventListener('change', function() {
        const pickupValue = pickupDate.value;
        const returnValue = this.value;

        if (!pickupValue) {
            alert('Please select a pickup date first');
            this.value = '';
            return;
        }

        // Check if return date is same as or before pickup date
        if (returnValue <= pickupValue) {
            alert('Return date must be at least one day after pickup date');
            this.value = '';
        }

        calculateDurationAndPrice();
    });
});
</script>
        <?php include('includes/footer.php');?>
    <div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
    <?php include('includes/login.php');?>
<?php include('includes/registration.php');?>
<?php include('includes/forgotpassword.php');?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>
