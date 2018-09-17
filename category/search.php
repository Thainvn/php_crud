
            <?php
                // include database connection
                include '../config/database.php';
                // include display html
                include_once "../display_html.php";

                $title = "You Searched For " .$_GET['key'];

                display_html_header($title,$conn);
                 // PAGINATION VARIABLES
                 // page is the current page, if there's nothing set, default is page 1
                 $page = isset($_GET['page']) ? $_GET['page'] : 1;
                  
                 // set records or rows of data per page
                 $records_per_page = 5;
                  
                 // calculate for the query LIMIT clause
                 $from_record_num = ($records_per_page * $page) - $records_per_page;
              
                if($_GET['key']){

                    // select all data
                   // select data for current page
                   $query = "SELECT * FROM categories  WHERE name LIKE :key1 OR description LIKE :key2  ORDER BY id DESC
                       LIMIT :from_record_num, :records_per_page";
                    
                   $stmt = $conn->prepare($query);
                   // sanitize
                   $keywords=htmlspecialchars(strip_tags($_GET['key']));
                   $keywords = "%{$keywords}%";



                   // bind data
                   $stmt->bindParam(":key1", $keywords);
                   $stmt->bindParam(":key2", $keywords);

                   $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
                   $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
                 
                   $stmt->execute();

                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();
                     
                    
                    display_html_search_form();
                    // link to create record form
                    echo "<a href='index.php' class='btn btn-primary pull-right m-b-1em'><span class='glyphicon glyphicon-list'></span> Read Categories</a>";
                     echo "<div class='clearfix'></div>";

                    //check if more than 0 record found
                    if($num>0){

                        echo "<div class='alert alert-info'>Find $num results</div>";
                        echo "<table class='table table-hover table-responsive table-bordered'>";//start table
                        

                            //creating our table heading
                            echo "<tr>";
                                echo "<th>Category Id</th>";
                                echo "<th>Name</th>";
                                echo "<th>Description</th>";
                               
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
                                   
                                    echo "<td>";
                                        // read one record 
                                        echo "<a href='../read_one.php?id={$id}' class='btn btn-info m-r-1em'><span class='glyphicon glyphicon-list'></span> View Product </a>";
                                         
                                        // we will use this links on next part of this post
                                        echo "<a href='../update.php?id={$id}' class='btn btn-primary m-r-1em'><span class='glyphicon glyphicon-edit'></span> Edit </a>";
                             
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