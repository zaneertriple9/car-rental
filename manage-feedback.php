<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Redirect to login if session is not active
if (strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
    exit;
}

// Delete testimonial
if (isset($_GET['del'])) {
    $id = intval($_GET['del']); // Ensure $id is an integer for security
    $sql = "DELETE FROM friztann_feedback WHERE testimonial_id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT); // Use PARAM_INT for integers
    $query->execute();
    $msg = "Feedback deleted successfully";
}

// Deactivate feedback
if (isset($_REQUEST['eid'])) {
    $eid = intval($_GET['eid']);
    $status = 0; // Use integer for status
    $sql = "UPDATE friztann_feedback SET status = :status WHERE testimonial_id = :eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_INT); // Use PARAM_INT
    $query->bindParam(':eid', $eid, PDO::PARAM_INT);
    $query->execute();
    $msg = "Feedback successfully inactive";
}

// Activate feedback
if (isset($_REQUEST['aeid'])) {
    $aeid = intval($_GET['aeid']);
    $status = 1;
    $sql = "UPDATE friztann_feedback SET status = :status WHERE testimonial_id = :aeid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':aeid', $aeid, PDO::PARAM_INT);
    $query->execute();
    $msg = "Feedback successfully active";
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
	
	<title>FritzAnn Shuttle Services  |Admin Manage Feedback </title>
	    <link rel="apple-touch-icon" sizes="144x144" href="img/favicon-icon/apple-touch-icon-144.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/favicon-icon/apple-touch-icon-114.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/favicon-icon/apple-touch-icon-72.png">
<link rel="apple-touch-icon" href="img/favicon-icon/apple-touch-icon-57.png">
<link rel="shortcut icon" href="img/favicon-icon/favicon.png">s
	<link rel="stylesheet" href="css/error-succ.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
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
  padding: 10px;
  border-bottom: 2px solid #f0f0f0;
}

#zctb td {
  padding: 10px;
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

.button68 {
  background: #fff;
  border: none;
  padding: 10px 20px;
  display: inline-block;
  font-size: 10px;
  font-weight: 600;
  width: 120px;
  text-transform: uppercase;
  cursor: pointer;
  transform: skew(-21deg);
  position: relative; 
  margin-left: 50px; 
}


.button68 span {
  display: inline-block;
  transform: skew(21deg);
}

.button68::before {
  content: '';
  position: absolute;
  top: 0;
  bottom: 0;
  right: 100%;
  left: 100%;
  background: rgb(20, 20, 20);
  opacity: 0;
  z-index: -1;
  transition: all 0.5s;
}

.button68:hover {
  color: white;
}

.button68:hover::before {
  left: 0;
  right: 0;
  opacity: 1;
}

.fritzannbtn {
  cursor: pointer;
  width: 50px;
  height: 50px;
  border: none;
  position: relative;
  border-radius: 10px;
  box-shadow: 1px 1px 5px .2px #00000035;
  transition: .2s linear;
  transition-delay: .2s;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.fritzannbtn:hover {
  width: 150px;
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
  font-size: 18px;
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

					<h2 class="page-title" >Manage Feedback</h2>

							<div class="panel-heading">
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
											<th>Name</th>
											<th>Email</th>
											<th>Testimonials</th>
											<th>Posting date</th>
											<th><div style="margin-left: 200px;">Action</div></th>

											</tr>
									</thead>
									<tfoot>
										<tr>
										    <th>ID</th>
											<th>Name</th>
											<th>Email</th>
											<th>Testimonials</th>
											<th>Posting date</th>
											<th><div style="margin-left: 200px;">Action</div></th>
											</tr>
									</tfoot>
									<tbody>

									<?php $sql = "SELECT friztann_users.FirstName,friztann_users.MiddleName,friztann_users.LastName,friztann_feedback.UserEmail,friztann_feedback.Testimonial,friztann_feedback.PostingDate,friztann_feedback.status,friztann_feedback.testimonial_id  from friztann_feedback join friztann_users on friztann_users.Emailid=friztann_feedback.UserEmail";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
										<tr>
										    	<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($result->FirstName);?> <?php echo htmlentities($result->MiddleName);?> <?php echo htmlentities($result->LastName);?></td>
											<td><?php echo htmlentities($result->UserEmail);?></td>
											<td><?php echo htmlentities($result->Testimonial);?></td>
											<td><?php echo htmlentities($result->PostingDate);?></td>
										<td><?php if($result->status=="" || $result->status==0) { ?>
    <button class="button68" onclick="if(confirm('Do you really want to activate?')) { window.location.href='manage-feedback.php?aeid=<?php echo htmlentities($result->testimonial_id); ?>'; } return false;">
        <span>Active</span>
    </button>
<?php } else { ?>
    <button class="button68" onclick="if(confirm('Do you really want to deactivate?')) { window.location.href='manage-feedback.php?eid=<?php echo htmlentities($result->testimonial_id); ?>'; } return false;">
        <span>Inactive</span>
    </button>
<?php } ?>
</td>
<td>
    <a href="manage-feedback.php?del=<?php echo $result->testimonial_id; ?>" 
       onclick="return confirm('Do you want to delete this feedback?');" 
       class="btn btn-danger btn-sm">
        <button class="fritzannbtn" type="button">
            <p class="paragraph">Delete</p>
            <span class="icon-wrapper">
                <svg class="icon" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16" 
                          stroke="#000000" 
                          stroke-width="2" 
                          stroke-linecap="round" 
                          stroke-linejoin="round"></path>
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
