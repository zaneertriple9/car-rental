<?php
session_start();
include('includes/config.php');
error_reporting(0);

if(strlen($_SESSION['alogin'])==0) {
    header('location:index.php');
} else {
    // Handle delete operation
    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM friztann_promo WHERE promo_id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        if ($query->execute()) {
            $_SESSION['msg'] = "Promotion deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete promotion.";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Handle form submission
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $imageP = $_FILES['file']['name'];
        $target = "promotion/" . basename($imageP);
        $priceAdd = $_POST['price_add'];
        $priceSubtract = $_POST['price_subtract'];
        $selectedCars = explode(",", $_POST['selectedCars']);

        $sql = "INSERT INTO friztann_promo (title, description, imageP) 
                VALUES (:title, :description, :imageP)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':imageP', $imageP, PDO::PARAM_STR);

        if ($query->execute()) {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
                $success = true;
                // Update prices for selected cars
                foreach ($selectedCars as $carId) {
                    $sqlUpdate = "UPDATE friztann_vehicles 
                                SET PricePerDay = PricePerDay + :priceAdd - :priceSubtract 
                                WHERE vehicle_id = :carId";
                    $updateQuery = $dbh->prepare($sqlUpdate);
                    $updateQuery->bindParam(':priceAdd', $priceAdd, PDO::PARAM_STR);
                    $updateQuery->bindParam(':priceSubtract', $priceSubtract, PDO::PARAM_STR);
                    $updateQuery->bindParam(':carId', $carId, PDO::PARAM_INT);
                    
                    if (!$updateQuery->execute()) {
                        $success = false;
                        break;
                    }
                }
                
                if ($success) {
                    $_SESSION['msg'] = "Promotion added and prices updated for selected cars successfully!";
                } else {
                    $_SESSION['error'] = "Failed to update prices for some cars.";
                }
            } else {
                $_SESSION['error'] = "Failed to upload file.";
            }
        } else {
            $_SESSION['error'] = "Failed to add promotion.";
        }
        
        // Redirect after processing
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Display messages
    if(isset($_SESSION['msg'])) {
        $msg = $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    if(isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FritzAnn Shuttle Services | Add Promo</title>
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
    <link rel="stylesheet" href="css/promo.css">
    <link rel="stylesheet" href="css/error-succ.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>
<style>
    #car-list {
    height: 60vh;
    width: 103%;
    overflow-y: auto;
}
</style>
<body>
<?php include('includes/header.php');?>

<div class="ts-main-content">
    <?php include('includes/leftbar.php');?>

    <div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
<div class="panel-heading">
    <h2 class="page-title" style="text-align: center; background-color: #f0f0f0; padding: 10px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 0 auto; width: fit-content; margin-bottom: 20px;">
        <button id="openModalBtn" class="primary-button">Add Promotion</button>
    </h2>

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

    <div class="panel-body">
        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                                        <th>ID</th>

                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                $sql = "SELECT promo_id, title, description, imageP FROM friztann_promo";
                $query = $dbh->prepare($sql);
                $query->execute();
                $cnt=1;

                $results = $query->fetchAll(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) { ?>
                        <tr>
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php echo htmlentities($result->title); ?></td>
                            <td><?php echo htmlentities($result->description); ?></td>
                            <td><img src="promotion/<?php echo htmlentities($result->imageP); ?>" alt="Promo Image" width="100"></td>
                            <td>
                                <a href="add-promo.php?del=<?php echo $result->promo_id; ?>" onclick="return confirm('Do you want to delete this promotion?');" class="btn btn-danger btn-sm">
                                    <button class="fritzannbtn">
                                        <p class="paragraph">Delete</p>
                                        <span class="icon-wrapper">
                                            <svg class="icon" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </a>
                            </td>
                        </tr>
               										<?php $cnt=$cnt+1; }} ?>

            </tbody>
        </table>
    </div>
</div>  
<div id="promoModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1 class="custom-heading">Add Promotion</h1>
        <form method="post" enctype="multipart/form-data" class="custom-form">
            <div class="custom22-form-group">
                <label for="title" class="custom-label">Title:</label>
<input type="text" name="title" id="title" required class="custom-input" minlength="1" maxlength="20">
            </div>

            <div class="custom22-form-group">
                <label for="description" class="custom-label">Description:</label>
<textarea name="description" id="description" required class="custom-textarea" maxlength="100" minlength="10"></textarea>
            </div>

            <div class="custom22-form-group">
                <label for="file" class="custom-label">Attach File:</label>
                <input type="file" name="file" id="file" required class="custom-input">
            </div>

            <input type="hidden" name="selectedCars" id="selectedCars">

            <button type="button" id="openModalButton">Select Car for Promo</button>

            <div id="carSelectionModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeModalButton">&times;</span>
                    <div class="custom22-form-group">
                        <label>Select Cars for Promotion:</label>
                        <div id="car-list">
                            <?php
                            $sql = "SELECT vehicle_id, VehiclesTitle, vimage0 FROM friztann_vehicles";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $vehicles = $query->fetchAll(PDO::FETCH_OBJ);
                            foreach ($vehicles as $vehicle) {
                                echo "<div class='car-item' data-id='" . $vehicle->vehicle_id . "'>";
                                echo "<img src='img/vehicleimages/" . $vehicle->vimage0 . "' alt='" . $vehicle->VehiclesTitle . "' style='width:100px;height:auto;' />";
                                echo "<p>" . $vehicle->VehiclesTitle . "</p>";
                                echo "<button type='button' class='select-car-button' onclick='toggleCarSelection(" . $vehicle->vehicle_id . ", this)'>Select</button>";
                                echo "</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="custom22-form-group">
                <label for="price_add">Price to Add +(Optional):</label>
<input 
    type="text" 
    id="price_add"
    name="price_add" 
    class="form-control input"
    maxlength="4"
    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
><br>
                <label for="price_subtract">Price to decrease - (Optional):</label>
                <input 
    type="text" 
    id="price_subtract"
    name="price_subtract" 
    class="form-control input"
    maxlength="4"
    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
><br>
            </div>

            <div class="button-borders">
                <button type="submit" style="margin-top: 10px;" name="submit" class="primary-button">SUBMIT</button>
            </div>
        </form>
    </div>
</div>
<script src="js/letselectedCars.js"></script>
<script src="js/promo-modal.js"></script>
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