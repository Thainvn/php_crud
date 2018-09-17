
            <?php
                // include database connection
                include '../config/database.php';
                // include display html
                include_once "../display_html.php";

                $title = "Read Products";

                display_html_header($title,$conn);
                 // PAGINATION VARIABLES
                 // page is the current page, if there's nothing set, default is page 1
                 $page = isset($_GET['page']) ? $_GET['page'] : 1;
                  
                 // set records or rows of data per page
                 $records_per_page = 5;
                  
                 // calculate for the query LIMIT clause
                 $from_record_num = ($records_per_page * $page) - $records_per_page;
               $action = isset($_GET['action']) ? $_GET['action'] : "";
               $category_id  = isset($_GET['category_id']) ? $_GET['category_id'] : "0";
                
               // if it was redirected from delete.php
               if($action=='deleted'){
                   echo "<div class='alert alert-success'>Record was deleted.</div>";
               }
                if($category_id>0){
                     // select data based on category
                    
                    $query = "SELECT products.id, products.name, products.description, products.price,categories.name as category_name FROM products JOIN categories ON products.category_id = categories.id WHERE products.category_id =:category_id ORDER BY id DESC
                        LIMIT :from_record_num, :records_per_page";
                     
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(":category_id", $category_id);

                }else{
                     // select all data
                    // select data for current page
                    $query = "SELECT products.id, products.name, products.description, products.price,categories.name as category_name FROM products JOIN categories ON products.category_id = categories.id ORDER BY id DESC
                        LIMIT :from_record_num, :records_per_page";
                     
                    $stmt = $conn->prepare($query);

                }
               
               $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
               $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
               $stmt->execute();
                // this is how to get number of rows returned
                $num = $stmt->rowCount();
                 
                
                display_html_search_form();
                // link to create record form
                echo "<a href='create.php' class='btn btn-primary pull-right m-b-1em'><span class='glyphicon glyphicon-plus'></span> Create New Product</a>";

                // link to export product csv file 
                echo "<a href='exportPro.php' class='btn btn-info pull-right m-b-1em m-r-1em'><span class='glyphicon glyphicon-plus'></span> Export CSV</a>";
                 echo "<div class='clearfix'></div>";
                //check if more than 0 record found
                if($num>0){
                 
                    echo "<table class='table table-hover table-responsive table-bordered'>";//start table
                     
                        //creating our table heading
                        echo "<tr>";
                            echo "<th>ID</th>";
                            echo "<th>Name</th>";
                            echo "<th>Description</th>";
                            echo "<th>Price</th>";
                            echo "<th>Category name</th>";
                            echo "<th>Action</th>";
                        echo "</tr>";
                         
                        // retrieve our table contents
                        // fetch() is faster than fetchAll()
                        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            // extract row
                            // this will make $row['firstname'] to
                            // just $firstname only
                            extract($row);
                             
                            // creating new table row per record
                            echo "<tr>";
                                echo "<td>{$id}</td>";
                                echo "<td>{$name}</td>";
                                echo "<td>{$description}</td>";
                                echo "<td>&#36;{$price}</td>";
                                echo "<td>$category_name</td>";
                                echo "<td>";
                                    // read one record 
                                    echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'><span class='glyphicon glyphicon-list'></span> Read </a>";
                                     
                                    // we will use this links on next part of this post
                                    echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'><span class='glyphicon glyphicon-edit'></span> Edit </a>";
                         
                                    // we will use this links on next part of this post
                                    echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span> Remove</a>";
                                echo "</td>";
                            echo "</tr>";
                        }
                     
                    // end table
                    echo "</table>";
                     // PAGINATION
                     // count total number of rows
                     $query = "SELECT COUNT(*) as total_rows FROM products";
                     $stmt = $conn->prepare($query);
                      
                     // execute query
                     $stmt->execute();
                      
                     // get total rows
                     $row = $stmt->fetch(PDO::FETCH_ASSOC);
                     $total_rows = $row['total_rows'];
                     // paginate records
                     $page_url="index.php?";
                     include_once "paging.php";
                }
                 
                // if no records found
                else{
                    echo "<div class='alert alert-danger'>No records found.</div>";
                }
            ?>
             
          <script type='text/javascript'>
        // confirm record deletion
        function delete_user( id ){
             
            var answer = confirm('Are you sure?');
            if (answer){
                // if user clicked ok, 
                // pass the id to delete.php and execute the delete query
                window.location = 'delete.php?id=' + id;
            } 
        }
    </script>
    <?php
        display_html_footer();
     ?>