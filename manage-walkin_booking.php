<?php
session_start();
include('includes/config.php');

if(empty($_SESSION['alogin'])) {  
    header('location:index.php');
    exit; 
} else {
    $sqlHistory = "SELECT * FROM friztann_walkin";
    $queryHistory = $dbh->prepare($sqlHistory);
    if(!$queryHistory->execute()) {
        echo "Error executing query: " . $queryHistory->errorInfo()[2];
        exit; 
    }
    $bookingHistory = $queryHistory->fetchAll(PDO::FETCH_ASSOC);
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
    <title>FritzAnn Shuttle Services  | Admin BOOKING</title>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


  <style>
           #zctb {
  background-color: #ffffff;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  overflow: hidden;
  border: 1px solid #f0f0f0;
}

#zctb th {
  background-color: #ffffff;
  color: black;
  font-weight: 600;
  text-transform: uppercase;
  padding: 16px;
  border-bottom: 2px solid #f0f0f0;
}

#zctb td {
  padding: 16px;
  text-align: center;
  vertical-align: middle;
  border-bottom: 1px solid #f0f0f0;
  transition: background-color 0.3s ease;
}

#zctb tbody tr:hover {
  background-color: #fafafa;
}

#zctb td img {
  border-radius: 50%;
  width: 48px;
  height: 48px;
  margin-right: 12px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

#zctb td a {
  padding: 8px 16px;
  border-radius: 8px;
  transition: all 0.3s ease;
}

#zctb td a:hover {
  background-color: #f0f0f0;
}
        .custom22-container {
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-left: 100px;
            margin-top: 50px;
            max-width: 100%;
            font-family: 'Arial', sans-serif;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .custom22-form-group {
            display: flex;
            flex-direction: column;
        }
        .custom22-form-group label {
            margin-bottom: 8px;
            font-weight: bold;
        }
        .custom22-form-group input,
        .custom22-form-group textarea {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .custom22-form-group textarea {
            resize: vertical;
        }
        .custom22-button {
            background-color: red;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .custom22-button:hover {
            background-color: #0056b3;
        }
        .input {
            padding: 10px;
            height: 40px;
            border: 2px solid #0B2447;
            border-top: none;
            font-size: 16px;
            background: transparent;
            outline: none;
            box-shadow: 7px 7px 0px 0px #000000;
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
        .underline {
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
        .topline {
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
        .primary-button {
            font-family: 'Ropa Sans', sans-serif;
            color: white;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.05rem;
            border: 1px solid #0E1822;
            padding: 0.8rem 2.1rem;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 531.28 200'%3E%3Cdefs%3E%3Cstyle%3E .shape %7B fill: %23FF4655 /* fill: %230E1822; */ %7D %3C/style%3E%3C/defs%3E%3Cg id='Layer_2' data-name='Layer 2'%3E%3Cg id='Layer_1-2' data-name='Layer 1'%3E%3Cpolygon class='shape' points='415.81 200 0 200 115.47 0 531.28 0 415.81 200' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A");
            background-color: #0E1822;
            background-size: 200%;
            background-position: 200%;
            background-repeat: no-repeat;
            transition: 0.3s ease-in-out;
            transition-property: background-position, border, color;
            position: relative;
            z-index: 1;
        }
        .primary-button:hover {
            border: 1px solid #FF4655;
            color: white;
            background-position: 40%;
        }
        /* Additional styles for the modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #f9f9f9;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
.fritzannbtn {
  cursor: pointer;
  width: 50px;
  height: 50px;
  border: none;
  position: relative;
  border-radius: 5px;
  box-shadow: 1px 1px 5px .2px #00000035;
  transition: .2s linear;
  transition-delay: .2s;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.fritzannbtn:hover {
  width: 150px;
  background-color: white; 
  transition-delay: .2s;
}

.fritzannbtn:hover > .paragraph {
  visibility: visible;
  opacity: 1;
  transition-delay: .4s;
}

.fritzannbtn:hover > .icon-wrapper .icon {
  transform: scale(1.1);
}

.fritzannbtn:hover > .icon-wrapper .icon path {
  stroke: black;
}


.paragraph {
  color: black;
  visibility: hidden;
  opacity: 0;
  font-size: 10px;
  margin-right: 20px;
  padding-left: 20px;
  transition: .2s linear;
  font-weight: bold;
  text-transform: uppercase;
}

.icon-wrapper {
  width: 50px;
  height: 50px;
  position: absolute;
  top: 0;
  right: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon {
  transform: scale(.9);
  transition: .2s linear;
}

.icon path {
  stroke: #000;
  stroke-width: 2px;
  transition: .2s linear;
}
.error-message,
.success-message {
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 8px;
    display: inline-block;
    font-weight: 600;
}

.error-message {
    background-color: #2a0000;
    color: #ff3333;
    border: 1px solid #ff0000;
}

.success-message {
    background-color: #002a00;
    color: #33ff33;
    border: 1px solid #00ff00;
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
<h2 class="page-title">Walkin Booking History</h2>
							<div class="panel-body">
    <?php if(!empty($bookingHistory)): ?>
       
                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>Fullname</th>
											<th>Phone Number</th>
											<th>Address</th>
											<th>Age</th>
											<th>Date</th>
											<th>Time</th>
											<th>Detaination</th>
                      <th>Total Price</th>
											<th>Vehicle</th>
											<th>Booking Days</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
										<th>Fullname</th>
											<th>Phone Number</th>
											<th>Address</th>
											<th>Age</th>
											<th>Date</th>
											<th>Time</th>
											<th>Detaination</th>
                      <th>Total Price</th>
											<th>Vehicle</th>
											<th>Booking Days</th>
										</tr>
									</tfoot>
									<tbody>

                    <?php foreach($bookingHistory as $history): ?>
                        <tr>
                            <td><?php echo htmlentities($history['firstname']); ?> <?php echo htmlentities($history['middlename']); ?> <?php echo htmlentities($history['lastname']); ?></td>
                            <td><?php echo htmlentities($history['phonenumber']); ?></td>
                             <td><?php echo htmlentities($history['address']); ?></td>
                            <td><?php echo htmlentities($history['age']); ?></td>
                            <td><?php echo htmlentities($history['fromdate']); ?><?php echo htmlentities($history['todate']); ?></td>
                            <td><?php echo htmlentities($history['pickuptime']); ?>:<?php echo htmlentities($history['returntime']); ?></td>
                            <td><?php echo htmlentities($history['Location']); ?></td>
                            <td><?php echo htmlentities($history['totalPrice']); ?></td>
                            <?php
                            $sql = "SELECT friztann_vehicles.*, friztann_brands.BrandName 
                                    FROM friztann_vehicles 
                                    JOIN friztann_brands ON friztann_brands.brand_id = friztann_vehicles.VehiclesBrand
                                    WHERE friztann_vehicles.vehicle_id = :vehicle_id";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':vehicle_id', $history['vehicle_id'], PDO::PARAM_INT);
                            $query->execute();
                            $carDetails = $query->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <?php if($carDetails): ?>
                                <td class="vehicle-details">
                                    <div class="vehicle-info">
                                        <div class="vehicle-text">
                                            <strong><?php echo htmlentities($carDetails['BrandName'] . ': ' . $carDetails['VehiclesTitle']); ?></strong><br>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                    $fromDate = new DateTime($history['fromdate']);
                                    $toDate = new DateTime($history['todate']);
                                    $interval = $fromDate->diff($toDate);
                                    echo $interval->days + 0; 
                                    ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No booking history found.</p>
    <?php endif; ?>
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