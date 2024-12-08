<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
}
?>


<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>FritzAnn Shuttle Services |Car-listing</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/carlisting.css" rel="stylesheet">
    <link href="assets/css/car-listing2.css" rel="stylesheet">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
 .custom-vehicle-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}

.custom-vehicle-item {
    display: flex;
    align-items: center;
    margin-right: 0;
    color: white;
}

/* Responsive Styling */
@media (max-width: 768px) {
    .custom-vehicle-list {
        display: flex;
        flex-direction: row;
        overflow-x: auto;
        white-space: nowrap;
        padding: 0;
        margin: 0;
        gap: 10px;
    }

    .custom-vehicle-item {
        flex: 0 0 auto;
        display: inline-block;
        font-size: 12px;
    }

    .custom-vehicle-list::-webkit-scrollbar {
        height: 6px;
    }

    .custom-vehicle-list::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.5);
        border-radius: 3px;
    }
}

</style>
<body>
    <?php include('includes/header.php');?>
    <section class="page-header listing_page">
        <div class="container">
            <div class="page-header_wrap">
                <div class="page-heading">
                    <h1>Car Listing</h1>
                </div>
                <ul class="coustom-breadcrumb">
                </ul>
            </div>
        </div>
        <div class="dark-overlay"></div>
    </section>
    <div class="container car-listing">
    <form action="car-listing.php" method="GET" class="car-filter-form">
        <div class="row">
            <div class="col-md-3">
                <h2 style="font-size: 13px;">Select Body Type</h2>
                <select name="body_type" class="form-control" style="font-size: 13px;">
                    <option value="">Select Body Type</option>
                    <?php
$ret = "SELECT DISTINCT bodytype FROM friztann_vehicles";
$query = $dbh->prepare($ret);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        echo "<option value='" . htmlspecialchars($result->bodytype) . "'>" . htmlspecialchars($result->bodytype) . "</option>";
    }
}
?>


                </select>
            </div>
            <div class="col-md-3">
                <h2 style="font-size: 13px;">Enter Price</h2>
                <input type="text" name="price" class="form-control" placeholder="Enter Price" style="font-size: 13px;">
            </div>
            <div class="col-md-3">
                <h2 style="font-size: 13px;">Select Brand</h2>
                <select name="brand" class="form-control" style="font-size: 13px;">
                    <option value="">Select Brand</option>
                    <?php
                    $ret = "SELECT brand_id, BrandName FROM friztann_brands";
                    $query = $dbh->prepare($ret);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                            echo "<option value='" . htmlspecialchars($result->brand_id) . "'>" . htmlspecialchars($result->BrandName) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <h2 style="font-size: 13px;">Select Fuel Type</h2>
                <select name="fuel_type" class="form-control" style="font-size: 13px;">
                    <option value="">Select Fuel Type</option>
                    <?php
$ret = "SELECT DISTINCT FuelType FROM friztann_vehicles";
$query = $dbh->prepare($ret);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        echo "<option value='" . htmlspecialchars($result->FuelType) . "'>" . htmlspecialchars($result->FuelType) . "</option>";
    }
}
?>


                </select>
            </div>


            
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block" style="font-size: 10px;">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
        </div>
    </form>
    <br>
    <div class="row">
    <?php
        // Base SQL Query
        $sql = "SELECT v.VehiclesTitle, b.BrandName, b.BrandLogo, v.PricePerDay, v.FuelType, 
                       v.bodytype, v.TransmissionType, v.vehicle_id, v.SeatingCapacity, v.STATUS, v.vimage0
                FROM friztann_vehicles v
                JOIN friztann_brands b ON b.brand_id = v.VehiclesBrand
                WHERE v.STATUS != 'MAINTENANCE'";

        $conditions = [];
        $params = [];

        // Filter by body type
        if (!empty($_GET['body_type'])) {
            $conditions[] = "v.bodytype = :bodyType";
            $params[':bodyType'] = $_GET['body_type'];
        }

        // Filter by price
        if (!empty($_GET['price'])) {
            $conditions[] = "v.PricePerDay <= :price";
            $params[':price'] = $_GET['price'];
        }

        // Filter by brand
        if (!empty($_GET['brand'])) {
            $conditions[] = "v.VehiclesBrand = :brand";
            $params[':brand'] = $_GET['brand'];
        }

        // Filter by fuel type
        if (!empty($_GET['fuel_type'])) {
            $conditions[] = "v.FuelType = :fuelType";
            $params[':fuelType'] = $_GET['fuel_type'];
        }

        // Apply filters to the query
        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }

        // Execute query
        $query = $dbh->prepare($sql);
        $query->execute($params);
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        // Display results
        if ($query->rowCount() > 0) {
            foreach ($results as $result) {
                ?>
        <div class="col-md-4 col-sm-6">
            <div class="recent-car-list">
                <div class="car-info-box">
                    <a href="car-details.php?vhid=<?php echo htmlentities($result->vehicle_id); ?>">
                        <img src="admin/img/vehicleimages/<?php echo htmlentities($result->vimage0); ?>" class="img-responsive" alt="image">
                        <img src="admin/img/brand/<?php echo htmlentities($result->BrandLogo); ?>" class="brand-logo" alt="brand-logo">
                    </a>
                </div>
                <div class="car-title-m">
                    <h6 class="car-title-m">
                        <a href="car-details.php?vhid=<?php echo htmlentities($result->vehicle_id); ?>">
                            <span class="brand"><?php echo htmlentities($result->BrandName); ?></span> 
                            <span class="title"><?php echo htmlentities($result->VehiclesTitle); ?></span>
                        </a>
                    </h6>
                    <div class="car-location">
                        <i class="fa fa-map-marker" aria-hidden="true"></i> Blk 2, Baldostamon Subd, Poblacion, Koronadal City, 9506 South Cotabato
                    </div>
                    <div class="car-status">
                        <span class="badge badge-danger">FritzAnn Shuttle Services</span>
                    </div>
                    <div class="car-details">
    <ul class="custom-vehicle-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
    <li class="custom-vehicle-item" style="display: flex; align-items: center; margin-right: 0; color: white;">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 128 128" aria-hidden="true" style="margin-right: 5px;">
            <path fill="none" stroke="#616161" stroke-miterlimit="10" stroke-width="6" d="M79.69 62.69c7.36 15.65 30.45 32.94 32.41 42.77c1.34 6.7-3.33 12.26-9.19 11.2c-6.6-1.19-6.91-10.69-4.31-17.99c6.54-18.38 8.79-28.99 6.53-38.95l-1.08-4.68"/>
            <path fill="#82aec0" d="M80.82 56.1c-1.87 0-1.14-1.61-1.14-3.6V25.92c0-1.99-.73-3.6 1.14-3.6s5.12 1.11 5.12 3.6V52.5c0 1.99-3.25 3.6-5.12 3.6"/>
            <path fill="#f44336" d="M82.1 113.93V27.96C82.1 14.73 71.37 4 58.14 4H34.96C21.72 4 11 14.73 11 27.96v85.97c-3.3.97-5.71 4.02-5.71 7.63v.3c0 1.18.96 2.14 2.14 2.14h78.24c1.18 0 2.14-.96 2.14-2.14v-.3a7.95 7.95 0 0 0-5.71-7.63"/>
            <path fill="#fff" d="M65.68 56.57H26.93c-1.77 0-3.21-1.44-3.21-3.21V22.42c0-1.77 1.44-3.21 3.21-3.21h38.75c1.77 0 3.21 1.44 3.21 3.21v30.93a3.21 3.21 0 0 1-3.21 3.22"/>
            <path fill="#9e9e9e" d="M32.22 29.6h29.31v7.64H32.22zm0 11.76h29.31V49H32.22z"/>
            <path fill="#82aec0" d="M24.13 47c-.05.52-.81.52-.86.01c-.74-7.27-1.16-14.55-1.48-21.82c-.47-4.02 2.63-7.49 6.78-7.21c11.79-.35 23.64-.35 35.43-.01c4.14-.28 7.27 3.19 6.79 7.21c-.32 7.28-.75 14.57-1.49 21.85c-.05.52-.81.52-.86 0c-.77-7.53-1.19-15.07-1.53-22.59a2 2 0 0 0-.09-.45c-.25-.9-1.12-1.65-2.02-1.56c-.48.02-36.58.01-37.04-.01c-.9-.09-1.77.66-2.02 1.57q-.06.225-.09.45c-.34 7.51-.75 15.04-1.52 22.56"/>
            <ellipse cx="46.31" cy="84.08" fill="#f5f5f5" rx="16.79" ry="17.89"/>
            <path fill="#212121" d="M38.87 86.6c0-4.37 7.43-12.95 7.43-12.95s7.43 8.58 7.43 12.95s-3.33 7.92-7.43 7.92s-7.43-3.55-7.43-7.92"/>
            <path fill="#c62828" d="M11 110.03h71.1v3.89H11z"/>
            <path fill="none" stroke="#ff7555" stroke-linecap="round" stroke-miterlimit="10" stroke-width="5" d="M17.45 22.04c.88-4.96 5.2-11.1 14.13-11.1"/>
            <path fill="#9e9e9e" d="m108.06 58.98l-5.796 1.472l-.955-3.76l5.795-1.473zm-3.29-29.13l6.73-12.2c.5-.9 1.16-1.7 1.95-2.35c2.46-2.02 7.97-6.58 9.13-7.84c1.51-1.64-1.29-5.1-3.28-3.73c-1.56 1.08-7.3 6.12-9.69 8.23c-.7.61-1.28 1.34-1.73 2.16l-7.07 12.82z"/>
            <path fill="#757575" d="m100.66 37.73l9.42-1.95l3.32 11.82c.53 2.08-.43 2.68-2.27 3.15l-6.66 1.85m-5.22-15.27l8.05 18.35l7.62-2.13c3.19-.93 3.1-3.53 2.61-5.46l-3.93-14.4z"/>
            <path fill="#f44336" d="m103.82 21.12l4.87 2.74c.65.36.89 1.17.56 1.83l-.97 1.94l2.25 1.7a8.57 8.57 0 0 1 3.16 4.77l.27 1.05l-6.96 1.79a2.74 2.74 0 0 0-1.95 3.34l3.21 12.63c.32 1.36.4 2.48-.97 2.78l-5.55 1.38c-1.32.29-2.63-.52-2.96-1.83L94.9 39.95c-1.74-6.85.94-9.17 1.5-10.3s3.5-4.21 3.5-4.21l2.01-3.76c.37-.69 1.23-.94 1.91-.56"/>
            <path fill="none" stroke="#ff7555" stroke-linecap="round" stroke-miterlimit="10" stroke-width="4" d="m106.8 29.34l-4.83-2.42"/>
        </svg>
        <?php echo htmlentities($result->FuelType); ?>
    </li>
    <li class="custom-vehicle-item" style="display: flex; align-items: center; margin-right: 0; color: white;">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" style="margin-right: 5px;">
        <path fill="#e00000" d="M21.907 9.641a1.1 1.1 0 0 0-.088-1.05c-.27-.519-2.14-.647-2.056-.033c.034.248.1.416-.206.446a2.4 2.4 0 0 1-.137-.317l-.53-1.627a2.65 2.65 0 0 0-1.282-1.5l-.373-.2A3.9 3.9 0 0 0 15.4 4.9H8.605a3.9 3.9 0 0 0-1.837.457l-.372.2a2.65 2.65 0 0 0-1.282 1.5L4.58 8.682A2.4 2.4 0 0 1 4.444 9c-.308-.03-.241-.2-.207-.446c.084-.614-1.786-.486-2.056.033a1.1 1.1 0 0 0-.088 1.05a2.16 2.16 0 0 0 1.721.287l-1.079 1.317a2.1 2.1 0 0 0-.578 1.459l.029 5.364A1.083 1.083 0 0 0 3.3 19.1h1.644a.5.5 0 0 0 .516-.475v-.021L5.432 17.4h13.142l-.029 1.21a.5.5 0 0 0 .5.5h1.664a1.083 1.083 0 0 0 1.116-1.04l.03-5.364a2.1 2.1 0 0 0-.578-1.459l-1.091-1.324a2.16 2.16 0 0 0 1.721-.282M5.388 8.9a3.18 3.18 0 0 1 3.279-3.07h6.666a3.183 3.183 0 0 1 3.281 3.076v.45a.125.125 0 0 1-.125.124H5.512a.124.124 0 0 1-.124-.124Zm1.393 4.029a.25.25 0 0 1-.205.115h-3.06c-.136 0-.418-.062-.418-.475l.207-1.069c.071-.372.806-.351 1.133-.156L6.7 12.591a.25.25 0 0 1 .081.342zM20.7 11.5l.207 1.073c0 .413-.282.475-.418.475h-3.06a.247.247 0 0 1-.124-.457l2.266-1.247c.318-.195 1.053-.218 1.129.156"/>
    </svg>
    <?php echo htmlentities($result->bodytype); ?>
</li>
<li class="custom-vehicle-item" style="display: flex; align-items: center; margin-right: 0; color: white;">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" style="margin-right: 5px;">
        <g fill="none" stroke="#e00000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3">
            <path fill="#e00000" fill-opacity="0" stroke-dasharray="48" stroke-dashoffset="48" d="M11 9h6v10h-6.5l-2 -2h-2.5v-6.5l1.5 -1.5Z">
                <animate fill="freeze" attributeName="fill-opacity" begin="1.95s" dur="0.75s" values="0;1"/>
                <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.9s" values="48;0"/>
            </path>
            <path fill="#e00000" fill-opacity="0" d="M17 13h0v-3h0v8h0v-3h0z" opacity="0">
                <animate fill="freeze" attributeName="d" begin="0.9s" dur="0.3s" values="M17 13h0v-3h0v8h0v-3h0z;M17 13h4v-3h1v8h-1v-3h-4z"/>
                <set fill="freeze" attributeName="fill-opacity" begin="1.2s" to="1"/>
                <set fill="freeze" attributeName="opacity" begin="0.9s" to="1"/>
            </path>
            <path d="M6 14h0M6 11v6" opacity="0">
                <animate fill="freeze" attributeName="d" begin="1.2s" dur="0.3s" values="M6 14h0M6 11v6;M6 14h-4M2 11v6"/>
                <set fill="freeze" attributeName="opacity" begin="1.2s" to="1"/>
            </path>
            <path d="M11 9v0M8 9h6" opacity="0">
                <animate fill="freeze" attributeName="d" begin="1.5s" dur="0.3s" values="M11 9v0M8 9h6;M11 9v-4M8 5h6"/>
                <set fill="freeze" attributeName="opacity" begin="1.5s" to="1"/>
            </path>
        </g>
    </svg>
    <?php echo htmlentities($result->TransmissionType); ?>
</li>
<li class="custom-vehicle-item" style="display: flex; align-items: center; margin-right: 0; color: white;">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="#f50000" d="M12 2a2 2 0 0 1 2 2c0 1.11-.89 2-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m.39 12.79a34 34 0 0 1 4.25.25c.06-2.72-.18-5.12-.64-6.04c-.13-.27-.31-.5-.5-.7l-8.07 6.92c1.36-.22 3.07-.43 4.96-.43M7.46 17c.13 1.74.39 3.5.81 5h2.07c-.29-.88-.5-1.91-.66-3c0 0 2.32-.44 4.64 0c-.16 1.09-.37 2.12-.66 3h2.07c.44-1.55.7-3.39.83-5.21a35 35 0 0 0-4.17-.25c-1.93 0-3.61.21-4.93.46M12 7S9 7 8 9c-.34.68-.56 2.15-.63 3.96l6.55-5.62C12.93 7 12 7 12 7m6.57-1.33l-1.14-1.33l-3.51 3.01c.55.19 1.13.49 1.58.95zm2.1 10.16c-.09-.03-1.53-.5-4.03-.79c-.01.57-.04 1.16-.08 1.75c2.25.28 3.54.71 3.56.71zm-13.3-2.87l-3.94 3.38l.89 1.48c.02-.01 1.18-.46 3.14-.82c-.11-1.41-.14-2.8-.09-4.04"/>
    </svg>
    <?php echo htmlentities($result->SeatingCapacity); ?> seats
</li>
    </ul>
</div>
<div class="price">
    <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512">
            <path fill="#131111" d="M448 183.8v-123A44.66 44.66 0 0 0 403.29 16H280.36a30.62 30.62 0 0 0-21.51 8.89L13.09 270.58a44.86 44.86 0 0 0 0 63.34l117 117a44.84 44.84 0 0 0 63.33 0l245.69-245.61A30.6 30.6 0 0 0 448 183.8M352 144a32 32 0 1 1 32-32a32 32 0 0 1-32 32"/>
            <path fill="#131111" d="M496 64a16 16 0 0 0-16 16v127.37L218.69 468.69a16 16 0 1 0 22.62 22.62l262-262A29.84 29.84 0 0 0 512 208V80a16 16 0 0 0-16-16"/>
        </svg>
        <?php echo htmlentities($result->PricePerDay); ?> PER 24 HOURS
    </span><br>
    <span class="service-fee"></span>
    <div class="total-price"></div>
</div>
                    <div class="select-button">
                        <a href="car-details.php?vhid=<?php echo htmlentities($result->vehicle_id); ?>">
                        <button class="btn btn-primary" style="background-color: black; color: white; border: 2px solid white;">VIEW DETAILS</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<div class='col-md-12'><p>No cars available for the selected criteria.</p></div>";
        }
        ?>

    </div>
</div>
<?php include('includes/footer.php');?>
    <div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
    <?php include('includes/login.php');?>
<?php include('includes/registration.php');?>
<?php include('includes/forgotpassword.php');?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>
