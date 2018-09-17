
            <?php
                // include to display html
                include '../display_html.php';

                $title = "Create Category";
                display_html_header($title,$conn);

                 // link to read record 
                echo "<a href='index.php' class='btn btn-primary pull-right m-b-1em'><span class='glyphicon glyphicon-list'></span> Read Category</a>";
                // variables to save error
                $nameErr = $desErr = "";

                if($_POST){
                    
                    // include database connection
                    include '../config/database.php';
                    if(empty($_POST['description'])){

                        $desErr = "Description is required";

                    }elseif(empty($_POST['description'])){

                        $priceErr = "Price is required";

                    }else{

                        try{
                         
                           // insert query
                           $query = "INSERT INTO categories
                                       SET name=:name, description=:description,
                                           created_at=:created";
                            
                           // prepare query for execution
                           $stmt = $conn->prepare($query);
                            
                           $name=htmlspecialchars(strip_tags($_POST['name']));
                           $description=htmlspecialchars(strip_tags($_POST['description']));
                         
                            
                          
                            
                           // bind the parameters
                           $stmt->bindParam(':name', $name);
                           $stmt->bindParam(':description', $description);
                       
                            
                           // specify when this record was inserted to the database
                           $created=date('Y-m-d H:i:s');
                           $stmt->bindParam(':created', $created);
                             
                            // Execute the query
                            if($stmt->execute()){
                                echo "<div class='alert alert-success'>Record was saved.</div>";
                               
                            }else{
                                echo "<div class='alert alert-danger'>Unable to save record.</div>";
                            }
                             
                        }
                         
                        // show error
                        catch(PDOException $exception){
                            die('ERROR: ' . $exception->getMessage());
                        }
                    }
                   
                 
                }
                display_html_create_form_category($nameErr, $desErr);
                display_html_footer();
            ?>
             
           
              
      