<?php

include '../database_connection.php';

include '../functions.php';

//checking  admin login 
if(!is_admin_login())
{
    header('location:../admin_login.php');
}


// Check if the form is submitted
if(isset($_POST["add_salesperson"]))
{

     $fname = $_POST['first_name'];
      $lname = $_POST['last_name'];
    $email = $_POST['email_address'];
    $phone = $_POST['phone_number'];
    function generate_salesperson_id($connect) {
    $query = "SELECT MAX(SUBSTRING(salesperson_id, 2)) AS max_id FROM salesperson";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $new_id = intval($result['max_id']) + 1;
    $new_id = str_pad($new_id, 3, '0', STR_PAD_LEFT);
    return 'S' . $new_id;
}
$new_salesperson_id = generate_salesperson_id($connect);

    // Insert the salesperson data into the database
    $query = "INSERT INTO salesperson(salesperson_id, first_name, last_name, email_address, phone_number) VALUES (:salesperson_id, :first_name, :last_name,:email_address, :phone_number)";
    $statement = $connect->prepare($query);
    $statement->bindParam(':salesperson_id', $new_salesperson_id);
    $statement->bindValue(':first_name', $fname);
     $statement->bindValue(':last_name', $lname);
    $statement->bindValue(':email_address', $email);
    $statement->bindValue(':phone_number', $phone);
    $result = $statement->execute();
    header('location:salesperson.php?msg=add');
}
if(isset($_POST["edit_salesperson"]))
{

     $fname = $_POST['first_name'];
      $lname = $_POST['last_name'];
    $email = $_POST['email_address'];
    $phone = $_POST['phone_number'];
    $salesperson_id=$_POST['salesperson_id'];
    $query = "UPDATE salesperson 
        SET first_name = :first_name, 
        last_name = :last_name,
        email_address = :email_address,
       phone_number  = :phone_number
        where salesperson_id =$salesperson_id";
    $statement = $connect->prepare($query);
    $statement->bindParam(':salesperson_id', $new_salesperson_id);
    $statement->bindValue(':first_name', $fname);
     $statement->bindValue(':last_name', $lname);
    $statement->bindValue(':email_address', $email);
    $statement->bindValue(':phone_number', $phone);
    $result = $statement->execute();
    header('location:salesperson.php?msg=edit');
}
$query = "
    SELECT * FROM salesperson 
    ORDER BY salesperson_id DESC
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
        <li class="breadcrumb-item"><a href="salesperson.php">Salesperson Management</a></li>
        <li class="breadcrumb-item active">Add Salesperson</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus"></i> Add New Salesperson
        </div>
        <div class="card-body">
            <form method="post">
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="row">   
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email_address" id="email_address" class="form-control"required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="number" name="phone_number" id="phone_number" class="form-control" required />
                        </div>
                    </div>
                </div>

                
                    
                <div class="mt-4 mb-3 text-center">
                    <input type="submit" name="add_salesperson" id="add_salesperson" class="btn btn-success" value="Add" />
                </div>
            </form>
        </div>
    </div>

    <?php 
        }

        else if($_GET["action"] == 'edit')
        {
            $salesperson_id = convert_data($_GET["code"], 'decrypt');

            if($salesperson_id > 0)
            {
                $query = "
                SELECT * FROM salesperson 
                WHERE salesperson_id = '$salesperson_id'
                ";

                $s_result = $connect->query($query);

                foreach($s_result as $s_row)
                {
    ?>
    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="salesperson.php">Salesperson Management</a></li>
        <li class="breadcrumb-item active">Edit Salesperson </li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus"></i> Edit Salesperson Details
        </div>
        <div class="card-body">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                           <label class="form-label">Salesperson ID</label>
                            <input type="text" name="salesperson_id" id="salesperson_id" class="form-control" readonly value="<?php echo $s_row['salesperson_id']; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                           <label class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" required value="<?php echo $s_row['first_name']; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" required value="<?php echo $s_row['last_name']; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">   
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email_address" id="email_address" class="form-control"required value="<?php echo $s_row['email_address']; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="number" name="phone_number" id="phone_number" class="form-control" required value="<?php echo $s_row['phone_number']; ?>"/>
                        </div>
                    </div>
                </div> 
                    
                </div>
                <div class="mt-4 mb-3 text-center">
                    <input type="submit" name="edit_salesperson" id="edit_salesperson" class="btn btn-success" value="Edit" />
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
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">New salesperson Added<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
        if($_GET['msg'] == 'edit')
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">salesperson Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }
    ?>
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6">
                    <i class="fas fa-table me-1"></i> Salesperson Management
                </div>
                <div class="col col-md-6" align="right">
                    <a href="salesperson.php?action=add" class="btn btn-success btn-sm">Add</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead> 
                    <tr> 
                        <th>salesperson ID</th>
                        <th>First name</th>
                        <th>Last person</th>
                        <th>Email address</th>
                        <th>Phone number</th>
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>salesperson ID</th>
                        <th>First name</th>
                        <th>Last person</th>
                        <th>Email address</th>
                        <th>Phone number</th>  
                        
                    </tr>
                </tfoot>
                <tbody>
                <?php 

                if($statement->rowCount() > 0)
                {
                    foreach($statement->fetchAll() as $row)
                    {
                        
                        echo '
                        <tr>
                            <td>'.$row["salesperson_id"].'</td>
                            <td>'.$row["first_name"].'</td>
                            <td>'.$row["last_name"].'</td>
                            <td>'.$row["email_address"].'</td>
                            <td>'.$row["phone_number"].'</td>
                            
                            
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