<?php
//uploadtxt.php
	$connect=mysqli_connect("113.1.1.167", "applications", "applications2019", "applications");
	$message='';

	if(isset($_POST["upload"]))
	{
		if($_FILES['product_file']['name'])
		{
			$filename=explode(".", $_FILES['product_file']['name']);
			
			if(end($filename)=="txt")
			{
				$handle=fopen($_FILES['product_file']['tmp_name'], "r");
				$firstline=true;
				
				while (!feof($handle))
				{
					if(!$firstline) 
					{
						$getTextLine = fgets($handle);
						$explodeLine = explode("\t",$getTextLine);
	
						list($No,$SID, $DID, $Stat, $DateTime) = $explodeLine;
	
						$qry = "insert into tblAttendanceLog (`No`,`SID`, `DID`, `Stat`, `DateTime`) values('".$No."','".$SID."','".$DID."','".$Stat."','".$DateTime."')";
						mysqli_query($connect, $qry);
						$quer="DELETE FROM tblAttendanceLog WHERE No=0";
						mysqli_query($connect, $quer);
					}
					$firstline=false;
				}
				fclose($handle);
				header("location: upload.php?updation=1");
			}
			else
			{
				$message='<label class="text-danger">Please Select Text File only</label>';
			}
		}
		else
		{
			$message='<label class="text-danger">Please Select File</label>';
		}
	}
	if(isset($_GET["updation"]))
	{
		$message='<label class="text-success">Upload Done</label>';
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Attendance Log</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="css/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Attendance Log</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Upload File</p>

      <form method="post" enctype='multipart/form-data'>
        <div class="input-group mb-3">
          <input type="file" name="product_file" placeholder="Please Select File(Only TXT Format)"/></p>
        </div>
        <div class="row">
          <!-- /.col -->
		  <div class="col-8">
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="upload">Upload <i class="fas fa-upload"></i></button>
          </div>
          <!-- /.col -->
        </div>
		<?php 
				echo $message; 
		?>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="css/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="css/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="css/dist/js/adminlte.min.js"></script>

</body>
</html>
