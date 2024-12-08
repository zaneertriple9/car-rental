<?php
session_start();
include('includes/config.php');
error_reporting(1);

if (isset($_POST['submit'])) {
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $pickuptime = $_POST['pickuptime'];
    $returntime = $_POST['returntime'];
    $useremail = $_SESSION['login'];
    $vhid = $_GET['vhid'];
    $status = 0;  
    $user_status_sql = "SELECT status FROM friztann_users WHERE EmailId = :useremail";
    $user_status_query = $dbh->prepare($user_status_sql);
    $user_status_query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $user_status_query->execute();
    $user_status = $user_status_query->fetchColumn();
    
    // Check if the status is 2, blank, or null (no status)
    if ($user_status == 2 || $user_status === '' || $user_status === null) {
        header("Location: bookingsummary.php");
        exit();
    }
    

    $check_status_sql = "SELECT Status FROM friztann_vehicles WHERE vehicle_id = :vhid";
    $check_status_query = $dbh->prepare($check_status_sql);
    $check_status_query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
    $check_status_query->execute();
    $vehicle_status = $check_status_query->fetchColumn();

    if ($vehicle_status == 'MAINTENANCE') {
        echo "<script>alert('The car is currently under maintenance and cannot be booked at this time. Please try again later.');</script>";
    } else {
        $booking_days = floor((strtotime($todate) - strtotime($fromdate)) / (60 * 60 * 24));
        $fromdatetime = $fromdate . ' ' . $pickuptime;
        $todatetime = $todate . ' ' . $returntime;

        $check_sql = "SELECT * FROM friztann_booking
                    WHERE vehicle_id = :vhid 
                    AND ((FromDate < :fromdate AND ToDate > :fromdate)
                    OR (FromDate < :todate AND ToDate > :todate)
                    OR (FromDate >= :fromdate AND ToDate <= :todate)
                    OR (ToDate = :fromdate AND returntime > :pickuptime))";
        $check_query = $dbh->prepare($check_sql);
        $check_query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
        $check_query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $check_query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $check_query->bindParam(':pickuptime', $pickuptime, PDO::PARAM_STR);
        $check_query->execute();

        $check_noacc_sql = "SELECT * FROM friztann_noaccbooking
                            WHERE vehicle_id = :vhid 
                            AND (:fromdatetime < CONCAT(ToDate, ' ', ReturnTime) 
                            AND :todatetime > CONCAT(FromDate, ' ', PickupTime))";
        $check_noacc_query = $dbh->prepare($check_noacc_sql);
        $check_noacc_query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
        $check_noacc_query->bindParam(':fromdatetime', $fromdatetime, PDO::PARAM_STR);
        $check_noacc_query->bindParam(':todatetime', $todatetime, PDO::PARAM_STR);
        $check_noacc_query->execute();

        $check_admin_sql = "SELECT * FROM friztann_walkin
                            WHERE vehicle_id = :vhid 
                            AND (:fromdatetime < CONCAT(ToDate, ' ', ReturnTime) 
                            AND :todatetime > CONCAT(FromDate, ' ', PickupTime))";
        $check_admin_query = $dbh->prepare($check_admin_sql);
        $check_admin_query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
        $check_admin_query->bindParam(':fromdatetime', $fromdatetime, PDO::PARAM_STR);
        $check_admin_query->bindParam(':todatetime', $todatetime, PDO::PARAM_STR);
        $check_admin_query->execute();

        if ($check_query->rowCount() == 0 && $check_noacc_query->rowCount() == 0 && $check_admin_query->rowCount() == 0) {

            $sql_price = "SELECT PricePerDay FROM friztann_vehicles WHERE vehicle_id = :vhid";
            $query_price = $dbh->prepare($sql_price);
            $query_price->bindParam(':vhid', $vhid, PDO::PARAM_STR);
            $query_price->execute();
            $result_price = $query_price->fetch(PDO::FETCH_ASSOC);
            $pricePerDay = $result_price['PricePerDay'];

            $bookingprice = ($pricePerDay * $booking_days) - 500;

            $pickupTimeFormatted = DateTime::createFromFormat('H:i', $pickuptime)->format('g:i a');
            $returnTimeFormatted = DateTime::createFromFormat('H:i', $returntime)->format('g:i a');

            $sql = "INSERT INTO friztann_booking(userEmail, vehicle_id, FromDate, ToDate, Status, BookingHours, pickuptime, returntime, BookingPrice) 
                    VALUES(:useremail, :vhid, :fromdate, :todate, :status, :booking_days, :pickuptime, :returntime, :bookingprice)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
            $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
            $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
            $query->bindParam(':todate', $todate, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->bindParam(':booking_days', $booking_days, PDO::PARAM_STR);
            $query->bindParam(':pickuptime', $pickupTimeFormatted, PDO::PARAM_STR);
            $query->bindParam(':returntime', $returnTimeFormatted, PDO::PARAM_STR);
            $query->bindParam(':bookingprice', $bookingprice, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {
                $update_status_sql = "UPDATE friztann_vehicles SET STATUS = 'MAINTENANCE' WHERE vehicle_id = :vhid";
                $update_status_query = $dbh->prepare($update_status_sql);
                $update_status_query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
                $update_status_query->execute();

                if ($user_status == 1) {
                    echo "<script>alert('Booking processed successfully'); window.location.href = 'booking-form.php';</script>";
                } elseif ($user_status == 2) {
                    header("Location: bookingsummary.php");
                    exit();
                }
            } else {
                echo "<script>alert('Something went wrong. Please try again');</script>";
            }
        } else {
            echo "<script>alert('The car is already booked for the selected dates. Please choose different dates.');</script>";
        }
    }
}
?>

    
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>FritzAnn Shuttle Services |Car Details</title>
      <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link href="assets/css/cardetails.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<body>
<?php include('includes/header.php');?>

<?php 
$vhid = intval($_GET['vhid']);
$sql = "SELECT friztann_vehicles.*, friztann_brands.BrandName, friztann_brands.BrandLogo, friztann_brands.brand_id as bid 
        FROM friztann_vehicles 
        JOIN friztann_brands ON friztann_brands.brand_id = friztann_vehicles.VehiclesBrand 
        WHERE friztann_vehicles.vehicle_id = :vhid";
$query = $dbh->prepare($sql);
$query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        $_SESSION['brndid'] = $result->bid;
        ?>

<section id="friztannlisting_img_slider" class="vehicle-showcase">
    <div class="friztannmain-image-container">
    <button class="fullscreen-btn">
    <span class="fullscreen-icon"></span>
</button>

        <img id="friztannmainmainImage" src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive main-img" alt="main image">
        <div class="image-overlay">
            <span class="image-count">1 / <?php echo $result->Vimage3 != "" ? "3" : "2"; ?></span>
        </div>
    </div>
    
    <div class="friztannmage-thumbnails">
        <div class="thumbnail-container">
            <div class="thumbnail active" onclick="changeImage('admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>', 0)">
                <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="thumbnail 1">
            </div>
            <div class="thumbnail" onclick="changeImage('admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2); ?>', 1)">
                <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2); ?>" alt="thumbnail 2">
            </div>
            <?php if($result->Vimage3 != "") { ?>
                <div class="thumbnail" onclick="changeImage('admin/img/vehicleimages/<?php echo htmlentities($result->Vimage3); ?>', 2)">
                    <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage3); ?>" alt="thumbnail 3">
                </div>
            <?php } ?>
            
        </div>
    </div>

    <div class="navigation-arrows">
        <button class="nav-arrow prev" onclick="changeSlide(-1)">&#10094;</button>
        <button class="nav-arrow next" onclick="changeSlide(1)">&#10095;</button>
    </div>
</section>


<div class="cyberpunk-heading">
    <svg viewBox="0 0 800 150" xmlns="http://www.w3.org/2000/svg">
        <rect width="100%" height="100%" fill="#000000"/>
        
        <polygon points="0,0 100,0 0,100" fill="#ff0000" opacity="0.5"/>
        <polygon points="800,150 700,150 800,50" fill="#ff0000" opacity="0.5"/>
        
        <path d="M0 75 H800 M200 0 V150 M600 0 V150" stroke="#ffffff" stroke-width="1" opacity="0.2"/>
    </svg>
    
    <div class="glitch-effect">
        <svg width="100%" height="100%">
            <rect width="100%" height="100%" fill="#ffffff" opacity="0.1">
                <animate attributeName="x" values="-100%;0%;100%" dur="10s" repeatCount="indefinite"/>
            </rect>
        </svg>
    </div>
    
    <span class="brand-name"><?php echo htmlentities($result->BrandName); ?></span>
    <span class="vehicle-title"><?php echo htmlentities($result->VehiclesTitle); ?></span>
</div>


<section class="listing-detail" style="background-color: #7f0000;">
    <div class="container">
        <div class="listing_detail_head row">
            <div class="col-md-9">
 
<div class="main_features">
<ul style="list-style-type: none; padding: 0; display: flex; justify-content: space-around;  font-family: 'Courier New', monospace;">
<li style="flex: 1 1 200px; background-color: black; border-radius: 10px; padding: 15px; box-shadow: 0 0 10px rgba(255,0,0,0.5); transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 0 20px rgba(255,0,0,0.8)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 10px rgba(255,0,0,0.5)'">
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
        <g fill="none" stroke="#e70d0d" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3">
            <path stroke-dasharray="64" stroke-dashoffset="64" d="M12 3c4.97 0 9 4.03 9 9c0 4.97 -4.03 9 -9 9c-4.97 0 -9 -4.03 -9 -9c0 -4.97 4.03 -9 9 -9Z">
                <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="64;0"/>
            </path>
            <path stroke-dasharray="8" stroke-dashoffset="8" d="M12 12h-5.5">
                <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.3s" dur="0.2s" values="8;0"/>
                <animateTransform attributeName="transform" begin="1.3s" dur="15s" repeatCount="indefinite" type="rotate" values="0 12 12;15 12 12;165 12 12;65 12 12;115 12 12;165 12 12;165 12 12;165 12 12;90 12 12;115 12 12;115 12 12;15 12 12;0 12 12"/>
            </path>
        </g>
        <g fill="#e70d0d">
            <path fill-opacity="0" d="M12 21C9.41 21 7.15 20.79 5.94 19L12 21L18.06 19C16.85 20.79 14.59 21 12 21Z">
                <animate fill="freeze" attributeName="d" begin="0.6s" dur="0.4s" values="M12 21C9.41 21 7.15 20.79 5.94 19L12 21L18.06 19C16.85 20.79 14.59 21 12 21Z;M12 16C9.41 16 7.15 17.21 5.94 19L12 21L18.06 19C16.85 17.21 14.59 16 12 16Z"/>
                <set fill="freeze" attributeName="fill-opacity" begin="0.6s" to="1"/>
            </path>
            <circle cx="7" cy="12" r="0" transform="rotate(15 12 12)">
                <animate fill="freeze" attributeName="r" begin="0.9s" dur="0.2s" values="0;1"/>
            </circle>
            <circle cx="7" cy="12" r="0" transform="rotate(65 12 12)">
                <animate fill="freeze" attributeName="r" begin="0.95s" dur="0.2s" values="0;1"/>
            </circle>
            <circle cx="7" cy="12" r="0" transform="rotate(115 12 12)">
                <animate fill="freeze" attributeName="r" begin="1s" dur="0.2s" values="0;1"/>
            </circle>
            <circle cx="7" cy="12" r="0" transform="rotate(165 12 12)">
                <animate fill="freeze" attributeName="r" begin="1.05s" dur="0.2s" values="0;1"/>
            </circle>
            <circle cx="12" cy="12" r="0">
                <animate fill="freeze" attributeName="r" begin="1.3s" dur="0.2s" values="0;2"/>
            </circle>
        </g>
    </svg>
<h5 style="margin: 10px 0 5px; font-size: 16px; color: black; text-transform: uppercase; letter-spacing: 2px; white-space: nowrap;">Shifting Type</h5>
    <p style="margin: 0; font-size: 18px; font-weight: bold; color: #ff0000;"><?php echo htmlentities($result->TransmissionType);?></p>
</li>
<li style="flex: 1 1 200px; background-color: black; border-radius: 10px; padding: 15px; box-shadow: 0 0 10px rgba(255,0,0,0.5); transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 0 20px rgba(255,0,0,0.8)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 10px rgba(255,0,0,0.5)'">
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 32 32">
        <g fill="none">
            <path fill="#f8312f" d="M7 29.01V3.99C7 2.89 7.89 2 8.99 2h12.02c1.1 0 1.99.89 1.99 1.99v25.02z"/>
            <path fill="currentColor" d="M26 12.5a.5.5 0 1 1-1 0a.5.5 0 0 1 1 0m0 12V13h1v11.5c0 .83-.67 1.5-1.5 1.5s-1.5-.67-1.5-1.5v-7c0-.28-.22-.5-.5-.5l-.098-.004c-.137-.007-.357-.019-.402.004v-1c.032-.008.305-.003.435-.001L23.5 16c.83 0 1.5.67 1.5 1.5v7c0 .28.22.5.5.5s.5-.22.5-.5"/>
            <path fill="#000000" d="M10.03 12h9.94c.57 0 1.03-.46 1.03-1.03V5.03C21 4.46 20.54 4 19.97 4h-9.94C9.46 4 9 4.46 9 5.03v5.94c0 .57.46 1.03 1.03 1.03M7 28h16.01c.55 0 .99.44.99.99V30H6v-1c0-.55.45-1 1-1M23 7.45c0 .07.01.13.04.19l.92 2.01c.03.06.04.13.04.19v3.1c0 .59.44 1.05.99 1.05h1.59c.23 0 .42-.2.42-.45V9.96a.46.46 0 0 0-.17-.36l-3.15-2.51c-.28-.22-.68-.01-.68.36m2.58 5.48h-.15c-.23 0-.42-.2-.42-.45v-1.65c0-.4.46-.6.72-.32l.15.16c.08.08.12.2.12.32v1.5c0 .24-.19.44-.42.44M7 14h16v1H7z"/>
            <path fill="currentColor" d="M9 6h12v-.97C21 4.46 20.54 4 19.97 4h-9.94C9.46 4 9 4.46 9 5.03zm6.5 1h4c.28 0 .5.22.5.5s-.22.5-.5.5h-4c-.28 0-.5-.22-.5-.5s.22-.5.5-.5"/>
        </g>
    </svg>
    <h5 style="margin: 10px 0 5px; font-size: 16px; color: black; text-transform: uppercase; letter-spacing: 2px;">Fuel Type</h5>
    <p style="margin: 0; font-size: 18px; font-weight: bold; color: #ff0000;"><?php echo htmlentities($result->FuelType);?></p>
</li>

<li style="flex: 1 1 200px; background-color: black; border-radius: 10px; padding: 15px; box-shadow: 0 0 10px rgba(255,0,0,0.5); transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 0 20px rgba(255,0,0,0.8)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 10px rgba(255,0,0,0.5)'">
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
      <g fill="none">
        <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/>
        <path fill="#e70d0d" d="M3.468 16.745c.495-.958 1.54-1.6 2.804-1.441a34 34 0 0 1 3.97.726c2.01.502 3.771 1.467 5.073 2.348l.44.306l.4.295l.358.276l.314.254l.267.226l.22.192c.843.751.27 1.978-.685 2.068l-.112.005H7.923c-1.682 0-3.08-.845-4.104-2.126c-.774-.967-.84-2.183-.35-3.129ZM19 2c.893 0 1.278.84 1.467 1.61l.06.268l.024.128c.144.797.221 1.842.252 2.916c.06 2.125-.062 4.602-.327 5.795c-.462 2.082-1.14 3.529-1.952 4.401c-.826.89-1.942 1.291-2.971.776c-.789-.394-1.26-1.331-1.518-2.13a5.73 5.73 0 0 1 .017-3.58c.21-.632.588-1.142 1.004-1.627l.363-.411c.442-.495.885-.99 1.187-1.593c.44-.88.56-1.843.597-2.81l.014-.58l.009-.56l.006-.138l.02-.28C17.347 3.107 17.716 2 19 2"/>
      </g>
    </svg>
    <h5 style="margin: 10px 0 5px; font-size: 16px; color: black; text-transform: uppercase; letter-spacing: 2px;">Seaters</h5>
    <p style="margin: 0; font-size: 18px; font-weight: bold; color: #ff0000;"><?php echo htmlentities($result->SeatingCapacity);?></p>
</li>


<li style="flex: 1 1 200px; background-color: black; border-radius: 10px; padding: 15px; box-shadow: 0 0 10px rgba(255,0,0,0.5); transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 0 20px rgba(255,0,0,0.8)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 10px rgba(255,0,0,0.5)'">
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" style="margin-bottom: 10px;">
        <path fill="#e30000" d="M3 21q-.425 0-.712-.288T2 20v-8l2.1-6q.15-.45.538-.725T5.5 5H9v1.375q0 .15.013.313T9.05 7h-3.2L4.8 10h6.375l3.35 3.35q-.25.2-.387.5T14 14.5q0 .625.438 1.063T15.5 16q.5 0 .9-.3t.525-.775q.275.05.537.075t.538-.025q.55-.05 1.063-.275t.937-.625V20q0 .425-.288.713T19 21h-1q-.425 0-.712-.288T17 20v-1H5v1q0 .425-.288.713T4 21zm3.5-5q.625 0 1.063-.437T8 14.5t-.437-1.062T6.5 13t-1.062.438T5 14.5t.438 1.063T6.5 16m10.05-3.45l-5.1-5.1q-.2-.2-.325-.488T11 6.376V2.5q0-.625.438-1.062T12.5 1h3.875q.3 0 .588.125t.487.325l5.1 5.1q.425.425.425 1.063t-.425 1.062l-3.875 3.875q-.425.425-1.062.425t-1.063-.425M15 6q.425 0 .713-.288T16 5t-.288-.712T15 4t-.712.288T14 5t.288.713T15 6" />
    </svg>
    <h5 style="margin: 10px 0 5px; font-size: 16px; color: black; text-transform: uppercase; letter-spacing: 2px;">Body Type</h5>
    <p style="margin: 0; font-size: 18px; font-weight: bold; color: #ff0000;"><?php echo htmlentities($result->bodytype);?></p>
</li>



</ul>
                </div>
            </div>
            <div class="col-md-3">
            
            <div class="col-md-3">
    <div class="price_info"> 
  
  
    <div style="
    position: relative;
    z-index: 2;
    white-space: nowrap;
    padding: 15px 25px;
    display: inline-block;

">
    <span style="
        color: white;
        font-size: 32px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-family: 'Orbitron', sans-serif;
    ">
        ₱<?php echo htmlentities($result->PricePerDay); ?>
    </span>
    <span style="
        color: black;
        font-size: 25px;
        font-weight: bold;
        font-family: 'Orbitron', sans-serif;
    ">:</span>
    <span style="
        color: black;
        font-size: 27px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: 'Orbitron', sans-serif;
    ">
        Per Day
    </span>
</div>

<div style="
    font-family: 'Arial', sans-serif;
    display: inline-block;
    position: relative;
    padding: 20px;
    background-color: #000000;
    border: 2px solid #ff0000;
    overflow: hidden;
">
    <svg width="100%" height="100%" style="position: absolute; top: 0; left: 0; z-index: 1;">
        <defs>
            <pattern id="diagonalHatch" patternUnits="userSpaceOnUse" width="8" height="8">
                <path d="M-2,2 l4,-4 M0,8 l8,-8 M6,10 l4,-4" style="stroke:#ff0000; stroke-width:1" />
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#diagonalHatch)" opacity="0.1">
            <animate attributeName="y" from="0" to="8" dur="0.5s" repeatCount="indefinite" />
        </rect>
        <rect width="100%" height="2" fill="#ff0000" opacity="0.5">
            <animate attributeName="y" from="0" to="100%" dur="2s" repeatCount="indefinite" />
        </rect>
    </svg>

    <?php
    if ($result->STATUS == 'MAINTENANCE') {
        echo '<span style="
            position: relative;
            z-index: 2;
            color: #ff0000;
            font-size: 40px;
            font-weight: bold;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: glitch 0.3s infinite;
        ">MAINTENANCE</span>';
    } else {
        echo '<span style="
            position: relative;
            z-index: 2;
            color: #ffffff;
            font-size: 40px;
            font-weight: bold;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 2px;
        ">Available</span>';
    }
    ?>
</div>
</div>
    </div>
        </div>
    
        <div class="row">
            <div class="col-md-9">
                <div class="main_features">

                <div class="friztann-main-features">
    <div class="friztann-main-features__requirement-box">
    <h2 style="font-family: 'Arial', sans-serif; color: black; border: 2px solid red; padding: 20px; background-color: #ecf0f1; border-radius: 10px;">
                    Requirement - Bring 2 Primary IDs
                </h2>        <ul>
                <p style="color: black; font-size: 18px;">
                Please be reminded to bring your two primary IDs (including your driver's license) with you when you pick up the car.</p>
                <p style="color: black; font-size: 18px;">
                The other primary ID provided will be checked by the assigned Fritzann employee for verification. For bookings, please ensure that the ID matches the one uploaded to your profile, allowing the assigned Fritzann employee to verify it accordingly.</p>
        </ul>
    </div>
    
    <div class="friztann-main-features__info-box friztann-main-features__late-returns">
    <h3>
    <span class="friztann-main-features__icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
            <g fill="none" stroke="#e70d0d" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3">
                <path stroke-dasharray="64" stroke-dashoffset="64" d="M12 3l9 17h-18l9-17Z">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.9s" values="64;0"/>
                </path>
                <path stroke-dasharray="6" stroke-dashoffset="6" d="M12 10v4">
                    <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.9s" dur="0.3s" values="6;0"/>
                </path>
                <path stroke-dasharray="2" stroke-dashoffset="2" d="M12 17v0.01">
                    <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.2s" dur="0.3s" values="2;0"/>
                </path>
            </g>
        </svg>
    </span> 
    Late Return
</h3>
        <p style="color: black; font-size: 18px;">
        Please return the car on time and estimate your travel time as accurately as possible, considering the traffic conditions in the Philippines. Failure to return the car to Friztann at the scheduled deadline shall result in a penalty of PHP 100 for every hour the car is not returned on time.</p>
    </div>
    
    <div class="friztann-main-features__info-box friztann-main-features__long-travel">
    <h3>
    <span class="friztann-main-features__icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
            <g fill="none" stroke="#e70d0d" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3">
                <path stroke-dasharray="64" stroke-dashoffset="64" d="M12 3l9 17h-18l9-17Z">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.9s" values="64;0"/>
                </path>
                <path stroke-dasharray="6" stroke-dashoffset="6" d="M12 10v4">
                    <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.9s" dur="0.3s" values="6;0"/>
                </path>
                <path stroke-dasharray="2" stroke-dashoffset="2" d="M12 17v0.01">
                    <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.2s" dur="0.3s" values="2;0"/>
                </path>
            </g>
        </svg>
    </span> 
    Maintenance Advisory
</h3>
        <p style="color: black; font-size: 20px;">
  If the car is under maintenance, please wait for the admin to change it or select another car!
</p>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Car Features</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>Air Conditioner</td>
                <td><?php echo $result->AirConditioner ? '<i class="fa fa-check" aria-hidden="true"></i>' : ''; ?></td>
            </tr>
            <tr>
                <td>Power Windows</td>
                <td><?php echo $result->PowerWindows ? '<i class="fa fa-check" aria-hidden="true"></i>' : ''; ?></td>
            </tr>
            <tr>
                <td>CD Player</td>
                <td><?php echo $result->CDPlayer ? '<i class="fa fa-check" aria-hidden="true"></i>' : ''; ?></td>
            </tr>
            <tr>
                <td>Central Locking</td>
                <td><?php echo $result->CentralLocking ? '<i class="fa fa-check" aria-hidden="true"></i>' : ''; ?></td>
            </tr>
            <tr>
                <td>Power Door Locks</td>
                <td><?php echo $result->PowerDoorLocks ? '<i class="fa fa-check" aria-hidden="true"></i>' : ''; ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
                <div class="listing_more_info">
                    <div class="listing_detail_wrap"> 
                       
                        <div class="tab-content"> 
                           
                            <div role="tabpanel" class="tab-pane" id="accessories"> 
                            
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php }} ?>
<aside class="col-md-3">
    <div class="sidebar_widget">
        <div class="widget_heading">
        <h5 style="color: black;"><i class="far fa-address-book" aria-hidden="true"></i> Book Now</h5>

            <div class="share_vehicle">
                <div id="bookingDuration" style="font-weight: bold; color: white; line-height: 2;"></div>
                <div id="bookingPrice" style="font-weight: bold; color: white; line-height: 2;"></div>
                <div id="calendar"></div>
            </div>
            <form method="post">
                <div class="form-group">
                    <label for="fromdate">Pick Up Date:</label>
                    <input type="date" class="form-control" name="fromdate" id="fromdate" onchange="calculateDurationAndPrice()" required>
                </div>
                <div class="form-group">
                    <label for="todate">Return Date:</label>
                    <input type="date" class="form-control" name="todate" id="todate" onchange="calculateDurationAndPrice()" required>
                </div>
                <div class="time-picker-group">
    <label for="pickuptime">Pick-Up Time:</label>
    <input type="time" class="time-picker-input" name="pickuptime" id="pickuptime" required>
</div>
<div class="time-picker-group">
    <label for="returntime">Return Time:</label>
    <input type="time" class="time-picker-input" name="returntime" id="returntime" required>
</div>
                <?php if($_SESSION['login']) { ?>
                    <div class="form-group">
                    <input type="submit" class="btn" name="submit" value="Book Now" 
       style="margin-top: 20px; width: 240px; height: 50px; background-color: black; color: white; border: 1px solid black;" 
       onmouseover="this.style.backgroundColor='red'" 
       onmouseout="this.style.backgroundColor='black'">
                    </div>
                    <a href="car-listing.php" style="display: inline-block; padding: 10px 20px; margin-top: 5px; width: 240px; height: 50px; background-color: #252525; color: white; text-align: center; text-decoration: none; border-radius: 4px; font-weight: bold;">
  <span style="display: flex; align-items: center; justify-content: center; height: 100%;">
    <span style="display: flex; align-items: center; justify-content: center; width: 24px; height: 24px; border: 2px solid white; border-radius: 50%; margin-right: 8px;">
      <i class="fas fa-arrow-left"></i>
    </span>
    SELECT ANOTHER CAR
  </span>
</a>

                <?php } else { ?>
                    <a href="#loginform" class="b btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login For Book</a>
                <?php } ?>
            </form>
        </div>
    </div>
</aside>
</section>
<script>
    <?php foreach($results as $result) { ?>
        var pricePerDayInPHP = <?php echo $result->PricePerDay; ?>;

        function calculateDurationAndPrice() {
            var fromDate = new Date(document.getElementById('fromdate').value);
            var toDate = new Date(document.getElementById('todate').value);
            var duration = toDate.getTime() - fromDate.getTime(); 
            var days = Math.ceil(duration / (1000 * 60 * 60 * 24)); 

            var totalPriceInPHP = days * pricePerDayInPHP; 

            document.getElementById('bookingDuration').innerText = 'Booking Duration: ' + days + ' days';
            document.getElementById('bookingPrice').innerText = 'Booking Price: ₱' + totalPriceInPHP.toFixed(2);
        }
    <?php } ?>
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const pickUpTimeInput = document.getElementById("pickuptime");
        const returnTimeInput = document.getElementById("returntime");

        pickUpTimeInput.addEventListener("change", function() {
            const pickUpTime = pickUpTimeInput.value;

            if (pickUpTime) {
                const pickUpDate = new Date(`1970-01-01T${pickUpTime}`);

                pickUpDate.setHours(pickUpDate.getHours() + 24);

                const returnHours = ('0' + pickUpDate.getHours()).slice(-2);
                const returnMinutes = ('0' + pickUpDate.getMinutes()).slice(-2);
                const returnTime = `${returnHours}:${returnMinutes}`;

                returnTimeInput.value = returnTime;
            }
        });
    });
</script>


</div>
<div class="space-20"></div>
<div class="divider"></div>
</div>
</div>
</div>
<?php include('includes/footer.php');?>
<div id="back-top" class="back-top"><a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i></a></div>
<?php include('includes/login.php');?>
<?php include('includes/registration.php');?>

<?php include('includes/forgotpassword.php');?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<script src="assets/switcher/js/switcher.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script>let currentSlide = 0;
const mainImage = document.getElementById('friztannmainmainImage');
const thumbnails = document.querySelectorAll('.thumbnail');
const imageCount = document.querySelector('.image-count');

function changeImage(src, index) {
    mainImage.src = src;
    currentSlide = index;
    updateActiveState();
    updateImageCount();
}

function changeSlide(direction) {
    currentSlide += direction;
    if (currentSlide < 0) currentSlide = thumbnails.length - 1;
    if (currentSlide >= thumbnails.length) currentSlide = 0;
    
    const newSrc = thumbnails[currentSlide].querySelector('img').src;
    changeImage(newSrc, currentSlide);
}

function updateActiveState() {
    thumbnails.forEach((thumb, index) => {
        thumb.classList.toggle('active', index === currentSlide);
    });
}

function updateImageCount() {
    imageCount.textContent = `${currentSlide + 1} / ${thumbnails.length}`;
}

updateImageCount();
</script>
<script>
// Fullscreen handler function
function handleFullscreen() {
    const slider = document.getElementById('friztannlisting_img_slider');
    const mainContainer = slider.querySelector('.friztannmain-image-container');
    const fullscreenBtn = slider.querySelector('.fullscreen-btn');

    // Function to enter fullscreen
    const enterFullscreen = (element) => {
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        }
    };

    // Function to exit fullscreen
    const exitFullscreen = () => {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        }
    };

    // Toggle fullscreen state
    const toggleFullscreen = () => {
        if (!document.fullscreenElement &&
            !document.webkitFullscreenElement &&
            !document.msFullscreenElement &&
            !document.mozFullScreenElement) {
            enterFullscreen(mainContainer);
        } else {
            exitFullscreen();
        }
    };

    // Add click or touch event listener to fullscreen button
    fullscreenBtn.addEventListener('click', toggleFullscreen);
    fullscreenBtn.addEventListener('touchstart', toggleFullscreen);

    // Update fullscreen icon based on state
    const updateFullscreenIcon = () => {
        const fullscreenIcon = fullscreenBtn.querySelector('.fullscreen-icon');
        if (document.fullscreenElement ||
            document.webkitFullscreenElement ||
            document.msFullscreenElement ||
            document.mozFullScreenElement) {
            fullscreenIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"/>
                </svg>`;
        } else {
            fullscreenIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
                </svg>`;
        }
    };

    document.addEventListener('fullscreenchange', updateFullscreenIcon);
    document.addEventListener('webkitfullscreenchange', updateFullscreenIcon);
    document.addEventListener('mozfullscreenchange', updateFullscreenIcon);
    document.addEventListener('MSFullscreenChange', updateFullscreenIcon);

    // Initialize fullscreen icon
    updateFullscreenIcon();

    // Adjust layout for mobile screens
    const adjustForMobile = () => {
        if (window.innerWidth < 768) { // Mobile screen breakpoint
            slider.style.width = '100%';
            slider.style.height = '100%';
            mainContainer.style.objectFit = 'cover';
        } else {
            slider.style.width = '';
            slider.style.height = '';
            mainContainer.style.objectFit = '';
        }
    };

    // Listen for resize events
    window.addEventListener('resize', adjustForMobile);
    adjustForMobile();
}

// Initialize fullscreen functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', handleFullscreen);
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the date inputs
    const pickupDate = document.getElementById('fromdate');
    const returnDate = document.getElementById('todate');
    
    // Get today's date and format it
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    
    // Set minimum dates and initial setup
    pickupDate.min = formattedDate;
    returnDate.min = formattedDate;
    
    // Set pickup date to today by default
    pickupDate.value = formattedDate;
    
    // Update return date minimum to tomorrow
    const minReturnDate = new Date(today);
    minReturnDate.setDate(minReturnDate.getDate() + 1);
    returnDate.min = minReturnDate.toISOString().split('T')[0];
    
    // Validate pickup date
    pickupDate.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        
        if (selectedDate < today) {
            alert('Please select a future date');
            this.value = formattedDate;
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
            
            // Update return date minimum
            // Add one day to pickup date for minimum return date
            const minReturnDate = new Date(selectedDate);
            minReturnDate.setDate(minReturnDate.getDate() + 1);
            returnDate.min = minReturnDate.toISOString().split('T')[0];
            
            // Check if existing return date is now invalid
            if (returnDate.value) {
                const returnValue = new Date(returnDate.value);
                if (returnValue <= selectedDate) {
                    returnDate.value = '';
                    returnDate.classList.remove('is-valid');
                    alert('Return date must be at least one day after pickup date');
                }
            }
        }
        
        calculateDurationAndPrice();
    });
    
    // Validate return date
    returnDate.addEventListener('change', function() {
        if (!pickupDate.value) {
            alert('Please select a pickup date first');
            this.value = '';
            this.classList.add('is-invalid');
            return;
        }
        
        const selectedDate = new Date(this.value);
        const pickupValue = new Date(pickupDate.value);
        
        // Check if return date is same as or before pickup date
        if (selectedDate <= pickupValue) {
            alert('Return date must be at least one day after pickup date');
            this.value = '';
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
        
        calculateDurationAndPrice();
    });
    
    const style = document.createElement('style');
    style.textContent = `
        .is-invalid {
            border-color: #dc3545 !important;
            background-color: #fff !important;
        }
        .is-valid {
            border-color: #198754 !important;
            background-color: #fff !important;
        }
    `;
    document.head.appendChild(style);
});
</script>
</body>
</html>
