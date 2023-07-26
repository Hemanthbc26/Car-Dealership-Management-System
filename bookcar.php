<?php

include '../database_connection.php';

include '../functions.php';

//checking  admin login 
if(!is_admin_login())
{
    header('location:../admin_login.php');
}
if (isset($_POST['book_car'])) {
    $car_id = $_POST['car_id'];
    $customer_name = $_POST['customer_name'];
    $customer_number = $_POST['contact_number'];
    $salesperson_id = $_POST['salesperson_id'];
    $booking_date = $_POST['booking_date']; // Use the current date as the booking date
    $query = "SELECT price from car WHERE VIN = ?";
    $statement = $connect->prepare($query);
    $statement->bindParam(1, $car_id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $price = $result['price'];
    $sale_status='Booked';
    try {
        $connect->beginTransaction();

        // Insert the booking details into the database
        $query = "INSERT INTO new_bookings (car_id, customer_name, contact_number, salesperson_id, price, booking_date) VALUES (:car_id, :customer_name, :contact_number, :salesperson_id, :price, :booking_date)";
        $statement = $connect->prepare($query);
        $statement->bindParam(':car_id', $car_id);
        $statement->bindParam(':customer_name', $customer_name);
        $statement->bindParam(':contact_number', $customer_number);
        $statement->bindParam(':salesperson_id', $salesperson_id);
        $statement->bindParam(':price', $price);
        $statement->bindParam(':booking_date', $booking_date);
        $statement->execute();
   
        // Update the car status to 'Booked' in the car table
        $query = "UPDATE car SET status = 'Booked' WHERE VIN = :car_id";
        $statement = $connect->prepare($query);
        $statement->bindParam(':car_id', $car_id);
        $statement->execute();
        $query="INSERT INTO sale (customer_name, car_id, salesperson_id, sale_date, sale_price, sale_status) VALUES (:customer_name, :car_id, :salesperson_id, :sale_date, :sale_price, :sale_status)";
       $statement = $connect->prepare($query);
        $statement->bindParam(':car_id', $car_id);
        $statement->bindParam(':customer_name', $customer_name);
        $statement->bindParam(':sale_status', $sale_status);
        $statement->bindParam(':salesperson_id', $salesperson_id);
        $statement->bindParam(':sale_price', $price);
        $statement->bindParam(':sale_date', $booking_date);
        $statement->execute();
        $connect->commit();

        // Redirect to the success page
        header('Location: sales.php');
    } catch (PDOException $e) {
        $connect->rollBack();
        echo "Error: " . $e->getMessage();
    }
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
    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Booking Management</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus"></i> Book new car
        </div>
        <div class="card-body">
            <form method="post">
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Vehicle Indetification Number</label>
                            <input type="text" name="car_id" id="car_id" class="form-control" required />
                            <span id="VIN_result"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="row">   
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Customer Phone Number</label>
                            <input type="text" name="contact_number" id="contact_number" class="form-control"required />
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Salesperson ID</label>
                            <input type="text" name="salesperson_id" id="salesperson_id" class="form-control"required />
                        </div>
                    </div>
                </div>
                    <div class="row">   
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Booking Date</label>
                            <input type="Date" name="booking_date" id="booking_date" class="form-control" required />
                        </div>
                    </div>
                </div>


                
                    
                <div class="mt-4 mb-3 text-center">
                    <input type="submit" name="book_car" id="book_car" class="btn btn-success" value="Book Car" />
                </div>
            </form>
            <script>
                    var car_id = document.getElementById('car_id');

                    car_id.onkeyup = function()
                    {
                        if(this.value.length > 1)
                        {
                            var form_data = new FormData();

                            form_data.append('action', 'search_VIN');

                            form_data.append('request', this.value);

                            fetch('action.php', {
                                method:"POST",
                                body:form_data
                            }).then(function(response){
                                return response.json();
                            }).then(function(responseData){
                                var html = '<div class="list-group" style="position:absolute; width:93%">';

                                if(responseData.length > 0)
                                {
                                    for(var count = 0; count < responseData.length; count++)
                                    {
                                        html += '<a href="#" class="list-group-item list-group-item-action"><span onclick="get_text(this)">'+responseData[count].VIN+'</span> - <span class="text-muted">'+responseData[count].make+'</span> - <span class="text-muted">'+responseData[count].model+'</span></a>';
                                    }
                                }
                                else
                                {
                                    html += '<a href="#" class="list-group-item list-group-item-action">No car Found</a>';
                                }

                                html += '</div>';

                                document.getElementById('VIN_result').innerHTML = html;
                            });
                        }
                        else
                        {
                            document.getElementById('VIN_result').innerHTML = '';
                        }
                    }

                    function get_text(event)
                    {
                        document.getElementById('VIN_result').innerHTML = '';

                        document.getElementById('car_id').value = event.textContent;
                    }
                </script>
        </div>
    </div>
</div>
<?php include '../footer.php';
