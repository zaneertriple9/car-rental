<?php
session_start();
include('includes/config.php');

$error = "";
$msg = "";

if (isset($_GET['user_id'])) {
    $booking_id = intval($_GET['user_id']);
    
    try {
        // Corrected SQL Query
        $sql = "SELECT 
                    friztann_users.FirstName,
                    friztann_users.MiddleName,
                    friztann_users.LastName,
                    friztann_users.ProfileImg,
                    friztann_users.ContactNo,
                    friztann_users.dob,
                    friztann_users.Barangay,
                    friztann_users.City,
                    friztann_users.Province,
                    friztann_users.Gender,
                    friztann_users.DriversLicenseFront,
                    friztann_users.DriversLicenseBack,
                    friztann_users.GovernmentIDFront,
                    friztann_users.GovernmentIDBack
                FROM friztann_users
                WHERE id = :user_id";
        
        $query = $dbh->prepare($sql);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if ($result) {
            // Process the fetched data
            $msg = "User data fetched successfully.";
        } else {
            $error = "No user found for the provided ID.";
        }
    } catch (PDOException $e) {
        $error = "Query failed: " . $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>FritzAnn Shuttle Services |Admin Manage testimonials   </title>
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
    <link rel="stylesheet" href="css/viewuser.css">

    <style>

    </style>
</head>

<body class="friztannbody">

<?php include('includes/header.php');?>

<div class="ts-main-content">
		<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
                    <div class="friztanncontainer">
        <div class="friztannprofile-section">
            <div class="friztannprofile-img-container">
            <?php
session_start();
include('includes/config.php');

$error = "";
$msg = "";

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
    
    try {
        $sql = "SELECT
                    u.FirstName,
                    u.MiddleName,
                    u.LastName,
                    u.ProfileImg,
                    u.Gender,
                    u.dob,
                    u.ContactNo,
                    u.DriversLicenseFront,
                    u.DriversLicenseBack,
                    u.GovernmentIDFront,
                    u.GovernmentIDBack,
                    u.EmailId,
                    u.City,
                    u.Barangay,
                    u.Province,
                    u.user_id
                FROM friztann_users u
                WHERE u.user_id = :user_id";

        $query = $dbh->prepare($sql);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if ($result) {
           
        } else {
            $error = "No user found with this ID.";
        }
    } catch (PDOException $e) {
        $error = "Error fetching user details: " . $e->getMessage();
    }
}
?>
                <?php if (!empty($result->ProfileImg) && file_exists('avatar/' . basename($result->ProfileImg))) : ?>
                    <img src="avatar/<?php echo htmlentities(basename($result->ProfileImg)); ?>" alt="Profile Image" class="friztannprofile-img">
                <?php else : ?>
                    <div class="friztannprofile-img-default">
                        <?php echo strtoupper(substr($result->FirstName, 0, 1)); ?>
                    </div>
                <?php endif; ?>
            </div>
            <h3 class="friztannprofile-name">
      <?php echo htmlentities(trim($result->FirstName)) . ' ' . htmlentities(trim($result->MiddleName)) . ' ' . htmlentities(trim($result->LastName)); ?>
            </h3>
        </div>

        <div class="basic-info-section friztanninfo-section">
    <h3 class="basic-info-title">Basic Information</h3>
    <div class="info-item">
<p class="basic-info-gender">
    Gender: 
    <?php 
        echo htmlentities($result->Gender == 1 ? "Male" : ($result->Gender == 2 ? "Female" : "Others")); 
    ?>
</p>    </div>
    <div class="info-item">
        <p class="basic-info-dob">Date of Birth: <?php echo htmlentities(date('F j, Y', strtotime($result->dob))); ?></p>
    </div>
    <div class="info-item">
        <p class="basic-info-contact">Contact: <?php echo htmlentities($result->ContactNo); ?></p>
    </div>
    <div class="info-item">
        <p class="basic-info-city">City: <?php echo htmlentities($result->City); ?></p>
    </div>
    <div class="info-item">
        <p class="basic-info-barangay">Barangay: <?php echo htmlentities($result->Barangay); ?></p>
    </div>
    <div class="info-item">
        <p class="basic-info-province">Province: <?php echo htmlentities($result->Province); ?></p>
    </div>
</div>



                <div class="friztannid-card">
                    <h5>Driver's License</h5>
                    <div class="d-flex justify-content-between">
                        <div class="friztannlicense-card">
                            <?php if (!empty($result->DriversLicenseFront) && file_exists('img/VALID_ID/' . basename($result->DriversLicenseFront))) : ?>
                                <a href="img/VALID_ID/<?php echo htmlentities(basename($result->DriversLicenseFront)); ?>" data-lightbox="license-<?php echo htmlentities($result->user_id); ?>" data-title="Driver's License Front">
                                    <img src="img/VALID_ID/<?php echo htmlentities(basename($result->DriversLicenseFront)); ?>" alt="License Front" class="img-fluid">
                                </a>
                            <?php else : ?>
                                <p class="friztannimage-not-found">Driver's license front image not uploaded</p>
                            <?php endif; ?>
                        </div>
                        <div class="friztannlicense-card">
                            <?php if (!empty($result->DriversLicenseBack) && file_exists('img/VALID_ID/' . basename($result->DriversLicenseBack))) : ?>
                                <a href="img/VALID_ID/<?php echo htmlentities(basename($result->DriversLicenseBack)); ?>" data-lightbox="license-<?php echo htmlentities($result->user_id); ?>" data-title="Driver's License Back">
                                    <img src="img/VALID_ID/<?php echo htmlentities(basename($result->DriversLicenseBack)); ?>" alt="License Back" class="img-fluid">
                                </a>
                            <?php else : ?>
                                <p class="friztannimage-not-found">Driver's license back image not uploaded</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            
                <div class="friztannid-card">
                    <h5>Government ID</h5>
                    <div class="d-flex justify-content-between">
                        <div class="friztannlicense-card">
                            <?php if (!empty($result->GovernmentIDFront) && file_exists('img/VALID_ID/' . basename($result->GovernmentIDFront))) : ?>
                                <a href="img/VALID_ID/<?php echo htmlentities(basename($result->GovernmentIDFront)); ?>" data-lightbox="governmentid-<?php echo htmlentities($result->user_id); ?>" data-title="Government ID Front">
                                    <img src="img/VALID_ID/<?php echo htmlentities(basename($result->GovernmentIDFront)); ?>" alt="Government ID Front" class="img-fluid">
                                </a>
                            <?php else : ?>
                                <p class="friztannimage-not-found">Government ID front image not uploaded</p>
                            <?php endif; ?>
                        </div>
                        <div class="friztannlicense-card">
                            <?php if (!empty($result->GovernmentIDBack) && file_exists('img/VALID_ID/' . basename($result->GovernmentIDBack))) : ?>
                                <a href="img/VALID_ID/<?php echo htmlentities(basename($result->GovernmentIDBack)); ?>" data-lightbox="governmentid-<?php echo htmlentities($result->user_id); ?>" data-title="Government ID Back">
                                    <img src="img/VALID_ID/<?php echo htmlentities(basename($result->GovernmentIDBack)); ?>" alt="Government ID Back" class="img-fluid">
                                </a>
                            <?php else : ?>
                                <p class="friztannimage-not-found">Government ID back image not uploaded</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="friztannuser-info-card">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                    </tr>
                </table>
            </div>
        </div>
    </div>

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
