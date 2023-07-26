	<?php 

//action.php

include '../database_connection.php';

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'search_VIN')
	{
		$query = "
		SELECT VIN, make , model  FROM car 
		WHERE VIN LIKE '%".$_POST["request"]."%' 
		AND status = 'Enable'
		";

		$result = $connect->query($query);

		$data = array();

		foreach($result as $row)
		{
			$data[] = array(
				'VIN'		=>	str_replace($_POST["request"], '<b>'.$_POST["request"].'</b>', $row["VIN"]),
				'make'		=>	$row['make'],
				'model'		=>	$row['model']

			);
		}
		echo json_encode($data);
	}
	
	
?>