<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if($_POST['submit']=="Update")
{
	$pagetype=$_GET['type'];
	$pagedetails=$_POST['pgedetails'];
$sql = "UPDATE friztann_pages SET detail=:pagedetails WHERE type=:pagetype";
$query = $dbh->prepare($sql);
$query -> bindParam(':pagetype',$pagetype, PDO::PARAM_STR);
$query-> bindParam(':pagedetails',$pagedetails, PDO::PARAM_STR);
$query -> execute();
$msg="Page data updated  successfully";

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
	
	<title>FritzAnn Shuttle Services  | Admin Page</title>
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
	
	<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { 
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}

function MM_jumpMenu(targ,selObj,restore){ 
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script type="text/javascript" src="nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
  <style>
	
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    color: #333;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

.content-wrapper {
    padding: 30px;
    max-width: 1400px;
    margin: 0 auto;
    background-color: white;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.page-title {
    color: #000;
    text-align: center;
    margin-bottom: 30px;
    font-size: 2.5em;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-bottom: 3px solid #ff0000;
    padding-bottom: 10px;
}

.panel {
    background: #fff;
    border: 2px solid #000;
    margin-bottom: 30px;
}

.panel-heading {
    background: #000;
    color: #fff;
    padding: 15px 20px;
    font-size: 1.2em;
    font-weight: bold;
    text-transform: uppercase;
}

.panel-body {
    padding: 20px;
}

.form-horizontal .form-group {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e0e0e0;
}

.form-horizontal .form-group:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.form-horizontal label {
    font-weight: bold;
    color: #000;
    text-transform: uppercase;
    flex: 0 0 200px;
    margin-right: 20px;
    padding-top: 10px;
}

.form-control {
    flex: 1;
    border: 2px solid #000;
    padding: 10px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #ff0000;
    outline: none;
}

select.form-control {
    appearance: none;
    background-image: linear-gradient(45deg, transparent 50%, #000 50%),
                      linear-gradient(135deg, #000 50%, transparent 50%);
    background-position: calc(100% - 20px) calc(1em + 2px),
                         calc(100% - 15px) calc(1em + 2px);
    background-size: 5px 5px, 5px 5px;
    background-repeat: no-repeat;
    padding-right: 30px;
}

.btn-primary {
    background: #ff0000;
    border: none;
    color: #fff;
    padding: 12px 30px;
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn-primary:hover {
    background: #cc0000;
}



.hr-dashed {
    border: none;
    border-top: 2px dashed #000;
    margin: 30px 0;
}

textarea.form-control {
    min-height: 150px;
    resize: vertical;
}

@media (max-width: 768px) {
    .form-horizontal label {
        flex: 0 0 100%;
        margin-bottom: 10px;
    }
    
    .form-control {
        width: 100%;
    }
    
    .btn-primary {
        width: 100%;
    }
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
                    <h2 class="page-title">Manage Pages</h2>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="panel panel-default">
                                <div class="panel-heading"></div>
                                <div class="panel-body">
                                    <form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">
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
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Select Page</label>
                                            <div class="col-sm-8">
                                                <select name="menu1" onChange="MM_jumpMenu('parent',this,0)" class="form-control">
                                                    <option value="" selected="selected">***Select One***</option>
                                                    <option value="manage-pages.php?type=terms">Terms and Conditions</option>
                                                    <option value="manage-pages.php?type=privacy">Privacy and Policy</option>
                                                    <option value="manage-pages.php?type=aboutus">About Us</option>
                                                    <option value="manage-pages.php?type=faqs">FAQs</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Selected Page</label>
                                            <div class="col-sm-8">
                                                <?php
                                                    switch($_GET['type']) {
                                                        case "terms" :
                                                            echo "Terms and Conditions";
                                                            break;
                                                        case "privacy" :
                                                            echo "Privacy And Policy";
                                                            break;
                                                        case "aboutus" :
                                                            echo "About Us";
                                                            break;
                                                        case "faqs" :
                                                            echo "FAQs";
                                                            break;
                                                        default :
                                                            echo "";
                                                            break;
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Page Details</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" rows="5" name="pgedetails" id="pgedetails" placeholder="Package Details" required>
                                                    <?php 
                                                        $pagetype=$_GET['type'];
                                                        $sql = "SELECT detail from friztann_pages where type=:pagetype";
                                                        $query = $dbh -> prepare($sql);
                                                        $query->bindParam(':pagetype',$pagetype,PDO::PARAM_STR);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                        if($query->rowCount() > 0)
                                                        {
                                                            foreach($results as $result)
                                                            {		
                                                                echo htmlentities($result->detail);
                                                            }
                                                        }
                                                    ?>
                                                </textarea> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-4">
                                                <button type="submit" name="submit" value="Update" id="submit" class="btn-primary btn">Update</button>
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