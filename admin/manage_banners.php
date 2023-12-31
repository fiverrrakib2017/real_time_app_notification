<?php
/**
 * Company : Nemosofts
 * Detailed : Software Development Company in Sri Lanka
 * Developer : Thivakaran
 * Contact : thivakaran829@gmail.com
 * Contact : nemosofts@gmail.com
 * Website : https://nemosofts.com
 */
 $page_title="Manage Promos";
    include("includes/header.php");
	require("includes/function.php");
	require("language/language.php");
	date_default_timezone_set("Asia/Colombo");
    
    $tableName="tbl_banner";   
    $targetpage = "manage_banners.php"; 
    $limit = 6; 
    
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
    
    $data_qry="SELECT * FROM tbl_banner ORDER BY tbl_banner.bid DESC LIMIT $start, $limit";
    
    $result=mysqli_query($mysqli,$data_qry); 
    
    if(isset($_GET['banner_id'])){
    
        $cat_res=mysqli_query($mysqli,'SELECT * FROM tbl_banner WHERE bid=\''.$_GET['banner_id'].'\'');
        $cat_res_row=mysqli_fetch_assoc($cat_res);
        
        if($cat_res_row['banner_image']!=""){
            unlink('images/'.$cat_res_row['banner_image']);
        }
    
        Delete('tbl_banner','bid='.$_GET['banner_id'].'');
        
        $_SESSION['msg']="12";
        $_SESSION['class']='success'; 
        header( "Location:manage_banners.php");
        exit;
    }	
	 
    if(isset($_GET['status_deactive_id'])){
        $data = array('status'  =>  '0');
        
        $edit_status=Update('tbl_banner', $data, "WHERE bid = '".$_GET['status_deactive_id']."'");
        
        $_SESSION['msg']="14";
        header( "Location:manage_banners.php");
        exit;
    }
  
    if(isset($_GET['status_active_id'])){
        $data = array('status'  =>  '1');
        
        $edit_status=Update('tbl_banner', $data, "WHERE bid = '".$_GET['status_active_id']."'");
        
        $_SESSION['msg']="13";   
        header( "Location:manage_banners.php");
        exit;
    }  
?>
                
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                 
                <div class="add_btn_primary"> <a href="add_banner.php?add=yes">Add Promos</a> </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>

           <div class="col-md-12 mrg-top">
            <div class="row">
              <?php 
              $i=0;
              while($row=mysqli_fetch_array($result))
              {         
          ?>
              <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="block_wallpaper">           
                  <div class="wall_image_title">
                    <h2><a href="#"><?php echo $row['banner_title'];?></a></h2>
                    <ul>                
                      <li><a href="add_banner.php?banner_id=<?php echo $row['bid'];?>" target="_blank" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>               
                      <li>
                        <a href="" class="btn_delete_a" data-id="<?php echo $row['bid'];?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                      </li>
                      
                      <?php if($row['status']!="0"){?>
                      <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['bid'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="" /></a></div></li>

                      <?php }else{?>
                      <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['bid'];?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="" /></a></div></li>
                      <?php }?>
                    </ul>
                  </div>
                  <span><img src="images/<?php echo $row['banner_image'];?>" /></span>
                </div>
              </div>
          <?php
            
            $i++;
              }
        ?>     
               
      </div>
          </div>
           <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
                <?php include("pagination.php");?>            
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       

<script type="text/javascript">
  $(".toggle_btn a").on("click",function(e){
    e.preventDefault();
    
    var _for=$(this).data("action");
    var _id=$(this).data("id");
    var _column=$(this).data("column");
    var _table='tbl_banner';

    $.ajax({
      type:'post',
      url:'processData.php',
      dataType:'json',
      data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'bid'},
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
    var _table = 'tbl_banner';

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
                  text: "Language is deleted.", 
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