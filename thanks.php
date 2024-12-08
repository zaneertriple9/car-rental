<?php
    session_start();
    include('includes/config.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment and License Preparation</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>FritzAnn Shuttle Services  | Booking Status</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/mybooking.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

    <style>
    body.custom22 {
        background-color: #111;
        color: #fff;
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }
    .cover-image.custom2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        object-fit: cover;
        opacity: 0.5;
    }
    .container.custom2 {
        max-width: 600px;
        margin: 100px auto;
        padding: 20px;
        border: 2px solid #ff4d4d;
        border-radius: 10px;
        background-color: rgba(0, 0, 0, 0.8);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        overflow: hidden;
        text-align: center;
    }
    h1.custom2 {
        font-size: 2.5em;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #ff4d4d;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }
    p.custom2 {
        font-size: 1.2em;
        line-height: 1.6;
        margin-bottom: 30px;
    }
    .btn2.custom2 {
        display: inline-block;
        padding: 12px 24px;
        background-color: #ff4d4d;
        color: #000;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 20px;
        transition: background-color 0.3s ease;
        font-size: 1em;
    }
    .btn2.custom2:hover {
        background-color: #cc3333;
    }
    #map.custom2 {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        border: 2px solid #ff4d4d;
        border-radius: 10px;
        background-color: rgba(0, 0, 0, 0.8);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        text-align: center;
    }
    #map h2.custom2 {
        font-size: 1.8em;
        margin-bottom: 10px;
        color: #ff4d4d;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }
    #map p.custom2 {
        font-size: 1.2em;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    #map iframe.custom2 {
        width: 100%;
        height: 300px;
        border: 0;
        border-radius: 10px;
    }
</style>
</head>
<body class="custom22">
    <?php include('includes/header.php');?>
    <div class="container custom2">
        <h1 class="custom2">THANK YOU FOR TRUSTING FRITZANN</h1>
        <p class="custom2">Please prepare your payment, valid ID, and driver's license, and go to our location to pick up your car. Make sure to provide the code from your booking to confirm the details of your reservation.</p>
        <a href="index.php" class="btn2 custom2">PROCEED</a>
   

    <div id="map" class="custom2">
        <h2 class="custom2">Our Location</h2>
        <p class="custom2">Blk 2, Baldostamon Subd, Poblacion, Koronadal City, 9506 South Cotabato</p>
        
        <iframe class="custom2" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7928.374069870745!2d124.8297936468493!3d6.497989965461435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32f819b18c604a37%3A0x3254390497218bfb!2sFritzAnn%20Shuttle%20Services!5e0!3m2!1sen!2sph!4v1713942524104!5m2!1sen!2sph" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
<?php include('includes/footer.php');?>

<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>

<?php include('includes/login.php');?>

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
