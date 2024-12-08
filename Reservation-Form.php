<?php
session_start();
include('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve POST data
    $firstname = htmlspecialchars($_POST['firstname']);
    $middlename = htmlspecialchars($_POST['middlename']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $address = htmlspecialchars($_POST['address']);
    $gender = htmlspecialchars($_POST['gender']);
    $needDriver = htmlspecialchars($_POST['needDriver']);
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $hours = $_POST['hours'];
    $selectedLocation = htmlspecialchars($_POST['selectedLocation']);

    // Function to generate a random booking code
    function generateBookingCode($length = 7) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($characters), 0, $length);
    }

    try {
        $dbh->beginTransaction();

        // Fetch the last inserted booking ID and price
        $stmt = $dbh->prepare("
            SELECT b.noaccbooking_ID, b.bookingprice 
            FROM friztann_noaccbooking b 
            WHERE b.noaccbooking_ID = (SELECT MAX(noaccbooking_ID) FROM friztann_noaccbooking)
        ");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new Exception("No bookings found.");
        }

        $lastInsertId = $row['noaccbooking_ID'];
        $bookingTotalPrice = $row['bookingprice'];

        // Check if booking info already exists
        $stmt = $dbh->prepare("SELECT COUNT(*) AS count FROM friztann_noaccbookinginfo WHERE noaccbooking_ID = :noaccbooking_ID");
        $stmt->bindParam(':noaccbooking_ID', $lastInsertId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] > 0) {
            throw new Exception("The booking information already exists.");
        }

        // Parse location details
        $locationInfo = explode('|', $selectedLocation);
        $locationName = $locationInfo[0];
        $locationPrice = isset($locationInfo[1]) ? (float)$locationInfo[1] : 0;

        // Fetch location ID
        $stmtLocationId = $dbh->prepare("SELECT location_id FROM friztann_location WHERE locationname = :locationName LIMIT 1");
        $stmtLocationId->bindParam(':locationName', $locationName);
        $stmtLocationId->execute();
        $locationIdInfo = $stmtLocationId->fetch(PDO::FETCH_ASSOC);

        if (!$locationIdInfo) {
            throw new Exception("Hello user, please select a location for your booking.");
        }

        $locationId = $locationIdInfo['location_id'];
        $totalPrice = $bookingTotalPrice + $locationPrice;
        $bookingCode = generateBookingCode();

        // Insert booking information
        $stmt = $dbh->prepare("
            INSERT INTO friztann_noaccbookinginfo (
                noaccbooking_ID, firstname, middlename, lastname, address, gender, age, phone, selectedLocation, LocationPrice, bookingprice, bookingCode, totalprice, hours, location_id, needDriver
            ) VALUES (
                :noaccbooking_ID, :firstname, :middlename, :lastname, :address, :gender, :age, :phone, :selectedLocation, :LocationPrice, :bookingprice, :bookingCode, :totalprice, :hours, :location_id, :needDriver
            )
        ");
        $stmt->bindParam(':noaccbooking_ID', $lastInsertId);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':middlename', $middlename);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':needDriver', $needDriver);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':selectedLocation', $locationName);
        $stmt->bindParam(':LocationPrice', $locationPrice);
        $stmt->bindParam(':bookingprice', $bookingTotalPrice);
        $stmt->bindParam(':bookingCode', $bookingCode);
        $stmt->bindParam(':totalprice', $totalPrice);
        $stmt->bindParam(':hours', $hours);
        $stmt->bindParam(':location_id', $locationId);  
        $stmt->execute();

        $dbh->commit();

        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('myModal').style.display = 'block';
                });
              </script>";
    } catch (PDOException $e) {
        $dbh->rollBack();
        displayError("Database Error: " . $e->getMessage());
    } catch (Exception $e) {
        displayError($e->getMessage());
    }
}

function displayError($message) {
    echo "<script>
           document.addEventListener('DOMContentLoaded', function() {
    var alertBox = document.createElement('div');
    alertBox.style.position = 'fixed';
    alertBox.style.top = '50%';
    alertBox.style.left = '50%';
    alertBox.style.transform = 'translate(-50%, -50%)';
    alertBox.style.background = '#fff';
    alertBox.style.padding = '20px';
    alertBox.style.border = '2px solid #f00';
    alertBox.style.boxShadow = '0 0 10px rgba(0,0,0,0.5)';
    alertBox.style.zIndex = '9999';
    alertBox.style.textAlign = 'center';
    alertBox.style.maxWidth = '300px';

    // Create close button
    var closeButton = document.createElement('button');
    closeButton.textContent = 'Close';
    closeButton.style.position = 'absolute';
    closeButton.style.top = '10px';
    closeButton.style.right = '10px';
    closeButton.style.padding = '5px 10px';
    closeButton.style.background = '#f44336';
    closeButton.style.color = 'white';
    closeButton.style.border = 'none';
    closeButton.style.cursor = 'pointer';
    closeButton.style.borderRadius = '3px';

    // Add click event to close button
    closeButton.addEventListener('click', function() {
        document.body.removeChild(alertBox);
    });

    // Create content container
    var contentContainer = document.createElement('div');
    contentContainer.innerHTML = '<h2>Error</h2><p>' + ". json_encode($message) ." + '</p>';
    contentContainer.style.marginTop = '20px';

    // Append close button and content to alert box
    alertBox.appendChild(closeButton);
    alertBox.appendChild(contentContainer);

    // Add to document body
    document.body.appendChild(alertBox);
});
          </script>";
}

?>



<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>FritzAnn Shuttle Services |Reservation-Form</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/booking1.css">
<link rel="stylesheet" href="assets/css/location.css">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 
<style>
 .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background: black;
        margin: 5% auto;
        max-width: 500px;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        overflow: hidden;
    }

    .location-card {
        padding: 0;
        background: white;
    }

    .image-container {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .location-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .top-booked-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: #00bcd4;
        color: white;
        padding: 8px 16px;
        border-radius: 25px;
        font-weight: bold;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .content-wrapper {
        padding: 24px;
    }

    .location-title {
        font-size: 28px;
        color: #333;
        margin: 0 0 8px 0;
        font-weight: bold;
    }

    .location-description {
        color: #666;
        margin-bottom: 24px;
    }

    .features-container {
        display: flex;
        gap: 20px;
        margin-bottom: 24px;
    }

    .feature {
        display: flex;
        align-items: center;
        padding: 10px 30px;
        background-color: #f0f9ff;
        border-radius: 12px;
        color: #08202c;
    }

    .feature-icon {
        width: 20px;
        height: 20px;
        margin-right: 8px;
    }

    .price-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .price-amount {
        font-size: 32px;
        font-weight: bold;
        color: #333;
    }

    .price-label {
        color: #666;
        font-size: 14px;
    }

    .booking-info {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #666;
        margin-bottom: 24px;
    }

    .select-button {
        text-align: center;
    }

    .select-button label {
        background-color: #00bcd4;
        color: white;
        padding: 12px 24px;
        border-radius: 25px;
        border: none;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
        display: inline-block;
    }

    .select-button label:hover {
        background-color: #008ba3;
    }

    .close {
        position: absolute;
        left: 20px;
        top: 20px;
        color: white;
        font-size: 28px;
        cursor: pointer;
        z-index: 10;
    }
    .receipt-header {
    text-align: center;
    margin-bottom: 20px;
}

.info-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.info-container .customer-info,
.info-container .booking-details {
    flex: 1 1 300px;
    background-color: #333333;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.info-container p {
    margin: 5px 0;
}

.info-container img {
    max-width: 100%;
    height: auto;
}

@media (max-width: 768px) {
    .receipt-header h2 {
        font-size: 14px;
    }

    .info-container {
        gap: 10px;
    }

    .info-container .customer-info,
    .info-container .booking-details {
        padding: 15px;
    }

    .info-container p {
        font-size: 14px;
    }

    .btn {
        padding: 10px 15px;
        font-size: 14px;
    }
}

@media (max-width: 768px) {
  img {
    width: 100%;
    height: auto;
    max-width: none;
  }
}

.pricing-container {
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 12px;
    margin: 0 auto;
}

.price-amount {
    font-size: 50px;
    color: white;
    font-family: 'Arial', sans-serif;
    letter-spacing: -2px;
    margin: 4px 180px; 
}
@media (max-width: 768px) {
    .price-amount {
        margin: 4px 49px; 
    }
}

.price-label-box {
    background-color: #000000;
    padding: 8px 16px; 
    border-radius: 6px;
    display: inline-block;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: relative;
    margin-top: -8px; 
}

.price-label {
    font-size: 14px;
    color: #ffffff;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0; /* Remove unnecessary margin */
}

/* Optional: Add a subtle border line between elements */
.price-amount::after {
    content: '';
    display: block;
    width: 40px;
    height: 2px;
    background-color: #e0e0e0;
    margin: 8px auto; /* Reduce spacing for the line */
}


</style>
</head>

<body class="custom-body">
                <form method="post" enctype="multipart/form-data">
<div class='locationrental-header'>
  <h1 class='title'>RENTAL LOCATION DEALS JUST FOR YOU</h1>
  <form class='rental-form'>
    


<div class="custom-container">
</div>
<input type="hidden" id="selectedLocation" name="selectedLocation">
<div class="wrapper">
  <input type="text" id="searchBar" placeholder="Search for a location..." style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">

  <div class="location-slider-container">
    <form method="POST" action="">
      <div class="location-slider" id="locationSlider">
        <?php
          $sql = "SELECT * FROM friztann_location";
          $query = $dbh->prepare($sql);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);
          if ($query->rowCount() > 0) {
            foreach ($results as $result) {  
        ?>
        <div class="location-item" data-location-name="<?php echo htmlentities($result->LocationName); ?>">
          <div class="location-info-box">
            <div class="image-container">
                
              <div class="main-image">
                <div style="position: relative; display: inline-block;">
                  <img src="admin/img/locationimages/<?php echo htmlentities($result->image1);?>" class="img-responsive active rounded-image" alt="location image">
    
                </div>
              </div>
            </div>
            <div class="location-details">
              <div class="description-container">
              <h2 class="location-title" style="color: white;"><?php echo htmlentities($result->LocationName); ?></h2>
              <div class="features-container">

 
                </div>
                
                <h1>Description:</h1>
                <p><?php echo htmlentities($result->LocationsOverview);?></p>
              </div>
              <div style="position: relative;">
              <div class="price-section">
              <div>
              <div class="pricing-container">
    <div class="price-wrapper">
        <div class="price-amount">₱<?php echo htmlentities($result->LocationPrice); ?></div>
        <div class="price-label-box">
            <div class="price-label">Starting from</div>
        </div>
    </div>
</div>
        </div>
                </div>

              </div>
              <div>
              <label style="font-family: Arial, sans-serif; font-size: 16px; padding: 5px; border: 2px solid #000; border-radius: 15px; background-color: #f1f1f1; display: inline-block; cursor: pointer;">
  <input type="radio" name="selectedLocation" value="<?php echo htmlentities($result->LocationName . '|' . $result->LocationPrice);?>" style="width: 20px; height: 20px; vertical-align: middle;">
  Select Location
</label>
                </div>
              </div>
            </div>
          </div>
          <?php 
              }
            }
          ?>
        </div>
      </div>
    </div>
<div class="needDriver-container">
    <label for="needDriver">Do you need a driver?</label>
    <div class="radio-option-wrapper">
        <input type="radio" id="needDriverYes" name="needDriver" value="Yes">
        <label for="needDriverYes">Yes</label>
    </div>
    <div class="radio-option-wrapper">
        <input type="radio" id="needDriverNo" name="needDriver" value="No" checked>
        <label for="needDriverNo">No</label>
    </div>
</div>
<div class="formself-container">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: flex; flex-wrap: wrap; gap: 20px; max-width: 800px; width: 100%;">
<div style=" gap: 10px;">

<div style="flex: 1; margin-bottom: 15px;">
  <label for="firstname" style="display: block; margin-bottom: 5px; color: red;">First Name:</label>
  <input type="text" id="firstname" name="firstname" placeholder="Your first name.." required
         style="width: 100%; padding: 10px; border: 1px solid red; border-radius: 4px; box-sizing: border-box; "
         minlength="2" maxlength="20">
</div>


<div style="flex: 1; margin-bottom: 15px;">
  <label for="middlename" style="display: block; margin-bottom: 5px;  color: red;">Middle Name:</label>
  <input type="text" id="middlename" name="middlename" placeholder="Your middle name.." required
         style="width: 100%; padding: 10px; border: 1px solid red; border-radius: 4px; box-sizing: border-box; "
         minlength="1" maxlength="20">
</div>

<div style="flex: 1; margin-bottom: 15px;">
  <label for="lastname" style="display: block; margin-bottom: 5px;  color: red;">Last Name:</label>
  <input type="text" id="lastname" name="lastname" placeholder="Your last name.." required
         style="width: 100%; padding: 10px; border: 1px solid red; border-radius: 4px; box-sizing: border-box; "
         minlength="2" maxlength="20">
</div>




    <div style="flex: 1;">
    <label for="age" style="display: block; margin-bottom: 5px;  color: red;">Age:</label>
<input type="number" id="age" name="age" placeholder="Your age.." min="1" max="99" step="1" required minlength="1" maxlength="2" style="width: 100%; padding: 10px; border: 1px solid red; border-radius: 4px; box-sizing: border-box; ">


    </div>
</div>
<div style="display: flex; gap: 20px;">
<div style="flex: 1;">
    <div style="position: relative; margin-bottom: 20px;">
        <label for="phone" style="display: block; margin-bottom: 8px; color: red; font-weight: 500; font-size: 14px;">
            Phone Number 
        </label>
        <div style="position: relative;">
            <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: red; font-weight: 500;">
                +63
            </span>
            <input 
                type="tel"
                id="phone"
                name="phone"
                placeholder="9xxxxxxxxx"
                style="width: 100%; padding: 12px 16px 12px 48px; border: 2px solid red;  border-radius: 8px; font-size: 16px; box-sizing: border-box; transition: all 0.3s ease;"
                pattern="[0-9]{10}"
                maxlength="10"
                required
                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                onkeyup="this.style.borderColor = this.validity.valid ? '#E5E7EB' : '#DC2626'"
            >
        </div>
        <div style="margin-top: 6px; font-size: 12px; color: #DC2626;" id="error-message">
        </div>
    </div>
</div>
    <div style="flex: 1;">
    <label for="address" style="display: block; margin-bottom: 5px; color: red; ">Address:</label>
<input type="text" id="address" name="address" placeholder="Your address.." 
       style="width: 100%; padding: 10px; border: 1px solid red; border-radius: 4px; box-sizing: border-box;  "
       minlength="10" maxlength="90" required title="Address must be between 10 and 90 characters.">

    </div>
</div>
        <div style="flex: 1 1 calc(33% - 20px);">
            <label for="gender" style="display: block; margin-bottom: 5px; color: red;">Gender:</label>
            <select id="gender" name="gender" required style="width: 100%; padding: 10px; border: 1px solid red; border-radius: 4px;  box-sizing: border-box;">
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div style="flex: 1 1 calc(33% - 20px);">
        <h1 class='title' style="text-align: center;">SELECT A RESERVATION TIME</h1>
        <label for="hours" style="display: block; margin-bottom: 5px; color: red;">Duration:</label>
    <select id="hours" name="hours" required style="width: 100%; padding: 10px; border: 1px solid red; border-radius: 4px; background-color: white; box-sizing: border-box; ">
        <option value="">Select</option>
        <option value="30Mins">30 Minutes</option>
        <option value="1Hour">1 Hour</option>
        <option value="2Hours">2 Hours</option>
    </select>
</div>

<div style="text-align: center;">
    <input type="submit" value="Submit" style="background-color: #ff0000; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; transition: background-color 0.3s ease; width: 150px;">
</div>

    </form>
</div>


<div id="myModal" class="modal" style="display: none;">
<div class="modal-content">
<?php
try {
    $stmt = $dbh->prepare("SELECT MAX(noaccbooking_ID) AS last_inserted_id FROM friztann_noaccbooking");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $lastInsertedId = $row['last_inserted_id'];

    if ($lastInsertedId) {
        $stmt = $dbh->prepare("SELECT a.*, b.*, v.VehiclesTitle, v.VehiclesBrand, v.Vimage0, br.BrandName
                               FROM friztann_noaccbooking a 
                               LEFT JOIN friztann_noaccbookinginfo b ON a.noaccbooking_ID = b.noaccbooking_ID 
                               LEFT JOIN friztann_vehicles v ON a.vehicle_id = v.Vehicle_id 
                               LEFT JOIN friztann_brands br ON v.VehiclesBrand = br.brand_id
                               WHERE a.noaccbooking_ID = :booking_id");
        $stmt->bindParam(':booking_id', $lastInsertedId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "
            <div class='receipt-header'>
                <h2 style='color: white; font-size: 16px;'>TAKE A SCREENSHOT OF YOUR BOOKING SUMMARY</h2>
                <img src='assets/images/logo.png' alt='Booking Summary Screenshot' width='500' height='150'>
            </div>
            <div class='info-container' style='display: flex; gap: 20px;'>
                <p style='border: 2px solid red; padding: 10px; background-color: #f0f0f0; border-radius: 5px; font-size: 16px; color: #333333; text-align: center; font-family: Arial, sans-serif;'>
                    <strong>Booking Code: FRITZANN</strong> " . htmlspecialchars($row['bookingCode']) . "
                </p>
                <div class='customer-info' style='flex: 1;'>
                    <h3>MY Information</h3>
                    <p style='color: white;'><strong>Full Name:</strong> " . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['middlename']) . " " . htmlspecialchars($row['lastname']) . "</p>
                    <p style='color: white;'><strong>Address:</strong> " . htmlspecialchars($row['address']) . "</p>
                    <p style='color: white;'><strong>Gender:</strong> " . htmlspecialchars($row['gender']) . "</p>
                    <p style='color: white;'><strong>Age:</strong> " . htmlspecialchars($row['age']) . "</p>
                    <p style='color: white;'><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>
                    <p style='color: white;'><strong>Destination:</strong> " . htmlspecialchars($row['selectedLocation']) . "</p>
                    <p style='color: white;'><strong>Location Price:</strong> " . htmlspecialchars($row['locationPrice']) . "</p>
                    <p style='color: white;'><strong>Reservation Time:</strong> " . htmlspecialchars($row['hours']) . "</p>
                    <p style='color: white;'><strong>Need Driver:</strong> " . htmlspecialchars($row['needDriver']) . "</p>
                </div>
                <div class='booking-details' style='flex: 1;'>
                    <h3>Booking Details</h3>
                    <p><strong>Car:</strong></p>
                    <p><img src='admin/img/vehicleimages/" . htmlspecialchars($row['Vimage0']) . "' alt='" . htmlspecialchars($row['VehiclesTitle']) . "' style='max-width: 200px;'></p>
                    <p style='color: white;'>" . htmlspecialchars($row['BrandName']) . " - " . htmlspecialchars($row['VehiclesTitle']) . "</p>
                    <p style='color: white;'><strong>Pickup Date:</strong> " . htmlspecialchars($row['FromDate']) . "</p>
                    <p style='color: white;'><strong>Pickup Time:</strong> " . htmlspecialchars($row['PickupTime']) . "</p>
                    <p style='color: white;'><strong>Return Date:</strong> " . htmlspecialchars($row['ToDate']) . "</p>
                    <p style='color: white;'><strong>Return Time:</strong> " . htmlspecialchars($row['ReturnTime']) . "</p>
                    <p style='color: white;'><strong>Booking Duration:</strong> " . htmlspecialchars($row['BookingDuration']) . " days</p>
                    <p style='color: white;'><strong>Total Price:</strong> " . htmlspecialchars($row['totalprice']) . "</p>
                </div>
            </div>
            <div style='text-align: center; margin-top: 20px;'>
                <a href='thanks.php' class='btn btn-primary' style='color: black; background-color: red;'>PROCEED</a>
            </div>";
        } else {
            echo "<p>No bookings found for ID: " . htmlspecialchars($lastInsertedId) . "</p>";
        }
    } else {
        echo "<p>No booking ID specified.</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error fetching booking information: " . htmlspecialchars($e->getMessage()) . "</p>";
}

?>

    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var slides = document.querySelectorAll('.mini-slider .slide');
    slides.forEach(function(slide) {
      slide.addEventListener('click', function() {
        var mainImage = this.closest('.location-item').querySelector('.main-image img');
        var newImageSrc = this.querySelector('img').src;
        mainImage.src = newImageSrc;
      });
    });
  });
</script>
<script>
  const searchBar = document.getElementById('searchBar');
  const locationItems = document.querySelectorAll('.location-item');

  searchBar.addEventListener('input', function() {
    const searchQuery = searchBar.value.toLowerCase();

    locationItems.forEach(function(item) {
      const locationName = item.getAttribute('data-location-name').toLowerCase();

      if (locationName.includes(searchQuery)) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    });
  });
</script>
</body>
</html>