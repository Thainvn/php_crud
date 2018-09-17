
        <?php
            //include database connection
            include '../config/database.php';
            
            include_once "../display_html.php";

            $title = "Read Detail Product";
            display_html_header($title,$conn);
             // link to read record 
            echo "<a href='index.php' class='btn btn-primary pull-right m-b-1em'><span class='glyphicon glyphicon-list'></span> Read Products</a>";
            
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
             
            
             
            // read current record's data
            try {
                // prepare select query
                $query = "SELECT products.id, products.name, products.description, products.price,products.image ,categories.name as category_name FROM products JOIN categories ON products.category_id = categories.id WHERE products.id = ? LIMIT 0,1";
                $stmt = $conn->prepare( $query );
             
                // this is the first question mark
                $stmt->bindParam(1, $id);
             
                // execute our query
                $stmt->execute();
             
                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
             
                display_html_read_detail_product($row);

            }
             
            // show error
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
            display_html_footer();
        ?>
 
        
 
   