<?php 
	/**
	 * Company : Nemosofts
	* Detailed : Software Development Company in Sri Lanka
	* Developer : Thivakaran
	* Contact : info.nemosofts@gmail.com
	* Website : https://nemosofts.com
	*/
	
	$page_title="User Profile";
	$current_page="users";
	include('includes/header.php'); 
	include('includes/function.php');
	include('language/language.php');
	
	$user_id=strip_tags(addslashes(trim($_GET['user_id'])));

	if(!isset($_GET['user_id']) OR $user_id==''){
		header("Location: manage_users.php");
	}

    $user_qry="SELECT * FROM tbl_users WHERE id='$user_id'";
    $user_result=mysqli_query($mysqli,$user_qry);
    if(mysqli_num_rows($user_result)==0){
    	header("Location: manage_users.php");
    }
    $user_row=mysqli_fetch_assoc($user_result);
	$user_img='assets/images/user-icons.jpg';

	function getLastActiveLog($user_id){
    	global $mysqli;
    	$sql="SELECT * FROM tbl_active_log WHERE `user_id`='$user_id'";
        $res=mysqli_query($mysqli, $sql);
        if(mysqli_num_rows($res) == 0){
        	echo 'no available';
        }else{
        	$row=mysqli_fetch_assoc($res);
			return calculate_time_span($row['date_time'],true);	
        }
    }
    
    $tableName="tbl_post";   
    $targetpage = "user_profile.php"; 
    $limit = 50; 
    $query = "SELECT COUNT(*) as num FROM $tableName WHERE tbl_post.user_id='$user_id'";
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
    
    $data_qry="SELECT * FROM $tableName WHERE tbl_post.user_id='$user_id'
    ORDER BY tbl_post.id DESC LIMIT $start, $limit";
    $result=mysqli_query($mysqli,$data_qry); 
        
        
    if(isset($_POST['btn_submit'])){
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['class']="warn";
            $_SESSION['msg']="invalid_email_format";
        }else{
            $email=cleanInput($_POST['email']);
            $sql="SELECT * FROM tbl_users WHERE `email` = '$email' AND `id` <> '".$user_id."'";
            $res=mysqli_query($mysqli, $sql);

            if(mysqli_num_rows($res) == 0){
                $data = array(
                    'name'  =>  cleanInput($_POST['name']),
                    'email'  =>  cleanInput($_POST['email']),
                    'phone'  =>  cleanInput($_POST['phone'])
                );
                if(isset($_POST['password']) && $_POST['password']!=""){
                    $password=md5(trim($_POST['password']));
                    $data = array_merge($data, array("password"=>$password));
                }
                $user_edit=Update('tbl_users', $data, "WHERE id = '".$user_id."'");
                $_SESSION['class']="success";
                $_SESSION['msg']="11";
            }else{
                $_SESSION['class']="warn";
                $_SESSION['msg']="email_exist";
            }
        }
        if(isset($_GET['redirect'])){
        	header("Location:user_profile.php?user_id=".$user_id.'&redirect='.$_GET['redirect']);
        }else{
        	header("Location:user_profile.php?user_id=".$user_id);
        }
        exit;
    }
?>

<link rel="stylesheet" type="text/css" href="assets/css/stylish-tooltip-new.css">

 <Style>
                .block_wallpaper .image-wrapper {
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 340px;
                }
                .block_wallpaper .image figure {
                    position: relative;
                    overflow: hidden;
                    width: 100%;
                    height: 100%;
                    margin: 0;
                    padding: 0 0 80%;
                    background-color: #e3e9ed;
                }
                .block_wallpaper .image--triple {
                    grid-template-areas:
                        'one three'
                        'two four';
                    row-gap: 1px;
                }
                .block_wallpaper .image--dual, .block_wallpaper .image--triple {
                    grid-template-columns: repeat(2, 50%);
                    column-gap: 1px;
                }
                .block_wallpaper .image {
                    display: grid;
                    height: 100%;
                }
                .block_wallpaper .image figure:nth-child(1) {
                    grid-area: one;
                }
                .block_wallpaper .image figure:nth-child(2) {
                    grid-area: two;
                }
                .block_wallpaper .image figure:nth-child(3) {
                    grid-area: three;
                }
                .block_wallpaper .image figure:nth-child(4) {
                    grid-area: four;
                }
                .block_wallpaper .image img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

            </Style>
<Style>

.user_dashboard_mr_bottom{
	margin-bottom:0px;
	display:inline-block;
	width:100%;
}
.user_dashboard_item .card-banner{
	overflow: hidden !important;
	margin-bottom:10px !important
}
.user_dashboard_item .badge-icon {
    padding: 0px 15px !important;
    margin-right: 10px;
	border-radius:6px;
	background:#fff !important;
	margin-bottom:10px !important;
}
.user_dashboard_item .badge-icon i {
    padding: 8px !important;
    border-radius: 30px;
    width: 38px !important;
    height: 38px !important;
	font-size: 16px !important;
	line-height: 20px;
}
.card-item-box a:hover{
	cursor:auto !important;
}
    .user_dashboard_item .user_profile_img{
    padding: 6px;
	border-radius: 30px;
    width: 55px;
    height: 55px;
	line-height:40px;
	float:left;
	padding-left:0;
    font-size: 16px;    
}
.user_dashboard_item span.badge span{
	line-height:54px;
}
.user_dashboard_item .user_profile_img img{
	border-radius:30px;
	width:42px;
	height:42px;
}
.user_dashboard_item .badge-success {
    color: #424242 !important;
}
.user_dashboard_item .content .value {
	margin-top:8px;
}
.user_dashboard_item .card-banner .content{
	padding:15px !important;
	display:block !important;
	float:left;
}
.user_dashboard_item .card-banner .content .title {
    float: left;
    text-align: left;
    margin-top: 25px;
}
.user_dashboard_item .card-banner .content .value {
    font-size: 2.2em !important;
    line-height: 32px !important;
    font-weight: 600;
    padding-top: 10px !important;
    color: #444;
	float:right;
}
.user_dashboard_item .card-banner .content .value .sign{
	line-height:20px !important;
	margin-right:0 !important;
	padding-left:3px;
}
.user_dashboard_item .card-banner .icon {
	font-size: 2em !important;
    color: #444;
    padding: 10px;
    height: 60px !important;
    width: 60px !important;    
}
</Style>

<div class="row">
	<div class="col-lg-12">
		<?php
			if(isset($_GET['redirect'])){
	         	echo '<a href="manage_users.php"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
	        }
	        else{
	         	echo '<a href="manage_users.php"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
	        }
		?>
		<div class="page_title_block user_dashboard_item" style="background-color: #E91E63;border-radius:6px;border-bottom:0">
			<div class="user_dashboard_mr_bottom">
			  <div class="col-md-12 col-xs-12"> <br>
				<span class="badge badge-success badge-icon">
				  <div class="user_profile_img">
				  
				   <?php 
					  if($user_row['user_type']=='Google'){
						echo '<img src="assets/images/google-logo.png" style="width: 16px;height: 16px;position: absolute;top: 25px;z-index: 1;left: 70px;">';
					  }
					  else if($user_row['user_type']=='Facebook'){
						echo '<img src="assets/images/facebook-icon2.png" style="width: 16px;height: 16px;position: absolute;top: 25px;z-index: 1;left: 70px;">';
					  }
					?>
					<img type="image" src="<?php echo $user_img;?>" alt="image" style=""/>
				  </div>
				  <span style="font-size: 14px;"><?php echo $user_row['name'];?>				
				  </span>
				</span>  
				<span class="badge badge-success badge-icon">
				<i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
				<span style="font-size: 14px;text-transform: lowercase;"><?php echo $user_row['email'];?></span>
				</span> 
				
				<?php if($user_row['otp_status'] == "0"){?>
			          <span class="badge badge-success badge-icon">
    				  <strong style="font-size: 14px;">OTP:</strong>
    				  <span style="font-size: 14px;">Not verified</span>
    				</span>   
                <?php }?> 
                
                <?php if($user_row['otp_status'] == "1"){?>
    	    	    <span class="badge badge-success badge-icon">
    				  <strong style="font-size: 14px;">OTP:</strong>
    				  <span style="font-size: 14px;">verified</span>
    				</span>         
                <?php }?> 
				
				
				<span class="badge badge-success badge-icon">
				  <strong style="font-size: 14px;">Registered At:</strong>
				  <span style="font-size: 14px;"><?php echo date('d-m-Y',$user_row['registered_on']);?></span>
				</span>
				<span class="badge badge-success badge-icon">
				  <strong style="font-size: 14px;">Last Activity On:</strong>
				  <span style="font-size: 14px;text-transform: lowercase;"><?php echo getLastActiveLog($user_id)?></span>
				</span>
				<br><br/>
			  </div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card card-tab">
			<div class="card-header" style="overflow-x: auto;overflow-y: hidden;">
				<ul class="nav nav-tabs" role="tablist">
		            <li role="dashboard" class="active"><a href="#edit_profile" aria-controls="edit_profile" role="tab" data-toggle="tab">Details</a></li>
		            <li role="dashboard" ><a href="#edit_post" aria-controls="edit_post" role="tab" data-toggle="tab">Post</a></li>
		        </ul>
			</div>
			<div class="card-body no-padding tab-content">
				<div role="tabpanel" class="tab-pane active" id="edit_profile">
					<div class="row">
						<div class="col-md-12">
							<form action="" method="post" class="form form-horizontal" enctype="multipart/form-data">
					          <div class="section">
					            <div class="section-body">
					                <div class="form-group">
                                        <label class="col-md-3 control-label">Name :-</label>
                                        <div class="col-md-6">
                                          <input type="text" name="name" id="name" value="<?php if(isset($_GET['user_id'])){echo $user_row['name'];}?>" class="form-control" required>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-md-3 control-label">Email :-</label>
                                        <div class="col-md-6">
                                          <input type="email" name="email" id="email" value="<?php if(isset($_GET['user_id'])){echo $user_row['email'];}?>" class="form-control" required>
                                        </div>
                                      </div>
                        
                                      <div class="form-group">
                                        <label class="col-md-3 control-label">Phone :-</label>
                                        <div class="col-md-6">
                                          <input type="text" name="phone" id="phone" value="<?php if(isset($_GET['user_id'])){echo $user_row['phone'];}?>" class="form-control">
                                        </div>
                                      </div>

                                    <div class="form-group">
					                <div class="col-md-9 col-md-offset-3">
					                  <button type="submit" name="btn_submit" class="btn btn-primary">Save</button>
					                </div>
					              </div>
					            </div>
					          </div>
					        </form>
						</div>
					</div>
				</div>
				
				<div role="tabpanel" class="tab-pane" id="edit_post">
					<div class="row">
						<div class="col-md-12">
							<form action="" method="post" class="form form-horizontal" enctype="multipart/form-data">
					          <div class="section">
					            <div class="section-body">
					              <div class="row">
                    <?php $i=0; while($row=mysqli_fetch_array($result)) { ?>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="block_wallpaper">    
                            <div class="wall_category_block" style="background: #00000075; z-index: 1;">
                                <h2 style="color: #FFC107;">
                                    <?php echo CURRENCY?>  <?php echo number_format($row['money']);?>
                                </h2>  
                                <div class="checkbox" style="float: right;">
                                    
                                </div>
                            </div>
                            <div class="wall_image_title">
                                <h2><a><?php echo $row['title'];?></a></h2>
                                <h2><a><?php echo $row['con'];?></a></h2>
                                <ul>        
                                    <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['total_views'];?> Views"><i class="fa fa-eye"></i></a></li>                      
                                    <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['total_share'];?> Share"><i class="fa fa-share-alt"></i></a></li>         

                                    <li><a href="add_post.php?post_id=<?php echo $row['id'];?>" target="_blank" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>               
                                    <li><a href="" class="btn_delete_a" data-id="<?php echo $row['id'];?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                                    </li>
                                    <?php if($row['status']!="0"){?>
                                    <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="" /></a></div></li>
                                    <?php }else{?>
                                    <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="" /></a></div></li>
                                    <?php }?>
                                </ul>
                            </div>
                            <?php if($row['image_4'] == ""){?>
						           <div class="image-wrapper">
                                    <div class="image image--triple">
                                        <figure>
                                            <img class="loaded" src="thumb.php?src=./images/<?php echo $row['image_1'];?>&size=300x300">
                                        </figure>
                                        <figure>
                                            <img class="loaded" src="thumb.php?src=./images/<?php echo $row['image_1'];?>&size=300x300">
                                        </figure>
                                        <figure>
                                            <img class="loaded" src="thumb.php?src=./images/<?php echo $row['image_1'];?>&size=300x300">
                                        </figure>
                                        <figure>
                                            <img class="loaded" src="thumb.php?src=./images/<?php echo $row['image_1'];?>&size=300x300>">
                                        </figure>
                                    </div>
        					    </div>  
                            <?php }?> 
                            
                            <?php if($row['image_4'] != ""){?>
    					        <div class="image-wrapper">
                                    <div class="image image--triple">
                                        <figure>
                                            <img class="loaded" src="thumb.php?src=./images/<?php echo $row['image_1'];?>&size=300x300">
                                        </figure>
                                        <figure>
                                            <img class="loaded" src="thumb.php?src=./images/<?php echo $row['image_2'];?>&size=300x300">
                                        </figure>
                                        <figure>
                                            <img class="loaded" src="thumb.php?src=./images/<?php echo $row['image_3'];?>&size=300x300">
                                        </figure>
                                        <figure>
                                            <img class="loaded" src="thumb.php?src=./images/<?php echo $row['image_4'];?>&size=300x300">
                                        </figure>
                                    </div>
        					    </div>                    
                            <?php }?> 
                          
                        </div>
                    </div>
                    <?php $i++; } ?>     
                </div>
                
    					            </div>
					          </div>
					        </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include('includes/footer.php'); ?>

<script type="text/javascript">

  $(".toggle_btn a").on("click",function(e){
    e.preventDefault();
    
    var _for=$(this).data("action");
    var _id=$(this).data("id");
    var _column=$(this).data("column");
    var _table='tbl_post';

    $.ajax({
      type:'post',
      url:'processData.php',
      dataType:'json',
      data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'id'},
      success:function(res){
          console.log(res);
          if(res.status=='1'){
            location.reload();
          }
        }
    });

  });
  
  
$(".btn_delete_a").on("click", function(e) {

    e.preventDefault();

    var _id = $(this).data("id");
    var _table = 'tbl_post';

    swal({
      title: "Are you sure?",
      text: "All data will be delete which belong to this.",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger btn_edit",
      cancelButtonClass: "btn-warning btn_edit",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true
    },
    function(isConfirm) {
      if (isConfirm) {

        $.ajax({
          type: 'post',
          url: 'processData.php',
          dataType: 'json',
          data: {id: _id, for_action: 'delete', table: _table, 'action': 'multi_action'},
          success: function(res) {
            console.log(res);
            $('.notifyjs-corner').empty();
            if(res.status=='1'){
              swal({
                  title: "Successfully", 
                  text: "Post is deleted.", 
                  type: "success"
              },function() {
                  location.reload();
              });
            }
            else if(res.status=='-2'){
                swal(res.message);
            }
          }
        });
      } else {
        swal.close();
      }

    });
  });;
</script>