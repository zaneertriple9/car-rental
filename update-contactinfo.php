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
$address=$_POST['address'];
$email=$_POST['email'];	
$contactno=$_POST['contactno'];
$sql="update friztann_contactinfo set Address=:address,EmailId=:email,ContactNo=:contactno";
$query = $dbh->prepare($sql);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':contactno',$contactno,PDO::PARAM_STR);
$query->execute();
$msg="Info Updateed successfully";
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
	
	<title>FritzAnn Shuttle Services | Admin Contact Info</title>
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
  <style>
	
body {
  background: #f4f7f9; 
  font-family: 'Roboto', sans-serif; 
  line-height: 1.6;
  margin: 0;
  padding: 0;
  overflow-x: hidden; 
}

.content-wrapper {
  padding: 30px 15px;
  max-width: 1200px;
  margin: auto;
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

.card {
  background-color: #fff;
  border: none;
  border-radius: 12px; 
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); 
  margin-bottom: 30px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-10px) scale(1.02); 
  box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15); 
}

.card-header {
  background-color: #333; 
  border-radius: 12px 12px 0 0; 
  color: #fff;
  font-size: 24px; 
  font-weight: 600;
  padding: 20px;
  text-align: center;
  position: relative;
}

.card-header::after {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 90%;
  height: 2px;
  background-color: rgba(255, 255, 255, 0.3); 
}

.card-body {
  padding: 30px;
}

.form-group {
  margin-bottom: 30px; 
  position: relative;
}

.form-group .tooltip {
  display: inline-block;
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  background-color: #e60000;
  color: #fff;
  padding: 8px 12px; 
  border-radius: 4px;
  font-size: 14px;
  visibility: hidden;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.form-group:hover .tooltip {
  visibility: visible;
  opacity: 1;
}

.control-label {
  color: #555; 
  display: block;
  font-weight: 600;
  margin-bottom: 12px; 
  text-transform: uppercase;
  letter-spacing: 1px;
}

.form-control {
  border: 1px solid #ccc; 
  border-radius: 8px;
  font-size: 16px;
  padding: 12px 16px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-control:focus {
  border-color: #e60000;
  box-shadow: 0 0 8px rgba(230, 0, 0, 0.5);
}

textarea.form-control {
  resize: vertical;
}

.btn-primary {
  background-color: #e60000;
  border: none;
  border-radius: 8px;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  font-size: 18px; 
  font-weight: 600; 
  padding: 14px 24px; 
  text-align: center;
  text-decoration: none;
  transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
}

.btn-primary:hover {
  background-color: #b30000;
  transform: translateY(-3px) scale(1.05); 
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); 
}


.navbar {
  background-color: #000;
  padding: 20px; 
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.navbar a {
  color: #fff;
  text-decoration: none;
  font-size: 18px; 
  font-weight: 600; 
  margin-left: 24px; 
  transition: color 0.3s ease;
}

.navbar a:hover {
  color: #e60000; 
}

.footer {
  background-color: #333;
  color: #fff;
  text-align: center;
  padding: 40px 0; 
  margin-top: 30px;
}

.footer p {
  margin: 0;
}

@media (max-width: 1200px) {
  .content-wrapper {
    padding: 20px;
  }
}

@media (max-width: 768px) {
  .page-title {
    font-size: 32px; 
  }
  .card {
    margin-bottom: 24px;
  }
  .card-header {
    font-size: 20px; 
  }
  .form-group {
    margin-bottom: 24px; 
  }
  .control-label {
    font-size: 14px; 
    letter-spacing: 0.5px; 
  }
  .form-control {
    padding: 10px 14px;
    font-size: 14px; 
  }
  .btn-primary {
    font-size: 16px; 
    padding: 12px 20px; 
  }
  .navbar {
    padding: 16px; 
  }
  .navbar a {
    font-size: 16px; 
    margin-left: 16px; 
  }
}

@media (max-width: 576px) {
  .page-title {
    font-size: 28px; 
  }
  .card {
    margin-bottom: 20px; 
  }
  .card-header {
    font-size: 18px; 
  }
  .form-group {
    margin-bottom: 20px; 
  }
  .control-label {
    font-size: 12px;
  }
  .form-control {
    padding: 8px 12px; 
    font-size: 12px; 
  }
  .btn-primary {
    font-size: 14px;
    padding: 10px 16px; 
  }
  .navbar {
    padding: 12px; 
  }
  .navbar a {
    font-size: 14px; 
    margin-left: 12px; 
  }
}


.fade-in {
  opacity: 0;
  animation: fadeIn 0.8s ease forwards;
}

@keyframes fadeIn {
  to {
    opacity: 1;
  }
}


.parallax-section {
  background-image: url('your-image-url.jpg');
  background-size: cover;
  background-position: center;
  height: 400px;
  position: relative;
}

.parallax-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  color: #fff;
}

.parallax-content h2 {
  font-size: 48px;
  font-weight: 700;
  text-transform: uppercase;
}

.parallax-content p {
  font-size: 18px;
  font-weight: 500;
  margin-top: 20px;
}

@media (max-width: 768px) {
  .parallax-content h2 {
    font-size: 36px;
  }
  .parallax-content p {
    font-size: 16px;
  }
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
					
						<h2 class="page-title">Update Contact Info</h2>

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
				<?php $sql = "SELECT * from  friztann_contactinfo ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	

				<div class="form-group">
												<label class="col-sm-4 control-label"> Address</label>
												<div class="col-sm-8">
								<input 
    type="adress" 
    class="form-control"
    id="address" 
    name="address" 
    required 
    minlength="10" 
    maxlength="50" 
    title="Address must be between 10 and 50 characters"
    value="<?php echo htmlspecialchars($result->Address, ENT_QUOTES, 'UTF-8'); ?>"
>
													
												</div>
											</div>
											<div class="form-group">
											<label class="col-sm-4 control-label"> Email </label>
												<div class="col-sm-8">
												    								<input 
    type="email" 
    class="form-control"
    id="email" 
    name="email" 
    required 
    minlength="10" 
    maxlength="50" 
    title="Email must be between 10 and 25 characters"
    value="<?php echo htmlspecialchars($result->EmailId, ENT_QUOTES, 'UTF-8'); ?>"
>
												</div>
											</div>
											<div class="form-group">
											<label class="col-sm-4 control-label"> Contact Number </label>
												<div class="col-sm-8">
												    												    								<input 
    <input 
        type="tel" 
        class="form-control" 
        id="contactno" 
        name="contactno" 
        pattern="9[0-9]{9}" 
        required 
        minlength="10" 
        maxlength="10" 
        title="Contact number must start with 9 and be 10 digits long"
        value="<?php echo htmlspecialchars(substr($result->ContactNo, -10), ENT_QUOTES, 'UTF-8'); ?>"
        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
        placeholder="9XXXXXXXXX"
    >
</div>
												</div>
											</div>
<?php }} ?>
											<div class="hr-dashed"></div>
											
										
								
											
											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-4">
								
													<button class="btn btn-primary" name="submit" type="submit">Update</button>
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