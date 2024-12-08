<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {    
    header('location:index.php');
    exit;
}

if (isset($_POST['signup'])) {
    $UserName = $_POST['UserName'];
    $Password = md5($_POST['Password']); // Hash the password using MD5

    try {
        $sql = "INSERT INTO admin (UserName, Password) VALUES (:UserName, :Password)";
        $query = $dbh->prepare($sql);

        $query->bindParam(':UserName', $UserName, PDO::PARAM_STR);
        $query->bindParam(':Password', $Password, PDO::PARAM_STR);

        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            echo "<script>alert('Registration successful'); window.location.href = 'dashboard.php';</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }

    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="theme-color" content="#3e454c">

<title>FritzAnn Shuttle Services  | Admin Create Account</title>
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
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<style>
  body {
    background-color: #f8f9fa;
    
}

.driver-form-container {
    padding: 30px;
    border-radius: 8px;
    margin-top: 110px; 
    margin-left: 400px;
    width: 1000px; 
    height: px; /* Added height */
}


.driver-form-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 40px rgba(0, 0, 0, 0.2);
}

.driver-form-container h1 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

.driver-form-container p {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

.driver-form-container input[type="text"],
.driver-form-container input[type="email"],
.driver-form-container input[type="password"],
.driver-form-container select {
    width: 200%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.driver-form-container input[type="text"]:focus,
.driver-form-container input[type="email"]:focus,
.driver-form-container input[type="password"]:focus,
.driver-form-container select:focus {
    border-color: #007BFF;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
}

.driver-form-container button {
    width: 100%;
    padding: 10px;
    background-color: black;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.driver-form-container button:hover {
    background-color: #0056b3;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}


.form-header {
    text-align: center;
    margin-bottom: 20px;
}

.form-control {
    margin-bottom: 10px;
    
}

.form-group {
    display: flex;
    align-items: center;
    justify-content: space-between;
    
}

.form-group label {
    flex-basis: 20%;
    margin-right: 10px;
    
}

.form-group input,
.form-group select {
    flex-basis: 75%;
    
}

.form-inline-group {
    display: flex;
    justify-content: space-between;
    
}

.form-inline-group .form-group {
    flex: 1;
}

.form-inline-group .form-group:not(:last-child) {
    margin-right: 100px;
    
}

.btn-submit {
    display: flex;
    justify-content: center;
}

.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}

.succWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.btn-31,
.btn-31 *,
.btn-31 :after,
.btn-31 :before,
.btn-31:after,
.btn-31:before {
  border: 0 solid;
  box-sizing: border-box;
}

.btn-31 {
  -webkit-tap-highlight-color: transparent;
  -webkit-appearance: button;
  background-color: #000;
  background-image: none;
  color: #fff;
  cursor: pointer;
  font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
    Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif,
    Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
  font-size: 100%;
  font-weight: 900;
  line-height: 1.5;
  margin: 0;
  -webkit-mask-image: -webkit-radial-gradient(#000, #fff);
  padding: 0;
}

.btn-31:disabled {
  cursor: default;
}

.btn-31:-moz-focusring {
  outline: auto;
}

.btn-31 svg {
  display: block;
  vertical-align: middle;
}

.btn-31 [hidden] {
  display: none;
}

.btn-31 {
  border-width: 1px;
  padding: 1rem 2rem;
  position: relative;
  text-transform: uppercase;
}

.btn-31:before {
  --progress: 100%;
  background: #fff;
  -webkit-clip-path: polygon(
    100% 0,
    var(--progress) var(--progress),
    0 100%,
    100% 100%
  );
  clip-path: polygon(
    100% 0,
    var(--progress) var(--progress),
    0 100%,
    100% 100%
  );
  content: "";
  inset: 0;
  position: absolute;
  transition: -webkit-clip-path 0.2s ease;
  transition: clip-path 0.2s ease;
  transition: clip-path 0.2s ease, -webkit-clip-path 0.2s ease;
}

.btn-31:hover:before {
  --progress: 0%;
}

.btn-31 .text-container {
  display: block;
  overflow: hidden;
  position: relative;
}

.btn-31 .text {
  display: block;
  font-weight: 900;
  mix-blend-mode: difference;
  position: relative;
}

.btn-31:hover .text {
  -webkit-animation: move-up-alternate 0.3s ease forwards;
  animation: move-up-alternate 0.3s ease forwards;
}

@-webkit-keyframes move-up-alternate {
  0% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(80%);
  }

  51% {
    transform: translateY(-80%);
  }

  to {
    transform: translateY(0);
  }
}

@keyframes move-up-alternate {
  0% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(80%);
  }

  51% {
    transform: translateY(-80%);
  }

  to {
    transform: translateY(0);
  }
}
.input-container {
  position: relative;
}

.input {
  padding: 10px;
  height: 40px;
  border: 2px solid #0B2447;
  border-top: none;
  border-bottom: none;
  font-size: 16px;
  background: transparent;
  outline: none;
  box-shadow: 7px 7px 0px 0px #535353;
  transition: all 0.5s;
}

.input:focus {
  box-shadow: none;
  transition: all 0.5s;
}

.label {
  position: absolute;
  top: 10px;
  left: 10px;
  color: #0B2447;
  transition: all 0.5s;
  transform: scale(0);
  z-index: -1;
}

.input-container .topline {
  position: absolute;
  content: "";
  background-color: #0B2447;
  width: 0%;
  height: 2px;
  right: 0;
  top: 0;
  transition: all 0.5s;
}

.input-container input[type="text"]:focus ~ .topline {
  width: 35%;
  transition: all 0.5s;
}

.input-container .underline {
  position: absolute;
  content: "";
  background-color: #0B2447;
  width: 0%;
  height: 2px;
  right: 0;
  bottom: 0;
  transition: all 0.5s;
}

.input-container input[type="text"]:focus ~ .underline {
  width: 100%;
  transition: all 0.5s;
}

.input-container input[type="text"]:focus ~ .label {
  top: -10px;
  transform: scale(1);
  transition: all 0.5s;
}
.page-title {
  color: #333;
  font-size: 36px; 
  font-weight: 700; 
  margin-bottom: 30px;
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 2px;
  position: relative;
}

.page-title:after {
  content: "";
  display: block;
  width: 80px; 
  height: 4px;
  background-color: #e60000;
  margin: 10px auto 0;
}
</style>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="container-fluid">
            
        <div class="row justify-content-center">
            
            <div class="col-md-8">

                <div class="driver-form-container">
                    
                    <div class="form-header">
            <h2 class="page-title">CREATE ACCOUNT</h2>
                    </div>
                    <form method="post" action="">
        <div class="form-inline-group">
            
            <div class="form-group">
    <div class="input-container">
        <input 
            type="text" 
            class="input" 
            id="UserName" 
            name="UserName" 
            required 
            minlength="10" 
            maxlength="15" 
            title="Username must be between 10 and 15 characters."
        >
        <label for="UserName" class="label">User Account:</label>
        <div class="topline"></div>
        <div class="underline"></div>
    </div>
</div>


<div class="form-group">
    <div class="input-container">
        <input 
            type="text" 
            class="input" 
            id="Password" 
            name="Password" 
            required 
            minlength="8" 
            maxlength="20" 
            pattern=".*\d.*" 
            title="Password must be between 8 and 20 characters and include numbers."
        >
        <label for="password" class="label">Password:</label>
        <div class="topline"></div>
        <div class="underline"></div>
        <span id="toggle-icon" onclick="togglePasswordVisibility()" style="position: absolute; left: 370px; top: 50%; transform: translateY(-50%); cursor: pointer;">👁️</span>
    </div>
</div>

</div>




<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('Password');
        const toggleIcon = document.getElementById('toggle-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.textContent = '👁️‍🗨'; // Change to "hide" icon
        } else {
            passwordInput.type = 'password';
            toggleIcon.textContent = '👁️'; // Change to "view" icon
        }
    }
</script>

      

        <div class="btn-submit">
            <button type="submit" class="btn btn-primary btn-31" name="signup">
                <span class="text-container">
                    <span class="text">Create Account</span>
                </span>
            </button>
        </div>
    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>   
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

                                    