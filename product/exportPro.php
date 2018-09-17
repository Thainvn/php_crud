<?php 
	
	header('Content-Type: text/csv; charset=utf-8');  
     header('Content-Disposition: attachment; filename=product.csv');  

     // connect to db
     include_once '../config/database.php';

      $output = fopen("php://output", "w");  
      fputcsv($output, array('ID', 'Name', 'Description','Price','Category Name'));  
     
     
	try {
		$query = "SELECT products.id, products.name, products.description, products.price,categories.name as category_name FROM products JOIN categories ON products.category_id = categories.id ORDER BY id DESC"
		   ;
		 
		$stmt = $conn->prepare($query);
		$stmt->execute();
		 // this is how to get number of rows returned
		$num = $stmt->rowCount();
		  
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