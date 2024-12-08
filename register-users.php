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
  $sql = "UPDATE friztann_users SET Status=:status WHERE  user_id=:eid";
  $query = $dbh->prepare($sql);
  $query -> bindParam(':status',$status, PDO::PARAM_STR);
  $query-> bindParam(':eid',$eid, PDO::PARAM_STR);
  $query -> execute();
  
  $msg="Profile Successfully Reject";
  }
  
  
  if(isset($_REQUEST['aeid']))
    {
  $aeid=intval($_GET['aeid']);
  $status=1;
  
  $sql = "UPDATE friztann_users SET Status=:status WHERE  user_id=:aeid";
  $query = $dbh->prepare($sql);
  $query -> bindParam(':status',$status, PDO::PARAM_STR);
  $query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
  $query -> execute();
  
  $msg="Profile  Successfully Verified";
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
	
	<title>FritzAnn Shuttle Services  |Admin Manage User  </title>
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
	
#zctb {
  background-color: #ffffff; /* White background for table */
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  overflow: hidden;
  border: 1px solid #f0f0f0; /* Light border for subtle separation */
}

#zctb th {
  background-color: #ffffff; /* White header background */
  color: black; /* Black text */
  font-weight: 600;
  text-transform: uppercase;
  padding: 16px;
  border-bottom: 2px solid #f0f0f0; /* Border for separation */
}

#zctb td {
  padding: 16px;
  text-align: center;
  vertical-align: middle;
  border-bottom: 1px solid #f0f0f0; /* Subtle border under cells */
  transition: background-color 0.3s ease;
}

#zctb tbody tr:hover {
  background-color: #ffffff; /* White on hover */
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
  background-color: #ffffff; /* White background on hover */
}


.button-link {
  display: inline-block;
  padding: 12px 24px;
  border: 2px solid #e0e0e0;
  border-radius: 12px;
  color: black;
  background: #ffffff;
  font-weight: 600;
  font-size: 16px;
  text-decoration: none;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.button-link:hover {
  color: #ffffff;
  border-color: #333333;
}

.button-link::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 0;
  background-color: #333333;
  z-index: -1;
  transition: all 0.3s ease;
}

.button-link:hover::before {
  width: 100%;
}

.btn {
  display: inline-block;
  padding: 10px 20px;
  margin: 5px;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  text-align: center;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s ease;
  background-color: #ffffff;
  color: black;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn:active {
  transform: translateY(1px);
}

.btn-verified {
  border-color: #4CAF50;
  color: #4CAF50;
}

.btn-verified:hover {
  background-color: #4CAF50;
  color: #ffffff;
}

.btn-reject {
  border-color: #f44336;
  color: #f44336;
}

.btn-reject:hover {
  background-color: #f44336;
  color: #ffffff;
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
					      <div class="panel-heading"> <h2 class="page-title" ">REGISTER USER</h2>

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
          <th>FullName</th>
          <th>Email </th>
          <th>Contact no</th>
          <th>View Details</th>
          <th>Status</th>
          <th>Action</th>
          <th>Registered Date</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>FullName</th>
          <th>Email </th>
          <th>Contact no</th>
          <th>View Details</th>
          <th>Status</th>
          <th>Action</th>
          <th>Registered Date</th>

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
        $profileImgPath = 'userprofile/' . basename($result->ProfileImg);
?>
        <tr>
		  <td class="no-wrap">
                    <?php 
                echo htmlentities(trim($result->FirstName)) . ' ' . 
                     htmlentities(trim($result->MiddleName)) . ' ' . 
                     htmlentities(trim($result->LastName)); 
            ?>
        </td> 
          <td><?php echo htmlentities($result->EmailId);?></td>
          <td><?php echo htmlentities($result->ContactNo);?></td>
          <td><a class="button-link" href="VIEWUSER.php?user_id=<?php echo htmlentities($result->user_id);?>">View</a></td>
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
<td>
  <a href="register-users.php?aeid=<?php echo htmlentities($result->user_id);?>" 
     class="btn btn-verified"
     onclick="return confirm('Do you really want to verify this user?')">
    Verified
  </a>
  <a href="register-users.php?eid=<?php echo htmlentities($result->user_id);?>" 
     class="btn btn-reject"
     onclick="return confirm('Do you really want to reject this user?')">
    Reject
  </a>
</td>
   <td><?php echo htmlentities($result->RegDate);?></td>
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