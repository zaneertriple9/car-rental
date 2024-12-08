<?php
session_start();
include('includes/config.php');

if(isset($_POST['login'])) {
    $email = $_POST['username'];
    $password = md5($_POST['password']); 

    $sql = "SELECT UserName, Password FROM admin WHERE UserName=:email and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0) {
        $_SESSION['alogin'] = $_POST['username'];
        echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}

if(isset($_POST['forgotPassword'])) {
    $username = $_POST['username'];
    $pin = $_POST['pin'];
    $newPassword = md5($_POST['newPassword']); 

    // Predefined PIN
    $validPin = "FRITZANN2024";

    if($pin === $validPin) {
        $sql = "UPDATE admin SET Password=:newPassword WHERE UserName=:username";
        $query = $dbh->prepare($sql);
        $query->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();

        if($query->rowCount() > 0) {
            echo "<script>alert('Password successfully updated.');</script>";
        } else {
            echo "<script>alert('Invalid username or update failed.');</script>";
        }
    } else {
        echo "<script>alert('Invalid PIN.');</script>";
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

	<title>FritzAnn Shuttle Services  | Admin Login</title>
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
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>
<style>
	/* Modal Base Styles */
.modal {
    backdrop-filter: blur(8px);
    transition: opacity 0.3s ease-in-out;
}

.modal-dialog {
    transform: scale(0.95);
    transition: transform 0.3s ease-in-out;
}

.modal.show .modal-dialog {
    transform: scale(1);
}

.modal-content {
    background: #1a1a1a;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    padding: 24px;
}

.modal-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding-bottom: 20px;
    margin-bottom: 24px;
}

.modal-title {
    color: #ffffff;
    font-size: 24px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.close {
    color: #ffffff;
    opacity: 0.7;
    transition: opacity 0.2s ease;
}

.close:hover {
    opacity: 1;
}

/* Form Elements */
.form-group {
    margin-bottom: 24px;
    position: relative;
}

.text-uppercase {
    color: #9ca3af;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 1px;
    margin-bottom: 8px;
    display: block;
}

.form-control {
    background: #2a2a2a;
    border: 2px solid transparent;
    border-radius: 12px;
    color: #ffffff;
    font-size: 15px;
    height: 50px;
    padding: 0 16px;
    transition: all 0.3s ease;
}

.form-control:focus {
    background: #2a2a2a;
    border-color: #ff3333;
    box-shadow: none;
    outline: none;
}

.form-control::placeholder {
    color: #6b7280;
}

/* Submit Button */
.btn-primary {
    background: #ff3333;
    border: none;
    border-radius: 12px;
    color: #ffffff;
    font-size: 16px;
    font-weight: 600;
    height: 50px;
    letter-spacing: 0.5px;
    margin-top: 8px;
    position: relative;
    transition: transform 0.2s ease, background 0.2s ease;
}

.btn-primary:hover {
    background: #ff4444;
    transform: translateY(-2px);
}

.btn-primary:active {
    transform: translateY(0);
}

/* Input Animation */
.form-control {
    transform-origin: left;
    animation: slideIn 0.4s ease forwards;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Sequential Form Animation */
.form-group:nth-child(1) .form-control {
    animation-delay: 0.1s;
}

.form-group:nth-child(2) .form-control {
    animation-delay: 0.2s;
}

.form-group:nth-child(3) .form-control {
    animation-delay: 0.3s;
}
       .meow-meow3 {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 70%;
            transform: translateY(-50%);
        }
        .form-group {
            position: relative;
        }
</style>
<body>

<div class="login-page bk-img" style="background-image: url(img/adminlogin.jpg);">
    <div class="form-content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
				<h1 style="text-align: center; font-weight: bold; color: white; margin-top: 4rem; text-transform: uppercase;">Sign in</h1>
				<div class="well row pt-2x pb-3x bk-light">
                        <div class="col-md-8 col-md-offset-2">
                            <form method="post">
							<label for="" class="text-uppercase text-sm" style="color: #000000;"> Your UserName</label>
							<input type="text" placeholder="Username" name="username" class="form-control mb">

  <label for="password" class="text-uppercase text-sm" style="color: #000000;">Password</label>
<div style="position: relative; width: 100%;">
    <input 
        type="password" 
        placeholder="Password" 
        name="password" 
        class="form-control mb" 
        id="password" 
        style="padding-right: 40px; width: 100%; box-sizing: border-box;"
    >
    <span 
        onclick="togglePasswordVisibility()" 
        style="
            position: absolute; 
            right: 10px; 
            top: 50%; 
            transform: translateY(-50%);
            cursor: pointer; 
            color: #555;
        ">
        <i id="password-icon" class="fas fa-eye-slash"></i>
    </span>
</div>
                                <button class="btn btn-primary btn-block" name="login" type="submit">LOGIN</button>
                            </form>
                            <p class="text-center mt-3">
							<a href="#" data-toggle="modal" data-target="#forgotPasswordModal" style="display: inline-block;font-family: 'Arial', sans-serif;font-size: 14px;color: red;text-decoration: none;background-color: white;border: 1px solid red;padding: 5px 10px;border-radius: 4px;transition: all 0.3s ease;"onmouseover="this.style.backgroundColor='red'; this.style.color='white';"onmouseout="this.style.backgroundColor='white'; this.style.color='red';">Forgot Password?</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div id="forgotPasswordModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
<div class="form-group">
    <label for="resetUsername" class="text-uppercase text-sm">Your Username</label>
    <input type="text" placeholder="Username" name="username" class="form-control mb" id="resetUsername" minlength="5" maxlength="20" required>
</div>
                    <div class="form-group">
<label for="resetPin" class="text-uppercase text-sm">Enter PIN</label>
<input type="text" placeholder="PIN" name="pin" class="form-control mb" id="resetPin" required min="20" max="25">
                    </div>
        <div class="form-group">
            <label for="newPassword" class="text-uppercase text-sm">New Password</label>
            <input 
                type="password" 
                placeholder="New Password" 
                name="newPassword" 
                class="form-control mb" 
                id="newPassword" 
                minlength="8"
                maxlength="20"
                required
            >
            <span id="passwordToggle" class="meow-meow3">        <i class="fas fa-eye-slash" id="toggleIcon"></i>
️</span>
        </div>
                    <button class="btn btn-primary btn-block" name="forgotPassword" type="submit">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('passwordToggle').addEventListener('click', function () {
        const passwordField = document.getElementById('newPassword');
        const toggleIcon = document.getElementById('toggleIcon');

        // Toggle the input type between password and text
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        }
    });
</script>
 <script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        }
    }
</script>
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