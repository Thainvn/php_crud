<?php

	function display_html_header($title,$conn){
	
		// display header of page
		?>
			<!DOCTYPE HTML>
			<html>
			    <head>
			        <title> <?php echo $title; ?> </title>
			         
			        <!-- Latest compiled and minified Bootstrap CSS -->
			        <link rel="stylesheet" href="../libs/css/lib/bootstrap.min.css" />
			        <link rel="stylesheet" href="libs/css/lib/bootstrap.min.css" />
			             
			        <!-- custom css -->
			        <style>
			        .m-r-1em{ margin-right:1em; }
			        .m-b-1em{ margin-bottom:1em; }
			        .m-l-1em{ margin-left:1em; }
			        .mt0{ margin-top:0; }
			        .has-error{
			        	color: #f33;
			        }
			        </style>
			     
			    </head>
			    <body>
			     	<?php 
			     		display_html_navigation($conn);
			     	 ?>
			        <!-- container -->
			        <div class="container">
			      
			            <div class="page-header">
			                <h1> <?php echo $title; ?> </h1>
			            </div>
		<?php
	}



	function display_html_footer(){
		// display footer of page
		?>
			        </div> <!-- end .container -->
			         
			    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
			    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
			       
			    <!-- Latest compiled and minified Bootstrap JavaScript -->
			    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			     
			  
			     
			    </body>
			</html>
		<?php
	}
	function display_html_navigation($conn){
		?>
			<nav class="navbar navbar-inverse">
			  <div class="container-fluid">
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span> 
			      </button>
			      <a class="navbar-brand" href="<?php display_url('/product/index.php') ?>">ThaiVni</a>
			    </div>
			    <div class="collapse navbar-collapse" id="myNavbar">
			      <ul class="nav navbar-nav">
			       
			       	<li class="dropdown">
			       	       <a class="dropdown-toggle" data-toggle="dropdown" href="#">Products
			       	       <span class="caret"></span></a>
			       	       <ul class="dropdown-menu">
			       	         <li><a href="<?php display_url("/product/index.php")  ?>">All Products</a></li>
			       	        <?php 
			       	        	$query = "SELECT id,name FROM categories";
			       	        	$stmt = $conn->prepare($query);
			       	        	$stmt->execute();
			       	        	$num = $stmt->rowCount();

			       	        	if ($num>0) {
			       	        		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			       	        			extract($row);
			       	        			?>
											<li><a href="<?php display_url("/product?category_id=$id")  ?>"><?php echo $name ?></a></li>
			       	        			<?php
			       	        		}
			       	        	}

			       	         ?>
			       	       </ul>
			       	</li>
			       	 <li><a href="<?php display_url("/category/index.php")  ?>">Catgories</a></li>
			      </ul>
			      
			    </div>
			  </div>
			</nav>
		<?php
	}


	function display_html_create_form($nameErr,$desErr,$priceErr){
		// display form create product
		?>
			<!-- html form here where the product information will be entered -->
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
			    <table class='table table-hover table-responsive table-bordered'>
			        <tr>
			            <td>Name</td>
			            <td><input type='text' name='name' class='form-control' />
			            	<span class ="has-error"><?php echo $nameErr; ?></span>
			            </td>
			        </tr>
			        <tr>
			            <td>Description</td>
			            <td><textarea name='description' class='form-control'></textarea>
			            	<span class ="has-error"><?php echo $desErr; ?></span>
			            </td>
			        </tr>
			        <tr>
			            <td>Price</td>
			            <td><input type='text' name='price' class='form-control' />
			            	<span class ="has-error"><?php echo $priceErr; ?></span>
			            </td>
			        </tr>
			        <tr>
			            <td>Photo</td>
			            <td><input type="file" name="image" /></td>
			        </tr>
			        <tr>
			            <td></td>
			            <td>
			            	
			                <button type='submit'  class='btn btn-primary' >
			                <span class='glyphicon glyphicon-plus'></span> Create
			                </button>
			            </td>
			        </tr>
			    </table>
			</form>
		<?php
	}

	function display_html_read_detail_product($row){
		// display read detail one product
		?>
			<!--we have our html table here where the record will be displayed-->
			<table class='table table-hover table-responsive table-bordered'>
			    <tr>
			        <td>Name</td>
			        <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES);  ?></td>
			    </tr>
			    <tr>
			        <td>Description</td>
			        <td><?php echo htmlspecialchars($row['description'], ENT_QUOTES);  ?></td>
			    </tr>
			    <tr>
			        <td>Price</td>
			        <td>&#36;<?php echo htmlspecialchars($row['price'], ENT_QUOTES);  ?></td>
			    </tr>
			    <tr>
			        <td>Category name</td>
			        <td><?php echo htmlspecialchars($row['category_name'], ENT_QUOTES);  ?></td>
			    </tr>
			    <tr>
			        <td>Image</td>
			        <td>
				        <?php 
				        	 $image = htmlspecialchars($row['image'], ENT_QUOTES);
				        	echo $image ? "<img src='uploads/{$image}' style='width:300px;' />" : "No image found.";  
				        ?>
			        </td>
			    </tr>
			   
			</table>
		<?php
	}

	function display_html_update_form($row,$nameErr,$desErr,$priceErr){
		// display update form
		?>
			<!--we have our html form here where new record information can be updated-->
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$row['id']}");?>" method="post">
				<table class='table table-hover table-responsive table-bordered'>
					<tr>
						<td>Name</td>
						<td><input type='text' name='name' value="<?php echo htmlspecialchars($row['name'], ENT_QUOTES);  ?>" class='form-control' /></td>
							<span class ="has-error"><?php echo $nameErr; ?></span>
					</tr>
					<tr>
						<td>Description</td>
						<td><textarea name='description' class='form-control'><?php echo htmlspecialchars($row['description'], ENT_QUOTES);  ?></textarea>
							<span class ="has-error"><?php echo $desErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Price</td>
						<td>
							<input type='text' name='price' value="&#36;<?php echo htmlspecialchars($row['price'], ENT_QUOTES);  ?>" class='form-control' />
							<span class ="has-error"><?php echo $priceErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Category Name</td>
						<td>
							<select class="form-control" name="category_id">
								<?php 
									$category = ['1'=>'Motors','2'=>'Electronics','3'=>'Fashion'];
									foreach ($category as $key => $value) {

										if ($row['category_id'] == $key) {
											echo " <option value='$key' selected>";
											echo	 $value;
											echo '</option>';
										}else{
											echo" <option value='$key'>";
											echo	 $value;
											echo '</option>';
										}
										
									}
								 ?>
							   
							  </select>
							<span class ="has-error"><?php echo $priceErr; ?></span>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<button type='submit'  class='btn btn-primary' ><span class='glyphicon glyphicon-edit'> </span> Update </button>
							
						</td>
					</tr>
				</table>
			</form>
		<?php
	}

	function display_html_search_form(){
		// search form
	?>
		<form class="navbar-form pull-left" action="search.php" method = "get">
		   

		    <div class="input-group m-b-1em">
		        <input type="text" class="form-control" name="key" placeholder="Search">
		        <div class="input-group-btn">
		            <button class="btn btn-primary" type="submit">
		               <span class='glyphicon glyphicon-search'></span> Search
		            </button>
		        </div>
		    </div>

		</form>
		<?php
	}


	function display_html_create_form_category($nameErr,$desErr){
		// display form create product
		?>
			<!-- html form here where the product information will be entered -->
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			    <table class='table table-hover table-responsive table-bordered'>
			        <tr>
			            <td>Name</td>
			            <td><input type='text' name='name' class='form-control' />
			            	<span class ="has-error"><?php echo $nameErr; ?></span>
			            </td>
			        </tr>
			        <tr>
			            <td>Description</td>
			            <td><textarea name='description' class='form-control'></textarea>
			            	<span class ="has-error"><?php echo $desErr; ?></span>
			            </td>
			        </tr>
			        
			        <tr>
			            <td></td>
			            <td>
			            	
			                <button type='submit'  class='btn btn-primary' >
			                <span class='glyphicon glyphicon-plus'></span> Create
			                </button>
			            </td>
			        </tr>
			    </table>
			</form>
		<?php
	}
	function display_html_update_form_category($row,$nameErr,$desErr){
		// display update form
		?>
			<!--we have our html form here where new record information can be updated-->
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?category_id={$row['id']}");?>" method="post">
				<table class='table table-hover table-responsive table-bordered'>
					<tr>
						<td>Name</td>
						<td><input type='text' name='name' value="<?php echo htmlspecialchars($row['name'], ENT_QUOTES);  ?>" class='form-control' /></td>
							<span class ="has-error"><?php echo $nameErr; ?></span>
					</tr>
					<tr>
						<td>Description</td>
						<td><textarea name='description' class='form-control'><?php echo htmlspecialchars($row['description'], ENT_QUOTES);  ?></textarea>
							<span class ="has-error"><?php echo $desErr; ?></span>
						</td>
					</tr>
					
					<tr>
						<td></td>
						<td>
							<button type='submit'  class='btn btn-primary' ><span class='glyphicon glyphicon-edit'> </span> Update </button>
							
						</td>
					</tr>
				</table>
			</form>
		<?php
	}
	function display_url($des){
		$url =  "http://localhost/web_developer/phplesson/php-beginner-crud" .$des;
		echo $url;

	}
?>