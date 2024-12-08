<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{	
    header('location:index.php');
}
else{
    if(isset($_GET['del']))
    {
        $id=$_GET['del'];
        $sql = "delete from friztann_contactus  WHERE 	contactuquery_id=:id";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':id',$id, PDO::PARAM_STR);
        $query -> execute();
        $msg="Page data updated  successfully";
    }
    else{
        if(isset($_REQUEST['eid']))
        {
            $eid=intval($_GET['eid']);
            $status=1;
            $sql = "UPDATE friztann_contactus SET status=:status WHERE  id=:eid";
            $query = $dbh->prepare($sql);
            $query -> bindParam(':status',$status, PDO::PARAM_STR);
            $query-> bindParam(':eid',$eid, PDO::PARAM_STR);
            $query -> execute();
            $msg="Message Successfully Read";
        }
    }	
}
?>

<!doctype html>
<html lang="en" class="no-js">
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
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="BLACK">
    
    <title>FritzAnn Shuttle Services  | Admin Manage Contact Us</title>
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
	    <link rel="stylesheet" href="css/brand.css">

	<link rel="stylesheet" href="css/error-succ.css">
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
                        <div class="card">
                            <div class="panel-heading"> <h2 class="page-title"  ">Manage Contactus</h2>

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
                                <div class="table-responsive">
                                    <table id="zctb" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                            <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact No</th>
                                                <th>Message</th>
                                                <th>Posting Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                            <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact No</th>
                                                <th>Message</th>
                                                <th>Posting Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php 
                                                $sql = "SELECT * from  friztann_contactus ";
                                                $query = $dbh -> prepare($sql);
                                                $query->execute();
                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt=1;
                                                if($query->rowCount() > 0)
                                                {
                                                    foreach($results as $result)
                                                    { ?>  
                                                        <tr>
                                                        										    	<td><?php echo htmlentities($cnt);?></td>

                                                            <td><?php echo htmlentities($result->name);?></td>
                                                            <td><?php echo htmlentities($result->EmailId);?></td>
                                                            <td><?php echo htmlentities($result->ContactNumber);?></td>
                                                            <td><?php echo htmlentities($result->Message);?></td>
                                                            <td><?php echo htmlentities($result->PostingDate);?></td>
                                                             <td><a href="manage-contactus.php
?del=<?php echo $result->contactuquery_id;?>" onclick="return confirm('Do you want to delete this brand?');" class="btn btn-danger btn-sm"><button class="fritzannbtn"><p class="paragraph"> delete </p><span class="icon-wrapper"><svg class="icon" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></span></button></a></td>
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

        </div>
    </div>
    </div></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

