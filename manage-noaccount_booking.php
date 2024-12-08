<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
    exit;
}

if(isset($_GET['del'])) {
    $id = $_GET['del'];
    
    // First, get the noaccbooking_ID from the bookinginfo table
    $getBookingIdSql = "SELECT noaccbooking_ID FROM friztann_noaccbookinginfo WHERE noaccbookinginfo_ID=:id";
    $getBookingIdQuery = $dbh->prepare($getBookingIdSql);
    $getBookingIdQuery->bindParam(':id', $id, PDO::PARAM_STR);
    $getBookingIdQuery->execute();
    $bookingId = $getBookingIdQuery->fetch(PDO::FETCH_OBJ)->noaccbooking_ID;

    try {
        // Start transaction to ensure both deletes succeed or none do
        $dbh->beginTransaction();

        // Delete from friztann_noaccbookinginfo first (child table)
        $sql1 = "DELETE FROM friztann_noaccbookinginfo WHERE noaccbookinginfo_ID=:id";
        $query1 = $dbh->prepare($sql1);
        $query1->bindParam(':id', $id, PDO::PARAM_STR);
        $query1->execute();

        // Then delete from friztann_noaccbooking (parent table)
        $sql2 = "DELETE FROM friztann_noaccbooking WHERE noaccbooking_ID=:bookingId";
        $query2 = $dbh->prepare($sql2);
        $query2->bindParam(':bookingId', $bookingId, PDO::PARAM_STR);
        $query2->execute();

        // If both queries succeed, commit the transaction
        $dbh->commit();
        $msg = "Booking deleted successfully";
    } catch (Exception $e) {
        // If any query fails, roll back the transaction
        $dbh->rollBack();
        $msg = "Error deleting booking: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="theme-color" content="#3e454c">
<title>FritzAnn Shuttle Services l | No Account Booking</title>
	<link rel="stylesheet" href="css/error-succ.css">
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
    <link rel="stylesheet" href="css/tablenoaccount.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
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

					<h2 class="page-title" >No Account Bookings</h2>
   



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

                <th>Full Name</th>
                <th>Number</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Date</th>
                <th>Time</th>
                <th>Selected Location</th>
                <th>Booking Code</th>
                <th>Total Price</th>
                <th>Reservation Time</th>
                <th>Timer</th>
                <th>Action</th>


            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>number</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Date</th>
                <th>Time</th>
                <th>Selected Location</th>
                <th>Booking Code</th>
                <th>Total Price</th>
                <th>Reservation Time</th>
                <th>Timer</th>
                <th>Action</th>

            </tr>
        </tfoot>
        <tbody>
    <?php
    $sql = "SELECT info.noaccbookinginfo_ID, info.gender, info.phone, info.age, info.hours, info.phone, info.selectedLocation, info.bookingCode, info.totalprice, 
                   booking.FromDate, booking.PickupTime, booking.ToDate, booking.ReturnTime, info.firstname, info.middlename, info.lastname
            FROM friztann_noaccbooking AS booking
            JOIN friztann_noaccbookinginfo AS info ON booking.noaccbooking_ID = info.noaccbooking_ID";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;

    if ($query->rowCount() > 0) {
        foreach ($results as $result) { 
            $countdownId = 'countdown_' . $result->noaccbookinginfo_ID;
            ?>
            <tr>
                											<td><?php echo htmlentities($cnt);?></td>
                <td><?php echo htmlentities($result->firstname); ?><?php echo htmlentities($result->middlename); ?><?php echo htmlentities($result->lastname); ?></td>
                <td><?php echo htmlentities($result->phone); ?></td>
                <td><?php echo htmlentities($result->gender); ?></td>
                <td><?php echo htmlentities($result->age); ?></td>
                <td><?php echo htmlentities($result->FromDate); ?> / <?php echo htmlentities($result->ToDate); ?></td>
                <td><?php echo htmlentities($result->PickupTime); ?> / <?php echo htmlentities($result->ReturnTime); ?></td>
                <td><?php echo htmlentities($result->selectedLocation); ?></td>
                <td>
                    <span style="color: green; border: 1px solid green; background-color: #e0ffe0; border-radius: 5px; padding: 5px;">
                        <?php echo htmlentities($result->bookingCode); ?>
                    </span>
                </td>
                <td><?php echo htmlentities($result->totalprice); ?></td>
                <td><?php echo htmlentities($result->hours); ?></td>
                <td><div id="<?php echo $countdownId; ?>" style="color: red; font-weight: bold;"></div></td>
                <td>
<a href="manage-noaccount_booking.php?del=<?php echo $result->noaccbookinginfo_ID; ?>" 
   onclick="return confirm('Do you want to delete this Booking?');" 
   class="btn btn-danger btn-sm">                            <button class="fritzannbtn">
                                <p class="paragraph">delete</p>
                                <span class="icon-wrapper">
                                    <svg class="icon" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            </button>
                        </a>
                    </td>

     <script>
(function () {
    function parseTimeFromDB(timeString) {
        // Parse hours and minutes from timeString
        const hoursMatch = timeString.match(/(\d+)\s*(?:hour|hr|h)/i);
        const minutesMatch = timeString.match(/(\d+)\s*(?:minute|min|m)/i);
        
        let totalMilliseconds = 0;

        if (hoursMatch) {
            const hours = parseInt(hoursMatch[1]);
            totalMilliseconds += hours * 60 * 60 * 1000; // Convert hours to milliseconds
        }

        if (minutesMatch) {
            const minutes = parseInt(minutesMatch[1]);
            totalMilliseconds += minutes * 60 * 1000; // Convert minutes to milliseconds
        }

        return totalMilliseconds;
    }

    // Retrieve data from the server
    var bookingTimeFromDB = "<?php echo htmlentities($result->hours); ?>";
    var countdownElementId = "<?php echo $countdownId; ?>";

    // Parse the total countdown time
    var countdownMs = parseTimeFromDB(bookingTimeFromDB);

    if (countdownMs <= 0) {
        document.getElementById(countdownElementId).innerHTML = "Invalid Time";
        return;
    }

    // Create a unique key for localStorage based on the countdown ID
    var localStorageKey = "countdown_" + countdownElementId;

    // Retrieve stored data or initialize
    var localStorageData = localStorage.getItem(localStorageKey);
    var countDownDate;

    if (localStorageData) {
        try {
            var localStorageObj = JSON.parse(localStorageData);
            countDownDate = localStorageObj.countDownDate;
        } catch (error) {
            console.error("Error parsing localStorage data:", error);
            countDownDate = new Date().getTime() + countdownMs;
        }
    } else {
        countDownDate = new Date().getTime() + countdownMs;
        localStorage.setItem(localStorageKey, JSON.stringify({ countDownDate }));
    }

    // Update the countdown every second
    var intervalId = setInterval(function () {
        var now = new Date().getTime();
        var distance = countDownDate - now;

        if (distance < 0) {
            clearInterval(intervalId);
            document.getElementById(countdownElementId).innerHTML = "EXPIRED";
            localStorage.setItem(localStorageKey, JSON.stringify({
                countDownDate: 0,
                expired: true
            }));
            return;
        }

        // Calculate hours, minutes, and seconds
        var hours = Math.floor(distance / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Format the countdown display
        var formattedTime = '';
        if (hours > 0) {
            formattedTime += String(hours).padStart(2, '0') + ":";
        }
        formattedTime += String(minutes).padStart(2, '0') + ":" + String(seconds).padStart(2, '0');

        document.getElementById(countdownElementId).innerHTML = formattedTime;

        // Continuously update localStorage with the new countdown date
        localStorage.setItem(localStorageKey, JSON.stringify({
            countDownDate: countDownDate
        }));
    }, 1000);
})();
</script>



            </tr>
   										<?php $cnt=$cnt+1; }} ?>

</tbody>

    </table>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>   
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

