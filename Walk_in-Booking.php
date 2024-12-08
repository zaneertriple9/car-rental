<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/config.php');

if (empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit;
}

$error = '';
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $vhid = trim($_POST['vehicle_id'] ?? '');
        $firstname = trim($_POST['firstname'] ?? '');
        $middlename = trim($_POST['middlename'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $age = (int)($_POST['age'] ?? 0);
        $phonenumber = trim($_POST['phonenumber'] ?? '');
        $fromdate = trim($_POST['fromdate'] ?? '');
        $todate = trim($_POST['todate'] ?? '');
        $pricePerDay = (float)($_POST['pricePerDay'] ?? 0);
        $pickuptime = trim($_POST['pickuptime'] ?? '');
        $returntime = trim($_POST['returntime'] ?? '');
        $selectedLocation = trim($_POST['selectedLocation'] ?? '');

        if (!$vhid || !$firstname || !$lastname || !$phonenumber || !$fromdate || !$todate || !$pricePerDay || !$pickuptime || !$returntime || !$selectedLocation) {
            throw new Exception("All fields are required.");
        }

        if (strtotime($fromdate) > strtotime($todate)) {
            throw new Exception("The 'From Date' cannot be later than the 'To Date'.");
        }

        $pickupTimeFormatted = date('H:i:s', strtotime($pickuptime));
        $returnTimeFormatted = date('H:i:s', strtotime($returntime));

        $booking_days = floor((strtotime($todate) - strtotime($fromdate)) / (60 * 60 * 24));
        $fromdatetime = $fromdate . ' ' . $pickupTimeFormatted;
        $todatetime = $todate . ' ' . $returnTimeFormatted;
        $bookingPrice = $pricePerDay * $booking_days;

        $check_status_sql = "SELECT Status FROM friztann_vehicles WHERE Vehicle_id = :vhid";
        $check_status_query = $dbh->prepare($check_status_sql);
        $check_status_query->bindParam(':vhid', $vhid, PDO::PARAM_INT);
        $check_status_query->execute();
        $vehicle_status = $check_status_query->fetchColumn();

        if ($vehicle_status == 'MAINTENANCE') {
            throw new Exception("The car is currently under maintenance and cannot be booked.");
        }

        $sqlCheckAvailability = "
            SELECT 1 FROM friztann_noaccbooking WHERE vehicle_id = :vhid AND ((FromDate BETWEEN :fromdate AND :todate) OR (ToDate BETWEEN :fromdate AND :todate))
            UNION
            SELECT 1 FROM friztann_walkin WHERE vehicle_id = :vhid AND ((FromDate BETWEEN :fromdate AND :todate) OR (ToDate BETWEEN :fromdate AND :todate))
            UNION
            SELECT 1 FROM friztann_booking WHERE vehicle_id = :vhid AND ((FromDate BETWEEN :fromdate AND :todate) OR (ToDate BETWEEN :fromdate AND :todate))
        ";
        $queryCheckAvailability = $dbh->prepare($sqlCheckAvailability);
        $queryCheckAvailability->execute([
            ':vhid' => $vhid,
            ':fromdate' => $fromdatetime,
            ':todate' => $todatetime
        ]);

        if ($queryCheckAvailability->rowCount() > 0) {
            throw new Exception("Selected car is not available for the specified date range.");
        }

        $locationInfo = explode('|', $selectedLocation);
        $locationName = $locationInfo[0];
        $locationPrice = isset($locationInfo[1]) ? (float)$locationInfo[1] : 0;

        $sqlLocationId = "SELECT location_id FROM friztann_location WHERE locationname = :locationName LIMIT 1";
        $stmtLocationId = $dbh->prepare($sqlLocationId);
        $stmtLocationId->bindParam(':locationName', $locationName, PDO::PARAM_STR);
        $stmtLocationId->execute();
        $locationIdInfo = $stmtLocationId->fetch(PDO::FETCH_ASSOC);

        if (!$locationIdInfo) {
            throw new Exception("Invalid location selected.");
        }

        $locationId = $locationIdInfo['location_id'];
        $totalPrice = $bookingPrice + $locationPrice;

        $sqlAdmin = "
            INSERT INTO friztann_walkin 
            (vehicle_id, firstname, middlename, lastname, address, age, phonenumber, fromdate, todate, BookingPrice, pickuptime, returntime, Location, LocationPrice, totalPrice, location_id) 
            VALUES 
            (:vhid, :firstname, :middlename, :lastname, :address, :age, :phonenumber, :fromdate, :todate, :BookingPrice, :pickuptime, :returntime, :selectedLocation, :locationPrice, :totalPrice, :locationId)
        ";
        $queryAdmin = $dbh->prepare($sqlAdmin);
        $queryAdmin->execute([
            ':vhid' => $vhid,
            ':firstname' => $firstname,
            ':middlename' => $middlename,
            ':lastname' => $lastname,
            ':address' => $address,
            ':age' => $age,
            ':phonenumber' => $phonenumber,
            ':fromdate' => $fromdatetime,
            ':todate' => $todatetime,
            ':BookingPrice' => $bookingPrice,
            ':pickuptime' => $pickupTimeFormatted,
            ':returntime' => $returnTimeFormatted,
            ':selectedLocation' => $locationName,
            ':locationPrice' => $locationPrice,
            ':totalPrice' => $totalPrice,
            ':locationId' => $locationId
        ]);

        $msg = "Booking completed successfully.";
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>FritzAnn Shuttle Services| Admin Walkin Booking</title>
	    <link rel="apple-touch-icon" sizes="144x144" href="img/favicon-icon/apple-touch-icon-144.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/favicon-icon/apple-touch-icon-114.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/favicon-icon/apple-touch-icon-72.png">
<link rel="apple-touch-icon" href="img/favicon-icon/apple-touch-icon-57.png">
<link rel="shortcut icon" href="img/favicon-icon/favicon.png">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/error-succ.css">
    <link rel="stylesheet" href="css/adminbooking.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <style>
    .page-title {
  color: #333;
  font-size: 36px; 
  font-weight: 700; 
  margin-bottom: 30px;
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 2px;
  position: relative;
}

.page-title:after {
  content: "";
  display: block;
  width: 80px; 
  height: 4px;
  background-color: #e60000;
  margin: 10px auto 0;
}
</style>
</head>
<body>
<?php include('includes/header.php');?>
	<div class="ts-main-content">
    <?php include('includes/leftbar.php');?>
    <div class="content-wrapper">
			<div class="container-fluid">
    <div class="container mt-5">
    <div style="text-align: right;">
</div>
<h2 class="page-title">WALK IN BOOKING</h2>
<?php if($error){ ?>
    <div class="errorWrap">
        <div class="icon">❌</div>
        <strong>ERROR</strong>
        <span><?php echo htmlentities($error); ?></span>
        <button type="button" class="closeAlert" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
<?php } else if($msg){ ?>
    <div class="succWrap">
        <div class="icon">✓</div>
        <strong>SUCCESS</strong>
        <span><?php echo htmlentities($msg); ?></span>
        <button type="button" class="closeAlert" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
<?php } ?>
<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-horizontal">
    <form>
        <div class="row">
            <div class="col-md-6">
            <div class="form-group">
            <label for="firstname">First Name:</label>
            <input type="text" class="form-control" id="firstname" name="firstname" required minlength="1" maxlength="20" pattern="[A-Za-z]+" title="Only letters are allowed, and it must be 10 characters long.">
        </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
            <label for="middlename">Middle Name:</label>
            <input type="text" class="form-control" id="middlename" name="middlename" minlength="1" maxlength="20" pattern="[A-Za-z]+" title="Only letters are allowed, and it must be 20 characters long.">
        </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" class="form-control" id="lastname" name="lastname" required minlength="1" maxlength="20" pattern="[A-Za-z]+" title="Only letters are allowed, and it must be 20 characters long.">
        </div>
            </div>
            <div class="col-md-6">
            <div class="form-group" style="position: relative;">
    <label for="phonenumber">Phone Number:</label>
    <span style="position: absolute; left: 12px; top: 67%; transform: translateY(-50%); color: red; font-weight: 500;">
        +63
    </span>
    <input type="tel" class="form-control" id="phonenumber" name="phonenumber" required 
        style="padding-left: 40px;" 
        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
        maxlength="10" 
        pattern="[0-9]{10}"
        title="Numbers only, exactly 10 digits">


</div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <div class="form-group">
    <label for="address">Address:</label>
    <textarea class="form-control" id="address" name="address" rows="3" minlength="5" maxlength="40"></textarea>
    <small id="addressHelp" class="form-text text-muted">
        Address must be between 20 and 40 characters.
    </small>
</div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="age">Age:</label>
<input type="age" class="form-control" id="age" name="age" minlength="2" maxlength="2" required 
       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2);">
                </div>
            </div>
        </div>
    <div class="form-group row">
        <div class="col-sm-10">
        <button type="button" class="btn btn-primary custom-car-button" data-toggle="modal" data-target="#carModal" style="
    background: linear-gradient(145deg, #ff4757, #ee2736);
    border: none;
    padding: 12px 28px;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(238, 39, 54, 0.2);
    transition: all 0.3s ease;
    cursor: pointer;
">
    Select a Car
</button>
<div class="booking-container" style="
        width: 1100px;
        background: #ffffff;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin: 20px auto;
        border: 1px solid #f1f1f1;
        font-family: system-ui, -apple-system, sans-serif;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    ">
    <!-- Hidden inputs with improved security -->
    <input type="hidden" id="vehicle_id" name="vehicle_id" required>
    <input type="hidden" id="pricePerDay" name="pricePerDay">
    <!-- Selected Car Display -->
    <div id="selectedCar" style="
        padding: 15px;
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
        border-radius: 8px;
        margin-bottom: 15px;
        border-left: 4px solid #ff4757;
        font-size: 16px;
        color: #2d3436;
        font-weight: 500;
    "></div>
    <!-- Booking Duration Display -->
    <div id="bookingDuration" style="
        padding: 12px 15px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 10px;
        color: #2d3436;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    ">
        <span style="
            background: #ff4757;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 14px;
        ">Duration</span>
        <span class="duration-text"></span>
    </div>
    <!-- Booking Price Display -->
    <div id="bookingPrice" style="
        padding: 12px 15px;
        background: #f8f9fa;
        border-radius: 8px;
        color: #2d3436;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    ">
        <span style="
            background: #ff4757;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 14px;
        ">Total Price</span>
        <span class="price-text" style="
            color: #ff4757;
            font-size: 18px;
        "></span>
    </div>
</div>
        </div>
    </div>
    <div class="wrapper">
    <div class="location-slider-container">
        <div class="location-slider">
            <?php
                $sql = "SELECT * FROM friztann_location";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                foreach ($results as $result) {
            ?>
            <div class="location-item">
                <div class="location-card">
                    <div class="location-image-wrapper">
                        <img src="img/locationimages/<?php echo htmlentities($result->image1);?>" 
                             class="location-image" 
                             alt="<?php echo htmlentities($result->LocationName);?>">
                        <div class="location-name-overlay">
                            <h3 class="location-name"><?php echo htmlentities($result->LocationName);?></h3>
                       
                            </div>
    </div>
  
                    <div class="location-content">
                        <div class="price-tag">
                            <span class="price-label">Price</span>
                            <span class="price-amount"><?php echo htmlentities($result->LocationPrice);?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 512 512">
  <path fill="black" d="M327.027 65.816L229.79 128.23l9.856 5.397l86.51-55.53l146.735 83.116l-84.165 54.023l4.1 2.244v6.848l65.923-42.316l13.836 7.838l-79.76 51.195v11.723l64.633-41.487l15.127 8.57l-79.76 51.195v11.723l64.633-41.487l15.127 8.57l-79.76 51.195v11.723l100.033-64.21l-24.828-14.062l24.827-15.937l-24.828-14.064l24.827-15.937l-23.537-13.333l23.842-15.305zm31.067 44.74c-21.038 10.556-49.06 12.342-68.79 4.383l-38.57 24.757l126.903 69.47l36.582-23.48c-14.41-11.376-13.21-28.35 2.942-41.67zM227.504 147.5l-70.688 46.094l135.61 78.066l1.33-.85c2.5-1.61 6.03-3.89 10.242-6.613c8.42-5.443 19.563-12.66 30.674-19.86c16.002-10.37 24.248-15.72 31.916-20.694zm115.467 1.17a8.583 14.437 82.068 0 1 .003 0a8.583 14.437 82.068 0 1 8.32 1.945a8.583 14.437 82.068 0 1-.87 12.282a8.583 14.437 82.068 0 1-20.273 1.29a8.583 14.437 82.068 0 1 .87-12.28a8.583 14.437 82.068 0 1 11.95-3.237m-218.423 47.115L19.143 263.44l23.537 13.333l-23.842 15.305l24.828 14.063l-24.828 15.938l24.828 14.063l-24.828 15.938l166.135 94.106L285.277 381.8v-11.72l-99.433 63.824L39.11 350.787l14.255-9.15l131.608 74.547L285.277 351.8v-11.72l-99.433 63.824L39.11 320.787l14.255-9.15l131.608 74.547L285.277 321.8v-11.72l-99.433 63.824L39.11 290.787l13.27-8.52l132.9 75.28l99.997-64.188v-5.05l-5.48-3.154l-93.65 60.11l-146.73-83.116l94.76-60.824l-9.63-5.543zm20.46 11.78l-46.92 30.115c14.41 11.374 13.21 28.348-2.942 41.67l59.068 33.46c21.037-10.557 49.057-12.342 68.787-4.384l45.965-29.504l-123.96-71.358zm229.817 32.19c-8.044 5.217-15.138 9.822-30.363 19.688a36222 36222 0 0 1-30.69 19.873c-4.217 2.725-7.755 5.01-10.278 6.632c-.09.06-.127.08-.215.137v85.924l71.547-48.088zm-200.99 17.48a8.583 14.437 82.068 0 1 8.32 1.947a8.583 14.437 82.068 0 1-.87 12.28a8.583 14.437 82.068 0 1-20.27 1.29a8.583 14.437 82.068 0 1 .87-12.28a8.583 14.437 82.068 0 1 11.95-3.236z"/>
</svg>
                        </div>
                        <div class="location-selection">
                        <input type="radio" name="selectedLocation" value="<?php echo htmlentities($result->LocationName . '|' . $result->LocationPrice);?>">
                        <label>Select this location</label>
                        </div>
                    </div>
                    
                </div>
            </div>
            <?php }} ?>
        </div>
    </div>
</div>

    <div class="form-group row">
        <label for="fromdate" class="col-sm-2 col-form-label">Pick Up Date:</label>
        <div class="col-sm-4">
            <input type="date" class="form-control" name="fromdate" id="fromdate" onchange="calculateDurationAndPrice()" required>
        </div>
        <label for="todate" class="col-sm-2 col-form-label">Return Date:</label>
        <div class="col-sm-4">
            <input type="date" class="form-control" name="todate" id="todate" onchange="calculateDurationAndPrice()" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="pickuptime" class="col-sm-2 col-form-label">Pick-Up Time:</label>
        <div class="col-sm-4">
            <input type="time" class="form-control" name="pickuptime" id="pickuptime" required>
        </div>
        <label for="returntime" class="col-sm-2 col-form-label">Return Time:</label>
        <div class="col-sm-4">
            <input type="time" class="form-control" name="returntime" id="returntime" required>
        </div>

            <div id="bookingDuration" style="font-weight: bold; color: black; line-height: 2;"></div>
            <div id="bookingPrice" style="font-weight: bold; color: black; line-height: 2;"></div>
            <div style="text-align: center; margin-top: 69px; margin-left: 550px;">
    <button type="submit" style="background-color: red; color: white; padding: 10px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">Submit</button>
</div>
    </form>
    </div>  
<div class="modal fade" id="carModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select a Car</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $sql = "SELECT friztann_vehicles.VehiclesTitle, friztann_brands.BrandName, friztann_vehicles.PricePerDay, friztann_vehicles.FuelType, friztann_vehicles.bodytype, friztann_vehicles.TransmissionType, friztann_vehicles.Vehicle_id, friztann_vehicles.SeatingCapacity,  friztann_vehicles.Vimage0 
                            FROM friztann_vehicles 
                            JOIN friztann_brands ON friztann_brands.brand_id = friztann_vehicles.VehiclesBrand";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                    ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="recent-car-list">
                                    <div class="car-info-box">
                                        <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage0); ?>" class="img-responsive img-thumbnail" alt="image" style="max-width: 100%; height: auto;">
                                        <ul class="list-unstyled mt-2">
                                        <li style="display: flex; align-items: center; margin-right: 0;">
            <i class="fa fa-gas-pump" aria-hidden="true" style="margin-right: 5px;"></i>
            <?php echo htmlentities($result->FuelType); ?>
        </li>
        <li style="display: flex; align-items: center; margin-right: 0;">
            <i class="fa fa-car" aria-hidden="true" style="margin-right: 5px;"></i>
            <?php echo htmlentities($result->bodytype); ?>
        </li>
                                            <li><i class="fa-solid fa-cogs" aria-hidden="true"></i> <?php echo htmlentities($result->TransmissionType); ?> Engine</li>

                                            <li><i class="fa fa-user" aria-hidden="true"></i> <?php echo htmlentities($result->SeatingCapacity); ?> seats</li>
                                        </ul>
                                    </div>
                                    <div class="car-title-m">
                                        <h6><?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?></h6>
                                        <span class="price">₱<?php echo htmlentities($result->PricePerDay); ?> /Day</span>
                                    </div>
                                    <div class="inventory_info_m">
                                        <p></p>
                                    </div>
                                    <button type="button" class="btn btn-primary select-car-btn" data-id="<?php echo htmlentities($result->Vehicle_id); ?>" data-name="<?php echo htmlentities($result->BrandName . ' ' . $result->VehiclesTitle); ?>" data-price="<?php echo htmlentities($result->PricePerDay); ?>">
                                        Select
                                    </button>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
           
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
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
<script src="js/walkin.js"></script>
<script src="js/walkin2.js"></script>
<script src="js/selectedlocation.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
