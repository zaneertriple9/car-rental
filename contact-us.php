<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['send']))
  {
$name=$_POST['name'];
$email=$_POST['email'];
$contactno=$_POST['contactno'];
$message=$_POST['message'];
$sql="INSERT INTO  friztann_contactus (name,EmailId,ContactNumber,Message) VALUES(:name,:email,:contactno,:message)";
$query = $dbh->prepare($sql);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':contactno',$contactno,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Message Sent. We will contact you shortly";
}
else 
{
$error="Something went wrong. Please try again";
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
<title>FritzAnn Shuttle Services |Contact Us</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">


<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
 <style>
    .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
/* General styles */
.contact_us {
      background-color: #fff;
      color: #333;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .row {
      display: flex;
      flex-wrap: wrap;
    }

    /* Contact form styles */
    .contact-form-container {
      flex: 1;
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      border: 2px solid #000;
    }

    .contact_form h3 {
      margin-bottom: 30px;
      color: #000;
      border-bottom: 2px solid #000;
      padding-bottom: 10px;
    }

    .form-group {
      margin-bottom: 25px;
    }

    .control-label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #000;
    }

    .form-control {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #000;
      background-color: #fff;
      color: #000;
    }

    .form-control:focus {
      outline: none;
      border-color: #e60000;
      box-shadow: 0 0 5px rgba(230, 0, 0, 0.4);
    }

    textarea.form-control {
      resize: vertical;
    }

    /* Button styles */
    .btn-submit {
      display: inline-block;
      padding: 12px 30px;
      background-color: #e60000;
      color: #fff;
      border: 2px solid #000;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
    }

    .btn-submit:hover {
      background-color: #fff;
      color: #e60000;
      border-color: #e60000;
    }

    /* Contact info styles */
    .contact-info-container {
      flex: 1;
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      border: 2px solid #000;
    }

    .contact-info-container h3 {
      margin-bottom: 30px;
      color: #000;
      font-size: 24px;
      border-bottom: 2px solid #000;
      padding-bottom: 10px;
    }

    .contact_detail ul {
      list-style: none;
      padding: 0;
    }

    .contact_detail li {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      color: #000;
    }

    .icon_wrap {
      margin-right: 12px;
      color: #e60000;
      font-size: 24px;
    }

    .contact_detail a {
      color: #000;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .contact_detail a:hover {
      color: #e60000;
    }

    </style>
</head>
<body>

        
<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 

<!--Page Header-->
<section class="page-header contactus_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Contact Us</h1>
      </div>
      <ul class="coustom-breadcrumb">

      </ul>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Page Header--> 

<!--Contact-us-->
<section class="contact_us section-padding">
<div class="container">
    <div class="row">
      <div class="col-md-6 contact-form-container">
        <h3>Get in touch using the form below</h3>
      <?php if($error){?>
    <div class="errorWrap" style="background-color: #1a0000; border: 2px solid #ff0000; color: #ff0000; padding: 10px; margin-bottom: 20px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">
      <strong style="color: #ff0000;">ERROR</strong>: <?php echo htmlentities($error); ?>
    </div>
  <?php } else if($msg){?>
    <div class="succWrap" style="background-color: #001a00; border: 2px solid #00ff00; color: #00ff00; padding: 10px; margin-bottom: 20px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">
      <strong style="color: #00ff00;">SUCCESS</strong>: <?php echo htmlentities($msg); ?>
    </div>
  <?php }?>
        <div class="contact_form">
          <form method="post">
            <div class="form-group">
              <label class="control-label">Full Name <span>*</span></label>
 <input type="text" name="name" class="form-control" id="name" required minlength="5" maxlength="25">
            </div>
            <div class="form-group">
              <label class="control-label">Email Address <span>*</span></label>
              <input type="email" name="email" class="form-control" id="emailaddress" required minlength="5" maxlength="40">
            </div>
            <div class="form-group">
              <label class="control-label">Phone Number <span>*</span></label>
              <input
    type="text"
    name="contactno"
    class="form-control"
    id="phonenumber"
    maxlength="11"
    required
    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
>

            </div>
            <div class="form-group">
              <label class="control-label">Message <span>*</span></label>
              <textarea class="form-control" name="message" rows="4" required minlength="5" maxlength="500"></textarea>
            </div>
            <div class="form-group">
              <button class="btn-submit" type="submit" name="send">Send Message</button>
            </div>
          </form>
        </div>
      </div>

      <div class="col-md-6 contact-info-container">
        <h3>Contact Info</h3>
        <div class="contact_detail">
          <?php 
          $pagetype = $_GET['type'];
          $sql = "SELECT * FROM friztann_contactinfo";
          $query = $dbh->prepare($sql);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);
          if($query->rowCount() > 0) {
            foreach($results as $result) { ?>
              <ul>
<li>
    <div class="icon_wrap">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 72 72" aria-hidden="true">
            <circle cx="36.446" cy="28.864" r="7.225" fill="#fff" />
            <path fill="#d22f27" d="M52.573 29.11c0-9.315-7.133-16.892-15.903-16.892s-15.903 7.577-15.903 16.896c.002.465.223 11.609 12.96 31.245a3.46 3.46 0 0 0 2.818 1.934c1.84 0 3.094-2.026 3.216-2.232C52.58 40.414 52.58 29.553 52.573 29.11M36.67 35.914a7.083 7.083 0 1 1 7.083-7.083a7.09 7.09 0 0 1-7.083 7.083" />
            <path fill="#ea5a47" d="M52.573 29.11c0-9.315-7.133-16.892-15.903-16.892a15 15 0 0 0-3.865.525c8.395.45 15.1 7.823 15.1 16.85c.006.443.006 11.303-12.813 30.95a6 6 0 0 1-.586.797c.52.584 1.257.928 2.04.954c1.839 0 3.093-2.027 3.215-2.233C52.58 40.414 52.58 29.553 52.573 29.11" />
            <g fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M36.545 62.294a3.46 3.46 0 0 1-2.817-1.935C20.99 40.723 20.769 29.58 20.766 29.114c0-9.32 7.134-16.896 15.904-16.896s15.903 7.577 15.903 16.892c.007.444.007 11.304-12.812 30.95c-.122.207-1.377 2.234-3.216 2.234" />
                <path d="M36.67 35.914a7.083 7.083 0 1 1 7.083-7.083a7.09 7.09 0 0 1-7.083 7.083" />
            </g>
        </svg>
    </div>
    <?php echo htmlentities($result->Address); ?>
</li>
<li>
    <div class="icon_wrap">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512">
            <path fill="#af0000" d="M511.824 425.007c1.941-5.245-220.916-173.519-220.916-173.519c-27.9-20.589-42.574-20.913-70.164 0c0 0-222.532 168.138-220.659 173.311l-.045.038c.023.045.06.076.091.117a48.5 48.5 0 0 0 8.119 14.157c1.473 1.786 3.248 3.282 4.955 4.837l-.083.064c.136.121.317.177.453.298c7.235 6.454 16.359 10.634 26.495 11.827c.159.019.287.102.446.121h.612c1.541.147 3.006.517 4.584.517h420.721c20.717 0 38.269-13.028 45.241-31.291c.083-.136.211-.234.287-.374z"/>
            <path fill="#b92929" d="M256.133 232.176L1.216 423.364V152.515c0-26.4 21.397-47.797 47.797-47.797h414.24c26.4 0 47.797 21.397 47.797 47.797v270.849z"/>
            <path fill="#e6e8ed" d="m4.189 135.896l217.645 170.949c27.47 20.271 41.918 20.591 69.083 0L508.22 136.167c-3.77-6.834-9.414-12.233-15.869-16.538l2.989-2.342c-7.295-6.641-16.62-10.946-26.971-12.058l-424.455.015c-10.322 1.097-19.662 5.417-26.942 12.043l2.967 2.313c-6.38 4.245-11.972 9.551-15.75 16.296"/>
            <path fill="#6f6f6f" d="M4.118 136.254C2.207 141.419 221.63 307.099 221.63 307.099c27.47 20.271 41.918 20.591 69.083 0c0 0 219.103-165.546 217.258-170.64l.045-.037c-.022-.045-.059-.074-.089-.115a47.7 47.7 0 0 0-7.994-13.939c-1.45-1.759-3.198-3.231-4.878-4.763l.082-.063c-.134-.119-.312-.175-.446-.294c-7.124-6.354-16.107-10.47-26.086-11.645c-.156-.019-.283-.1-.439-.119h-.602c-1.517-.145-2.96-.509-4.514-.509H48.81c-20.398 0-37.68 12.828-44.543 30.809c-.082.134-.208.231-.283.368z"/>
            <path fill="#090808" d="M291.401 154.645h-38.632a6.155 6.155 0 0 0-6.155 6.155v21.722a6.155 6.155 0 0 0 6.155 6.155h31.415a6.155 6.155 0 0 1 6.155 6.155v11.616a6.155 6.155 0 0 1-6.155 6.155h-31.415a6.155 6.155 0 0 0-6.155 6.155v23.578a6.155 6.155 0 0 0 6.155 6.155h41.316a6.155 6.155 0 0 1 6.155 6.155v12.441a6.155 6.155 0 0 1-6.155 6.155h-75.76a6.155 6.155 0 0 1-6.155-6.155V136.461a6.155 6.155 0 0 1 6.155-6.155h74.81c3.749 0 6.627 3.322 6.092 7.033l-1.733 12.028a6.156 6.156 0 0 1-6.093 5.278"/>
        </svg>
    </div> 
    <a href="mailto:<?php echo htmlentities($result->EmailId); ?>">
        <?php echo htmlentities($result->EmailId); ?>
    </a>
</li>
<li>
    <div class="icon_wrap">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 48 48">
            <path fill="#b73a3a" d="M40 7H8c-2.2 0-4 1.8-4 4v26c0 2.2 1.8 4 4 4h5v-1.3c-.6-.3-1-1-1-1.7c0-1.1.9-2 2-2s2 .9 2 2c0 .7-.4 1.4-1 1.7V41h18v-1.3c-.6-.3-1-1-1-1.7c0-1.1.9-2 2-2s2 .9 2 2c0 .7-.4 1.4-1 1.7V41h5c2.2 0 4-1.8 4-4V11c0-2.2-1.8-4-4-4" />
            <g fill="#040405">
                <circle cx="24" cy="18" r="4" />
                <path d="M31 28s-1.9-4-7-4s-7 4-7 4v2h14z" />
            </g>
        </svg>
    </div>
    <a href="tel:<?php echo htmlentities($result->ContactNo); ?>">
        <?php echo htmlentities($result->ContactNo); ?>
    </a>
</li>
              </ul>
          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /Contact-us--> 


<?php include('includes/footer.php');?>

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
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
