<?php
session_start();
include('includes/config.php');

$error = "";
$msg = "";

if (isset($_POST['update'])) {
    try {
        $id = $_POST['booking_info_id'];
        $driverId = $_POST['DriverId'];

        $sql = "UPDATE friztann_bookinginfo SET DriverId = :driverId WHERE booking_info_id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':driverId', $driverId, PDO::PARAM_INT);
        $query->execute();

        $msg = "Driver updated successfully";
    } catch (PDOException $e) {
        $error = "Update failed: " . $e->getMessage();
    }
}

if (isset($_GET['booking_id'])) {
    $booking_id = intval($_GET['booking_id']);
    
    try {
        $sql = "SELECT 
        friztann_users.FirstName,
        friztann_users.MiddleName,
        friztann_users.LastName,
        friztann_users.ProfileImg,
        friztann_users.ContactNo,
        friztann_bookinginfo.NeedDriver,
        friztann_bookinginfo.DriverId,
        friztann_bookinginfo.selectedLocation,
        friztann_bookinginfo.totalprice,
        friztann_bookinginfo.booking_info_id,
        friztann_bookinginfo.paymentproof,
        friztann_payments.proof_path,
        friztann_drivers.DriverName
    FROM 
        friztann_bookinginfo
    JOIN 
        friztann_users ON friztann_users.EmailId = friztann_bookinginfo.useremail
    LEFT JOIN 
        friztann_payments ON friztann_bookinginfo.booking_id = friztann_payments.booking_id
    LEFT JOIN 
        friztann_drivers ON friztann_bookinginfo.DriverId = friztann_drivers.driver_id
    WHERE 
        friztann_bookinginfo.booking_id = :booking_id";

        
        $query = $dbh->prepare($sql);
        $query->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if (!$result) {
            $error = "No booking found for the provided ID.";
        }
    } catch (PDOException $e) {
        $error = "Query failed: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FritzAnn Shuttle Services | View Payments</title>
        <link rel="apple-touch-icon" sizes="144x144" href="img/favicon-icon/apple-touch-icon-144.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/favicon-icon/apple-touch-icon-114.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/favicon-icon/apple-touch-icon-72.png">
<link rel="apple-touch-icon" href="img/favicon-icon/apple-touch-icon-57.png">
<link rel="shortcut icon" href="img/favicon-icon/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/error-succ.css">
</head>
<style>
    :root {
    --primary-color: #ff0000;
    --secondary-color: #1a1a1a;
    --accent-color: #aa0000;
    --text-color: #ffffff;
    --background-dark: #000000;
    --background-light: #0a0a0a;
    --border-color: #333333;
}

body {
    background-color: var(--background-dark);
    color: var(--text-color);
    font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
    margin: 0;
    padding: 20px;
    line-height: 1.6;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

.back-button {
    background-color: var(--secondary-color);
    color: var(--text-color);
    border: 1px solid var(--primary-color);
    padding: 10px 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    margin-bottom: 30px;
    transition: background-color 0.3s;
}

.back-button:hover {
    background-color: var(--accent-color);
    color: var(--text-color);
}

.main-card {
    background-color: var(--background-light);
    border: 1px solid var(--border-color);
    padding: 30px;
    border-radius: 8px;
}

.page-title {
    color: var(--primary-color);
    font-size: 2rem;
    margin-bottom: 30px;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 10px;
}




.profile-section {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 30px;
    padding: 1px;
    background-color: var(--secondary-color);
    border-radius: 8px;
}

.profile-img, .profile-img-default {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 2px solid var(--primary-color);
    object-fit: cover;
}

.profile-img-default {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--accent-color);
    font-size: 2rem;
}

.booking-details {
    margin-bottom: 30px;
    padding: 20px;
    background-color: var(--secondary-color);
    border-radius: 8px;
}

.booking-details h5 {
    color: var(--primary-color);
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.detail-item {
    padding: 15px;
    background-color: var(--background-dark);
    border: 1px solid var(--border-color);
    border-radius: 4px;
}

.detail-item strong {
    color: var(--primary-color);
    display: block;
    margin-bottom: 5px;
}

.payment-section {
    background-color: var(--secondary-color);
    padding: 20px;
    border-radius: 8px;
}

.payment-section h5 {
    color: var(--primary-color);
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.payment-proof-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.proof-box {
    background-color: var(--background-dark);
    padding: 15px;
    border-radius: 4px;
    text-align: center;
}

.proof-box img {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    border: 1px solid var(--primary-color);
}

.driver-form {
    background-color: var(--background-dark);
    padding: 20px;
    border-radius: 4px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
}

select {
    width: 100%;
    padding: 12px;
    background-color: var(--secondary-color);
    color: var(--text-color);
    border: 1px solid var(--primary-color);
    border-radius: 4px;
}

select:focus {
    outline: none;
    border-color: var(--accent-color);
}

.submit-button {
    background-color: var(--primary-color);
    color: var(--text-color);
    border: none;
    padding: 12px 24px;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    width: 100%;
    border-radius: 4px;
}

.submit-button:hover {
    background-color: var(--accent-color);
}

@media (max-width: 768px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .payment-proof-container {
        grid-template-columns: 1fr;
    }
    
    .profile-section {
        flex-direction: column;
        text-align: center;
    }
}
    </style>
</head>
<body>
    <div class="container">
        <button class="back-button" onclick="window.location.href='manage-bookings.php';">
            <span>Back to Bookings</span>
        </button>

        <div class="main-card">
            <h2 class="page-title">User Payments</h2>
            
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

            <div class="profile-section">
                <?php if (!empty($result->ProfileImg) && file_exists('avatar/' . basename($result->ProfileImg))) : ?>
                    <img src="avatar/<?php echo htmlentities(basename($result->ProfileImg)); ?>" alt="Profile Image" class="profile-img">
                <?php else : ?>
                    <div class="profile-img-default">👤</div>
                <?php endif; ?>
                <h3><?php echo htmlentities(trim($result->FirstName)) . ' ' . htmlentities(trim($result->MiddleName)) . ' ' . htmlentities(trim($result->LastName)); ?> <p><?php echo htmlentities($result->ContactNo); ?></p>
                </h3>
            </div>

            <div class="booking-details">
                <h5> Booking Details</h5>
                <div class="detail-item">
                    <strong>Need Driver:</strong>
                    <?php echo htmlentities($result->NeedDriver); ?>
                </div>
                <div class="detail-item">
    <strong>Driver Name:</strong>
    <?php echo htmlentities($result->DriverName); ?>

</div>

                <div class="detail-item">
                    <strong>Selected Location:</strong>
                    <?php echo htmlentities($result->selectedLocation); ?>
                </div>
                <div class="detail-item">
                    <strong>Total Price:</strong>
                    <?php echo htmlentities($result->totalprice); ?>
                </div>
            </div>

            <div class="payment-section">
                <h5> Payment Proofs</h5>
                <div class="payment-proof-container">
                    <div class="proof-box">
                        <?php if (!empty($result->paymentproof) && file_exists('img/payments/' . basename($result->paymentproof))) : ?>
                            <a href="img/payments/<?php echo htmlentities(basename($result->paymentproof)); ?>" data-lightbox="image-<?php echo htmlentities($result->booking_info_id); ?>">
                                <img src="img/payments/<?php echo htmlentities(basename($result->paymentproof)); ?>" alt="Payment Proof">
                            </a>
                        <?php else : ?>
                            <p class="text-danger">Payment proof not available</p>
                        <?php endif; ?>
                    </div>
                    <div class="proof-box">
                        <?php if (!empty($result->proof_path) && file_exists('img/payments/' . basename($result->proof_path))) : ?>
                            <a href="img/payments/<?php echo htmlentities(basename($result->proof_path)); ?>" data-lightbox="image-<?php echo htmlentities($result->booking_info_id); ?>">
                                <img src="img/payments/<?php echo htmlentities(basename($result->proof_path)); ?>" alt="Balance Payment Proof">
                            </a>
                        <?php else : ?>
                            <p class="text-danger">Balance payment proof not available</p>
                        <?php endif; ?>
                    </div>
                </div>

                <form method="post" action="" class="driver-form">
                    <input type="hidden" name="booking_info_id" value="<?php echo htmlentities($result->booking_info_id); ?>">
                    <div class="form-group">
                        <label for="DriverId"> Select Driver</label>
                        <select name="DriverId" required>
    <?php
        $Driver_query = "SELECT * FROM friztann_drivers";
        $Driver_stmt = $dbh->prepare($Driver_query);
        $Driver_stmt->execute();
        $Drivers = $Driver_stmt->fetchAll(PDO::FETCH_ASSOC);

        $currentDriverId = isset($result->DriverId) ? $result->DriverId : null;

        foreach ($Drivers as $Driver) {
            $selected = ($Driver['driver_id'] == $currentDriverId) ? "selected" : "";
            echo "<option value='" . htmlentities($Driver['driver_id']) . "' $selected>" . htmlentities($Driver['DriverName']) . "</option>";
        }
    ?>
</select>

                    </div>
                    <button type="submit" name="update" class="submit-button">Update Driver</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
