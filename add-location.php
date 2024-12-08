<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Handle delete operation
    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM friztann_location WHERE location_id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['msg'] = "Location deleted successfully";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Handle form submission
    if(isset($_POST['submit'])) {
        $LocationName = $_POST['LocationName'];
        $LocationsOverview = $_POST['LocationsOverview'];
        $LocationPrice = $_POST['LocationPrice'];
        $image1 = $_FILES["img1"]["name"];

        if(move_uploaded_file($_FILES["img1"]["tmp_name"], "img/locationimages/".$image1)) {
            $sql = "INSERT INTO friztann_location (LocationName, LocationsOverview, LocationPrice, image1) 
                   VALUES(:LocationName, :LocationsOverview, :LocationPrice, :image1)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':LocationName', $LocationName, PDO::PARAM_STR);
            $query->bindParam(':LocationsOverview', $LocationsOverview, PDO::PARAM_STR);
            $query->bindParam(':LocationPrice', $LocationPrice, PDO::PARAM_INT);
            $query->bindParam(':image1', $image1, PDO::PARAM_STR);
            
            if($query->execute()) {
                $lastInsertId = $dbh->lastInsertId();
                $_SESSION['msg'] = "Location posted successfully";
            } else {
                $_SESSION['error'] = "Something went wrong. Please try again";
            }
        } else {
            $_SESSION['error'] = "Error uploading image";
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
    <title>FritzAnn Shuttle Services | Add Location</title>
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
    <link rel="stylesheet" href="css/addlocation.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
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

  
                        <div class="panel-heading"> <h2 class="page-title" style="text-align: center; background-color: #f0f0f0; padding: 10px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 0 auto; width: fit-content; margin-bottom: 20px;">           <button id="openModalBtn" class="primary-button">Add Location</button>

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

            <th>Location Name</th>
            <th>Location Price</th>
            <th>Locations Overview</th>
            <th>Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Location Name</th>
            <th>Location Price</th>
            <th>Locations Overview</th>
            <th>Action</th>
        </tr>
    </tfoot>
    <tbody>
        <?php
        $sql = "SELECT location_id, LocationName, LocationPrice, LocationsOverview, image1 FROM friztann_location";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt=1;

        if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>
                <tr>
                	<td><?php echo htmlentities($cnt);?></td>
                    <td><?php echo htmlentities($result->LocationName); ?></td>
                    <td><?php echo htmlentities($result->LocationPrice); ?></td>
                    <td><?php echo htmlentities($result->LocationsOverview); ?></td>
                    <td>
                        <a href="add-location.php?del=<?php echo $result->location_id; ?>" onclick="return confirm('Do you want to delete this location?');" class="btn btn-danger btn-sm">
                            <button class="fritzannbtn">
                                <p class="paragraph">delete</p>
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

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        
        <h2 class="page-title">Add Location</h2>
        
        <form method="post" enctype="multipart/form-data" class="custom22-form">
            <div class="custom22-form-group">
                <?php if($error){ ?>
                <div class="errorWrap">ERROR: <?php echo htmlentities($error); ?></div>
                <?php } else if($msg){ ?>
                <div class="succWrap">SUCCESS: <?php echo htmlentities($msg); ?></div>
                <?php } ?>
                
                <label for="LocationName">Location Name</label>
<input type="text" id="LocationName" name="LocationName" class="input" required minlength="1" maxlength="20">
                <div class="topline"></div>
                <div class="underline"></div>
                <div class="label">Location Name</div>
            </div>
            <div class="custom22-form-group">
                <label for="LocationsOverview"style="margin-top: 10px;">Locations Overview</label>
<textarea id="LocationsOverview" name="LocationsOverview" rows="3" required maxlength="500"></textarea>
            </div>
            <div class="custom22-form-group">
                <label for="LocationPrice">Price</label>
                <input 
    type="text" 
    id="LocationPrice"
    name="LocationPrice" 
    class="input" 
    maxlength="4"
    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
>
                <div class="topline"></div>
                <div class="underline"></div>
                <div class="label">Price</div>
            </div>
            <div class="custom22-form-group">
                <label for="img1"style="margin-top: 10px;">Image 1</label>
                <input type="file" id="img1" name="img1" required>
            </div>
            <div class="button-borders">
                <button type="submit"style="margin-top: 10px;" name="submit" class="primary-button">SUBMIT</button>
            </div>
        </form>
    </div>
</div>
<script src="js/addlocation.js"></script>
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
