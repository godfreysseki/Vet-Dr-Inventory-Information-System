<?php
  
  include_once "../includes/config.inc.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $_POST['report_type'] ?> Report | <?= COMPANY ?></title>
	
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../assets/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
	<!-- Main content -->
	<section class="invoice p-3">
		<!-- info row -->
		<div class="row invoice-info border-bottom mb-4">
			<div class="col-sm-2 invoice-col">
				<img src="<?= FAVICON ?>" style="width: 100%">
			</div>
			<!-- /.col -->
			<div class="col-sm-6 invoice-col">
				<h3 class="mb-0"><?= strtoupper(COMPANY) ?></h3>
				<p class="my-0">
					<i><q><?= MOTTO ?></q></i><br>
					<b>Location:</b> <?= LOCATION ?>, <b>Email:</b> <?= COMPANYEMAIL ?><br>
					<b>Tel:</b> <?= COMPANYPHONE ?>, <?= COMPANYPHONE2 ?>
				</p>
			</div>
			<!-- /.col -->
			<div class="col-sm-4 invoice-col text-right">
				<h3 class="text-uppercase"><?= $_POST['report_type'] ?> Report</h3>
				<b>Selected Date:</b> <?= dates($_POST['start_date']) ?> - <?= dates($_POST['end_date']) ?><br>
				<b>Report Date:</b> <?= dates(date('Y-m-d', $_SERVER['REQUEST_TIME'])) ?>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
    
    <?php
	    
	    $data = new Reports();
      
      if ($_POST['report_type'] === 'expenses') {
        echo $data->expensesReport($_POST['start_date'], $_POST['end_date']);
        
      } elseif ($_POST['report_type'] === 'inventory') {
        echo $data->inventoryReport($_POST['start_date'], $_POST['end_date']);
        
      } elseif ($_POST['report_type'] === 'payroll') {
        echo $data->payrollReport($_POST['start_date'], $_POST['end_date']);
        
      } elseif ($_POST['report_type'] === 'profit') {
        echo $data->profitReport($_POST['start_date'], $_POST['end_date']);
        
      } elseif ($_POST['report_type'] === 'sales') {
        echo $data->salesReport($_POST['start_date'], $_POST['end_date']);
      }
    
    ?>
	
	</section>
	<!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  //window.addEventListener("load", window.print());
</script>
</body>
</html>
