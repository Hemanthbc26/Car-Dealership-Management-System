<?php

include '../database_connection.php';

include '../functions.php';

//checking  admin login 
if(!is_admin_login())
{
    header('location:../admin_login.php');
}
include '../header.php';
?>
<div class="container-fluid py-4" style="min-height: 700px;">
    <h1>Dealership Management</h1>
    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Report Management</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus"></i> Daily report
        </div>
        <div class="card-body">
            <form method="post">
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="datewise-report" class="form-label"> Select Date</label>
                             <input type="date" class="form-control" id="datewise-report" name="datewise-report" required>
                        </div>
                        </div>
                    </div>
                    <div class="mt-4 mb-3 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
        </div>
    </div>
</div>
<?php
if(isset($_POST['datewise-report'])) {
$date = $_POST['datewise-report'];

// Query to fetch data for today's transactions
$sql = "SELECT customer_name, car_id, salesperson_id, sale_price FROM sale WHERE sale_date = '$date'";
$stmt = $connect->prepare($sql);
 $stmt->bindParam(':sale_date', $date);
$stmt->execute();

// Check if any rows were returned
if ($stmt->rowCount() > 0) {
    // Start report table
    ?>
    <div class="container-fluid py-4" style="min-height: 700px;">
    <h1>Sales Report on : <?php echo $date ?></h1>
    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Report Management</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6">
                    <i class="fas fa-table me-1"></i> Daily report Management
                </div>
                
            </div>
        </div>
    <div class="card-body">
            <table id="datatablesSimple">
                <thead> 
                    <tr> 
                        <th>Customer Name</th>
                        <th>VIN</th>
                        <th>Salesperson ID</th>                     
                        <th>Sale Price</th>
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Customer Name</th>
                        <th>VIN</th>
                        <th>Salesperson ID</th>                        
                        <th>Sale Price</th>
                        
                        
                    </tr>
                </tfoot>
                <tbody>
   <?php
   while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
         echo '
                        <tr>
                            <td>'.$row["customer_name"].'</td>
                            <td>'.$row["car_id"].'</td>
                            <td>'.$row["salesperson_id"].'</td>
                            <td>'.$row["sale_price"].'</td>                                                     
                        </tr>';
    }
}
    
    // End report table
 else
                {
                    echo '
                    <tr>
                        <td colspan="10" class="text-center">No Data Found</td>
                    </tr>
                    ';
                }
            }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php

include '../footer.php';

?>
