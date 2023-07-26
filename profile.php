<?php

//profile.php

include '../database_connection.php';

include '../functions.php';

if(!is_admin_login())
{
	header('location:../admin_login.php');
}

$message = '';

$error = '';

if(isset($_POST['edit_admin']))
{

	$formdata = array();

	if(empty($_POST['admin_email']))
	{
		$error .= '<li>Email Address is required</li>';
	}
	else
	{
		if(!filter_var($_POST["email_address"], FILTER_VALIDATE_EMAIL))
		{
			$error .= '<li>Invalid Email Address</li>';
		}
		else
		{
			$formdata['email_address'] = $_POST['email_address'];
		}
	}

	if(empty($_POST['password']))
	{
		$error .= '<li>Password is required</li>';
	}
	else
	{
		$formdata['password'] = $_POST['password'];
	}
	if(empty($_POST['first_name']))
	{
		$error .= '<li>First Name is required</li>';
	}
	else
	{
		$formdata['first_name'] = $_POST['first_name'];
	}
	if(empty($_POST['last_name']))
	{
		$error .= '<li>Last Name is required</li>';
	}
	else
	{
		$formdata['last_name'] = $_POST['last_name'];
	}
	if(empty($_POST['phone_number']))
	{
		$error .= '<li>Phone Number is required</li>';
	}
	else
	{
		$formdata['phone_number'] = $_POST['phone_number'];
	}
	if($error == '')
	{
		$admin_id = $_SESSION['admin_id'];

		$data = array(
			':first_name'	=>	$formdata['first_name'],
			':last_name'	=>	$formdata['last_name'],
			':phone_number'	=>	$formdata['phone_number'],
			':email_address'	=>	$formdata['email_address'],
			':password'			=>	$formdata['password'],
			':admin_id'			=>	$admin_id
		);

		$query = "
		UPDATE admin 
            SET first_name = :first_name,
            last_name = :last_name,
            phone_number = :phone_number,
            email_address = :email_address,
            password = :password 
            WHERE admin_id = :admin_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		$message = 'User Data Edited';
	}
}

$query = "
	SELECT * FROM admin 
    WHERE admin_id = '".$_SESSION["admin_id"]."'
";

$result = $connect->query($query);


include '../header.php';

?>

<div class="container-fluid px-4">
	<h1 class="mt-4">Profile</h1>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Profile</a></li>
	</ol>
	<div class="row">
		<div class="col-md-6">
			<?php 

			if($error != '')
			{
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">'.$error.'</ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			if($message != '')
			{
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$message.' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			?>
			<div class="card mb-4">
				<div class="card-header">
					<i class="fas fa-user-edit"></i> Edit Profile Details
				</div>
				<div class="card-body">

				<?php 

				foreach($result as $row)
				{
				?>

					<form method="post">
						<div class="mb-3">
							<label class="form-label">First Name</label>
							<input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $row['first_name']; ?>" />
						</div>
						<div class="mb-3">
							<label class="form-label">Last Name</label>
							<input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $row['last_name']; ?>" />
						</div>
						<div class="mb-3">
							<label class="form-label">Phone Number</label>
							<input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo $row['phone_number']; ?>" />
						</div>
						<div class="mb-3">
							<label class="form-label">Email Address</label>
							<input type="text" name="email_address" id="email_address" class="form-control" value="<?php echo $row['email_address']; ?>" />
						</div>
						<div class="mb-3">
							<label class="form-label">Password</label>
							<input type="password" name="password" id="password" class="form-control" value="<?php echo $row['password']; ?>" />
						</div>
						<div class="mt-4 mb-0">
							<input type="submit" name="edit_admin" class="btn btn-primary" value="Edit" />
						</div>
					</form>

				<?php 
				}

				?>

				</div>
			</div>

		</div>
	</div>
</div>

<?php 

include '../footer.php';

?>