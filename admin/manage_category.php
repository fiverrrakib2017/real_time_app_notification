<?php

 $page_title="Manage Categories";
include("includes/header.php");

    require("includes/function.php");
    require("language/language.php");
    
    if(isset($_POST['data_search'])){
        $qry="SELECT * FROM tbl_category                   
        WHERE tbl_category.category_name like '%".addslashes($_POST['search_value'])."%'
        ORDER BY tbl_category.category_name";
        $result=mysqli_query($mysqli,$qry); 
    
    }else{

        $tableName="tbl_category";   
        $targetpage = "manage_category.php"; 
        $limit = 12; 
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
        $qry="SELECT * FROM tbl_category
        ORDER BY tbl_category.cid DESC LIMIT $start, $limit";
        $result=mysqli_query($mysqli,$qry); 
    }  
    
    function get_total_post($cat_id){ 
        global $mysqli;   
        $qry_songs="SELECT COUNT(*) as num FROM tbl_post WHERE cat_id='".$cat_id."'";
        $total_songs = mysqli_fetch_array(mysqli_query($mysqli,$qry_songs));
        $total_songs = $total_songs['num'];
        return $total_songs;
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
                    <div class="search_block">
                        <form  method="post" action="">
                            <input class="form-control input-sm" placeholder="Search category..." aria-controls="DataTables_Table_0" type="search" name="search_value" value="<?php if(isset($_POST['data_search'])){ echo $_POST['search_value'];} ?>" required>
                            <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                        </form>  
                    </div>
                    <div class="add_btn_primary"> <a href="add_category.php?add=yes">Add Server</a> </div>
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
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="block_wallpaper">           
                        <div class="wall_image_title">
                            <h2><a href="#"><?php echo $row['category_name'];?> <span>(<?php echo get_total_post($row['cid']);?>)</span></a></h2>
                            <ul>                
                                <li><a href="add_category.php?cat_id=<?php echo $row['cid'];?>" target="_blank" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>               
                                <li>
                                <a href="" class="btn_delete_a" data-id="<?php echo $row['cid'];?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                                </li>
                                <?php if($row['status']!="0"){?>
                                <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['cid'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="" /></a></div></li>
                                <?php }else{?>
                                <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['cid'];?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="" /></a></div></li>
                                <?php }?>
                            </ul>
                        </div>
                        <span><img src="images/<?php echo $row['category_image'];?>" /></span>
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
                    <?php if(!isset($_POST["data_search"])){ include("pagination.php");}?>
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
    var _table='tbl_category';

    $.ajax({
      type:'post',
      url:'processData.php',
      dataType:'json',
      data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'cid'},
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
    var _table = 'tbl_category';

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
                  text: "Category is deleted.", 
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