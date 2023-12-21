<?php 
/**
	 * Company : Nemosofts
	* Detailed : Software Development Company in Sri Lanka
	* Developer : Thivakaran
	* Contact : info.nemosofts@gmail.com
	* Website : https://nemosofts.com
	*/
    $page_title="Manage Post Reports";
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

    // Get page data
    $tableName="tbl_reports";    
    $targetpage = "manage_reports.php";  
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


    $qry="SELECT tbl_reports.*,tbl_post.title FROM tbl_reports
    LEFT JOIN tbl_post ON tbl_reports.post_id= tbl_post.id ORDER BY tbl_reports.id DESC LIMIT $start, $limit";   
    $result=mysqli_query($mysqli,$qry);
 
   
?>
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
              
            </div>

				<div class="col-md-12">
					<div class="col-md-4 col-xs-12 text-right" style="float: right;">
						<div class="checkbox" style="width: 95px;margin-top: 5px;margin-left: 10px;right: 100px;position: absolute;">
							<input type="checkbox" id="checkall_input">
							<label for="checkall_input">
								Select All
							</label>
						</div>
						<div class="dropdown" style="float:right">
							<button class="btn btn-primary dropdown-toggle btn_cust" type="button" data-toggle="dropdown">Action
								<span class="caret"></span></button>
							<ul class="dropdown-menu" style="right:0;left:auto;">
								<li><a href="" class="actions" data-action="delete">Delete !</a></li>
							</ul>
						</div>
					</div>
				</div>
          </div>
          <div class="clearfix"></div>

          <div class="col-md-12 mrg-top">
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                <th class="text-center">#</th>
                  <th>Report User</th>
                  <th>Post Title</th>
                  <th>Date Time</th>
                  <th>Report</th> 
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
                    <td width="50">
                        <div class="checkbox" style="float: right;margin: 0px">
                        	<input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i; ?>" value="<?php echo $row['id']; ?>" class="post_ids" style="margin: 0px;">
                        	<label for="checkbox<?php echo $i;?>"></label>
                        </div>
    				</td>
                    <td><b><a href="user_profile.php?user_id=<?php echo $row['user_id'];?>&redirect=<?=$redirectUrl?>"><?php echo get_user_info($row['user_id'])['name'];?></a></b></td>
                    
                    <td><b><a href="add_post.php?post_id=<?php echo $row['post_id'];?>"><?php echo $row['title'];?></a></b></td>
                    
                    <td><?php echo calculate_time_span($row['date_time'],true)?></td>
                    
                    <td><?php echo $row['report'];?></td>                  
                    <td nowrap="">
                      <a href="" data-id="<?php echo $row['id'];?>" data-toggle="tooltip" data-tooltip="Delete" class="btn btn-danger btn_delete btn_delete_a">
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
              	<?php if(!isset($_POST["search"])){ include("pagination.php");}?>                 
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>            
               
        
<?php include("includes/footer.php");?>  


<script type="text/javascript">
	$(".toggle_btn_a").on("click", function(e) {
		e.preventDefault();

		var _for = $(this).data("action");
		var _id = $(this).data("id");
		var _column = $(this).data("column");
		var _table = 'tbl_reports';

		$.ajax({
			type: 'post',
			url: 'processData.php',
			dataType: 'json',
			data: {
				id: _id,
				for_action: _for,
				column: _column,
				table: _table,
				'action': 'toggle_status',
				'tbl_id': 'id'
			},
			success: function(res) {
				console.log(res);
				if (res.status == '1') {
					location.reload();
				}
			}
		});

	});

	$(".btn_delete_a").on("click", function(e) {

		e.preventDefault();

		var _id = $(this).data("id");
		var _table = 'tbl_reports';

		swal({
			title: "Are you sure to delete this?",
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
		                        text: "User is deleted.", 
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
	});

	$(".actions").click(function(e) {
		e.preventDefault();

		var _ids = $.map($('.post_ids:checked'), function(c) {
			return c.value;
		});
		var _action = $(this).data("action");

		if (_ids != '') {
			swal({
				title: "Do you really want to perform?",
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

					var _table = 'tbl_reports';

					$.ajax({
						type: 'post',
						url: 'processData.php',
						dataType: 'json',
						data: {
							id: _ids,
							for_action: _action,
							table: _table,
							'action': 'multi_action'
						},
						success: function(res) {
							console.log(res);
							$('.notifyjs-corner').empty();
							if (res.status == '1') {
								swal({
									title: "Successfully",
									text: "You have successfully done",
									type: "success"
								}, function() {
									location.reload();
								});
							}
						}
					});
				} else {
					swal.close();
				}

			});
		} else {
			swal("Sorry no users selected !!")
		}
	});


	var totalItems = 0;

	$("#checkall_input").click(function() {

		totalItems = 0;

		$('input:checkbox').not(this).prop('checked', this.checked);
		$.each($("input[name='post_ids[]']:checked"), function() {
			totalItems = totalItems + 1;
		});

		if ($('input:checkbox').prop("checked") == true) {
			$('.notifyjs-corner').empty();
			$.notify(
				'Total ' + totalItems + ' item checked', {
					position: "top center",
					className: 'success',
					clickToHide: false,
					autoHide: false
				}
			);
		} else if ($('input:checkbox').prop("checked") == false) {
			totalItems = 0;
			$('.notifyjs-corner').empty();
		}
	});

	$(".post_ids").click(function(e) {

		if ($(this).prop("checked") == true) {
			totalItems = totalItems + 1;
		} else if ($(this).prop("checked") == false) {
			totalItems = totalItems - 1;
		}

		if (totalItems == 0) {
			$('.notifyjs-corner').empty();
			exit();
		}

		$('.notifyjs-corner').empty();

		$.notify(
			'Total ' + totalItems + ' item checked', {
				position: "top center",
				className: 'success',
				clickToHide: false,
				autoHide: false
			}
		);
	});
</script>