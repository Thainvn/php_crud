
    
        <?php
            include_once "../display_html.php";

        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id=isset($_GET['category_id']) ? $_GET['category_id'] : die('ERROR: Record ID not found.');

        //include database connection
        include '../config/database.php';

        $title = "Update Category";
        display_html_header($title,$conn);

         // link to read record 
        echo "<a href='index.php' class='btn btn-primary pull-right m-b-1em'><span class='glyphicon glyphicon-list'></span> Read Category</a>";
        echo "<div class='clearfix'></div>";
        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, name, description FROM categories WHERE id = ? LIMIT 0,1";
            $stmt = $conn->prepare( $query );
            
            // this is the first question mark
            $stmt->bindParam(1, $id);
            
            // execute our query
            $stmt->execute();
            
            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
          
        }

        // show error
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
       
        // variables to save error
        $nameErr = $desErr = "";

      // check if form was submitted
      if($_POST){

       

        if(empty($_POST['name'])){

            $nameErr = "Name is required";

        }else if(empty($_POST['description'])){

            $desErr = "Description is required";

        }else{
            try{
            
                // write update query
                // in this case, it seemed like we have so many fields to pass and 
                // it is better to label them and not use question marks
                $query = "UPDATE categories 
                            SET name=:name, description=:description 
                            WHERE id = :id";

                // prepare query for excecution
                $stmt = $conn->prepare($query);

                // posted values
                $name=htmlspecialchars(strip_tags($_POST['name']));
                $description=htmlspecialchars(strip_tags($_POST['description']));
              

                // bind the parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
               
                $stmt->bindParam(':id', $id);
                
                // Execute the query
                if($stmt->execute()){
                    echo "<div class='alert alert-success'>Record was updated.</div>";
                }else{
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
                
            }
            
            // show errors
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }
    }
        display_html_update_form_category($row,$nameErr,$desErr);
        display_html_footer();

      ?>

      