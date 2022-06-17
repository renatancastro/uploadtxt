<?php
//uploadcsv.php
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
				header("location: uploadtxt.php?updation=1");
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
		<title>Upload File</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
	</head>
	<body>
		<br/>
		<div class="container">
			<h2 align="center">Upload File</a></h2>
			<br/>
			<form method="post" enctype='multipart/form-data'>
				<p><label>Please Select File(Only CSV Format)</label>
				<input type="file" name="product_file"/></p>
				<br/>
				<input type="submit" name="upload" class="btn btn-info" value="Upload"/>
			</form>
			<br/>
			<?php 
				echo $message; 
			?>
		</div>
	</body>
</html>