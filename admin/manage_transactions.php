<?php 
/**
	 * Company : Nemosofts
	* Detailed : Software Development Company in Sri Lanka
	* Developer : Thivakaran
	* Contact : info.nemosofts@gmail.com
	* Website : https://nemosofts.com
	*/
    $page_title="Manage Transactions";
    include("includes/header.php");

    require("includes/function.php");
    require("language/language.php");
    
    
    
     function get_user_info($user_id){
        global $mysqli;
        $user_qry="SELECT * FROM tbl_users where id='".$user_id."'";
        $user_result=mysqli_query($mysqli,$user_qry);
        $user_row=mysqli_fetch_assoc($user_result);
        return $user_row;
    }
    
    function get_subscription_plan($user_id){
        global $mysqli;
        $user_qry="SELECT * FROM subscription_plan where id='".$user_id."'";
        $user_result=mysqli_query($mysqli,$user_qry);
        $user_row=mysqli_fetch_assoc($user_result);
        return $user_row;
    }
    
    $qry2="SELECT * FROM transaction where id='1'";
    $result2=mysqli_query($mysqli,$qry2);
    $settings_row2=mysqli_fetch_assoc($result2);
    
    $qry3="SELECT * FROM payment_settings where id='1'";
    $result3=mysqli_query($mysqli,$qry3);
    $settings_row3=mysqli_fetch_assoc($result3);
    

    // Get page data
    $tableName="subscription_plan";    
    $targetpage = "manage_transactions.php";  
    $limit = 15; 
    
    $query = "SELECT COUNT(*) as num FROM $tableName";
    $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
    $total_pages = $total_pages['num'];
    
    $stages = 3;
    $page=0;
    if(isset($_GET['page'])){
        $page = mysqli_real_escape_string($mysqli,$_GET['page']);
    }
    if($page){
        $start = ($page - 1) * $limit; 
    }else{
        $start = 0; 
    }


    $qry="SELECT transaction.*,transaction.id FROM transaction ORDER BY transaction.id DESC LIMIT $start, $limit";   
    $result=mysqli_query($mysqli,$qry);
 
   
?>

<Style>
    img.my_img {
    max-height: 40px;
    max-width: 35px;
}
</Style>
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="col-md-12 mrg-top">
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Plan</th>
                  <th>Amount</th>
                  <th>Payment Gateway</th>
                  <th>Payment ID</th> 
                  <th>Payment Date</th> 
                </tr>
              </thead>
              <tbody>
              <?php
				$i = 0;
				if(mysqli_num_rows($result) > 0){
					while ($row = mysqli_fetch_array($result)) {
			    ?>
                <tr>
                   
                  <td><a href="user_profile.php?user_id=<?php echo $row['user_id'];?>"><?php echo get_user_info($row['user_id'])['name'];?></a></td>
                
                  <td>
                  <?php if ($row['daily_bump_up'] == "1") { ?>
						<img class="my_img" src="assets/images/<?php echo get_subscription_plan(1)['promote_image'];?>" alt="Girl in a jacket" width="500" height="200">
				    <?php }  ?>
				    <?php if ($row['top_ad'] == "1") { ?>
						<img class="my_img" src="assets/images/<?php echo get_subscription_plan(2)['promote_image'];?>" alt="Girl in a jacket" width="500" height="200">
				    <?php }  ?>
				    <?php if ($row['spot_light'] == "1") { ?>
						<img class="my_img" src="assets/images/<?php echo get_subscription_plan(3)['promote_image'];?>" alt="Girl in a jacket" width="500" height="200">
				    <?php }  ?>
				</td>	
                  
                   
					
					
					
                  <td><?php echo $settings_row3['currency_code'];?> <?php echo $row['payment_amount'];?></td>
                  <td><?php echo $row['gateway'];?></td>
                  <td><?php echo $row['payment_id'];?></td>
                  <td><?php echo date('M d Y h:i A', $row['date_time']); ?></td>
                  

                </tr>
               <?php
				$i++;
			    }
				}
				else{
					?>
					<tr>
						<td colspan="7">
							<p class="not_data"><strong>Sorry</strong> no data found!</p>
						</td>
					</tr>
					<?php
				}
			?>
              </tbody>
            </table>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
              	<?php if(!isset($_POST["search"])){ include("pagination.php");}?>                 
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>            
<?php include("includes/footer.php");?>  
