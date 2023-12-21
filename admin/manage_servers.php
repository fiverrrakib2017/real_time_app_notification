<?php 
  include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");
    require_once("thumbnail_images.class.php");
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

      <div id="content">

      

     

          <!-- Page Heading -->
          <h1 class="h3 mb-4 white">Manage Servers</h1>
		  
		  <a href="add_server.php" class="btn btn-success">Add Server</a>
		 
		  <br>
		  <br>
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Servers List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
			<table id="example" class="table dataTable dispay table-hover table-striped" style="width:100%">
				<thead>
					<tr>
						<th>Server ID</th>
						<th>Hostname</th>
						<th>City</th>
						<th>Status</th>
						<th>Type</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$query = "SELECT * FROM servers ORDER BY server_id";
				$servers = mysqli_query($mysqli, $query);
				while($row = mysqli_fetch_assoc($servers)){
				?>
					<tr>
						<td><?php echo $row['server_id']; ?></td>
						<td><?php echo $row['HostName']; ?></td>
						<td><?php echo $row['city']; ?></td>
						<td><?php echo $row['ServerStatus'] == 1 ? "ENABLED" : "DISABLED" ?></td>
						<td><?php echo $row['type'] == 1 ? "FREE" : "PREMIUM" ?></td>
						<td><a style="margin:2px" href="update_server.php?server_id=<?php echo $row['server_id']; ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a><a style="margin:2px" href="#" onclick="var x = confirm('Are you sure?'); if(x){deleteServer(<?php echo $row['server_id']; ?>)}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
					</tr>
				<?php
				}
				?>
				<tbody>
			</table>
			</div>
			</div>
			</div>

       

      </div>

		
	</div>
	


 


          </div>
        </div>

        

      </div>
    </div>
    
    
    
     <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
});

function deleteServer(serverId){
	$.post("delete_server.php",
	{
		server_id: serverId
	},
	function(data, status){
		alert("Data: " + data);
		location.reload(true);
	});
}
</script>
    
    
    
    
   <?php 
  require 'include/js.php';
  ?>
    

  </body>


</html>
