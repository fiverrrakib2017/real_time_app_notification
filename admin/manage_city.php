<?php
/**
 * Company : Nemosofts
 * Detailed : Software Development Company in Sri Lanka
 * Developer : Thivakaran
 * Contact : thivakaran829@gmail.com
 * Contact : nemosofts@gmail.com
 * Website : https://nemosofts.com
 */
 $page_title="Manage City";

include("includes/header.php");

    require("includes/function.php");
    require("language/language.php");
    
    if(isset($_POST['data_search'])){
        $qry="SELECT * FROM tbl_city                   
        WHERE tbl_city.city_name like '%".addslashes($_POST['search_value'])."%'
        ORDER BY tbl_city.city_name";
        $result=mysqli_query($mysqli,$qry); 
    
    }else{

        $tableName="tbl_city";   
        $targetpage = "manage_city.php"; 
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
        $qry="SELECT * FROM tbl_city
        ORDER BY tbl_city.aid DESC LIMIT $start, $limit";
        $result=mysqli_query($mysqli,$qry); 
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
                            <input class="form-control input-sm" placeholder="Search Districts..." aria-controls="DataTables_Table_0" type="search" name="search_value" value="<?php if(isset($_POST['data_search'])){ echo $_POST['search_value'];} ?>" required>
                            <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                        </form>  
                    </div>
                    <div class="add_btn_primary"> <a href="add_city.php?add=yes">Add City</a> </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-md-12 mrg-top">
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>User Name</th>
                  <th class="cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              
		        <?php
				$i = 0;
				if(mysqli_num_rows($result) > 0){
					while ($row = mysqli_fetch_array($result)) {
			    ?>
                <tr>
                 
                <td><?php echo $row['city_name'];?></td>  

                <td nowrap="">
                    <a href="add_city.php?city_id=<?php echo $row['aid'];?>"class="btn btn-primary btn_delete" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a>

                    <a href="javascript:void(0)" data-id="<?php echo $users_row['id']; ?>" data-toggle="tooltip" data-tooltip="Delete" class="btn btn-danger btn_delete btn_delete_a">
                        <i class="fa fa-trash"></i>
                    </a>
                </td> 

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
    var _table='tbl_language';

    $.ajax({
      type:'post',
      url:'processData.php',
      dataType:'json',
      data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'lid'},
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
    var _table = 'tbl_language';

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