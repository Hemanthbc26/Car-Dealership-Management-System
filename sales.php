<?php

include '../database_connection.php';

include '../functions.php';

//checking  admin login 
if(!is_admin_login())
{
    header('location:../admin_login.php');
}
$query = "
    SELECT * FROM sale 
    ORDER BY sale_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();


include '../header.php';

?>
<div class="container-fluid py-4" style="min-height: 700px;">
    <h1>Dealership Management</h1>
    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Dealership Management</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6">
                    <i class="fas fa-table me-1"></i> Car sale Management
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
                        
                        <th>Sale Date</th>  
                        <th>Sale Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Customer Name</th>
                        <th>VIN</th>
                        <th>Salesperson ID</th>
                        
                        <th>Sale Date</th>  
                        <th>Sale Price</th>
                        <th>Status</th>
                        
                    </tr>
                </tfoot>
                <tbody>
                <?php 

                if($statement->rowCount() > 0)
                {
                    foreach($statement->fetchAll() as $row)
                    {
                        $sale_status = '';
                        if($row['sale_status'] == 'Booked')
                        {
                            $sale_status = '<div class="badge bg-success">Booked</div>';
                        }
                       
                        echo '
                        <tr>
                            <td>'.$row["customer_name"].'</td>
                            <td>'.$row["car_id"].'</td>
                            <td>'.$row["salesperson_id"].'</td>
                            
                            <td>'.$row["sale_date"].'</td>
                            <td>'.$row["sale_price"].'</td>
                            <td>'.$sale_status.'</td>
                          
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
    
   
</div>


<?php

include '../footer.php';

?>