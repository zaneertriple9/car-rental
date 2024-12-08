<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 

if(isset($_POST['submit']))
  {
$vehicletitle=$_POST['vehicletitle'];
$brand=$_POST['brandname'];
$priceperday=$_POST['priceperday'];
$fueltype=$_POST['fueltype'];
$bodytype=$_POST['bodytype'];
$TransmissionType =$_POST['TransmissionType'];
$seatingcapacity=$_POST['seatingcapacity'];
$vimage0=$_FILES["img0"]["name"];
$vimage1=$_FILES["img1"]["name"];
$vimage2=$_FILES["img2"]["name"];
$vimage3=$_FILES["img3"]["name"];
$airconditioner=$_POST['airconditioner'];
$powerdoorlocks=$_POST['powerdoorlocks'];
$powerwindow=$_POST['powerwindow'];
$cdplayer=$_POST['cdplayer'];
$centrallocking=$_POST['centrallocking'];
move_uploaded_file($_FILES["img0"]["tmp_name"],"img/vehicleimages/".$_FILES["img0"]["name"]);
move_uploaded_file($_FILES["img1"]["tmp_name"],"img/vehicleimages/".$_FILES["img1"]["name"]);
move_uploaded_file($_FILES["img2"]["tmp_name"],"img/vehicleimages/".$_FILES["img2"]["name"]);
move_uploaded_file($_FILES["img3"]["tmp_name"],"img/vehicleimages/".$_FILES["img3"]["name"]);

$sql="INSERT INTO friztann_vehicles(VehiclesTitle,VehiclesBrand,PricePerDay,FuelType,bodytype,TransmissionType,SeatingCapacity,vimage0,Vimage1,Vimage2,Vimage3,AirConditioner,PowerDoorLocks,PowerWindows,CDPlayer,CentralLocking) VALUES(:vehicletitle,:brand,:priceperday,:fueltype,:bodytype,:TransmissionType,:seatingcapacity,:vimage0,:vimage1,:vimage2,:vimage3,:airconditioner,:powerdoorlocks,:powerwindow,:cdplayer,:centrallocking)";
$query = $dbh->prepare($sql);
$query->bindParam(':vehicletitle',$vehicletitle,PDO::PARAM_STR);
$query->bindParam(':brand',$brand,PDO::PARAM_STR);
$query->bindParam(':priceperday',$priceperday,PDO::PARAM_STR);
$query->bindParam(':fueltype',$fueltype,PDO::PARAM_STR);
$query->bindParam(':bodytype',$bodytype ,PDO::PARAM_STR);
$query->bindParam(':TransmissionType',$TransmissionType,PDO::PARAM_STR);
$query->bindParam(':seatingcapacity',$seatingcapacity,PDO::PARAM_STR);
$query->bindParam(':vimage0',$vimage0,PDO::PARAM_STR);
$query->bindParam(':vimage1',$vimage1,PDO::PARAM_STR);
$query->bindParam(':vimage2',$vimage2,PDO::PARAM_STR);
$query->bindParam(':vimage3',$vimage3,PDO::PARAM_STR);
$query->bindParam(':airconditioner',$airconditioner,PDO::PARAM_STR);
$query->bindParam(':powerdoorlocks',$powerdoorlocks,PDO::PARAM_STR);
$query->bindParam(':powerwindow',$powerwindow,PDO::PARAM_STR);
$query->bindParam(':cdplayer',$cdplayer,PDO::PARAM_STR);
$query->bindParam(':centrallocking',$centrallocking,PDO::PARAM_STR);

$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Car posted successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

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
	
	<title>FritzAnn Shuttle Services  | Admin Add Cars</title>
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
	
	<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .panel {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .panel-heading {
            background-color: #f0f0f0;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .panel-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
        }

        .btn-default {
            background-color: red;
        }

        .btn-primary {
            background-color: #000000;
        }

        .checkbox-inline {
            margin-right: 20px;
        }

        .checkbox-inline label {
            font-weight: normal;
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

.input-container .topline {
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

.input-container .underline {
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
.file-upload-wrapper {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .file-upload-container {
            display: flex;
            gap: 20px;
        }

        .file-upload-header {
            font-weight: bold;
        }

        .file-upload-form-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .file-upload-col-sm-4 {
            display: flex;
            align-items: center;
        }

        .custom-file-upload {
            background-color: #ed0000;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .file-upload-input {
            display: none;
        }

        .file-name {
            margin-left: 10px;
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
    


        <div class="row">
          <div class="col-md-12">

               <h2 class="page-title" ">Add Cars</h2></div>
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
                <form method="post" class="form-horizontal" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Car Name<span style="color:red">*</span></label>
                    <div class="col-sm-4">
<input type="text" name="vehicletitle" class="form-control input" required minlength="3" maxlength="30">
                      <div class="topline"></div>
                      <div class="underline"></div>
                      <label class="label">Car name</label>
                    </div>
                    <label class="col-sm-2 control-label">Select Brand<span style="color:red">*</span></label>
                    <div class="col-sm-4">
                      <select class="selectpicker form-control input" name="brandname" required>
                        <option value=""> Select </option>
                        <?php
                        $ret="select brand_id,BrandName from friztann_brands";
                        $query= $dbh -> prepare($ret);
                        $query-> execute();
                        $results = $query -> fetchAll(PDO::FETCH_OBJ);
                        if($query -> rowCount() > 0)
                        {
                          foreach($results as $result)
                          {
                        ?>
                        <option value="<?php echo htmlentities($result->brand_id);?>"><?php echo htmlentities($result->BrandName);?></option>
                        <?php }} ?>
                      </select>
                      <div class="topline"></div>
                      <div class="underline"></div>
                      <label class="label">Select Brand</label>
                    </div>

                    <label class="col-sm-2 control-label">Select Body Type<span style="color:red">*</span></label>
                    <div class="col-sm-4">
                      <div class="custom-select" style="margin-top: 20px;">
                        <select class="selectpicker form-control input" name="bodytype" required>
                          <option style="margin-top: 2px;" value="">Select</option>
                          <option style="margin-top: 2px;" value="SEDAN">SEDAN</option>
                          <option style="margin-top: 2px;" value="SUV">SUV</option>
                          <option style="margin-top: 2px;" value="PICK-UP">PICK UP</option>
                          <option style="margin-top: 2px;" value="VAN">VAN</option>
                          <option style="margin-top: 2px;" value="HATCHBACK">HATCHBACK</option>
                          <option style="margin-top: 2px;" value="MPV">MPV</option>
                          <option style="margin-top: 2px;" value="VAN">VAN</option>

                        </select>
                        <div class="topline"></div>
                        <div class="underline"></div>
                        <label class="label">Select Body Type</label>
                      </div>
                    </div>
                  </div>

                  <div class="hr-dashed"></div>
                  <div class="form-group">                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Price Per Day(in ₱eso)<span style="color:red">*</span></label>
                    <div class="col-sm-4">
 <input 
    type="text" 
    name="priceperday" 
    class="form-control input"
    maxlength="5"
    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
>
                      <div class="topline"></div>
                      <div class="underline"></div>
                      <label class="label">Price Per Day</label>
                    </div>
                    <label class="col-sm-2 control-label">Select Fuel Type<span style="color:red">*</span></label>
                    <div class="col-sm-4">
                      <select class="selectpicker form-control input" name="fueltype" required>
                        <option value=""> Select </option>
                        <option value="Petrol">Petrol</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Gasoline">Gasoline</option>
                      </select>
                      <div class="topline"></div>
                      <div class="underline"></div>
                      <label class="label">Select Fuel Type</label>
                    </div>
                  </div>

                  <div class="form-group">
                  <label class="col-sm-2 control-label">Select Engine Type<span style="color:red">*</span></label>
<div class="col-sm-4">
  <select class="selectpicker form-control input" name="TransmissionType" required>
    <option value=""> Select </option>
    <option value="Manual">Manual</option>
    <option value="Automatic">Automatic</option>
    <option value="CVT">CVT</option>
  </select>
</div>


                    <label class="col-sm-2 control-label">Seating Capacity<span style="color:red">*</span></label>
                    <div class="col-sm-4">
 
        <input 
    type="text" 
    name="seatingcapacity" 
    class="form-control input"
    maxlength="2"
    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
>
                      <div class="topline"></div>
                      <div class="underline"></div>
                      <label class="label">Seating Capacity</label>
                    </div>
                  </div>

                  <div class="hr-dashed"></div>

                  <div class="form-group">
                    <div class="col-sm-12">
                      <h4><b>Car Images</b></h4>
                    </div>
                    
                  </div>
                  <div style="display: flex; flex-wrap: wrap; gap: 10px; margin: 10px;">
    <div style="flex: 1 1 calc(50% - 10px); border: 1px solid #ccc; padding: 10px; box-sizing: border-box;">
        <div style="font-weight: bold; margin-bottom: 10px;">Cover Image</div>
        <label for="img0" style="display: block; background: #ff0000; color: #fff; text-align: center; padding: 8px; cursor: pointer; border-radius: 5px;">Choose File</label>
        <input type="file" id="img0" name="img0" style="display: none;" accept="image/*" onchange="displayImage(event, 'preview-img0')" required>
        <img id="preview-img0" style="max-width: 100%; display: none; margin-top: 10px;" />
    </div>
    <div style="flex: 1 1 calc(50% - 10px); border: 1px solid #ccc; padding: 10px; box-sizing: border-box;">
        <div style="font-weight: bold; margin-bottom: 10px;">Car Image 1</div>
        <label for="img1" style="display: block; background: #ff0000; color: #fff; text-align: center; padding: 8px; cursor: pointer; border-radius: 5px;">Choose File</label>
        <input type="file" id="img1" name="img1" style="display: none;" accept="image/*" onchange="displayImage(event, 'preview-img1')" required>
        <img id="preview-img1" style="max-width: 100%; display: none; margin-top: 10px;" />
    </div>
    <div style="flex: 1 1 calc(50% - 10px); border: 1px solid #ccc; padding: 10px; box-sizing: border-box;">
        <div style="font-weight: bold; margin-bottom: 10px;">Car Image 2</div>
        <label for="img2" style="display: block; background: #ff0000; color: #fff; text-align: center; padding: 8px; cursor: pointer; border-radius: 5px;">Choose File</label>
        <input type="file" id="img2" name="img2" style="display: none;" accept="image/*" onchange="displayImage(event, 'preview-img2')" required>
        <img id="preview-img2" style="max-width: 100%; display: none; margin-top: 10px;" />
    </div>
    <div style="flex: 1 1 calc(50% - 10px); border: 1px solid #ccc; padding: 10px; box-sizing: border-box;">
        <div style="font-weight: bold; margin-bottom: 10px;">Car Image 3</div>
        <label for="img3" style="display: block; background: #ff0000; color: #fff; text-align: center; padding: 8px; cursor: pointer; border-radius: 5px;">Choose File</label>
        <input type="file" id="img3" name="img3" style="display: none;" accept="image/*" onchange="displayImage(event, 'preview-img3')" required>
        <img id="preview-img3" style="max-width: 100%; display: none; margin-top: 10px;" />
    </div>
</div>
    </div>
                  <div class="hr-dashed"></div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="panel panel-default">
                        <div class="panel-heading">Car features</div>
                        <div class="panel-body">
                          <div class="form-group">
                            <div class="col-sm-3">
                              <div class="checkbox checkbox-inline">
                                <input type="checkbox" id="airconditioner" name="airconditioner" value="1">
                                <label for="airconditioner"> Air Conditioner </label>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="checkbox checkbox-inline">
                                <input type="checkbox" id="powerdoorlocks" name="powerdoorlocks" value="1">
                                <label for="powerdoorlocks"> Power Door Locks </label>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="checkbox checkbox-inline">
                                <input type="checkbox" id="powerwindow" name="powerwindow" value="1">
                                <label for="powerwindow"> Power Windows </label>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="checkbox checkbox-inline">
                                <input type="checkbox" id="cdplayer" name="cdplayer" value="1">
                                <label for="cdplayer"> CD Player </label>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="checkbox checkbox-inline">
                                <input type="checkbox" id="centrallocking" name="centrallocking" value="1">
                                <label for="centrallocking"> Central Locking </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2">
                      <button class="btn btn-default" type="reset">Cancel</button>
                      <button class="btn btn-primary" name="submit" type="submit">Save changes</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    function displayImage(event, imgId) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgElement = document.getElementById(imgId);
                imgElement.src = e.target.result;
                imgElement.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>
<script>
        document.querySelectorAll('.file-upload-input').forEach(input => {
            input.addEventListener('change', function() {
                const fileNameDiv = this.nextElementSibling.nextElementSibling;
                if (this.files.length > 0) {
                    fileNameDiv.textContent = this.files[0].name;
                } else {
                    fileNameDiv.textContent = 'No file chosen';
                }
            });
        });
    </script>
	<!-- Loading Scripts -->
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