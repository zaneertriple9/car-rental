<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
} else {
    $email = $_SESSION['login'];
    $statusQuery = $dbh->prepare("SELECT status FROM friztann_users WHERE EmailId = :email");
    $statusQuery->bindParam(':email', $email, PDO::PARAM_STR);
    $statusQuery->execute();
    $statusResult = $statusQuery->fetch(PDO::FETCH_ASSOC);

    $statusMessage = '';
    if ($statusResult['status'] == 1) {
        $statusMessage = "Verified";
    } elseif ($statusResult['status'] == 2) {
        $statusMessage = "Rejected";
    }

    if (isset($_POST['updateprofile'])) {
        $FirstName = $_POST['FirstName'];
        $MiddleName = $_POST['MiddleName'];
        $LastName = $_POST['LastName'];
        $mobileno = $_POST['mobilenumber'];
        $dob = $_POST['dob'];
        $Barangay = $_POST['Barangay'];
        $City = $_POST['City'];
        $Province = $_POST['Province'];
        $GenderId = $_POST['Gender']; 
        $avatar = $_POST['avatar'];

        $DriversLicenseFront = $_FILES["DriversLicenseFront"]["name"];
        $DriversLicenseBack = $_FILES["DriversLicenseBack"]["name"];
        $GovernmentIDFront = $_FILES["GovernmentIDFront"]["name"];
        $GovernmentIDBack = $_FILES["GovernmentIDBack"]["name"];

        if ($DriversLicenseFront) {
            move_uploaded_file($_FILES["DriversLicenseFront"]["tmp_name"], "admin/img/VALID_ID/" . $DriversLicenseFront);
        }
        if ($DriversLicenseBack) {
            move_uploaded_file($_FILES["DriversLicenseBack"]["tmp_name"], "admin/img/VALID_ID/" . $DriversLicenseBack);
        }
        if ($GovernmentIDFront) {
            move_uploaded_file($_FILES["GovernmentIDFront"]["tmp_name"], "admin/img/VALID_ID/" . $GovernmentIDFront);
        }
        if ($GovernmentIDBack) {
            move_uploaded_file($_FILES["GovernmentIDBack"]["tmp_name"], "admin/img/VALID_ID/" . $GovernmentIDBack);
        }

        $sql = "UPDATE friztann_users SET 
                FirstName = :FirstName, 
                MiddleName = :MiddleName, 
                LastName = :LastName, 
                ContactNo = :mobileno, 
                dob = :dob, 
                Barangay = :Barangay, 
                City = :City, 
                Province = :Province, 
                Gender = :GenderId,  
                ProfileImg = :avatar";

        if ($DriversLicenseFront) {
            $sql .= ", DriversLicenseFront = :DriversLicenseFront";
        }
        if ($DriversLicenseBack) {
            $sql .= ", DriversLicenseBack = :DriversLicenseBack";
        }
        if ($GovernmentIDFront) {
            $sql .= ", GovernmentIDFront = :GovernmentIDFront";
        }
        if ($GovernmentIDBack) {
            $sql .= ", GovernmentIDBack = :GovernmentIDBack";
        }

        $sql .= " WHERE EmailId = :email";

        try {
            $query = $dbh->prepare($sql);
            $query->bindParam(':FirstName', $FirstName, PDO::PARAM_STR);
            $query->bindParam(':MiddleName', $MiddleName, PDO::PARAM_STR);
            $query->bindParam(':LastName', $LastName, PDO::PARAM_STR);
            $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
            $query->bindParam(':dob', $dob, PDO::PARAM_STR);
            $query->bindParam(':Barangay', $Barangay, PDO::PARAM_STR);
            $query->bindParam(':City', $City, PDO::PARAM_STR);
            $query->bindParam(':Province', $Province, PDO::PARAM_STR);
            $query->bindParam(':GenderId', $GenderId, PDO::PARAM_INT); 
            $query->bindParam(':avatar', $avatar, PDO::PARAM_STR);

            if ($DriversLicenseFront) {
                $query->bindParam(':DriversLicenseFront', $DriversLicenseFront, PDO::PARAM_STR);
            }
            if ($DriversLicenseBack) {
                $query->bindParam(':DriversLicenseBack', $DriversLicenseBack, PDO::PARAM_STR);
            }
            if ($GovernmentIDFront) {
                $query->bindParam(':GovernmentIDFront', $GovernmentIDFront, PDO::PARAM_STR);
            }
            if ($GovernmentIDBack) {
                $query->bindParam(':GovernmentIDBack', $GovernmentIDBack, PDO::PARAM_STR);
            }

            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->execute();
            $msg = "Profile Updated Successfully";
        } catch (PDOException $e) {
            $msg = "Error updating profile: " . $e->getMessage();
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
<title>FritzAnn Shuttle Services  | My Profile</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/profile.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">



<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 
</head>
<body>
   
<?php include('includes/header.php');?>

<section class="page-header profile_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Your Profile</h1>
      </div>
      <ul class="coustom-breadcrumb">
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
        ?>
<section class="user_profile inner_pages" style="background-image: url('background.jpg'); background-size: cover; background-position: center;"> 
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


<img src="<?php echo isset($avatar) && !empty($avatar) ? $avatar : 'design/download.jpg'; ?>" alt="Avatar" style="width: 250px; height: 200px; border-radius: 50%; border: 2px solid #000;">
      <div class="dealer_info">
      <h5><?php echo htmlentities($result->FirstName); ?> <?php echo htmlentities($result->MiddleName); ?> <?php echo htmlentities($result->LastName); ?></h5>
      <div class="cyberpunk-container">
<p class="glitch"><div style="display: flex;">
    <span><?php echo htmlentities($result->Barangay); ?>/<?php echo htmlentities($result->City); ?>/<?php echo htmlentities($result->Province); ?></span>
</div>
</p>
</div></div>
    </div>
    <div class="row">
  <div class="col-md-3 col-sm-3">
    <?php include('includes/sidebar.php');?>
  <div class="col-md-6 col-sm-8">
    <div class="profile_wrap">
      <h5 class="uppercase underline">Profile Settings</h5>
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
       
        <div class="cyberpunk-status">
  <h4>Status: <?php echo isset($statusMessage) && !empty($statusMessage) ? $statusMessage : 'Not Verified'; ?></h4>
</div>

        <?php } ?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#avatarModal" style="background-color: red; border-color: red;">
    Select Avatar
</button>

<div class="modal fade" id="avatarModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
<h4 class="modal-title" align="center"><font size="20"><b><u>Select Avatar</u></b></font></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                
<div class="avatar-container">
    <input type="radio" name="avatar" value="avatar2.jfif" id="avatar2">
    <label for="avatar2">
        <img src="admin/avatar/avatar2.jfif" alt="Avatar 2" style="width: 100px; height: 100px; border-radius: 50%; border: 5px solid #3498db; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
    </label>
</div>

<div class="avatar-container">
    <input type="radio" name="avatar" value="avatar3.jfif" id="avatar3">
    <label for="avatar3">
        <img src="admin/avatar/avatar3.jfif" alt="Avatar 3" style="width: 100px; height: 100px; border-radius: 50%; border: 5px solid #3498db; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
    </label>
</div>

<div class="avatar-container">
    <input type="radio" name="avatar" value="avatar4.jfif" id="avatar4">
    <label for="avatar4">
        <img src="admin/avatar/avatar4.jfif" alt="Avatar 4" style="width: 100px; height: 100px; border-radius: 50%; border: 5px solid #3498db; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
    </label>
</div>

<div class="avatar-container">
    <input type="radio" name="avatar" value="avatar5.jfif" id="avatar5">
    <label for="avatar5">
        <img src="admin/avatar/avatar5.jfif" alt="Avatar 5" style="width: 100px; height: 100px; border-radius: 50%; border: 5px solid #3498db; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
    </label>
</div>

<div class="avatar-container">
    <input type="radio" name="avatar" value="avatar6.jfif" id="avatar6">
    <label for="avatar6">
        <img src="admin/avatar/avatar6.jfif" alt="Avatar 6" style="width: 100px; height: 100px; border-radius: 50%; border: 5px solid #3498db; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
    </label>
</div>
<div class="avatar-container">
    <input type="radio" name="avatar" value="avatar7.jfif" id="avatar7">
    <label for="avatar7">
        <img src="admin/avatar/avatar7.jfif" alt="Avatar 7" style="width: 100px; height: 100px; border-radius: 50%; border: 5px solid #3498db; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
    </label>
</div>

<div class="avatar-container">
    <input type="radio" name="avatar" value="avatar8.jfif" id="avatar8">
    <label for="avatar8">
        <img src="admin/avatar/avatar8.jfif" alt="Avatar 8" style="width: 100px; height: 100px; border-radius: 50%; border: 5px solid #3498db; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
    </label>
</div>

<div class="avatar-container">
    <input type="radio" name="avatar" value="avatar9.jfif" id="avatar9">
    <label for="avatar9">
        <img src="admin/avatar/avatar9.jfif" alt="Avatar9" style="width: 100px; height: 100px; border-radius: 50%; border: 5px solid #3498db; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
    </label>
</div>

                </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal" style="background-color: red; border-color: red;">
    Save
</button>
            </div>

        </div>
    </div>
</div>
</div>
<div class="row" style="display: flex; gap: 10px;">
  <div class="form-group" style="flex: 1;">
    <label class="control-label" for="FirstName">First Name</label>
    <input class="form-control white_bg" name="FirstName" value="<?php echo htmlentities($result->FirstName); ?>" id="FirstName" type="text" required maxlength="20" minlength="2" style="width: 100%;">
  </div>

  <div class="form-group" style="flex: 1;">
    <label class="control-label" for="MiddleName">Middle Name</label>
    <input class="form-control white_bg" name="MiddleName" value="<?php echo htmlentities($result->MiddleName); ?>" id="MiddleName" type="text" required maxlength="20" minlength="1" style="width: 100%;">
  </div>

  <div class="form-group" style="flex: 1;">
    <label class="control-label" for="LastName">Last Name</label>
    <input class="form-control white_bg" name="LastName" value="<?php echo htmlentities($result->LastName); ?>" id="LastName" type="text" required maxlength="20" minlength="2" style="width: 100%;">
  </div>
</div>




          <div class="form-group">
          <label class="control-label">Gender</label>
            <select class="form-control" name="Gender">
            <?php
    $gender_query = "SELECT * FROM friztann_gender";
    $gender_stmt = $dbh->prepare($gender_query);
    $gender_stmt->execute();
    $genders = $gender_stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($genders as $gender) {
        echo "<option value='" . $gender['GenderId'] . "'>" . $gender['Gender'] . "</option>";
    }
    ?>
            </select>
          </div>
          <div class="form-group">
            <label class="control-label">Email Address</label>
            <input class="form-control white_bg" value="<?php echo htmlentities($result->EmailId);?>" name="emailid" id="email" type="email" required readonly>
          </div>
          <div class="form-group">
          <span style="position: absolute; left: 12px; top: 69%; transform: translateY(-50%); color: red; font-weight: 500; ">
                +63
            </span>
    <label class="control-label" for="phone-number">Phone Number</label>
    <input
        type="tel"
        id="phone-number"
        name="mobilenumber"
        placeholder="9xxxxxxxxx"
        style="width: 100%; padding: 12px 16px 12px 48px; border: 2px solid #E5E7EB; border-radius: 8px; font-size: 16px; box-sizing: border-box;  transition: all 0.3s ease;"
        pattern="[0-9]{10}"
        maxlength="10"
        required
        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
        onkeyup="this.style.borderColor = this.validity.valid ? '#E5E7EB' : '#DC2626';"
        class="form-control white_bg"
        value="<?php echo htmlentities($result->ContactNo); ?>"
    >
</div>

          <div class="form-group">
    <label class="control-label">Date of Birth&nbsp;(dd/mm/yyyy)</label>
    <input class="form-control white_bg" value="<?php echo htmlentities($result->dob);?>" name="dob" id="birth-date" type="date">
</div>

          <div class="form-group" style="display: flex; gap: 10px;">
  <div style="flex: 1;">
    <label class="control-label">Barangay</label>
    <input class="form-control white_bg" id="Barangay" name="Barangay" value="<?php echo htmlentities($result->Barangay);?>" type="text" required maxlength="15" minlength="3">
  </div>
  <div style="flex: 1;">
    <label class="control-label">City</label>
    <input class="form-control white_bg" id="City" name="City" value="<?php echo htmlentities($result->City);?>" type="text" required maxlength="15" minlength="3">
  </div>
  <div style="flex: 1;">
    <label class="control-label">Province</label>
    <input class="form-control white_bg" id="Province" name="Province" value="<?php echo htmlentities($result->Province);?>" type="text" required maxlength="15" minlength="3">
  </div>
</div>
 


    <div style="display: flex; gap: 15px;">
    <div style="flex: 1;">
        <label class="control-label">Driver's License (Front)</label>
        <input class="form-control white_bg" id="DriversLicenseFront" name="DriversLicenseFront" type="file" onchange="displayImage('DriversLicenseFrontDisplay', this)"required>
        <div id="DriversLicenseFrontDisplay"></div>
    </div>

    <div style="flex: 1;">
        <label class="control-label">Driver's License (Back)</label>
        <input class="form-control white_bg" id="DriversLicenseBack" name="DriversLicenseBack" type="file" onchange="displayImage('DriversLicenseBackDisplay', this)"required>
        <div id="DriversLicenseBackDisplay"></div>
    </div>
</div>

<div style="display: flex; gap: 15px; margin-top: 15px;">
    <div style="flex: 1;">
        <label class="control-label">Government ID (Front)</label>
        <input class="form-control white_bg" id="GovernmentIDFront" name="GovernmentIDFront" type="file" onchange="displayImage('GovernmentIDFrontDisplay', this)"required>
        <div id="GovernmentIDFrontDisplay"></div>
    </div>

    <div style="flex: 1;">
        <label class="control-label">Government ID (Back)</label>
        <input class="form-control white_bg" id="GovernmentIDBack" name="GovernmentIDBack" type="file" onchange="displayImage('GovernmentIDBackDisplay', this)"required>
        <div id="GovernmentIDBackDisplay"></div>
    </div>
</div>

        <?php } ?>
       
        <div class="form-group">
  <button type="submit" name="updateprofile" class="buttonsave" style="margin-top: 30px;">
    <div class="svg-wrapper-1">
      <div class="svg-wrapper">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          width="30"
          height="30"
          class="icon"
        >
          <path
            d="M22,15.04C22,17.23 20.24,19 18.07,19H5.93C3.76,19 2,17.23 2,15.04C2,13.07 3.43,11.44 5.31,11.14C5.28,11 5.27,10.86 5.27,10.71C5.27,9.33 6.38,8.2 7.76,8.2C8.37,8.2 8.94,8.43 9.37,8.8C10.14,7.05 11.13,5.44 13.91,5.44C17.28,5.44 18.87,8.06 18.87,10.83C18.87,10.94 18.87,11.06 18.86,11.17C20.65,11.54 22,13.13 22,15.04Z"
          ></path>
        </svg>
      </div>
    </div>
    <span>Save Changes</span>
  </button>



        </div>
      </form>
    </div>
  </div>
</div>
</section>
<script>
function displayImage(displayId, input, width = '100%', height = '50%') {
    const displayDiv = document.getElementById(displayId);
    displayDiv.innerHTML = '';  
    
    for (const file of input.files) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.maxWidth = width;
        img.style.maxHeight = height;
        img.style.marginTop = '10px';
        
        displayDiv.appendChild(img);
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
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
