<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>FritzAnn Shuttle Services |Booking history</title>
<!--Bootstrap -->
<link href="assets/css/bookinghistory.css" rel="stylesheet">

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 
</head>
<body>
<style>

</style>  
<a href="my-booking.php" class="back-button">Back</a>
<?php 
$useremail = $_SESSION['login'];
$sql = "SELECT * FROM friztann_users WHERE EmailId = :useremail";
$query = $dbh->prepare($sql);
$query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $result) { 
        $avatar = $result->ProfileImg ? "admin/avatar/" . $result->ProfileImg : "design/download.jpg";
       
    }
}?>
<section class="user_profile inner_pages">
    <div class="container">
        <div class="user_profile_info gray-bgs padding_4x4_40">
        <div class="upload_user_logo">
        <img src="<?php echo $avatar; ?>" alt="Avatar" style="width: 250px; height: 190px; border-radius: 50%; border: 2px solid #000;">


  </div>
  <div class="dealer_info">
    <?php
    $useremail = $_SESSION['login'];
    $sql = "SELECT * from friztann_users where EmailId=:useremail";
    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            ?>
            <h5><?php echo htmlentities($result->FirstName); ?> <?php echo htmlentities($result->MiddleName); ?> <?php echo htmlentities($result->LastName); ?></h5>
            <p><?php echo htmlentities($result->Barangay); ?> <?php echo htmlentities($result->City); ?> <?php echo htmlentities($result->Province); ?></p>
        <?php }
    } ?>
</div>
</div>
<div class="container">
    <div class="profile_wrap">
        <h2>Booking History</h2>
        <div class="my_vehicles_list">
            <ul class="vehicle_listing">
            <?php
                $useremail = $_SESSION['login'];
                $sql = "SELECT * from friztann_users where EmailId=:useremail";
                $query = $dbh->prepare($sql);
                $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                        ?>
                       

                    <?php }
                } ?>
               
<?php
$sql = "SELECT 
friztann_vehicles.vimage0 AS vimage0, 
friztann_vehicles.VehiclesTitle, 
friztann_vehicles.vehicle_id AS vid, 
friztann_brands.BrandName, 
friztann_booking.FromDate, 
friztann_booking.ToDate, 
friztann_booking.pickuptime, 
friztann_booking.returntime, 
friztann_booking.BookingHours, 
friztann_vehicles.STATUS AS VehicleStatus,
friztann_vehicles.FuelType,
friztann_vehicles.bodytype,
friztann_vehicles.TransmissionType,
friztann_vehicles.SeatingCapacity,
friztann_bookinginfo.selectedLocation,
friztann_users.FirstName,
friztann_users.MiddleName,
friztann_users.LastName
FROM friztann_booking
JOIN friztann_vehicles ON friztann_booking.vehicle_id = friztann_vehicles.vehicle_id
JOIN friztann_brands ON friztann_vehicles.VehiclesBrand = friztann_brands.brand_id
JOIN friztann_users ON friztann_users.EmailId = friztann_booking.userEmail
LEFT JOIN friztann_bookinginfo ON friztann_booking.booking_id = friztann_bookinginfo.booking_info_id
WHERE friztann_booking.Status = 1";

$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        ?>
        <li>
            <div class="vehicle_img">
                <a href="car-details.php?vhid=<?php echo htmlentities($result->vid); ?>">
                    <img src="admin/img/vehicleimages/<?php echo htmlentities($result->vimage0); ?>" alt="image">
                </a>
            </div>
            <div class="vehicle_title">
                <h6>
                <a href="car-details.php?vhid=<?php echo htmlentities($result->vid); ?>" style="text-transform: uppercase;">
    <?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->VehiclesTitle); ?>
</a>

                </h6>
                <p>
                
                <b style="font-size: 19px; color: #c1b8b8;">Name:</b> 
<span style="font-size: 19px; color: #5d5d5d;">
    <span style="padding: 9px; margin: 20px; border: 1px solid #ccc; background-color: #715a5a; border-radius: 10px; font-size: 16px; color: black; font-weight: bold;"><?php echo htmlentities(trim($result->FirstName)) . ' ' . htmlentities(trim($result->MiddleName)) . ' ' . htmlentities(trim($result->LastName)); ?></span>
</span><br>



                    <b>Booking Days:</b> <?php echo htmlentities($result->BookingHours); ?><br>
                    <b>Pick up Date:</b> <?php echo htmlentities($result->FromDate); ?><br>
                    <b>Return Date:</b> <?php echo htmlentities($result->ToDate); ?><br>
                    <b>Pick up Time:</b> <?php echo htmlentities($result->pickuptime); ?><br>
                    <b>Return Time:</b> <?php echo htmlentities($result->returntime); ?><br>
                    <b>Fuel Type:</b> <?php echo htmlentities($result->FuelType); ?><br>
                    <b>Body Type:</b> <?php echo htmlentities($result->bodytype); ?><br>
                    <b>Engine type:</b> <?php echo htmlentities($result->TransmissionType); ?><br>
                    <b>Seating Capacity:</b> <?php echo htmlentities($result->SeatingCapacity); ?><br>
                </p>
            </div>
            <div class="status_paid">
            <img src="paid.png" alt="Paid">
            </div>
        </li>
        <?php
    }
} else {
    echo "<li>No confirmed bookings found.</li>";
}
?>
                           </ul>
                       </div>
                   </div>
                   <div class="similar_wrap">
                       <h2 class="section-title">Similar Car Booked</h2>
                       <div class="similar_vehicles_list">
                           <ul class="vehicle_listing">
                               
                           <?php
$sql_similar = "
    SELECT 
        friztann_vehicles.vimage0 AS vimage0,
        friztann_vehicles.VehiclesTitle AS VehiclesTitle,
        friztann_vehicles.vehicle_id AS vid,
        friztann_brands.BrandName AS BrandName,
        COUNT(friztann_booking.vehicle_id) AS BookingCount
    FROM friztann_booking
    JOIN friztann_vehicles 
        ON friztann_booking.vehicle_id = friztann_vehicles.vehicle_id
    JOIN friztann_brands 
        ON friztann_brands.brand_id = friztann_vehicles.VehiclesBrand
    WHERE friztann_booking.Status = 1
    GROUP BY friztann_booking.vehicle_id
    ORDER BY BookingCount DESC
    LIMIT 10000
";

// Assuming $dbh is your PDO connection
$query_similar = $dbh->prepare($sql_similar);
$query_similar->execute();
$results_similar = $query_similar->fetchAll(PDO::FETCH_OBJ);

if ($query_similar->rowCount() > 0) {
    foreach ($results_similar as $result_similar) {
?>
        <li>
            <div class="vehicle_img">
                <a href="car-details.php?vhid=<?php echo htmlentities($result_similar->vid); ?>">
                    <img src="admin/img/vehicleimages/<?php echo htmlentities($result_similar->vimage0); ?>" alt="image">
                </a>
            </div>
            <div class="vehicle_title">
                <h6>
                    <a href="car-details.php?vhid=<?php echo htmlentities($result_similar->vid); ?>" style="text-transform: uppercase;">
                        <?php echo htmlentities($result_similar->BrandName); ?>, <?php echo htmlentities($result_similar->VehiclesTitle); ?>
                    </a>
                </h6>
                <p>
                    <b>Times Booked:</b> 
                    <span style="font-size: 18px; color: red; font-weight: bold;">
                        <?php echo htmlentities($result_similar->BookingCount); ?>
                    </span>
                </p>
            </div>
        </li>
<?php
    }
} else {
    echo "<li>No similar car bookings found.</li>";
}
?>

                           </ul>
                       </div>
                   </div>
                   </div>
</body>
</html>
