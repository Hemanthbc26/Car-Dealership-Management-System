<?php

//setting.php

include '../database_connection.php';

include '../functions.php';

if(!is_admin_login())
{
	header('location:../admin_login.php');
}

$message = '';

if(isset($_POST['edit_setting']))
{
	$data = array(
		':dealership_name'					=>	$_POST['dealership_name'],
		':dealership_address'				=>	$_POST['dealership_address'],
		':dealership_contact_no'		    =>	$_POST['dealership_contact_no'],
		':dealership_email'					=>	$_POST['dealership_email'],
		':dealership_currency'				=>	$_POST['dealership_currency'],
		':dealership_timezone'				=>	$_POST['dealership_timezone']
		
	);

	$query = "
	UPDATE setting 
        SET dealership_name = :dealership_name,
        dealership_address = :dealership_address, 
        dealership_contact_no = :dealership_contact_no, 
        dealership_email = :dealership_email, 
        dealership_currency = :dealership_currency, 
        dealership_timezone = :dealership_timezone
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	$message = '
	<div class="alert alert-success alert-dismissible fade show" role="alert">Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
	';
}

$query = "
SELECT * FROM setting 
LIMIT 1
";

$result = $connect->query($query);

include '../header.php';

?>

<div class="container-fluid px-4">
	<h1 class="mt-4">Setting</h1>

	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Setting</a></li>
	</ol>
	<?php 

	if($message != '')	
	{
		echo $message;
	}

	?>
	<div class="card mb-4">
		<div class="card-header">
			<i class="fas fa-user-edit"></i> Dealership Setting
		</div>
		<div class="card-body">

			<form method="post">
				<?php 
				foreach($result as $row)
				{
				?>
				<div class="row">
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Dealership Name</label>
							<input type="text" name="dealership_name" id="dealership_name" class="form-control" value="<?php echo $row['dealership_name']; ?>" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="mb-3">
							<label class="form-label">Address</label>
							<textarea name="dealership_address" id="dealership_address" class="form-control"><?php echo $row["dealership_address"]; ?></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Contact Number</label>
							<input type="text" name="dealership_contact_no" id="dealership_contact_no" class="form-control" value="<?php echo $row['dealership_contact_no']; ?>" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Email Address</label>
							<input type="text" name="dealership_email" id="dealership_email" class="form-control" value="<?php echo $row['dealership_email']; ?>" />
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Currency</label>
							<select name="dealership_currency" id="dealership_currency" class="form-control">
								<?php echo Currency_list(); ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Timezone</label>
							<select name="dealership_timezone" id="dealership_timezone" class="form-control">
								<?php echo Timezone_list(); ?>
							</select>
						</div>
					</div>
				</div>
				</div>
				<div class="mt-4 mb-0">
					<input type="submit" name="edit_setting" class="btn btn-primary" value="Save" />
				</div>
				<script type="text/javascript">

				document.getElementById('dealership_currency').value = "<?php echo $row['dealership_currency']; ?>";

				document.getElementById('dealership_timezone').value="<?php echo $row['dealership_timezone']; ?>"; 

				</script>
				<?php 
				}
				?>
			</form>

		</div>
	</div>
</div>

<?php 

include '../footer.php';

?>