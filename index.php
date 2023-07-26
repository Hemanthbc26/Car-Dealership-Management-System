<?php

//index.php

include '../database_connection.php';

include '../functions.php';
include '../header.php';

if(!is_admin_login())
{
	header('location:../admin_login.php');
}




?>
<html>
<body>
<div class="container-fluid py-4">
	<h1 class="mb-5">Dashboard</h1>
	<div class="row">
		<div class="col-xl-3 col-md-6">
			<div class="card bg-primary text-white mb-4">
				<div class="card-body">
					<h1 class="text-center"><?php echo Count_total_cars_number($connect); ?></h1>
					<h5 class="text-center">Total Cars</h5>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card bg-warning text-white mb-4">
				<div class="card-body">
					<h1 class="text-center"><?php echo Count_total_soldcars_number($connect); ?></h1>
					<h5 class="text-center">Total Cars Sold</h5>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card bg-danger text-white mb-4">
				<div class="card-body">
					<h1 class="text-center"><?php echo Count_total_available_cars_number($connect); ?></h1>
					<h5 class="text-center">Total Available cars</h5>
				</div>
			</div>
		</div>
	
		<div class="col-xl-3 col-md-6">
			<div class="card bg-success text-white mb-4">
				<div class="card-body">
					<h1 class="text-center"><?php echo get_currency_symbol($connect) . Count_total_revenue_Generated($connect); ?></h1>
					<h5 class="text-center">Total Revenue generated </h5>
				</div>
			</div>
		</div>
		</div>
		<div class="row">
		<div class="col-xl-3 col-md-6">
			<div class="card bg-danger text-white mb-4">
				<div class="card-body">
					<h1 class="text-center"><?php echo Count_total_salesman_number($connect); ?></h1>
					<h5 class="text-center">Total Salespersons</h5>
				</div>
			</div>
		</div>
		
	</div>
</div>
</body>
</html>


<?php

include '../footer.php';

?>