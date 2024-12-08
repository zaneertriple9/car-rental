
<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
if(isset($_POST['update']))
  {
$password=md5($_POST['password']);
$newpassword=md5($_POST['newpassword']);
$email=$_SESSION['login'];
  $sql ="SELECT Password FROM friztann_users WHERE EmailId=:email and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update friztann_users set Password=:newpassword where EmailId=:email";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
$msg="Your Password succesfully changed";
}
else {
$error="Your current password is wrong";  
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
<title>FritzAnn Shuttle Services | Change Password</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
<link href="assets/css/profile.css" rel="stylesheet">

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<!-- Add Font Awesome CDN -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
  rel="stylesheet"
/>
<script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("New Password and Confirm Password Field do not match  !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>
 <style>


.col-md-3, .col-md-6, .col-sm-3, .col-sm-8 {
    padding: 15px;
}

.profile_wrap {
    background-color: #000;
    color: white;
    padding: 30px;
    border-radius: 10px;
    max-width: 500px;
    margin: 0 auto;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.gray-bgs.field-title {
    background-color: #111;
    padding: 10px;
    margin-bottom: 20px;
    text-align: center;
}

.gray-bgs.field-title h6 {
    color: white;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 2px;
}


.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    color: white;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.form-control.white_bg {
    width: 100%;
    padding: 10px;
    background-color: #111;
    color: white;
    border: 2px solid #333;
    border-radius: 5px;
    transition: border-color 0.3s ease;
}

.form-control.white_bg:focus {
    outline: none;
    border-color: red;
}

.btn.btn-block {
    width: 100%;
    padding: 12px;
    background-color: red;
    color: white;
    border: none;
    border-radius: 5px;
    text-transform: uppercase;
    letter-spacing: 2px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn.btn-block:hover {
    background-color: darkred;
}
@media (max-width: 768px) { /* Adjust breakpoint as needed */
    span[id^="togglePassword"] {
        left: 80%; /* Adjust left positioning for mobile screens */
        top: 50%; /* Center vertically for mobile */
        transform: translate(-50%, -50%);
    }
}



</style>
</head>
<body>


        
<?php include('includes/header.php');?>
<section class="page-header profile_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Update Password</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Update Password</li>
      </ul>
    </div>
  </div>
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
 <img src="<?php echo $avatar; ?>" alt="Avatar" style="width: 250px; height: 200px; border-radius: 50%; border: 2px solid #000;">
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
<form name="chngpwd" method="post" onSubmit="return valid();">
        
            <div class="gray-bgs field-title">
              <h6>Update password</h6>
            </div>
 <?php if($error){?>
    <div class="errorWrap" style="background-color: #1a0000; border: 2px solid #ff0000; color: #ff0000; padding: 10px; margin-bottom: 20px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">
      <strong style="color: #ff0000;">ERROR</strong>: <?php echo htmlentities($error); ?>
    </div>
  <?php } else if($msg){?>
    <div class="succWrap" style="background-color: #001a00; border: 2px solid #00ff00; color: #00ff00; padding: 10px; margin-bottom: 20px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">
      <strong style="color: #00ff00;">SUCCESS</strong>: <?php echo htmlentities($msg); ?>
    </div>
  <?php }?>
<div class="form-group">
    <label class="control-label">Current Password</label>
    <input 
        type="password" 
        class="form-control white_bg" 
        id="password" 
        name="password" 
        required 
        minlength="8" 
        maxlength="20" 
        pattern=".*\d.*" 
        title="Password must be between 8 and 20 characters and include numbers."
    >
  <span id="togglePassword659" style="position: absolute; left: 380px; top: 70%; transform: translateY(-50%); cursor: pointer; color: white;"><i class="fas fa-eye-slash"></i>️</span>
</div>



<div class="form-group">
  <label class="control-label">Password</label>
  <input
    type="password"
    class="form-control white_bg"
    id="newpassword"
    name="newpassword"
    required
    minlength="8"
    maxlength="20"
    pattern=".*\d.*"
    title="Password must be between 8 and 20 characters and include numbers."
  >
  <span
    id="togglePassword679"
    style="position: absolute; left: 380px; top: 70%; transform: translateY(-50%); cursor: pointer; color: white;"
  >
    <i class="fas fa-eye-slash"></i>
  </span>
</div>

<div class="form-group">
  <label class="control-label">Confirm Password</label>
  <input
    type="password"
    class="form-control white_bg"
    id="confirmpassword"
    name="confirmpassword"
    required
    minlength="8"
    maxlength="20"
    pattern=".*\d.*"
    title="Password must be between 8 and 20 characters and include numbers."
  >
  <span
    id="togglePassword669"
    style="position: absolute; left: 380px; top: 70%; transform: translateY(-50%); cursor: pointer; color: white;"
  >
    <i class="fas fa-eye-slash"></i>
  </span>
</div>

<div class="form-group">
  <input type="submit" value="Update" name="update" id="submit" class="btn btn-block">
</div>

<script>
  // Function to toggle password visibility
  function togglePasswordVisibility(toggleId, inputId) {
    const toggleIcon = document.getElementById(toggleId).querySelector('i');
    const passwordInput = document.getElementById(inputId);

    toggleIcon.addEventListener('click', () => {
      const isPassword = passwordInput.type === 'password';
      passwordInput.type = isPassword ? 'text' : 'password';
      toggleIcon.className = isPassword ? 'fas fa-eye' : 'fas fa-eye-slash'; 
    });
  }

  // Initialize toggle functionality for each password field
  togglePasswordVisibility('togglePassword659', 'password');
  togglePasswordVisibility('togglePassword679', 'newpassword');
  togglePasswordVisibility('togglePassword669', 'confirmpassword');
</script>


          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('includes/footer.php');?>
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<?php include('includes/login.php');?>
<?php include('includes/registration.php');?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>
<?php } ?>