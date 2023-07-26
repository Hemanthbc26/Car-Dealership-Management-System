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
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-user-plus"></i> Generate Reports
        </div>
         <div class="container mt-5">
        <h3 class="text-center mb-5">Select a Report to View</h3>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <a href="datewise-report.php" class="btn btn-primary btn-block mb-3">Datewise Report</a>
                <a href="monthly-report.php" class="btn btn-primary btn-block mb-3">Monthly Report</a>
                <a href="salespersons-report.php" class="btn btn-primary btn-block mb-3">Salespersons Report</a>
                <a href="yearly-report.php" class="btn btn-primary btn-block mb-3">Yearly Report</a>
            </div>
        </div>
    </div>
</div>
</div>
<?php include'../footer.php';?>