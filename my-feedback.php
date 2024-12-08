
<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>FritzAnn Shuttle Services |Feed  Back</title>
<link href="assets/css/profile.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
 <style>
    .coustom-breadcrumb {
        background-color: transparent;
        padding: 0;
        margin: 0;
    }
    .coustom-breadcrumb li {
        display: inline;
        list-style: none;
        color: #777;
    }
    .coustom-breadcrumb li a {
        color: #777;
        text-decoration: none;
    }
    .coustom-breadcrumb li::after {
        content: "/";
        margin: 0 10px;
    }
 
    .profile_wrap h5 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }
    
    .btn {
        background-color: #000000;
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn:hover {
        background-color: #0056b3;
    }

    .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
:root {
    --primary-red: #ff0040;
    --secondary-red: #ff3366;
    --text-black: #000000;
}

.testimonial_card {
    background-color: #ffffff;
    border: 2px solid var(--primary-red);
    border-radius: 8px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 
        0 0 10px rgba(255, 0, 64, 0.3),
        0 4px 6px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.testimonial_card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        45deg, 
        transparent, 
        var(--primary-red), 
        transparent
    );
    opacity: 0.1;
}

.testimonial_card p {
    color: var(--text-black);
    font-size: 16px;
    line-height: 1.6;
    position: relative;
    border-left: 3px solid var(--primary-red);
    padding-left: 15px;
}

.testimonial_card b {
    color: var(--primary-red);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.testimonial_status {
    background-color: var(--primary-red);
    color: #ffffff;
    border-radius: 20px;
    padding: 5px 15px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: absolute;
    top: 15px;
    right: 15px;
    box-shadow: 0 2px 4px rgba(255, 0, 64, 0.3);
}

.testimonial_status.pending {
    background-color: #cccccc;
    color: var(--text-black);
}

@media (max-width: 600px) {
    .testimonial_card {
        padding: 15px;
    }
}
.vehicle_status {
    margin-right: 180px; /* Add right margin */
}
/* Base button styles */
.btnS {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

/* Active button (Green) */
.btnS.active-btn {
    background-color: #22c55e;
    color: #ffffff !important;
    border: 1px solid #22c55e;
    width: 120px;
    text-align: center;
    font-weight: 800;  /* Extra bold */
}
.btnS.active-btn:hover {
    background-color: #16a34a;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Waiting for approval button (Red) */
.btnS.outline:not(.active-btn) {
    background-color: #ef4444;
    color: #ffffff;
    border: 1px solid #ef4444;
    width: auto; /* Automatically adjusts width to fit content */
    text-align: center;
    font-weight: 800;
    white-space: nowrap;
    overflow: visible;
    text-overflow: clip;
    padding: 5px 10px; /* Optional: Adjusts padding for better spacing */
}


.btnS.outline:not(.active-btn):hover {
    background-color: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Container styling */
.vehicle_status {
    margin: 10px 0;
    display: inline-block;
}

.clearfix {
    clear: both;
}
    </style>
</head>
<body>      
<?php include('includes/header.php');?>
<section class="page-header profile_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>My Feedback</h1>
      </div>
      <ul class="coustom-breadcrumb">

      </ul>
    </div>
  </div>
  <div class="dark-overlay"></div>
</section>

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
    <?php echo htmlentities($result->Barangay); ?>/<?php echo htmlentities($result->City); ?>/<?php echo htmlentities($result->Province); ?>
</span>
</div>
</p>
</div></div>
    </div>
  <div class="row">
      <div class="col-md-3 col-sm-3">
        <?php include('includes/sidebar.php');?>
      <div class="col-md-8 col-sm-8">



        <div class="profile_wrap">
          <h5 class="uppercase underline">My Feedback </h5>
          <div class="my_vehicles_list">
            <ul class="vehicle_listing">
            <?php  
$useremail = $_SESSION['login']; 
$sql = "SELECT * from friztann_feedback where UserEmail=:useremail ORDER BY PostingDate DESC LIMIT 3"; 
$query = $dbh->prepare($sql); 
$query->bindParam(':useremail', $useremail, PDO::PARAM_STR); 
$query->execute(); 
$results = $query->fetchAll(PDO::FETCH_OBJ);  

if($query->rowCount() > 0) { 
    foreach($results as $result) { 
?>
    <li>
        <div class="testimonial_card">
            <p><?php echo htmlentities($result->Testimonial);?> </p>
            <p><b>Posting Date:</b> <?php echo htmlentities($result->PostingDate);?> </p>
        </div>
        <?php if($result->status == 1){ ?>
            <div class="vehicle_status"> 
                <a class="btnS outline btn-xs active-btn">Active</a>
                <div class="clearfix"></div>
            </div>
        <?php } else { ?>
            <div class="vehicle_status"> 
                <a href="#" class="btnS outline btn-xs">Waiting for approval</a>
                <div class="clearfix"></div>
            </div>
        <?php } ?>
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

<?php include('includes/footer.php');?>
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/switcher/js/switcher.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>
<?php } ?>