<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin']) == 0)
{	
    header('location:index.php');
    exit();  
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
	
	<title>FritzAnn Shuttle Services |Admin Manage Payment  </title>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <h2 class="page-title">Payment</h2>
            <div class="dashboard-grid">
            <?php
try {
    $sql = "
        SELECT 
            'NOACCOUNT' AS source,
            SUM(CAST(totalprice AS DECIMAL(10,2))) AS total_price 
        FROM friztann_noaccbookinginfo
        
        UNION ALL
        
        SELECT 
            'USER' AS source,
            SUM(totalprice) + 500 AS total_price 
        FROM friztann_bookinginfo
        
        UNION ALL
        
        SELECT 
            'WALKIN' AS source,
            SUM(totalPrice) AS total_price 
        FROM friztann_walkin
    ";

    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if (!$results) {
        echo "<div class='alert alert-warning'>No data found.</div>";
    } else {
        $grandTotal = 0;
        $dataPoints = [];

        foreach ($results as $result) {
            $grandTotal += $result->total_price;
            $dataPoints[] = ['source' => $result->source, 'total_price' => $result->total_price];
            $remainingTotal = 100000; 
            $percentage = ($result->total_price / ($result->total_price + $remainingTotal)) * 100;

            echo "
                <div class='card'>
                    <div class='chart-details'>
                        <div class='chart-detail'>
                            <div class='chart-detail-label'>Income</div>
                            <div class='chart-detail-value'>₱" . htmlentities(number_format($result->total_price, 2)) . "</div>
                        </div>
                        <div class='chart-detail'>
                            <div class='chart-detail-label'>Remaining</div>
                            <div class='chart-detail-value'>₱" . htmlentities(number_format($remainingTotal, 2)) . "</div>
                        </div>
                        <div class='chart-detail'>
                            <div class='chart-detail-label'>Percentage</div>
                            <div class='chart-detail-value'>" . htmlentities(number_format($percentage, 2)) . "%</div>
                        </div>
                    </div>
                    <div class='chart-container'>
                        <canvas id='chart-{$result->source}'></canvas>
                    </div>
                    <div class='chart-label'>{$result->source}</div>
                </div>
            ";
        }

        echo "
            <div class='grand-total-container'>
                <div class='grand-total-row'>
                    <span class='grand-total-label'>Total Income</span>
                    ₱" . htmlentities(number_format($grandTotal, 2)) . "
                </div>
            </div>
        ";
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Query failed: " . $e->getMessage() . "</div>";
}
?>

            </div>
        </div>
    </div>
    <div id="zctb-wrapper">
    <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Car</th>
            <th>Payment</th>
            <th>Balance</th>
            <th>Total Price</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Car</th>
            <th>Payment</th>
            <th>Balance</th>
            <th>Total Price</th>
        </tr>
    </tfoot>
    <tbody>
    <?php 
try {
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
        friztann_booking.vehicle_id AS vid,
        friztann_booking.Status,
        friztann_booking.PostingDate,
        friztann_booking.booking_id,
        friztann_bookinginfo.totalprice,
        friztann_bookinginfo.paymentproof,
        friztann_payments.proof_path
    FROM 
        friztann_booking 
    JOIN 
        friztann_vehicles ON friztann_vehicles.Vehicle_id = friztann_booking.vehicle_id 
    JOIN 
        friztann_users ON friztann_users.EmailId = friztann_booking.userEmail 
    JOIN 
        friztann_bookinginfo ON friztann_bookinginfo.booking_id = friztann_booking.booking_id
    JOIN 
        friztann_brands ON friztann_vehicles.VehiclesBrand = friztann_brands.brand_id
    LEFT JOIN 
        friztann_payments ON friztann_payments.booking_id = friztann_booking.booking_id";
    
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $fullName = htmlentities($result->FirstName . ' ' . $result->MiddleName . ' ' . $result->LastName);
?>
            <tr>
                <td><?php echo htmlentities($cnt); ?></td>
                <td><?php echo $fullName; ?></td>
                <td><?php echo htmlentities($result->VehiclesTitle); ?></td>
                <td>
                    <?php if (!empty($result->paymentproof)) : ?>
                        <span class="paid">Paid</span>
                    <?php else : ?>
                        <span class="unpaid">Unpaid</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!empty($result->proof_path)) : ?>
                        <span class="paid">Paid</span>
                    <?php else : ?>
                        <span class="unpaid">Unpaid</span>
                    <?php endif; ?>
                </td>
                <td>₱<?php echo htmlentities($result->totalprice + 500); ?></td>
            </tr>
<?php 
            $cnt++;
        }
    } else {
        echo "<tr><td colspan='5'>No bookings found</td></tr>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

    </tbody>
</table>
</div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dataPoints = <?php echo json_encode($dataPoints); ?>;
        const grandTotal = <?php echo $grandTotal; ?>;

        dataPoints.forEach((dataPoint) => {
            const ctx = document.getElementById(`chart-${dataPoint.source}`).getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Income', 'Remaining'],
                    datasets: [{
                        data: [dataPoint.total_price, 100000], 
                        backgroundColor: ['#e63946', '#FFFFFF'],
                        borderColor: ['black', 'black'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '75%',
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        });
    </script>
        <script>
    document.addEventListener('DOMContentLoaded', function() {
        var table = document.getElementById('zctb');
        var headers = table.querySelectorAll('thead th');
        var rows = table.querySelectorAll('tbody tr');

        rows.forEach(function(row) {
            var cells = row.querySelectorAll('td');
            cells.forEach(function(cell, index) {
                cell.setAttribute('data-label', headers[index].textContent);
            });
        });
    });
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