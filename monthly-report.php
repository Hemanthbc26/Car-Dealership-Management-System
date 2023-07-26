<?php

include '../database_connection.php';

include '../functions.php';

//checking  admin login 
if(!is_admin_login())
{
    header('location:../admin_login.php');
}
include '../header.php';

// Get the current month and year
$current_month = date('m');
$current_year = date('Y');

// Prepare the SQL statement
$sql = "SELECT customer_name, car_id, salesperson_id, sale_price FROM sale WHERE MONTH(sale_date) = ? AND YEAR(sale_date) = ?";
$stmt = $connect->prepare($sql);
$stmt->execute([$current_month, $current_year]);

// Check if any rows were returned
if ($stmt->rowCount() > 0) {
    ?>
    <div class="container-fluid py-4" style="min-height: 700px;">
    <h1>Dealership Management</h1>
    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Report Management</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6">
                    <i class="fas fa-table me-1"></i> Monthly report Management
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
            
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php

include '../footer.php';

?>