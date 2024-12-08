<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('includes/config.php');


if (strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
    exit();  
}

try {
    
    $sql_bookinginfo = "
    SELECT 
        friztann_bookinginfo.booking_info_id, 
        friztann_bookinginfo.userEmail, 
        COALESCE(friztann_drivers.DriverName, 'No Driver') AS DriverName, 
        friztann_bookinginfo.selectedLocation, 
        friztann_bookinginfo.locationprice,
        friztann_bookinginfo.bookingprice,
        friztann_bookinginfo.totalprice, 
        friztann_bookinginfo.booking_id, 
        friztann_booking.FromDate, 
        friztann_booking.ToDate, 
        friztann_booking.pickuptime, 
        friztann_booking.BookingHours, 
        friztann_booking.returntime, 
        friztann_vehicles.Vehicle_id, 
        friztann_vehicles.VehiclesTitle, 
        friztann_vehicles.VehiclesBrand,
        friztann_users.FirstName, 
        friztann_users.MiddleName, 
        friztann_users.LastName
    FROM 
        friztann_bookinginfo
    JOIN 
        friztann_booking ON friztann_bookinginfo.booking_id = friztann_booking.booking_id
    JOIN 
        friztann_vehicles ON friztann_booking.Vehicle_id = friztann_vehicles.Vehicle_id
    LEFT JOIN 
        friztann_drivers ON friztann_bookinginfo.DriverId = friztann_drivers.driver_id 
    JOIN 
        friztann_users ON friztann_bookinginfo.userEmail = friztann_users.EmailId
";



    
    $query_bookinginfo = $dbh->prepare($sql_bookinginfo);
    $query_bookinginfo->execute();
    $results_bookinginfo = $query_bookinginfo->fetchAll(PDO::FETCH_OBJ);

    
    $sql_noaccbookinginfo = "
        SELECT 
            friztann_noaccbookinginfo.noaccbookinginfo_ID, 
            friztann_noaccbookinginfo.noaccbooking_ID, 
            friztann_noaccbookinginfo.firstname, 
             friztann_noaccbookinginfo.middlename, 
            friztann_noaccbookinginfo.lastname  , 
            friztann_noaccbookinginfo.selectedLocation, 
            friztann_noaccbookinginfo.locationPrice,
            friztann_noaccbookinginfo.address, 
            friztann_noaccbookinginfo.gender, 
            friztann_noaccbookinginfo.age, 
            friztann_noaccbookinginfo.phone, 
            friztann_noaccbookinginfo.totalprice, 
            friztann_noaccbookinginfo.bookingCode,
            friztann_noaccbookinginfo.hours,
            friztann_noaccbooking.FromDate, 
            friztann_noaccbooking.PickupTime, 
            friztann_noaccbooking.ToDate, 
            friztann_noaccbooking.ReturnTime, 
            friztann_vehicles.VehiclesTitle, 
            friztann_vehicles.VehiclesBrand
        FROM 
            friztann_noaccbookinginfo
        JOIN 
            friztann_noaccbooking ON friztann_noaccbookinginfo.noaccbooking_ID = friztann_noaccbooking.noaccbooking_ID
        JOIN 
            friztann_vehicles ON friztann_noaccbooking.vehicle_id = friztann_vehicles.Vehicle_id
    ";

    
    $query_noaccbookinginfo = $dbh->prepare($sql_noaccbookinginfo);
    $query_noaccbookinginfo->execute();
    $results_noaccbookinginfo = $query_noaccbookinginfo->fetchAll(PDO::FETCH_OBJ);

    
    $sql_bookingadmin = "
        SELECT 
            friztann_walkin.walk_id, 
            friztann_walkin.vehicle_id, 
            friztann_walkin.firstname, 
             friztann_walkin.middlename, 
            friztann_walkin.lastname, 
            friztann_walkin.address, 
            friztann_walkin.age, 
            friztann_walkin.phonenumber,
            friztann_walkin.fromdate, 
            friztann_walkin.todate, 
            friztann_walkin.pickuptime,
            friztann_walkin.returntime,
            friztann_walkin.Location, 
            friztann_walkin.LocationPrice,
            friztann_walkin.totalPrice, 
            friztann_vehicles.VehiclesTitle, 
            friztann_vehicles.VehiclesBrand
        FROM 
            friztann_walkin
        JOIN 
            friztann_vehicles ON friztann_walkin.vehicle_id = friztann_vehicles.Vehicle_id
    ";

   
    $query_bookingadmin = $dbh->prepare($sql_bookingadmin);
    $query_bookingadmin->execute();
    $results_bookingadmin = $query_bookingadmin->fetchAll(PDO::FETCH_OBJ);

} catch (PDOException $e) {
    
    echo "Error: " . $e->getMessage();
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
	
	<title>FritzAnn Shuttle Services  |Admin Manage Reports </title>
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
    <link rel="stylesheet" href="css/payment.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
 @import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap');

.report-body {
    font-family: 'Open Sans', sans-serif;
    line-height: 1.6;
    color: #333;
    margin: 0 auto;
    background-color: #f9f9f9;
}

@media print {
    .report-body {
        background-color: white;
        margin: 0; 
    }
    .no-print {
        display: none;
    }
}

.report-container {
    background-color: white;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 83%; 
    height: auto; 
    max-width: 100%; 
    margin-left: 256px; 
    margin-top: 50px;  
}

.report-header {
    text-align: center;
    margin-bottom: 40px;
    border-bottom: 2px solid #333;
    padding-bottom: 20px;
}

.report-title {
    font-family: 'Merriweather', serif;
    font-size: 30px;
    margin-bottom: 10px;
}

.report-date {
    font-style: italic;
    color: #666;
}

.report-section {
    margin-bottom: 40px;
}

.section-title {
    font-family: 'Merriweather', serif;
    font-size: 22px;
    border-bottom: 1px solid #333;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.report-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.report-table th, .report-table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

.report-table th {
    background-color: #f2f2f2;
    font-weight: 600;
}

.report-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.no-data {
    text-align: center;
    font-style: italic;
    color: #666;
}

.svg-divider {
    display: block;
    margin: 30px 0;
    text-align: center;
}

.print-button {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

.print-button:hover {
    background-color: #555;
}

@media print {
    .print-button {
        display: none;
    }
    .report-container {
        margin: 0; 
        width: 100%; 
        box-shadow: none; 
        border: none; 
    }
}

    </style>
</head>
<body class="report-body">
<?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>

    <div class="report-container">
        <header class="report-header">
            <h1 class="report-title">Friztann Reports</h1>   
 <button onclick="window.print()" class="print-button no-print">Print Report</button>

            <p class="report-date">Generated on <?php echo date('F j, Y'); ?></p>

            <section class="report-section">
    <h2 class="section-title">User Booking Reports</h2>
    <table class="report-table">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>User Email</th>
                <th>Vehicle</th>
                <th>Driver Name</th>
                <th>Selected Location</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Pickup Time</th>
                <th>Return Time</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php if($query_bookinginfo->rowCount() > 0) {
                foreach($results_bookinginfo as $row) { ?>
                    <tr>
                        <td><?php echo htmlentities($row->FirstName); ?> <?php echo htmlentities($row->MiddleName); ?> <?php echo htmlentities($row->LastName); ?></td>
                        <td><?php echo htmlentities($row->userEmail); ?></td>
                        <td><?php echo htmlentities($row->VehiclesTitle); ?></td>
                        <td><?php echo htmlentities($row->DriverName); ?></td>
                        <td><?php echo htmlentities($row->selectedLocation); ?></td>
                        <td><?php echo htmlentities($row->FromDate); ?></td>
                        <td><?php echo htmlentities($row->ToDate); ?></td>
                        <td><?php echo htmlentities($row->pickuptime); ?></td>
                        <td><?php echo htmlentities($row->returntime); ?></td>
                        <td><?php echo htmlentities($row->totalprice + 500); ?></td>

                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="11" class="no-data">No data found</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>


        <svg class="svg-divider" width="200" height="20" xmlns="http://www.w3.org/2000/svg">
            <line x1="0" y1="10" x2="200" y2="10" stroke="#333" stroke-width="1" stroke-dasharray="10,5"/>
            <circle cx="100" cy="10" r="5" fill="#333"/>
        </svg>

        <section class="report-section">
    <h2 class="section-title">No Account Booking Reports</h2>
    <table class="report-table">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Selected Location</th>
                <th>Vehicle</th>
                <th>From Date</th>
                <th>Pickup Time</th>
                <th>To Date</th>
                <th>Return Time</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php if($query_noaccbookinginfo->rowCount() > 0) {
                foreach($results_noaccbookinginfo as $row) { ?>
                    <tr>
                        <td><?php echo htmlentities($row->firstname); ?> <?php echo htmlentities($row->middlename); ?> <?php echo htmlentities($row->lastname); ?></td>
                        <td><?php echo htmlentities($row->selectedLocation); ?></td>
                        <td><?php echo htmlentities($row->VehiclesTitle); ?></td>
                        <td><?php echo htmlentities($row->FromDate); ?></td>
                        <td><?php echo htmlentities($row->PickupTime); ?></td>
                        <td><?php echo htmlentities($row->ToDate); ?></td>
                        <td><?php echo htmlentities($row->ReturnTime); ?></td>
                        <td><?php echo htmlentities($row->totalprice); ?></td>

                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="9" class="no-data">No data found</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>
        <svg class="svg-divider" width="200" height="20" xmlns="http://www.w3.org/2000/svg">
            <line x1="0" y1="10" x2="200" y2="10" stroke="#333" stroke-width="1" stroke-dasharray="10,5"/>
            <circle cx="100" cy="10" r="5" fill="#333"/>
        </svg>

        <section class="report-section">
    <h2 class="section-title">Walkin Reports</h2>
    <table class="report-table">
        <thead>
            <tr>
            <th>Full Name</th>
            <th>Address</th>
            <th>Age</th>
                <th>Vehicle </th>
                <th>Location</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php if($query_bookingadmin->rowCount() > 0) {
                foreach($results_bookingadmin as $row) { ?>
                    <tr>
                        <td><?php echo htmlentities($row->firstname); ?> <?php echo htmlentities($row->middlename); ?> <?php echo htmlentities($row->lastname); ?></td>
                        <td><?php echo htmlentities($row->address); ?></td>
                        <td><?php echo htmlentities($row->age); ?></td>
                        <td><?php echo htmlentities($row->VehiclesTitle); ?></td>
                        <td><?php echo htmlentities($row->Location); ?></td>
                        <td><?php echo htmlentities($row->fromdate); ?></td>
                        <td><?php echo htmlentities($row->todate); ?></td>
                        <td><?php echo htmlentities($row->totalPrice); ?></td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="8" class="no-data">No data found</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

    </div>


    <script>
        window.onbeforeprint = function() {
            document.title = "Booking Report - " + new Date().toLocaleDateString();
        };
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



