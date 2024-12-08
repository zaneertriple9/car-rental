<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_POST['submit']))
	{
$password=md5($_POST['password']);
$newpassword=md5($_POST['newpassword']);
$username=$_SESSION['alogin'];
$sql ="SELECT Password FROM admin WHERE UserName=:username and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update admin set Password=:newpassword where UserName=:username";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':username', $username, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
$msg="Your Password succesfully changed";
}
else {
$error="Your current password is not valid.";	
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
	
	<title>FritzAnn Shuttle Services  | Admin Change Password</title>
	    <link rel="apple-touch-icon" sizes="144x144" href="img/favicon-icon/apple-touch-icon-144.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/favicon-icon/apple-touch-icon-114.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/favicon-icon/apple-touch-icon-72.png">
<link rel="apple-touch-icon" href="img/favicon-icon/apple-touch-icon-57.png">
<link rel="shortcut icon" href="img/favicon-icon/favicon.png">
	<link rel="stylesheet" href="css/error-succ.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
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
		    .col-md-10 {
            max-width: 100%;
        }

        .panel-default {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            background: white;
        }

        .panel-body {
            padding: 30px;
        }

        .form-horizontal .form-group {
            margin-bottom: 24px;
        }

        .col-sm-4.control-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .col-sm-8 .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #e1e1e1;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s ease;
        }

        .col-sm-8 .form-control:focus {
            outline: none;
            border-color: #dc3545;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.1);
        }

        .btn-primary {
            background: #dc3545;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-primary:hover {
            background: #c82333;
        }

		.errorWrap, .succWrap {
        background: linear-gradient(145deg, rgba(255, 240, 240, 0.95), rgba(255, 235, 235, 0.95));
        padding: 20px 24px;
        margin-bottom: 24px;
        border-radius: 16px;
        backdrop-filter: blur(10px);
        position: relative;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .errorWrap {
        color: #d63030;
        border: 1px solid rgba(214, 48, 48, 0.1);
        box-shadow: 0 4px 24px -1px rgba(214, 48, 48, 0.1),
                   0 2px 8px -1px rgba(214, 48, 48, 0.06);
    }

    .succWrap {
        background: linear-gradient(145deg, rgba(240, 255, 244, 0.95), rgba(235, 255, 240, 0.95));
        color: #0e6245;
        border: 1px solid rgba(14, 98, 69, 0.1);
        box-shadow: 0 4px 24px -1px rgba(14, 98, 69, 0.1),
                   0 2px 8px -1px rgba(14, 98, 69, 0.08);
    }

    .errorWrap::before, .succWrap::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 60%;
        border-radius: 4px;
    }

    .errorWrap::before {
        background: linear-gradient(to bottom, #ff6b6b, #d63030);
    }

    .succWrap::before {
        background: linear-gradient(to bottom, #34d399, #0e6245);
    }

    .errorWrap strong, .succWrap strong {
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .errorWrap strong {
        background: rgba(214, 48, 48, 0.1);
    }

    .succWrap strong {
        background: rgba(14, 98, 69, 0.1);
    }

    .icon {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .errorWrap .icon {
        background: rgba(214, 48, 48, 0.1);
    }

    .succWrap .icon {
        background: rgba(14, 98, 69, 0.1);
    }

    .closeAlert {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        opacity: 0.6;
        transition: opacity 0.2s ease;
        padding: 4px 8px;
        border-radius: 4px;
    }

    .closeAlert:hover {
        opacity: 1;
    }

    .errorWrap .closeAlert {
        color: #d63030;
    }

    .succWrap .closeAlert {
        color: #0e6245;
    }

    @media (max-width: 768px) {
        .errorWrap, .succWrap {
            padding: 16px 20px;
            gap: 8px;
        }
        
        strong {
            font-size: 12px;
        }
    }

        .hr-dashed {
            border: none;
            border-top: 1px dashed #e1e1e1;
            margin: 20px 0;
        }

        .col-sm-8.col-sm-offset-4 {
            text-align: right;
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
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
					<h2 class="page-title">Change Password</h2>

						<div class="row">
							<div class="col-md-10">
									<div class="panel-body">
										<form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">
										
											
										<?php if($error){ ?>
    <div class="errorWrap">
        <div class="icon">❌</div>
        <strong>ERROR</strong>
        <span><?php echo htmlentities($error); ?></span>
        <button type="button" class="closeAlert" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
<?php } else if($msg){ ?>
    <div class="succWrap">
        <div class="icon">✓</div>
        <strong>SUCCESS</strong>
        <span><?php echo htmlentities($msg); ?></span>
        <button type="button" class="closeAlert" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
<?php } ?>
											<div class="form-group">
												<label class="col-sm-4 control-label">Current Password</label>
												<div class="col-sm-8">
																									    <input 
            type="text" 
            class="form-control" 
            id="password" 
            name="password" 
            required 
            minlength="8" 
            maxlength="20" 
            pattern=".*\d.*" 
            title="Password must be between 8 and 20 characters and include numbers."
        >
<span id="toggle-icon-password" onclick="togglePasswordVisibility('password')" style="position: absolute; left: 620px; top: 50%; transform: translateY(-50%); cursor: pointer;">👁️</span>
												</div>
											</div>
											<div class="hr-dashed"></div>
											
											<div class="form-group">
												<label class="col-sm-4 control-label">New Password</label>
												<div class="col-sm-8">
												    <input 
            type="text" 
            class="form-control" 
            id="newpassword" 
            name="newpassword" 
            required 
            minlength="8" 
            maxlength="20" 
            pattern=".*\d.*" 
            title="Password must be between 8 and 20 characters and include numbers."
        >
<span id="toggle-icon-new" onclick="togglePasswordVisibility('newpassword')" style="position: absolute; left: 620px; top: 50%; transform: translateY(-50%); cursor: pointer;">👁️</span>
												</div>
											</div>
											<div class="hr-dashed"></div>

											<div class="form-group">
												<label class="col-sm-4 control-label">Confirm Password</label>
												<div class="col-sm-8">
												      <input 
            type="text" 
            class="form-control" 
            id="confirmpassword" 
            name="confirmpassword" 
            required 
            minlength="8" 
            maxlength="20" 
            pattern=".*\d.*" 
            title="Password must be between 8 and 20 characters and include numbers."
        >
<span id="toggle-icon-confirm" onclick="togglePasswordVisibility('confirmpassword')" style="position: absolute; left: 620px; top: 50%; transform: translateY(-50%); cursor: pointer;">👁️</span>
												</div>
											</div>
											<div class="hr-dashed"></div>
										
								
											
											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-4">
								
													<button class="btn btn-primary" name="submit" type="submit">Save changes</button>
												</div>
											</div>

										</form>

									</div>
								</div>
							</div>
							
						</div>
						
					

					</div>
				</div>
				
			
			</div>
		</div>
	</div>
<script>
function togglePasswordVisibility(inputType) {
    let passwordInput, toggleIcon;

    switch(inputType) {
        case 'password':
            passwordInput = document.getElementById('password');
            toggleIcon = document.getElementById('toggle-icon-password');
            break;
        case 'newpassword':
            passwordInput = document.getElementById('newpassword');
            toggleIcon = document.getElementById('toggle-icon-new');
            break;
        case 'confirmpassword':
            passwordInput = document.getElementById('confirmpassword');
            toggleIcon = document.getElementById('toggle-icon-confirm');
            break;
        default:
            return;
    }

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.textContent = '👁️‍🗨'; // Hide icon
    } else {
        passwordInput.type = 'password';
        toggleIcon.textContent = '👁️'; // View icon
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
<?php } ?>