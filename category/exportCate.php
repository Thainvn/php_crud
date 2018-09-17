<?php 
	
	header('Content-Type: text/csv; charset=utf-8');  
     header('Content-Disposition: attachment; filename=category.csv');  

     // connect to db
     include_once '../config/database.php';

      $output = fopen("php://output", "w");  
      fputcsv($output, array('ID', 'Name', 'Description'));  
     
     
	try {
		$query = "SELECT id,name,description from categories ORDER BY id DESC";  
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$num  = $stmt->rowCount();

		if($num>0)  {
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))  
			{  
			     fputcsv($output, $row);  
			}  
		}
		
	} catch (Exception $e) {

		echo "Error : " .$e->getMessage();
	}
	  fclose($output);  
 ?>