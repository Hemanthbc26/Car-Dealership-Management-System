<?php

include '../database_connection.php';

include '../functions.php';

//checking  admin login 
if(!is_admin_login())
{
    header('location:../admin_login.php');
}
// Initialize variables to store form data and error messages
$errors = array();

// Check if the form is submitted
if(isset($_POST["add_car"]))
{

    // Validate form data
    if (empty($_POST['make'])) {
        $errors[] = 'Make is required';
    } else {
        $make = $_POST['make'];
    }

    if (empty($_POST['model'])) {
        $errors[] = 'Model is required';
    } else {
        $model = $_POST['model'];
    }

    if (empty($_POST['year'])) {
        $errors[] = 'Year is required';
    } else {
        $year = $_POST['year'];
    }
    if (empty($_POST['color'])) {
        $errors[] = 'color is required';
    } else {
        $color = $_POST['color'];
    }
    if (empty($_POST['mileage'])) {
        $errors[] = 'Mileage is required';
    } else {
        $mileage = $_POST['mileage'];
    }
    if (empty($_POST['price'])) {
        $errors[] = 'Price is required';
    } else {
        $price = $_POST['price'];
    }
    if (empty($_POST['VIN'])) {
        $errors[] = 'VIN is required';
    } else {
        $VIN = $_POST['VIN'];
    }
    $status=1;
    // If there are no errors, insert the car data into the database
    if (empty($errors)) {
        // Prepare the SQL query
        $query = "INSERT INTO car (make, model, year, color, mileage, price, VIN, status) VALUES (:make, :model, :year, :color, :mileage,  :price, :VIN, :status)";

        $statement = $connect->prepare($query);

        // Bind the parameters with the form data
        $statement->bindParam(':make', $make);
        $statement->bindParam(':model', $model);
        $statement->bindParam(':year', $year);
        $statement->bindParam(':color', $color);
        $statement->bindParam(':mileage', $mileage);
        $statement->bindParam(':price', $price);
        $statement->bindParam(':VIN', $VIN);
        $statement->bindParam(':status', $status);
        $statement->execute();
    }
    header('location:add.php?msg=add');
}
if(isset($_POST["edit_car"]))
{

    // Validate form data
    if (empty($_POST['make'])) {
        $errors[] = 'Make is required';
    } else {
        $make = $_POST['make'];
    }

    if (empty($_POST['model'])) {
        $errors[] = 'Model is required';
    } else {
        $model = $_POST['model'];
    }

    if (empty($_POST['year'])) {
        $errors[] = 'Year is required';
    } else {
        $year = $_POST['year'];
    }
    if (empty($_POST['color'])) {
        $errors[] = 'color is required';
    } else {
        $color = $_POST['color'];
    }
    if (empty($_POST['mileage'])) {
        $errors[] = 'Mileage is required';
    } else {
        $mileage = $_POST['mileage'];
    }
    if (empty($_POST['price'])) {
        $errors[] = 'Price is required';
    } else {
        $price = $_POST['price'];
    }
    $car_id=$_POST['car_id'];
    $status=1;
    // If there are no errors, insert the car data into the database
    if (empty($errors)) {
        // Prepare the SQL query
        $query = "UPDATE car 
        SET make = :make, 
        model = :model,
        year = :year,
        color = :color, 
        mileage = :mileage, 
        price = :price
        where car_id =$car_id";
        

        $statement = $connect->prepare($query);

        // Bind the parameters with the form data
        $statement->bindParam(':make', $make);
        $statement->bindParam(':model', $model);
        $statement->bindParam(':year', $year);
        $statement->bindParam(':color', $color);
        $statement->bindParam(':mileage', $mileage);
        $statement->bindParam(':price', $price);
        $statement->execute();
    }
    header('location:add.php?msg=edit');
}


$query = "
    SELECT * FROM car 
    ORDER BY car_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();


include '../header.php';

?>

<div class="container-fluid py-4" style="min-height: 700px;">
    <h1>Dealership Management</h1>
    <?php 
    if(isset($_GET["action"]))
    {
        if($_GET["action"] == 'add')
        {
    ?>

    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="add.php">Dealership Management</a></li>
        <li class="breadcrumb-item active">Add Car</li>
    </ol>

   

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus"></i> Add New Car
        </div>
        <div class="card-body">
            <form method="post">
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Make</label>
                            <input type="text" name="make" id="make" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Model</label>
                            <input type="text" name="model" id="model" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="row">   
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Year</label>
                            <input type="text" name="year" id="year" class="form-control"required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">color</label>
                            <input type="text" name="color" id="color" class="form-control" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Mileage</label>
                             <input type="text" name="mileage" id="mileage" class="form-control"required />
                        </div>
                    </div>
                
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">price</label>
                            <input type="number" name="price" id="price" class="form-control"required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Vehile Identification Number</label>
                            <input type="text" name="VIN" id="VIN" class="form-control"required />
                        </div>
                    </div>
                    
                </div>
                
                    
                <div class="mt-4 mb-3 text-center">
                    <input type="submit" name="add_car" id="add_car" class="btn btn-success" value="Add" />
                </div>
            </form>
        </div>
    </div>

    <?php 
        }
        else if($_GET["action"] == 'edit')
        {
            $car_id = convert_data($_GET["code"], 'decrypt');

            if($car_id > 0)
            {
                $query = "
                SELECT * FROM car 
                WHERE car_id = '$car_id'
                ";

                $car_result = $connect->query($query);

                foreach($car_result as $car_row)
                {
    ?>
    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="add.php">Dealership Management</a></li>
        <li class="breadcrumb-item active">Edit car </li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus"></i> Edit car Details
        </div>
        <div class="card-body">
            <form method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Make</label>
                            <input type="text" name="make" id="make" class="form-control" required value="<?php echo $car_row['make']; ?>"/> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Model</label>
                            <input type="text" name="model" id="model" class="form-control" required value="<?php echo $car_row['model']; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">   
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Year</label>
                            <input type="text" name="year" id="year" class="form-control"required value="<?php echo $car_row['year']; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">color</label>
                            <input type="text" name="color" id="color" class="form-control" required value="<?php echo $car_row['color']; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Mileage</label>
                             <input type="text" name="mileage" id="mileage" class="form-control"required value="<?php echo $car_row['mileage']; ?>"/>
                        </div>
                    </div>
                
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">price</label>
                            <input type="number" name="price" id="price" class="form-control"required value="<?php echo $car_row['price']; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Vehile Identification Number</label>
                            <input type="text" name="VIN" id="VIN" class="form-control" readonly value="<?php echo $car_row['VIN']; ?>"/> 
                        </div>
                    </div>
                    
                </div>
                <div class="mt-4 mb-3 text-center">
                    <input type="submit" name="edit_car" id="edit_car" class="btn btn-success" value="Edit" />
                </div>
            </form>
        </div>
    </div>
    <?php
}
}
}
}
    else
    {   
    ?>
    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Dealership Management</li>
    </ol>
    <?php 

    if(isset($_GET["msg"]))
    {
        if($_GET["msg"] == 'add')
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">New Car Added<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
        if($_GET['msg'] == 'edit')
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Car Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }
    ?>
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6">
                    <i class="fas fa-table me-1"></i> Car Management
                </div>
                <div class="col col-md-6" align="right">
                    <a href="add.php?action=add" class="btn btn-success btn-sm">Add</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead> 
                    <tr> 
                        <th>Car Make</th>
                        <th>Car Model.</th>
                        <th>Mfg Year</th>
                        <th>Color</th>
                        <th>Mileage</th>  
                        <th>Price</th>
                        <th>VIN</th>
                        <th>Status</th>  
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Car Make</th>
                        <th>Car Model.</th>
                        <th>Mfg Year</th>
                        <th>Color</th>
                        <th>Mileage</th>  
                        <th>Price</th>
                        <th>VIN</th>
                        <th>Status</th>  
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                <?php 

                if($statement->rowCount() > 0)
                {
                    foreach($statement->fetchAll() as $row)
                    {
                        $car_status = '';
                        if($row['status'] == 'Enable')
                        {
                            $car_status = '<div class="badge bg-success">Available</div>';
                        }
                        else
                        {
                            $car_status = '<div class="badge bg-warning">Booked</div>';
                        }
                        echo '
                        <tr>
                            <td>'.$row["make"].'</td>
                            <td>'.$row["model"].'</td>
                            <td>'.$row["year"].'</td>
                            <td>'.$row["color"].'</td>
                            <td>'.$row["mileage"].'</td>
                            <td>'.$row["price"].'</td>
                            <td>'.$row["VIN"].'</td>
                            <td>'.$car_status.'</td>
                           
                            <td>
                                <a href="add.php?action=edit&code='.convert_data($row["car_id"]).'" class="btn btn-sm btn-primary">Edit</a>
                                
                            </td>
                        </tr>
                        ';
                    }
                }
                else
                {
                    echo '
                    <tr>
                        <td colspan="10" class="text-center">No Data Found</td>
                    </tr>
                    ';
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php 
    }

    ?>
</div>


<?php

include '../footer.php';

?>