<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
} else {

    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM friztann_vehicles WHERE vehicle_id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $msg = "Car deleted successfully";
    }

    if(isset($_POST['update'])) {
        $id = $_POST['vehicle_id'];
        $status = $_POST['carstatus'];
        $sql = "UPDATE friztann_vehicles SET Status=:status WHERE vehicle_id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $msg = "Car status updated successfully";
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
	
	<title>FritzAnn Shuttle Services  | Admin Manage Shuttle</title>
	    <link rel="apple-touch-icon" sizes="144x144" href="img/favicon-icon/apple-touch-icon-144.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/favicon-icon/apple-touch-icon-114.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/favicon-icon/apple-touch-icon-72.png">
<link rel="apple-touch-icon" href="img/favicon-icon/apple-touch-icon-57.png">
<link rel="shortcut icon" href="img/favicon-icon/favicon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/error-succ.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


	<style>
  
    body {
            font-family: 'Helvetica Neue', sans-serif;
            background-color: #ffffff;
            color: #333;
        }

      
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
  border-radius: 8px;
  transition: all 0.3s ease;
}

#zctb td a:hover {
  background-color: #f0f0f0;
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
                        <div class="panel-heading"> <h2 class="page-title" ">Manage Cars</h2>
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
                            <table id="zctb" class="display table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                                                        <th>ID</th>

                                        <th>Car Name</th>
                                        <th>Brand</th>
                                        <th>Price Per day</th>
                                        <th>Fuel Type</th>
                                        <th>Body Type</th>
                                        <th>Transmission Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>ID</th>
                                        <th>Car Name</th>
                                        <th>Brand</th>
                                        <th>Price Per day</th>
                                        <th>Fuel Type</th>
                                        <th>Body Type</th>
                                        <thTransmission Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $sql = "SELECT friztann_vehicles.vehicle_id, friztann_vehicles.VehiclesTitle, friztann_brands.BrandName, friztann_vehicles.PricePerDay, friztann_vehicles.FuelType, friztann_vehicles.bodytype, friztann_vehicles.TransmissionType, friztann_vehicles.Status FROM friztann_vehicles JOIN friztann_brands ON friztann_brands.brand_id=friztann_vehicles.VehiclesBrand";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if($query->rowCount() > 0) {
                                        foreach($results as $result) { ?>  
                                            <tr>
                                            	<td><?php echo htmlentities($cnt);?></td>
                                                <td><?php echo htmlentities($result->VehiclesTitle);?></td>
                                                <td><?php echo htmlentities($result->BrandName);?></td>
                                                <td><?php echo htmlentities($result->PricePerDay);?></td>
                                                <td><?php echo htmlentities($result->FuelType);?></td>
                                                <td><?php echo htmlentities($result->bodytype);?></td>
                                                <td><?php echo htmlentities($result->TransmissionType ? $result->TransmissionType : 'N/A');?></td>
                                               <td> <?php
    $status_text = '';
    $border_color = '';

    if ($result->Status == "AVAILABLE") {
        $status_text = 'Available';
        $border_color = 'green';
    } elseif ($result->Status == "MAINTENANCE") {
        $status_text = 'Maintenance';
        $border_color = 'red';
    } else {
        $status_text = 'Unknown';
        $border_color = 'gray';
    }

    echo '<span style="color: ' . $border_color . '; border: 1px solid ' . $border_color . '; border-radius: 4px; padding: 2px 6px;">' . $status_text . '</span>';
?></td>
                                                <td>
                                                <form method="post" action="manage-cars.php" style="display: flex; align-items: center; gap: 10px; flex-wrap: nowrap;">
    <input type="hidden" name="vehicle_id" value="<?php echo htmlentities($result->vehicle_id); ?>">
    
    <select name="carstatus" required style="padding: 10px; border: 2px solid #ccc; border-radius: 5px; background-color: #f9f9f9; font-size: 16px; flex-shrink: 0;">
        <option value="" style="color: #999;">Select</option>
        <option value="AVAILABLE" <?php if($result->Status == "AVAILABLE") echo "selected";?> style="color: green;">Available</option>
        <option value="MAINTENANCE" <?php if($result->Status == "MAINTENANCE") echo "selected";?> style="color: red;">Maintenance</option>
    </select>
    
    <button type="submit" name="update" class="btn btn-success btn-sm" style="font-size: 10px; white-space: nowrap; flex-shrink: 0;">
        Update
    </button>
    
    <a href="manage-cars.php?del=<?php echo $result->vehicle_id;?>" 
       onclick="return confirm('Do you want to delete this vehicle?');" 
       class="btn btn-danger btn-sm" 
       style="background-color: red; font-size: 10px; white-space: nowrap; flex-shrink: 0;">
        <i class="fa fa-close"></i> Delete
    </a>
</form>

                                                </td>
                                            </tr>
                                        <?php $cnt = $cnt + 1; }
                                    } ?>
                                </tbody>
                            </table>
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

