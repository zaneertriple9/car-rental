<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
    exit;
}

if(isset($_GET['del'])) {
  $id = $_GET['del'];
  $sql = "DELETE FROM friztann_drivers WHERE driver_id=:id";
  $query = $dbh->prepare($sql);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  $msg = "Brand deleted successfully";
}


if (isset($_POST['signup'])) {
    $EmailId = $_POST['EmailId'];
    $DriverName = $_POST['DriverName'];
    $gender = $_POST['Gender'];
    $contactNo = $_POST['ContactNo'];

    try {
        $sql = "INSERT INTO friztann_drivers (DriverName, Gender, EmailId, ContactNo) 
                VALUES (:DriverName, :Gender, :EmailId, :ContactNo)";
        $query = $dbh->prepare($sql);

        $query->bindParam(':DriverName', $DriverName, PDO::PARAM_STR);
        $query->bindParam(':Gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':EmailId', $EmailId, PDO::PARAM_STR);
        $query->bindParam(':ContactNo', $contactNo, PDO::PARAM_STR);

        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            echo "<script>alert('Registration successful'); window.location.href = 'register-driver.php';</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }

    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
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

<title>FritzAnn Shuttle Services  | Admin Register Driver</title>
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
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
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

.name-input {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .name-segments {
        display: flex;
        border: 1px solid #ccc;
        border-radius: 4px;
        overflow: hidden;
    }

    .segment {
        flex: 1;
        padding: 10px;
        border: none;
        outline: none;
        text-align: center;
    }

    .segment:not(:last-child) {
        border-right: 1px solid #ccc;
    }
    
    .segment::placeholder {
        color: #aaa;
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
    <h2 class="page-title" style="text-align: center; background-color: #f0f0f0; padding: 10px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 0 auto; width: fit-content; margin-bottom: 20px;">
        <button id="openModalBtn" class="primary-button">Add Driver</button>
    </h2>
</div>

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
                <th>Full Name</th>
                <th>Gender</th>
                <th>Email ID</th>
                <th>Contact Number</th>
                <th>Registration Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Email ID</th>
                <th>Contact Number</th>
                <th>Registration Date</th>
                <th>Action</th>
            </tr>
        </tfoot>
        <tbody>
            <?php
            $sql = "SELECT driver_id, DriverName, Gender, EmailId, ContactNo, RegDate FROM friztann_drivers";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt=1;
            if ($query->rowCount() > 0) {
                foreach ($results as $result) { ?>
                    <tr>
                        <td><?php echo htmlentities($cnt);?></td>
                        <td><?php echo htmlentities($result->DriverName); ?></td>
                        <td><?php echo htmlentities($result->Gender); ?></td>
                        <td><?php echo htmlentities($result->EmailId); ?></td>
                        <td><?php echo htmlentities($result->ContactNo); ?></td>
                        <td><?php echo htmlentities($result->RegDate); ?></td>
                        <td>
                            <a href="register-driver.php?del=<?php echo $result->driver_id; ?>" onclick="return confirm('Do you want to delete this driver?');" class="btn btn-danger btn-sm">
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
            <?php }
            } ?>
        </tbody>
    </table>
</div>

<!-- Modal Structure -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        
        <h2 class="page-title">Register Driver</h2>
        
        <form method="post" enctype="multipart/form-data" class="custom22-form">
            <div class="custom22-form-group">
                <!-- Error and Success Messages -->
                <?php if ($error) { ?>
                <div class="errorWrap">ERROR: <?php echo htmlentities($error); ?></div>
                <?php } else if ($msg) { ?>
                <div class="succWrap">SUCCESS: <?php echo htmlentities($msg); ?></div>
                <?php } ?>
                
                <!-- DriverName -->
                <div class="name-input">
    <label for="DriverName">Full Name</label>
    
    <!-- Separate inputs for visual sections -->
    <div class="name-segments">
        <input type="text" id="FirstName" class="segment" placeholder="FirstName" oninput="updateFullName()" required>
        <input type="text" id="MiddleName" class="segment" placeholder="MiddleName" oninput="updateFullName()">
        <input type="text" id="LastName" class="segment" placeholder="LastName" oninput="updateFullName()" required>
    </div>
    
    <!-- Hidden field for concatenated full name -->
    <input type="hidden" id="DriverName" name="DriverName">
</div>
            
            <!-- Gender -->
            <div class="custom22-form-group">
                <label for="Gender" style="margin-top: 10px;">Gender</label>
                <select id="Gender" name="Gender" required>
                <?php
                $gender_query = "SELECT * FROM friztann_gender";
                $gender_stmt = $dbh->prepare($gender_query);
                $gender_stmt->execute();
                $genders = $gender_stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($genders as $gender) {
                    echo "<option value='" . $gender['Gender'] . "'>" . $gender['Gender'] . "</option>";
                }
                ?>
            </select>
            </div>
            
            <!-- Email -->
            <div class="custom22-form-group">
                <label for="EmailId"style="margin-top: 10px;">Email</label>
                <input type="email" id="EmailId" name="EmailId" class="input" required>
                <div class="topline"></div>
                <div class="underline"></div>
                <div class="label">Email</div>
            </div>
            
            <!-- Contact Number -->
            <div class="custom22-form-group">
                <label for="ContactNo"style="margin-top: 10px;">Contact Number</label>


    <input class="input" type="tel" id="ContactNo" name="ContactNo" placeholder="9xxxxxxxxx" maxlength="11" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" onkeyup="this.style.borderColor = this.validity.valid ? '' : '';">
                <div class="topline"></div>
                <div class="underline"></div>
                <div class="label">Contact Number</div>
            </div>
            
            <!-- Submit Button -->
            <div class="button-borders">
                <button type="submit" style="margin-top: 10px;" name="signup" class="primary-button">SUBMIT</button>
            </div>
        </form>
    </div>
</div>
<script>
var modal = document.getElementById("myModal");

var btn = document.getElementById("openModalBtn");

var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script>
    function updateFullName() {
    const firstName = document.getElementById("FirstName").value.trim();
    const middleName = document.getElementById("MiddleName").value.trim();
    const lastName = document.getElementById("LastName").value.trim();
    
    // Combine the segments into a single hidden field
    const fullName = [firstName, middleName, lastName].filter(Boolean).join(' ');
    document.getElementById("DriverName").value = fullName;
}

</script>

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

                                    