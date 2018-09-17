
            <?php
                // include database connection
                include '../config/database.php';
                
                // include to display html
                include '../display_html.php';

                $title = "Create Product";
                display_html_header($title,$conn);

                 // link to read record 
                echo "<a href='index.php' class='btn btn-primary pull-right m-b-1em'><span class='glyphicon glyphicon-list'></span> Read Products</a>";
                // variables to save error
                $nameErr = $desErr =  $priceErr = "";

                if($_POST){
                    
                 
                    if(empty($_POST['name'])){

                        $nameErr = "Name is required";

                    }else if(empty($_POST['description'])){

                        $desErr = "Description is required";

                    }elseif(empty($_POST['price'])){

                        $priceErr = "Price is required";

                    }else{

                        try{
                         
                           // insert query
                           $query = "INSERT INTO products
                                       SET name=:name, description=:description,
                                           price=:price, image=:image, created=:created";
                            
                           // prepare query for execution
                           $stmt = $conn->prepare($query);
                            
                           $name=htmlspecialchars(strip_tags($_POST['name']));
                           $description=htmlspecialchars(strip_tags($_POST['description']));
                           $price=htmlspecialchars(strip_tags($_POST['price']));
                            
                           // new 'image' field
                           $image=!empty($_FILES["image"]["name"])
                                   ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                                   : "";
                           $image=htmlspecialchars(strip_tags($image));
                            
                           // bind the parameters
                           $stmt->bindParam(':name', $name);
                           $stmt->bindParam(':description', $description);
                           $stmt->bindParam(':price', $price);
                           $stmt->bindParam(':image', $image);
                            
                           // specify when this record was inserted to the database
                           $created=date('Y-m-d H:i:s');
                           $stmt->bindParam(':created', $created);
                             
                            // Execute the query
                            if($stmt->execute()){
                                echo "<div class='alert alert-success'>Record was saved.</div>";
                                // now, if image is not empty, try to upload the image
                                if($image){
                                 
                                    // sha1_file() function is used to make a unique file name

                                    $target_directory = "uploads/";
                                    $target_file = $target_directory . $image;
                                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                                 
                                    // error message is empty
                                    $file_upload_error_messages="";

                                    // make sure that file is a real image
                                    $check = getimagesize($_FILES["image"]["tmp_name"]);

                                    if($check!==false){
                                        // submitted file is an image
                                    }else{
                                        $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
                                    }

                                    // make sure certain file types are allowed
                                    $allowed_file_types=array("jpg", "jpeg", "png", "gif");
                                    if(!in_array($file_type, $allowed_file_types)){
                                        $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                                    }

                                    // make sure file does not exist
                                    if(file_exists($target_file)){
                                        $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
                                    }

                                    // make sure submitted file is not too large, can't be larger than 1 MB
                                    if($_FILES['image']['size'] > (1024000)){
                                        $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
                                    }
                                    // make sure the 'uploads' folder exists
                                    // if not, create it
                                    if(!is_dir($target_directory)){
                                        mkdir($target_directory, 0777, true);
                                    }

                                    // if $file_upload_error_messages is still empty
                                    if(empty($file_upload_error_messages)){
                                        // it means there are no errors, so try to upload the file
                                        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                                            // it means photo was uploaded
                                        }else{
                                            echo "<div class='alert alert-danger'>";
                                                echo "<div>Unable to upload photo.</div>";
                                                echo "<div>Update the record to upload photo.</div>";
                                            echo "</div>";
                                        }
                                    }
                                     
                                    // if $file_upload_error_messages is NOT empty
                                    else{
                                        // it means there are some errors, so show them to user
                                        echo "<div class='alert alert-danger'>";
                                            echo "<div>{$file_upload_error_messages}</div>";
                                            echo "<div>Update the record to upload photo.</div>";
                                        echo "</div>";
                                    }
                                 
                                }
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
                display_html_create_form($nameErr, $desErr, $priceErr );
                display_html_footer();
            ?>
             
           
              
      