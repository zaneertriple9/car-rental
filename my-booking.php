<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/config.php');


$db_host = 'localhost';
$db_name = 'u532615850_friztann';
$db_user = 'u532615850_root';
$db_pass = 'Bwsesitmani23';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$proofPath = '';
$targetDir = "admin/img/payments/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (isset($_FILES['paymentimg']) && $_FILES['paymentimg']['error'] === UPLOAD_ERR_OK) {
            $filename = basename($_FILES['paymentimg']['name']);
            $proofPath = $targetDir . $filename;
            
            if (move_uploaded_file($_FILES['paymentimg']['tmp_name'], $proofPath)) {
            } else {
                throw new Exception("Failed to move uploaded file.");
            }
        }

        $stmt = $pdo->query("SELECT booking_id FROM friztann_bookinginfo ORDER BY booking_id DESC LIMIT 1");
        $bookingId = $stmt->fetchColumn();

        if ($bookingId) {
            $stmt = $pdo->prepare("INSERT INTO friztann_payments (booking_id, proof_path) VALUES (?, ?)");
            $stmt->execute([$bookingId, $proofPath]);

            $message = "Payment successful and wait for confirmation.";
            echo "<script>alert('$message');</script>";
        } else {
            echo "<script>alert('No booking found.');</script>";
        }
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>FritzAnn Shuttle Services  | Booking Status</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="assets/css/profile.css" rel="stylesheet">
    <link href="assets/css/mybooking2.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<style>
    .cyberpunk-btn {
   display: block;
   width: 210px;
   height: 60px;
   margin-left: auto;
   margin-right: 20px;
   padding: 16px 32px;
   border: 2px solid #ff0040;
   text-decoration: none;
   color: #ffffff;
   text-transform: uppercase;
   font-weight: bold;
   font-size: 16px;
   background-color: #000000;
   border-radius: 0;
   cursor: pointer;
   transition: all 0.3s ease;
}
.cyberpunk-btn:hover {
   color: #ff0040;
   border-color: #ffffff;
}
.cyberpunk-btn:active {
   transform: translateY(2px);
}
@media (max-width: 768px) {
   .cyberpunk-btn {
       width: 80%;
       height: auto;
       text-align: center;
       margin-left: auto;
       margin-right: auto;
   }
}
    </style>
<body>
       
<?php include('includes/header.php');?>
<section class="page-header profile_page">

  <div class="dark-overlay"></div>
</section>
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
     <div class="container">
  <div class="user_profile_info gray-bgs padding_4x4_40 cloud-background">

  <div class="upload_user_logo">
  <div class="cloud small"></div>
      <div class="cloud medium"></div>
      <div class="cloud large"></div>
      <div class="cloud extra-small"></div>
      <div class="cloud extra-large"></div>
      <div class="cloud medium-two"></div>
 </div>


 <img src="<?php echo $avatar; ?>" alt="Avatar" style="width: 250px; height: 190px; border-radius: 50%; border: 2px solid #000;">
      <div class="dealer_info">
      <h5><?php echo htmlentities($result->FirstName); ?> <?php echo htmlentities($result->MiddleName); ?> <?php echo htmlentities($result->LastName); ?></h5>
      <div class="cyberpunk-container">
<p class="glitch"><div style="display: flex;">
<span style="color: white; font-weight: bold;">
<?php
$location = [];

if (!empty($result->Barangay)) {
    $location[] = htmlentities($result->Barangay);
}
if (!empty($result->City)) {
    $location[] = htmlentities($result->City);
}
if (!empty($result->Province)) {
    $location[] = htmlentities($result->Province);
}

echo !empty($location) ? implode('/', $location) : 'NO LOCATION';
?></span>
</div>
</p>
</div></div>
    </div>
    <a href="bookinghistory.php" class="cyberpunk-btn" style="white-space: nowrap;">
    Booking History
</a>
    <div class="container">
  <div class="row">

  
    <div class="profile_wrap">
      <div class="filter_sidebar">
        <h6>Filter Bookings</h6>
        <form method="GET" action="">
          <div class="date_filter">
            <input type="date" id="from_date" name="from_date" value="<?php echo isset($_GET['from_date']) ? htmlspecialchars($_GET['from_date']) : ''; ?>">
            <input type="date" id="to_date" name="to_date" value="<?php echo isset($_GET['to_date']) ? htmlspecialchars($_GET['to_date']) : ''; ?>">
            <button type="submit" class="filter_btn">Apply Filter</button>
          </div>
        </form>
      </div>
      <div class="my_vehicles_list">
        <h5 class="uppercase underline">My Booking Status</h5>
        <ul class="vehicle_listing">
        <?php
$useremail = $_SESSION['login'];
$sql = "SELECT friztann_vehicles.Vimage0 as Vimage0, 
               friztann_vehicles.VehiclesTitle, 
               friztann_vehicles.vehicle_id as vid,
               friztann_brands.BrandName, 
               friztann_booking.FromDate, 
               friztann_booking.ToDate, 
               friztann_booking.pickuptime,
               friztann_booking.returntime, 
               friztann_booking.BookingHours,
               friztann_booking.Status, 
               friztann_booking.PostingDate,
               friztann_bookinginfo.NeedDriver, 
               friztann_bookinginfo.selectedLocation, 
               friztann_bookinginfo.totalprice,
               friztann_drivers.DriverName 
        FROM friztann_booking
        JOIN friztann_vehicles ON friztann_booking.vehicle_id = friztann_vehicles.vehicle_id
        JOIN friztann_brands ON friztann_brands.brand_id = friztann_vehicles.VehiclesBrand
        JOIN friztann_bookinginfo ON friztann_booking.booking_id = friztann_bookinginfo.booking_id
        LEFT JOIN friztann_drivers ON friztann_bookinginfo.DriverId = friztann_drivers.driver_id
        WHERE friztann_booking.userEmail = :useremail";


if (isset($_GET['from_date']) && isset($_GET['to_date']) && !empty($_GET['from_date']) && !empty($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
    $sql .= " AND friztann_booking.PostingDate BETWEEN :from_date AND :to_date";
}

$sql .= " ORDER BY friztann_booking.PostingDate DESC LIMIT 3";  

$query = $dbh->prepare($sql);
$query->bindParam(':useremail', $useremail, PDO::PARAM_STR);

if (isset($from_date) && isset($to_date)) {
    $query->bindParam(':from_date', $from_date, PDO::PARAM_STR);
    $query->bindParam(':to_date', $to_date, PDO::PARAM_STR);
}

$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $result) {
?>
    <li>
        <div class="vehicle_img">
            <a href="car-details.php?vhid=<?php echo htmlentities($result->vid); ?>">
                <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage0); ?>" alt="image">
            </a>
        </div>
        <div class="vehicle_title">
        <?php if ($result->Status == 1) { ?>
                <div class="vehicle_status">
                    <a href="#" class="btnS outline btn-xs active-btnS">Confirmed</a>
                </div>
            <?php } else if ($result->Status == 2) { ?>
                <div class="vehicle_status">
                    <a href="#" class="btnS outline btn-xs">Cancelled</a>
                </div>
            <?php } else { ?>
                <div class="vehicle_status">
                    <a href="#" class="btnS outline btn-xs">Not Confirmed</a>
                    <button id="openModalBtn_<?php echo htmlentities($result->vid); ?>" class="friztann-button btn-xs payment-btn" style="--clr: #00ad54; margin-top: 5px;">
    <span class="button-decor"></span>
    <div class="button-content">
        <div class="button__icon">
            <svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" width="24">
                <circle opacity="0.5" cx="25" cy="25" r="23" fill="url(#icon-payments-cat_svg__paint0_linear_1141_21101)"></circle>
                <mask id="icon-payments-cat_svg__a" fill="#fff">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M34.42 15.93c.382-1.145-.706-2.234-1.851-1.852l-18.568 6.189c-1.186.395-1.362 2-.29 2.644l5.12 3.072a1.464 1.464 0 001.733-.167l5.394-4.854a1.464 1.464 0 011.958 2.177l-5.154 4.638a1.464 1.464 0 00-.276 1.841l3.101 5.17c.644 1.072 2.25.896 2.645-.29L34.42 15.93z">
                    </path>
                </mask>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M34.42 15.93c.382-1.145-.706-2.234-1.851-1.852l-18.568 6.189c-1.186.395-1.362 2-.29 2.644l5.12 3.072a1.464 1.464 0 001.733-.167l5.394-4.854a1.464 1.464 0 011.958 2.177l-5.154 4.638a1.464 1.464 0 00-.276 1.841l3.101 5.17c.644 1.072 2.25.896 2.645-.29L34.42 15.93z" fill="#fff"></path>
                <path d="M25.958 20.962l-1.47-1.632 1.47 1.632zm2.067.109l-1.632 1.469 1.632-1.469zm-.109 2.068l-1.469-1.633 1.47 1.633zm-5.154 4.638l-1.469-1.632 1.469 1.632zm-.276 1.841l-1.883 1.13 1.883-1.13zM34.42 15.93l-2.084-.695 2.084.695zm-19.725 6.42l18.568-6.189-1.39-4.167-18.567 6.19 1.389 4.166zm5.265 1.75l-5.12-3.072-2.26 3.766 5.12 3.072 2.26-3.766zm2.072 3.348l5.394-4.854-2.938-3.264-5.394 4.854 2.938 3.264zm5.394-4.854a.732.732 0 01-1.034-.054l3.265-2.938a3.66 3.66 0 00-5.17-.272l2.939 3.265zm-1.034-.054a.732.732 0 01.054-1.034l2.938 3.265a3.66 3.66 0 00.273-5.169l-3.265 2.938zm.054-1.034l-5.154 4.639 2.938 3.264 5.154-4.638-2.938-3.265zm1.023 12.152l-3.101-5.17-3.766 2.26 3.101 5.17 3.766-2.26zm4.867-18.423l-6.189 18.568 4.167 1.389 6.19-18.568-4.168-1.389zm-8.633 20.682c1.61 2.682 5.622 2.241 6.611-.725l-4.167-1.39a.732.732 0 011.322-.144l-3.766 2.26zm-6.003-8.05a3.66 3.66 0 004.332-.419l-2.938-3.264a.732.732 0 01.866-.084l-2.26 3.766zm3.592-1.722a3.66 3.66 0 00-.69 4.603l3.766-2.26c.18.301.122.687-.138.921l-2.938-3.264zm11.97-9.984a.732.732 0 01-.925-.926l4.166 1.389c.954-2.861-1.768-5.583-4.63-4.63l1.39 4.167zm-19.956 2.022c-2.967.99-3.407 5.003-.726 6.611l2.26-3.766a.732.732 0 01-.145 1.322l-1.39-4.167z" fill="#fff" mask="url(#icon-payments-cat_svg__a)"></path>
                <defs>
                    <linearGradient id="icon-payments-cat_svg__paint0_linear_1141_21101" x1="25" y1="2" x2="25" y2="48" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#fff" stop-opacity="0.71"></stop>
                        <stop offset="1" stop-color="#fff" stop-opacity="0"></stop>
                    </linearGradient>
                </defs>
            </svg>
        </div>
        <span class="button__text" style="font-size: 10px; font-weight: bold;">Payment</span>
        </div>
</button>

                </div>
            <?php } ?>
            <h6>
                <a href="car-details.php?vhid=<?php echo htmlentities($result->vid); ?>">
                    <?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->VehiclesTitle); ?>
                </a>
            </h6>
           
            <p>
<b>Total Price:</b> <?php echo htmlentities($result->totalprice); ?><br />
 <b>Pick Up Date:</b> <?php echo htmlentities($result->FromDate); ?><br />
<b>Return Date:</b> <?php echo htmlentities($result->ToDate); ?><br />
<b>Pick Up Time:</b> <?php echo htmlentities($result->pickuptime); ?><br />
<b>Return Time:</b> <?php echo htmlentities($result->returntime); ?><br />
<b>Booking Days:</b> <?php echo htmlentities($result->BookingHours); ?><br />
<b>Need Driver:</b> <?php echo htmlentities($result->NeedDriver ? 'Yes' : 'No'); ?><br />
<b>Driver Name:</b> <?php echo htmlentities($result->DriverName ? $result->DriverName : 'Not Assigned'); ?><br />
<b>Selected Location:</b> <?php echo htmlentities($result->selectedLocation); ?><br />

            </p>
        </div>
    </li>
<?php
    }
}
?>


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Payment Modal -->
<div id="paymentModal" class="modal">
    
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="container1">
            <img src="design/GCash-Logo-PNG-8.png" alt="GCash Logo" style="width: 150px; height: auto;">
            <form action="" method="post" enctype="multipart/form-data">
            <div class="file-upload">
        <input type="file" id="paymentimg" name="paymentimg" required onchange="previewImage()">
        <label for="paymentimg" class="file-upload-label">
            Click to upload payment proof
        </label>
    </div>
    <div id="imagePreviewContainer" style="display: none;">
        <h4>Preview of uploaded payment proof:</h4>
        <img id="imagePreview" src="" alt="Payment Image" style="width: 200px; height: auto;" />
    </div>
                <button type="submit" class="payment-btn2">Submit Payment</button>
            </form>
            <div class="custom-details">
                <h2 style="text-align: center;">PAYMENT DETAILS</h2>
                <div class="price-container">
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Gcash Name</th>
                            <th>GCash Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AL FRITZ ALLEN DELA CRUZ</td>
                            <td>09360386693</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php');?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/previewImagePAYMENT.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script>
    var modal = document.getElementById('paymentModal');
    var buttons = document.querySelectorAll('.payment-btn');
    var span = document.getElementsByClassName('close')[0];
    var paymentDone = <?php echo isset($message) ? 'true' : 'false'; ?>; 
    buttons.forEach(function(button) {
        button.onclick = function() {
            if (!paymentDone) {
                modal.style.display = 'block';
            } else {
                button.style.display = 'none';
            }
        };
    });

    span.onclick = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
</script>

</body>
</html>