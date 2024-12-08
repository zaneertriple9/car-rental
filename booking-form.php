<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $useremail = $_SESSION['login'];
        error_log("User email from session: " . $useremail);

        $needDriver = isset($_POST['needDriver']) ? 'Yes' : 'No';
        $paymentproofPath = '';
        $targetDir = "admin/img/payments/";

        if(isset($_FILES['paymentproof']) && $_FILES['paymentproof']['error'] === UPLOAD_ERR_OK) {
            $paymentproofPath = $targetDir . basename($_FILES['paymentproof']['name']);
            move_uploaded_file($_FILES['paymentproof']['tmp_name'], $paymentproofPath);
        }

        $sqlBookingInfo = "SELECT booking_id, bookingprice FROM friztann_booking ORDER BY booking_id DESC LIMIT 1";
        $stmtBookingInfo = $dbh->prepare($sqlBookingInfo);
        $stmtBookingInfo->execute();
        $bookingInfo = $stmtBookingInfo->fetch(PDO::FETCH_ASSOC);
        error_log("Booking info: " . print_r($bookingInfo, true));

        $bookingId = $bookingInfo['booking_id'];
        $bookingPrice = $bookingInfo['bookingprice'];

        $selectedLocation = $_POST['selectedLocation'];
        $locationInfo = explode('|', $selectedLocation);
        $locationName = $locationInfo[0];
        $locationPrice = isset($locationInfo[1]) ? $locationInfo[1] : 0;

        $sqlLocationId = "SELECT location_id FROM friztann_location WHERE locationname = :locationName LIMIT 1";
        $stmtLocationId = $dbh->prepare($sqlLocationId);
        $stmtLocationId->bindParam(':locationName', $locationName);
        $stmtLocationId->execute();
        $locationIdInfo = $stmtLocationId->fetch(PDO::FETCH_ASSOC);

        if (!$locationIdInfo) {
            echo "<script>alert('Invalid location selected.');</script>";
            exit;
        }
        
        $locationId = $locationIdInfo['location_id'];
        $totalPrice = $bookingPrice + $locationPrice;

        $sql = "INSERT INTO friztann_bookinginfo (booking_id, useremail, paymentproof, needDriver, selectedLocation, bookingprice, locationprice, totalprice, location_id) 
                VALUES (:booking_id, :useremail, :paymentproof, :needDriver, :selectedLocation, :bookingprice, :locationprice, :totalprice, :location_id)";
        $stmt = $dbh->prepare($sql);

        $stmt->bindParam(':booking_id', $bookingId);
        $stmt->bindParam(':useremail', $useremail);
        $stmt->bindParam(':paymentproof', $paymentproofPath);
        $stmt->bindParam(':needDriver', $needDriver);
        $stmt->bindParam(':selectedLocation', $selectedLocation);
        $stmt->bindParam(':bookingprice', $bookingPrice);
        $stmt->bindParam(':locationprice', $locationPrice);
        $stmt->bindParam(':totalprice', $totalPrice);
        $stmt->bindParam(':location_id', $locationId);

        if ($stmt->execute()) {
            echo "<script>alert('Your booking has been processed. You can proceed to your payment.'); window.location.href = 'my-booking.php';</script>";
        } else {
            $errorInfo = $stmt->errorInfo();
            error_log("SQL error: " . print_r($errorInfo, true));
            echo "<script>alert('Sorry, there was an error processing your booking.');</script>";
        }
    }
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
<title>FRIZTANN|Booking-Form</title>
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
    .pricing-container {
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 12px;
    margin: 0 auto;
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
    
.price-amount {
    font-size: 50px;
    color: white;
    font-family: 'Arial', sans-serif;
    letter-spacing: -2px;
    margin: 4px 200px; /* Add 1000px margin to the left and right */
}
@media (max-width: 768px) {
    .price-amount {
        margin: 4px 49px; /* Apply 4px top/bottom and 60px left/right margin for mobile */
    }
}

.price-label-box {
    background-color: #000000;
    padding: 8px 16px; /* Reduce padding for a more compact look */
    border-radius: 6px;
    display: inline-block;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: relative;
    margin-top: -8px; /* Adjust overlap or spacing between label and amount */
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
.pricedss {
            color: black;
            font-weight: bold;
            font-size: 24px;
            margin-right: 200px;
            width: 100%;
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
              <h2 class="location-title"><?php echo htmlentities($result->LocationName); ?></h2>
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
<?php
$sql = "
SELECT 
    loc.LocationName, 
    loc.LocationPrice, 
    loc.image1,
    (SUM(CASE WHEN walk.location_id IS NOT NULL THEN  1 ELSE 0 END) +
     SUM(CASE WHEN noacc.location_id IS NOT NULL THEN 1 ELSE 0 END) +
     SUM(CASE WHEN booking_info.location_id IS NOT NULL THEN 1 ELSE 0 END)) AS totalBookingCount
FROM friztann_location loc
LEFT JOIN friztann_walkin walk ON loc.location_id = walk.location_id
LEFT JOIN friztann_noaccbookinginfo noacc ON loc.location_id = noacc.location_id
LEFT JOIN friztann_bookinginfo booking_info ON loc.location_id = booking_info.location_id
GROUP BY loc.location_id
ORDER BY totalBookingCount DESC
LIMIT 1";
$query = $dbh->prepare($sql);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

if ($result) {
?>


<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="location-card">
            <div class="image-container">
                <img 
                    class="location-image"
                    src="admin/img/locationimages/<?php echo htmlentities($result->image1); ?>" 
                    alt="<?php echo htmlentities($result->LocationName); ?>"
                />
                <div class="top-booked-badge">Top Booked</div>
            </div>
            
            <div class="content-wrapper">
                <h2 class="location-title"><?php echo htmlentities($result->LocationName); ?></h2>
                <p class="location-description">Experience the ultimate Location </p>

                <div class="features-container">


 
                </div>

                <div class="price-section">
                    <div>
                    <div class="pricedss">₱<?php echo htmlentities($result->LocationPrice); ?></div>
    <div class="pricedss">Starting from</div>
                    </div>
                </div>

                <div class="booking-info">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span style="color: black; font-weight: 600; font-size: 14px; background-color: #f0f0f0; padding: 4px 8px;  border-radius: 4px; display: inline-block; margin: 5px 0;box-shadow: 0 1px 3px rgba(0,0,0,0.1);">4.9 Rating • <?php echo htmlentities($result->totalBookingCount); ?>+ bookings</span>                </div>

                <div class="select-button">
                <label style="font-family: Arial, sans-serif; font-size: 16px; padding: 5px; border: 2px solid #000; border-radius: 15px; background-color: #fff; color: #000; display: inline-block; cursor: pointer;">
  <input type="radio" name="selectedLocation" value="<?php echo htmlentities($result->LocationName . '|' . $result->LocationPrice);?>" style="width: 20px; height: 20px; vertical-align: middle;">
  Select Location
</label>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        document.getElementById('myModal').style.display = "block";
    }

    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        document.getElementById('myModal').style.display = "none";
    }

    window.onclick = function(event) {
        var modal = document.getElementById('myModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<?php
} else {
    echo "<p>No location found.</p>";
}
?>
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
                    <div class="gcash-container">
    <div class="gcash-header">
        <svg class="gcash-logo" viewBox="0 0 24 24" width="48" height="48">
            <path fill="#00aeef" d="M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M12,20c-4.41,0-8-3.59-8-8 s3.59-8,8-8s8,3.59,8,8S16.41,20,12,20z"/>
            <path fill="#00aeef" d="M11,7h2v6h-2V7z M11,15h2v2h-2V15z"/>
        </svg>
        <a href="your-link-here">
    <img src="design/GCash-Logo-PNG_011.png" alt="FRITZANN GCASH DETAILS Logo" style="width: 200px; height: auto;">
</a>
    </div>
    <div class="gcash-content">
        <table class="gcash-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>GCash Number</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Arnold Schwarzenegger</td>
                    <td>09960004909</td>
                </tr>
            </tbody>
        </table>
        <div class="gcash-note">
            NOTE: You need to pay 500 of your rental price via GCash for Booking.
        </div>
        <div class="gcash-form-group">
    <h5>
        <svg class="gcash-icon" viewBox="0 0 24 24" width="24" height="24">
            <path fill="currentColor" d="M20,4H4C2.89,4,2,4.89,2,6v12c0,1.1,0.89,2,2,2h16c1.1,0,2-0.9,2-2V6C22,4.89,21.1,4,20,4z M20,18H4v-6h16V18z M20,8H4V6h16V8z"/>
            <path fill="currentColor" d="M17,14h-6c-0.55,0-1,0.45-1,1s0.45,1,1,1h6c0.55,0,1-0.45,1-1S17.55,14,17,14z"/>
        </svg>
        Payment Proof Image
    </h5>
    <input type="file" class="gcash-file-input" name="paymentproof" id="fileInputPayment" required>
<img id="previewImage" style="display:none; width: 200px; height: auto; margin-top: 10px;" alt="Preview">
</div>

        <div class="gcash-form-group">
            <button type="submit" name="submit" class="gcash-submit-btn">DONE</button>
        </div>
    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script>
  const fileInput = document.getElementById('fileInputPayment');
  const previewImage = document.getElementById('previewImage');

  fileInput.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewImage.src = e.target.result;
        previewImage.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      previewImage.style.display = 'none';
    }
  });
</script>
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