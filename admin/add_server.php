<?php 
  include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");
    require_once("thumbnail_images.class.php");
    
    
    
    
  ?>
  
<?php
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		include('dbconfig.php');
		$HostName = $_POST['HostName'];
		$ServerStatus = $_POST['ServerStatus'];
		$city = $_POST['city'];
		$password = $_POST['password'];
		$username = $_POST['username'];
		$IP = $_POST['IP'];
		$certificate = $_POST['certificate'];
		$type = $_POST['type'];
		
		$query = "INSERT INTO servers(HostName, ServerStatus, city, password, username, IP, certificate, type) VALUES('$HostName', '$ServerStatus', '$city', '$password', '$username', '$IP', '$certificate', $type)";
		$result = mysqli_query($mysqli, $query);
		if(!$mysqli){
			$status = 0;
			$message = "Query Error: ".mysqli_error($mysqli);
		} else {
			$status = 1;
			$message = "Server Added Successfully";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">


  <body data-col="2-columns" class=" 2-columns ">
      <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


     
      <?php include('main.php'); ?>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->

<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Add Server</h4>
					
				</div>
			<div class="row">
				<div class="col-sm-10 offset-sm-1">
		<?php
			if(isset($status)){
				if($status == 1){
					echo '<div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Success!</strong> '.$message.'
</div>';
				} else {
					echo '<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Error!</strong> '.$message.'
</div>';
				}
			}
		?>

         
		  
		  <div class="card shadow mb-4">
            
              
            </div>
            <div class="card-body">
				<form action="" method="POST">
				  <div class="form-group">
					<label for="HostName">Country Name</label>
					<input type="text" class="form-control" id="HostName" name="HostName" aria-describedby="emailHelp"  required>
					<small id="emailHelp" class="form-text text-muted"></small>
				  </div>
				  
			
				  
				
			
				 
				  
			
				  
				  
				  <div class="form-group">
					<label for="type">Type</label>
					<select class="form-control" id="type" name="type" required>
					  <option value="1">Free</option>
					  <option value="2">Premium</option>
					</select>
				  </div>
				  
				  <div class="form-group">
					<label for="ServerStatus">Server Status</label>
					<select class="form-control" id="ServerStatus" name="ServerStatus" required>
					  <option value="1">Enable</option>
					  <option value="2">Disable</option>
					</select>
				  </div>
				  
			
				  
				  <div class="form-group">
					<label for="city">City Name</label>
					<input type="text" class="form-control" id="city" name="city" aria-describedby="emailHelp" required>
					<small id="emailHelp" class="form-text text-muted"></small>
				  </div>
				  
				  
				  
				  
				  
				  	  <div class="form-group">
					<label for="username">username</label>
					<input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" required>
					<small id="emailHelp" class="form-text text-muted"></small>
				  </div>
				  
				  <div class="form-group">
					<label for="password">password</label>
					<input type="text" class="form-control" id="password" name="password" aria-describedby="emailHelp" required>
					<small id="emailHelp" class="form-text text-muted"></small>
				  </div>
				  
				  
				  
				  
				  
				  
				  <div class="form-group">
					<label for="IP">IP Address</label>
					<input type="text" class="form-control" id="IP" name="IP" aria-describedby="emailHelp" required>
					<small id="emailHelp" class="form-text text-muted"></small>
				  </div>
				  
				   <div class="form-group">
					<label for="certificate">Certificate</label>
					<input type="text" class="form-control" id="certificate" name="certificate" aria-describedby="emailHelp" required>
					<small id="emailHelp" class="form-text text-muted"></small>
				  </div>
				  
				  
				  <button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		  </div>
		</div>
		</div>
			</div>
		</div>

		
	</div>
	


 


          </div>
        </div>

        

      </div>
    </div>
    
   <?php include("includes/footer.php");?>
    

  </body>


</html>