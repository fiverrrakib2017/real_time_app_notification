<?php
/**
 * Company : Nemosofts
 * Detailed : Software Development Company in Sri Lanka
 * Developer : Thivakaran
 * Contact : thivakaran829@gmail.com
 * Contact : nemosofts@gmail.com
 * Website : https://nemosofts.com
 */
 
    $page_title="Manage Post Approval";
    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");
    
    $tableName="tbl_post";   
    $targetpage = "manage_post.php"; 
    $limit = 12; 
    $query = "SELECT COUNT(*) as num FROM $tableName WHERE tbl_post.status='1' AND tbl_post.active='0'";
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
    
    $data_qry="SELECT * FROM $tableName WHERE tbl_post.status='1' AND tbl_post.active='0'
    ORDER BY tbl_post.id DESC LIMIT $start, $limit";
    $result=mysqli_query($mysqli,$data_qry); 
    
?>

                
<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title"><?=$page_title?></div>
                </div>
                
            </div>
            <div class="clearfix"></div>
            
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
            
            <div class="col-md-12 mrg-top">
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
                                <h2><?php echo $row['title'];?> (<?php echo $row['con'];?>)</h2>
                                <h2><?php echo $row['phone_1'];?></h2>
                                <h2><?php echo $row['phone_2'];?></h2>
                                <ul>                
                                    <li><a href="add_post.php?post_id=<?php echo $row['id'];?>" target="_blank" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>               
                                    <li><a href="" class="btn_delete_a" data-id="<?php echo $row['id'];?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                                    </li>
                                    <?php if($row['active']!="0"){?>
                                    <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" data-action="deactive" data-column="active" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="" /></a></div></li>
                                    <?php }else{?>
                                    <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" data-action="active" data-column="active" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="" /></a></div></li>
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
            <div class="col-md-12 col-xs-12">
                <div class="pagination_item_block">
                    <nav>
                        <?php if(!isset($_POST["search_data"])){ include("pagination.php");}?>            
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
    var _table='tbl_post';

    $.ajax({
      type:'post',
      url:'processData.php',
      dataType:'json',
      data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_active','tbl_id':'id'},
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