
<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_REQUEST['eid']))
	{
$eid=intval($_GET['eid']);
$status="2";
$sql = "UPDATE friztann_booking SET Status=:status WHERE  booking_id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();

$msg="Booking Successfully Cancelled";
}


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
	
	<title>FritzAnn Shuttle Services  |Admin Manage Booking</title>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


  <style>
	
body {
  font-family: 'Helvetica Neue', sans-serif;
  background-color: #ffffff;
  color: #333;
}

#zctb {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

#zctb th {
  background-color: #ffffff;
  color: #000000;
  font-weight: 600;
  text-transform: uppercase;
  padding: 12px;
}

#zctb td {
  padding: 0; 
  text-align: center; 
  vertical-align: middle; 
  border-bottom: 1px solid #e8e8e8;
}


#zctb tbody tr:hover {
  background-color: #f5f5f5;
}

#zctb td img {
  border-radius: 50%;
  width: 48px;
  height: 48px;
  margin-right: 12px;
}

#zctb td a {
  padding: 6px 12px;
  border-radius: 4px;
}

#zctb td a:hover {
  background-color: #333;
}

	

.custom68 {
  display: flex;
  align-items: center;
  justify-content: center;
  outline: none;
  cursor: pointer;
  width: 150px;
  height: 50px;
  background-image: linear-gradient(to top, #D8D9DB 0%, #fff 80%, #FDFDFD 100%);
  border-radius: 30px;
  border: 1px solid #8F9092;
  transition: all 0.2s ease;
  font-family: "Source Sans Pro", sans-serif;
  font-size: 14px;
  font-weight: 600;
  color: #606060;
  text-shadow: 0 1px #fff;
}

.custom68:hover {
  box-shadow: 0 4px 3px 1px #FCFCFC, 0 6px 8px #D6D7D9, 0 -4px 4px #CECFD1, 0 -6px 4px #FEFEFE, inset 0 0 3px 3px #CECFD1;
}

.custom68:active {
  box-shadow: 0 4px 3px 1px #FCFCFC, 0 6px 8px #D6D7D9, 0 -4px 4px #CECFD1, 0 -6px 4px #FEFEFE, inset 0 0 5px 3px #999, inset 0 0 30px #aaa;
}

.custom68:focus {
  box-shadow: 0 4px 3px 1px #FCFCFC, 0 6px 8px #D6D7D9, 0 -4px 4px #CECFD1, 0 -6px 4px #FEFEFE, inset 0 0 5px 3px #999, inset 0 0 30px #aaa;
}
.button-link {
    display: inline-block;
    padding: 15px 25px;
    border: unset;
    border-radius: 15px;
    color: #212121;
    z-index: 1;
    background: #e8e8e8;
    position: relative;
    font-weight: 1000;
    font-size: 17px;
    text-decoration: none; 
    -webkit-box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
    box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
    transition: all 250ms;
    overflow: hidden;
}

.button-link:hover {
    color: #e8e8e8;
}

.button-link::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 0;
    border-radius: 15px;
    background-color: #212121;
    z-index: -1;
    -webkit-box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
    box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
    transition: all 250ms;
}

.button-link:hover::before {
    width: 100%;
}




.cti {
  background-color: #333;
  padding: 10px 20px;
  border: 3px solid transparent;
  border-radius: 0.6em;
  transition: 0.2s;
}

.cti:hover {
  background-color: transparent;
  border: 3px solid #000000;
  box-shadow: 0px 0px 27px 5px #000000;
}

.CTI {
  color: white;
  font-family: 'Courier New', Courier, monospace;
  font-size: 15px;
  font-weight: bold;
  overflow: hidden;
  border-right: 4px solid transparent;
  white-space: nowrap;
  margin: 0 auto;
}

.cti:hover .CTI {
  color: black;
  border-right: 4px solid #000000;
  animation: letters 1.75s steps(22, end), cursor .4s step-end infinite;
}

@keyframes letters {
  from {
    width: 0;
  }

  to {
    width: 100%;
  }
}

@keyframes cursor {
  from {
    border-color: transparent;
  }

  50% {
    border-color: #000000;
  }
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
          <div class="panel-heading">

					<h2 class="page-title" >Users Bookings</h2>
   



							<div class="panel-body">
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
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>ID</th>
											<th>User</th>
											<th>Car</th>
											<th>From Date</th>
											<th>To Date</th>
											<th>booking Days</th>
                      <th>view payments</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
										<th>ID</th>
										<th>User</th>
										 <th>Car</th>
											<th>From Date</th>
											<th>To Date</th>
											<th>booking Days</th>
                      <th>view payments</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</tfoot>
									<tbody>

									<?php
$sql = "SELECT 
            friztann_users.FirstName,
            friztann_users.MiddleName,
            friztann_users.LastName,
            friztann_users.ProfileImg,
            friztann_brands.BrandName,
            friztann_vehicles.VehiclesTitle,
            friztann_booking.FromDate,
            friztann_booking.ToDate,
            friztann_booking.BookingHours,
            friztann_booking.vehicle_id as vid,
            friztann_booking.Status,
            friztann_booking.PostingDate,
            friztann_booking.booking_id  
        FROM 
            friztann_booking 
        JOIN 
            friztann_vehicles ON friztann_vehicles.Vehicle_id = friztann_booking.vehicle_id 
        JOIN 
            friztann_users ON friztann_users.EmailId = friztann_booking.userEmail 
        JOIN 
            friztann_brands ON friztann_vehicles.VehiclesBrand = friztann_brands.brand_id";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	$profileImgPath = 'userprofile/' . basename($result->ProfileImg);
  $bookingId = $result->booking_id;		?>	
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
                      <td class="no-wrap">
                      <?php
                        if (!empty($result->ProfileImg) && file_exists($profileImgPath)) {
                            echo '<a href="' . htmlentities($profileImgPath) . '" data-lightbox="image-' . htmlentities($bookingId) . '"><img src="' . htmlentities($profileImgPath) . '" alt="Car Image" style="border-radius: 50%; width: 50px; height: 50px; margin-left: px;"></a>';
                        } else {
                            echo '<div class="custom69-profile-img-default"></div>';
                        }
                        ?><?php 
                echo htmlentities(trim($result->FirstName)) . ' ' . 
                     htmlentities(trim($result->MiddleName)) . ' ' . 
                     htmlentities(trim($result->LastName)); 
            ?>
        </td> 
        <td class="no-wrap"><?php echo htmlentities($result->BrandName);?> :<?php echo htmlentities($result->VehiclesTitle);?>	</td>
											<td><?php echo htmlentities($result->FromDate);?></td>
											<td><?php echo htmlentities($result->ToDate);?></td>
											<td><?php echo htmlentities($result->BookingHours);?></td>
                      <td><a class="button-link" href="view-booking.php?booking_id=<?php echo htmlentities($result->booking_id);?>">View</a></td>
											<td>




											<?php 
if($result->Status == 0) {
    echo '<span style="color: gray; border: 1px solid gray; background-color: #f0f0f0; border-radius: 5px; padding: 5px;">' . htmlentities('Not Confirmed') . '</span>';
} else if ($result->Status == 1) {
    echo '<span style="color: green; border: 1px solid green; background-color: #e0ffe0; border-radius: 5px; padding: 5px;">' . htmlentities('Confirmed') . '</span>';
} else {
    echo '<span style="color: red; border: 1px solid red; background-color: #ffe0e0; border-radius: 5px; padding: 5px;">' . htmlentities('Cancelled') . '</span>';
}
										?></td>
											<td>  
											<a href="manage-bookings.php?aeid=<?php echo htmlentities($result->booking_id);?>" 
   class="custom68 confirm" 
   onclick="return confirm('Do you really want to Confirm this booking')">Confirm</a>
<a href="manage-bookings.php?eid=<?php echo htmlentities($result->booking_id);?>" 
   class="custom68 cancel" 
   onclick="return confirm('Do you really want to Cancel this Booking')">Cancel</a>

</td>
										</tr>
										<?php $cnt=$cnt+1; }} ?>
										
									</tbody>
								</table>

						

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