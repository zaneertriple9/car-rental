<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(empty($_SESSION['login'])) { 
    header('location:index.php');
    exit();
} else {
    if(isset($_POST['submit'])) {
        $testimonial = $_POST['testimonial'];
        $email = $_SESSION['login'];

        $feedbackPath = '';

        $feedbackDir = "assets/feedback/";
        
        try {
            if (isset($_FILES['feedbackimg']) && $_FILES['feedbackimg']['error'] === UPLOAD_ERR_OK) {
                $feedbackPath = $feedbackDir . basename($_FILES['feedbackimg']['name']);
                move_uploaded_file($_FILES['feedbackimg']['tmp_name'], $feedbackPath);
            }
        
            $sql = "INSERT INTO friztann_feedback (UserEmail, Testimonial, FeedbackImage) VALUES(:email, :testimonial, :feedbackImage)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':testimonial', $testimonial, PDO::PARAM_STR);
            $query->bindParam(':feedbackImage', $feedbackPath, PDO::PARAM_STR);

            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if($lastInsertId) {
                $msg = "Feedback submitted successfully";
            } else {
                $error = "Something went wrong. Please try again";
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
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
<title>FritzAnn Shuttle Services | FeedBack</title>
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
    .profile_wrap {
        background-color: black;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .profile_wrap h5 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        font-weight: bold;
        color: #555;
    }
    .form-control {
        border: 1px solid #ddd;
        border-radius: 5px;
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
    </style>
</head>
<body>
<?php include('includes/header.php');?>
<section class="page-header profile_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>FeedBack</h1>
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
      <div class="col-md-6 col-sm-8">
        <div class="profile_wrap">
        <?php if($error){?>
    <div class="errorWrap" style="background-color: #1a0000; border: 2px solid #ff0000; color: #ff0000; padding: 10px; margin-bottom: 20px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">
      <strong style="color: #ff0000;">ERROR</strong>: <?php echo htmlentities($error); ?>
    </div>
  <?php } else if($msg){?>
    <div class="succWrap" style="background-color: #001a00; border: 2px solid #00ff00; color: #00ff00; padding: 10px; margin-bottom: 20px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">
      <strong style="color: #00ff00;">SUCCESS</strong>: <?php echo htmlentities($msg); ?>
    </div>
  <?php }?>
        <form method="post" enctype="multipart/form-data">
        <div style="font-family: 'Courier New', monospace; background-color: #0a0a0a; color: #ffffff; padding: 20px; border: 2px solid #ff0000; max-width: 500px; margin: 0 auto;">
  <div class="form-group" style="margin-bottom: 20px;">
    <label class="control-label" style="display: block; margin-bottom: 5px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #ff0000;">Feedback</label>
    <textarea class="form-control white_bg" name="testimonial" rows="4" required="" style="width: 100%; background-color: #ffffff; color: #0a0a0a; border: none; border-bottom: 2px solid #ff0000; padding: 10px; font-family: inherit; resize: vertical;"></textarea>
  </div>
  <div class="form-group" style="margin-bottom: 20px;">
    <label class="control-label" style="display: block; margin-bottom: 5px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #ff0000;">Upload Feedback Picture</label>
<!-- File Input -->
<input 
    type="file" 
    name="feedbackimg" 
    id="feedbackimg" 
    class="form-control-file" 
    style="width: 100%; background-color: #ffffff; color: #0a0a0a; border: none; border-bottom: 2px solid #ff0000; padding: 10px; font-family: inherit;" 
    onchange="previewImage(event)"
    accept="image/*" 
>

<!-- Image Preview Container -->
<div id="imagePreview" style="margin-top: 10px;">
    <img 
        id="preview" 
        src="#" 
        alt="Image Preview" 
        style="display: none; width: 100%; max-height: 300px; object-fit: contain; border: 1px solid #ddd; padding: 5px;"
    >
</div>  </div>
  <div class="form-group">
    <button type="submit" name="submit" class="btn" style="background-color: #ff0000; color: #ffffff; border: none; padding: 10px 20px; font-family: inherit; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; cursor: pointer;">
      Save <span class="angle_arrow" style="margin-left: 10px;"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
    </button>
  </div>
</div>
</form>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- JavaScript for Preview -->
<script>
    function previewImage(event) {
        const fileInput = event.target;
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(fileInput.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>
<?php include('includes/footer.php');?>
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
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
</body>
</html>
