<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{

	if(isset($_REQUEST['aeid']))
	{
$aeid=intval($_GET['aeid']);
$status=1;

$sql = "UPDATE friztann_booking SET Status=:status WHERE  booking_id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();

$msg="Booking Successfully Confirmed";
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
	
	<title>FritzAnn Shuttle Services  | Admin Dashboard</title>
	    <link rel="apple-touch-icon" sizes="144x144" href="img/favicon-icon/apple-touch-icon-144.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/favicon-icon/apple-touch-icon-114.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/favicon-icon/apple-touch-icon-72.png">
<link rel="apple-touch-icon" href="img/favicon-icon/apple-touch-icon-57.png">
<link rel="shortcut icon" href="img/favicon-icon/favicon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/dashboard.css?v=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    </head>
<body>
<?php include('includes/header.php');?>

	<div class="ts-main-content">
<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

					<h2 class="page-title" style="
    color: black;
    background-color: white;
    padding: 15px 20px;
    border-radius: 8px;
    font-family: Arial, sans-serif;
    font-size: 24px;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 2px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin: 20px 0;
">Dashboard</h2>			
		
		<body style="background-color: rgb(232 232 232);">

						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-primary text-light">
												<div class="stat-panel text-center">
<?php 
$sql ="SELECT user_id from friztann_users ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$regusers=$query->rowCount();
?>
									<div class="stat-panel-number h1 "><?php echo htmlentities($regusers);?></div>
                                    <div class="stat-panel-title text-uppercase" aria-hidden="true" style="font-size: 24px; margin: 2px;">
    <i>
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
            <g fill="none" stroke="black" stroke-width="1.5">
                <circle cx="9" cy="9" r="2"/>
                <path d="M13 15c0 1.105 0 2-4 2s-4-.895-4-2s1.79-2 4-2s4 .895 4 2Z"/>
                <path d="M2 12c0-3.771 0-5.657 1.172-6.828S6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172S22 8.229 22 12s0 5.657-1.172 6.828S17.771 20 14 20h-4c-3.771 0-5.657 0-6.828-1.172S2 15.771 2 12Z"/>
                <path stroke-linecap="round" d="M19 12h-4m4-3h-5m5 6h-3"/>
            </g>
        </svg>
    </i>
    Register Users
</div>
												</div>
											</div> 
											<a href="register-users.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-success text-light">
												<div class="stat-panel text-center">
												<?php 
$sql1 ="SELECT Vehicle_id from friztann_vehicles ";
$query1 = $dbh -> prepare($sql1);;
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
$totalvehicle=$query1->rowCount();
?>
													<div class="stat-panel-number h1 "><?php echo htmlentities($totalvehicle);?></div>
                                                    <div class="stat-panel-title text-uppercase" aria-hidden="true" style="font-size: 24px; margin: 2px;">
    <i>
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 16 16">
            <path fill="black" fill-rule="evenodd" d="M5.5 11H4.419l-.342 1.026l-.158.474H2V9.52c.496.129 1.213.23 2.25.23a.75.75 0 1 0 0-1.5c-1.073 0-1.682-.12-1.998-.217a2 2 0 0 1-.204-.075a1.8 1.8 0 0 1 .485-.87q.11-.11.214-.228C4.272 7.293 6.15 7.5 8 7.5s3.728-.207 5.253-.64q.103.119.214.228c.241.242.408.544.485.87q-.066.032-.204.075c-.316.097-.925.217-1.998.217a.75.75 0 0 0 0 1.5c1.037 0 1.754-.101 2.25-.23v2.98h-1.919l-.158-.474L11.581 11zm6.924-5.472C11.144 5.838 9.584 6 8 6s-3.144-.162-4.424-.472q.046-.112.088-.226l.448-1.257c.18-.505.57-.806.96-.863a20.8 20.8 0 0 1 5.855 0c.392.057.78.358.96.863l.45 1.257q.04.114.087.226m-1.652 7.788L10.5 12.5h-5l-.272.816a1 1 0 0 1-.949.684H1.5a1 1 0 0 1-1-1V8.375c0-.88.35-1.725.972-2.347a3.3 3.3 0 0 0 .43-.528H1.25a.75.75 0 1 1 0-1.5h1.286l.164-.46c.343-.96 1.148-1.696 2.157-1.842a22.3 22.3 0 0 1 6.286 0c1.009.146 1.814.882 2.157 1.843l.164.459h1.286a.75.75 0 0 1 0 1.5h-.651q.187.286.429.528a3.32 3.32 0 0 1 .972 2.347V13a1 1 0 0 1-1 1h-2.78a1 1 0 0 1-.948-.684" clip-rule="evenodd"/>
        </svg>
    </i>
    Total Cars
</div>
												</div>
											</div>
											<a href="manage-cars.php"class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-info text-light">
												<div class="stat-panel text-center">
                                                <?php 
                $totalBookings = 0;

                $sql1 = "SELECT booking_id FROM friztann_booking";
                $query1 = $dbh->prepare($sql1);
                $query1->execute();
                $bookings1 = $query1->rowCount();
                $totalBookings += $bookings1;

                $sql2 = "SELECT noaccbooking_ID FROM friztann_noaccbooking";
                $query2 = $dbh->prepare($sql2);
                $query2->execute();
                $bookings2 = $query2->rowCount();
                $totalBookings += $bookings2;

                $sql3 = "SELECT walk_id FROM friztann_walkin";
                $query3 = $dbh->prepare($sql3);
                $query3->execute();
                $bookings3 = $query3->rowCount();
                $totalBookings += $bookings3;
                ?>

                <!-- Display Total Bookings -->
                <div class="stat-panel-number h1"><?php echo htmlentities($totalBookings); ?></div>
                                                    <div class="stat-panel-title text-uppercase" aria-hidden="true" style="font-size: 24px; margin: 2px;">
    <i>
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 1024 1024">
            <path fill="black" d="M832 64H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V96c0-17.7-14.3-32-32-32m-260 72h96v209.9L621.5 312L572 347.4zm220 752H232V136h280v296.9c0 3.3 1 6.6 3 9.3a15.9 15.9 0 0 0 22.3 3.7l83.8-59.9l81.4 59.4c2.7 2 6 3.1 9.4 3.1c8.8 0 16-7.2 16-16V136h64v752z"/>
        </svg>
    </i>
    Total Bookings
</div>
												</div>
											</div>
											<a href="manage-bookings.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									
					<div class="col-md-12">

						
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-primary text-light">
												<div class="stat-panel text-center">
												<?php 
$sql11 ="SELECT driver_id from friztann_drivers ";
$query11 = $dbh -> prepare($sql11);
$query11->execute();
$results11=$query11->fetchAll(PDO::FETCH_OBJ);
$regdrivers=$query11->rowCount();	
?>
													<div class="stat-panel-number h1 "><?php echo htmlentities($regdrivers);?></div>
                                                    <div class="stat-panel-title text-uppercase" aria-hidden="true" style="font-size: 24px; margin: 2px;">
    <i>
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 48 48">
            <g fill="black">
                <path d="M21 11a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2h-4a1 1 0 0 1-1-1"/>
                <path fill-rule="evenodd" d="M33.364 18.52c-.363.285-.834.513-1.402.698Q32 19.604 32 20a8 8 0 1 1-15.962-.782c-.568-.185-1.039-.413-1.401-.698c-.47-.37-.785-.864-.822-1.458c-.035-.551.183-1.019.401-1.349a4.3 4.3 0 0 1 .76-.841q.212-.184.406-.327q-.058-.309-.122-.74A27 27 0 0 1 15 10c0-.314.134-.548.196-.647c.078-.125.17-.232.254-.318c.167-.175.383-.353.62-.524c.48-.348 1.14-.739 1.924-1.105C19.557 6.676 21.704 6 24 6s4.443.677 6.006 1.406a12 12 0 0 1 1.924 1.105c.237.171.453.35.62.524c.084.086.176.193.254.318c.062.099.196.333.196.647c0 1.602-.13 2.9-.26 3.805q-.064.432-.122.74c.128.095.267.204.407.327c.25.219.536.504.759.841c.219.33.436.798.402 1.35c-.037.593-.352 1.087-.822 1.457m-16.362-8.202c.015 1.348.127 2.438.238 3.2q.04.27.076.482h13.368q.037-.213.076-.482c.11-.762.223-1.852.238-3.2a4 4 0 0 0-.241-.188c-.361-.261-.909-.59-1.597-.911C27.777 8.573 25.924 8 24 8s-3.777.573-5.16 1.219c-.688.321-1.236.65-1.596.91a4 4 0 0 0-.242.19M16.788 16l-.003.002a5 5 0 0 0-.495.376c-.178.156-.32.308-.406.44a1 1 0 0 0-.055.093l.044.037c.15.118.472.291 1.1.462q.186.05.399.098l.009.002c.502.111 1.12.21 1.873.288c1.067.111 2.41.184 4.088.2L24 18c3.227 0 5.314-.201 6.62-.49l.008-.002q.214-.047.4-.098c.627-.17.95-.344 1.099-.462l.044-.037a1 1 0 0 0-.054-.093a2.4 2.4 0 0 0-.407-.44a5 5 0 0 0-.494-.376L31.212 16zm6.94 4c2.642 0 4.69-.14 6.26-.384q.012.19.012.384a6 6 0 1 1-11.992-.315c1.463.202 3.338.315 5.72.315m-7.65 18.877A8 8 0 0 0 16 40v1a1 1 0 0 1-1.864.504a3 3 0 0 1-2.203.259l-1.932-.518a3 3 0 0 1-2.12-3.674l.776-2.898a3 3 0 0 1 3.674-2.121l1.932.517c.672.18 1.23.575 1.618 1.091a9.99 9.99 0 0 1 8.12-4.16a9.99 9.99 0 0 1 8.116 4.158a3 3 0 0 1 1.616-1.088l1.932-.517a3 3 0 0 1 3.674 2.12l.777 2.899a3 3 0 0 1-2.122 3.674l-1.931.517a3 3 0 0 1-2.2-.256A1 1 0 0 1 32 41v-1a8 8 0 0 0-.078-1.123l-5.204 1.395a3 3 0 0 1-5.436 0zm5.042-.72A3 3 0 0 1 23 36.172v-4.11a8.01 8.01 0 0 0-6.397 4.886zm10.277-1.21A8.01 8.01 0 0 0 25 32.062v4.109c.904.32 1.61 1.06 1.88 1.987zm2.147-.72a1 1 0 0 1 .707-1.225l1.932-.518a1 1 0 0 1 1.224.707l.777 2.898a1 1 0 0 1-.707 1.225l-1.932.518a1 1 0 0 1-1.225-.708zm-21.73-1.743a1 1 0 0 0-1.226.707l-.776 2.897a1 1 0 0 0 .707 1.225l1.932.518a1 1 0 0 0 1.225-.707l.776-2.898A1 1 0 0 0 13.745 35zM25 39a1 1 0 1 1-2 0a1 1 0 0 1 2 0" clip-rule="evenodd"/>
            </g>
        </svg>
    </i>
    Driver
</div>

                                                    </div>
                                                    </div>
											<a href="register-driver.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>

									<div class="col-md-3">
						    				<div class="panel panel-default">
											<div class="panel-body bk-warning text-light">
												<div class="stat-panel text-center">




												<?php 
$sql6 ="SELECT contactuquery_id from friztann_contactus ";
$query6 = $dbh -> prepare($sql6);;
$query6->execute();
$results6=$query6->fetchAll(PDO::FETCH_OBJ);
$query=$query6->rowCount();
?>
													<div class="stat-panel-number h1 "><?php echo htmlentities($query);?></div>
                                                    <div class="stat-panel-title text-uppercase" aria-hidden="true" style="font-size: 24px; margin: 2px;">
    <i>
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
            <path fill="black" d="M2 3h22v11h-2V5H2v14h12v2H0V3zm8 4H6v4h4zm-6 6h8v4H4zm16-6h-6v2h6zm-6 4h6v2h-6zm3 4h-3v2h3zm4 6v3h-2v-3h-3v-2h3v-3h2v3h3v2z"/>
        </svg>
    </i>
    Contact Us
</div>

												</div>
											</div>
											<a href="manage-contactus.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-success text-light">
												<div class="stat-panel text-center">




<?php 
$sql5 ="SELECT testimonial_id from friztann_feedback ";
$query5= $dbh -> prepare($sql5);
$query5->execute();
$results5=$query5->fetchAll(PDO::FETCH_OBJ);
$testimonials=$query5->rowCount();
?>

													<div class="stat-panel-number h1 "><?php echo htmlentities($testimonials);?></div>
                                                    <div class="stat-panel-title text-uppercase" aria-hidden="true" style="font-size: 24px; margin: 2px;">
    <i>
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 16 16">
            <g fill="black">
                <path d="m4.5 1l-.5.5v1.527a4.6 4.6 0 0 1 1 0V2h9v5h-1.707L11 8.293V7H8.973a4.6 4.6 0 0 1 0 1H10v1.5l.854.354L12.707 8H14.5l.5-.5v-6l-.5-.5z"/>
                <path fill-rule="evenodd" d="M6.417 10.429a3.5 3.5 0 1 0-3.834 0A4.5 4.5 0 0 0 0 14.5v.5h1v-.5a3.502 3.502 0 0 1 7 0v.5h1v-.5a4.5 4.5 0 0 0-2.583-4.071M4.5 10a2.5 2.5 0 1 1 0-5a2.5 2.5 0 0 1 0 5" clip-rule="evenodd"/>
            </g>
        </svg>
    </i>
    Feedback
</div>

												</div>
											</div>
											<a href="manage-feedback.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
								
								</div>
							</div>
						</div>
					</div>
				</div>	
				</div>
		</div>
	</div>
</div>
</body>
<div class="custom69-panel">
    <?php if ($error) { ?>
        <div class="custom69-error-wrap"><strong>Error:</strong> <?php echo htmlentities($error); ?> </div>
    <?php } else if ($msg) { ?>
        <div class="custom69-success-wrap"><strong>Success:</strong> <?php echo htmlentities($msg); ?> </div>
    <?php } ?>
    <div class="custom69-table-wrapper">
        <table id="zctb" class="custom69-table">
            <thead>
            <tr>
          <th>User</th>
          <th>Gender</th>
          <th>Email </th>
          <th>Contact</th>
          <th>Status</th>
          <th>Register Date</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>User</th>
          <th>Gender</th>
          <th>Email </th>
          <th>Contact</th>
          <th>Status</th>
          <th>Register Date</th>
        </tr>
            </tfoot>
            <tbody>
            <?php
$sql = "SELECT * FROM friztann_users";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if($query->rowCount() > 0) {
    foreach($results as $result) {
        $profileImgPath = 'avatar/' . basename($result->ProfileImg);
?>
        <tr>
		  <td class="no-wrap">
    <?php
    if (!empty($result->ProfileImg) && file_exists($profileImgPath)) {
        echo '<div style="display: flex; align-items: center;">';
        echo '<a href="' . htmlentities($profileImgPath) . '" data-lightbox="image-' . htmlentities($bookingId) . '">';
        echo '<img src="' . htmlentities($profileImgPath) . '" alt="Car Image" style="border-radius: 50%; width: 50px; height: 50px; margin-right: 10px; border: 2px solid #ccc; padding: 3px; background-color: #fff;">';
        echo '</a>';
    } else {
        echo '<div class="custom69-profile-img-default" style="width: 50px; height: 50px; border-radius: 50%; background-color: #ccc; margin-right: 10px;"></div>';
    }
    echo '<div>';
    echo htmlentities(trim($result->FirstName)) . ' ' . 
         htmlentities(trim($result->MiddleName)) . ' ' . 
         htmlentities(trim($result->LastName));
    echo '</div>';
    ?>
</td>
<td class="no-wrap">
    <?php
    $gender = htmlentities($result->Gender);
    if ($gender == 1) {
        echo "Male";
    } elseif ($gender == 2) {
        echo "Female";
    } else {
        echo "Others";
    }
    ?>
</td>
<td class="no-wrap"><?php echo htmlentities($result->EmailId);?></td>
<td class="no-wrap"><?php echo htmlentities($result->ContactNo);?></td>
<td>
    <?php
    $status_text = '';
    $border_color = '';
    
    if ($result->status == 1) {
        $status_text = 'Verified';
        $border_color = 'green';
    } elseif ($result->status == 0) {
        $status_text = 'Not Verified';
        $border_color = 'gray';
    } elseif ($result->status == 2) {
        $status_text = 'Rejected';
        $border_color = 'red';
    } else {
        $status_text = 'Unknown';
        $border_color = 'gray';
    }
    
    echo '<span style="color: ' . $border_color . '; border: 1px solid ' . $border_color . '; border-radius: 4px; padding: 2px 6px;">' . $status_text . '</span>';
    ?>
</td>
<td class="no-wrap"><?php echo htmlentities($result->RegDate);?></td>
        </tr>
        <?php 
            $cnt++;
            }
          }
        ?>
      </tbody>
    </table>
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