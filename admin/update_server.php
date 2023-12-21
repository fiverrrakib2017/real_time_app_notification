<?php 

  require 'includes/header.php';

  ?>
<?php
	if(!isset($_GET['server_id'])){
		header("location:manage_servers.php");
		die();
	}
	$server_id = $_GET['server_id'];
	include('include/dbconfig.php');
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	    $HostName = $_POST['HostName'];
		$ServerStatus = $_POST['ServerStatus'];
		$city = $_POST['city'];
		$password = $_POST['password'];
		$username = $_POST['username'];
		$IP = $_POST['IP'];
		$certificate = $_POST['certificate'];
		$type = $_POST['type'];
	    
	    
	    
	    
	    
	    
	
		
		
		
		$query = "UPDATE servers SET HostName='$HostName', ServerStatus='$ServerStatus', city='$city', password='$password', username='$username', IP='$IP', certificate='$certificate', Type=$type WHERE server_id=$server_id";
		$result = mysqli_query($mysqli, $query);
		if(!$result){
			$status = 0;
			$message = "Query Error: ".mysqli_error($mysqli);
		} else {
			if(mysqli_affected_rows($mysqli) > 0){
				$status = 1;
				$message = "Server Updated Successfully";
			} else {
				$status = 0;
				$message = "Unable to update server";
			}
		}
	}
	//$server_id = $_GET['server_id'];
	$server = mysqli_query($mysqli, "SELECT * FROM servers WHERE server_id=$server_id");
	if(!$server || mysqli_num_rows($server) == 0){
		header("location:manage_servers.php");
		die();
	}
	$server = mysqli_fetch_assoc($server);
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
					<h4 class="card-title" id="basic-layout-form">Update Server</h4>
					
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

            <div class="card-body">
				<form action="" method="POST">
				  <input type="hidden" class="form-control" value="<?php echo $server['server_id']; ?>" id="server_id" name="server_id">
				 
				 
				  <div class="form-group">
					<label for="HostName">Country Name</label>
					<input type="text" class="form-control" value="<?php echo $server['HostName']; ?>" id="HostName" name="HostName" aria-describedby="emailHelp" required>
					<small id="emailHelp" class="form-text text-muted"></small>
				  </div>
				  
				  <div class="form-group">
					<label for="city">City Name</label>
					<input type="text" class="form-control" value="<?php echo $server['city']; ?>" id="city" name="city" aria-describedby="emailHelp" required>
					<small id="emailHelp" class="form-text text-muted"></small>
				  </div>
				  
			
				  
				  <div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" value="<?php echo $server['username']; ?>" id="username" name="username" aria-describedby="emailHelp" required>
					<small id="emailHelp" class="form-text text-muted"></small>
				  </div>
				  
				  <div class="form-group">
					<label for="password">Password</label>
					<input type="text" class="form-control" value="<?php echo $server['password']; ?>" id="password" name="password" aria-describedby="emailHelp" required>
					<small id="emailHelp" class="form-text text-muted"></small>
				  </div>
				  
				
				  
				  
				  
				  
				  
				  <div class="form-group">
					<label for="type">Type</label>
					<select class="form-control" id="type" name="type" required>
					  <option value="1" <?php echo $server['Type'] == 1 ? "selected" : ""; ?>>Free</option>
					  <option value="2" <?php echo $server['Type'] == 2 ? "selected" : ""; ?>>Premium</option>
					</select>
				  </div>
				  
				  
				   <div class="form-group">
					<label for="ServerStatus">Server Status</label>
					<select class="form-control" id="ServerStatus" name="ServerStatus" required>
					  <option value="1" <?php echo $server['Type'] == 1 ? "selected" : ""; ?>>Enable</option>
					  <option value="2" <?php echo $server['Type'] == 2 ? "selected" : ""; ?>>Disable</option>
					</select>
				  </div>
				  
				  
				
				  
				  
				  
				  	  <div class="form-group">
					<label for="IP">IP Address</label>
					<input type="text" class="form-control" value="<?php echo $server['IP']; ?>" id="IP" name="IP" aria-describedby="emailHelp" required>
					<small id="emailHelp" class="form-text text-muted"></small>
				  </div>
				  
				  
				    	  <div class="form-group">
					<label for="certificate">Certificate</label>
					<input type="text" class="form-control" value="<?php echo $server['certificate']; ?>" id="certificate" name="certificate" aria-describedby="emailHelp" required>
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
    </div>
    
   <?php 
  require 'include/js.php';
  ?>
    

  </body>


</html>
