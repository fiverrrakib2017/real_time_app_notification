<?php 
/**
	 * Company : Nemosofts
	* Detailed : Software Development Company in Sri Lanka
	* Developer : Thivakaran
	* Contact : info.nemosofts@gmail.com
	* Website : https://nemosofts.com
	*/
    $page_title="Manage Promote Plan";
    include("includes/header.php");

    require("includes/function.php");
    require("language/language.php");
    
    $qry2="SELECT * FROM payment_settings where id='1'";
    $result2=mysqli_query($mysqli,$qry2);
    $settings_row2=mysqli_fetch_assoc($result2);

    // Get page data
    $tableName="subscription_plan";    
    $targetpage = "manage_promote.php";  
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

    $qry="SELECT subscription_plan.*,subscription_plan.id FROM subscription_plan ORDER BY subscription_plan.id ASC LIMIT $start, $limit";   
    $result=mysqli_query($mysqli,$qry);
?>

<Style>
    img.my_img {
    max-height: 40px;
    max-width: 40px;
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
                  <th>logo</th>
                  <th>Plan Name</th>
                  <th>Duration</th>
                  <th>Price</th>
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
                    <td><img class="my_img" src="assets/images/<?php echo $row['promote_image'];?>" alt="Girl in a jacket" width="500" height="200"></td>
                    <td><b><?php echo $row['plan_name'];?></b></td>
                    
                    <td>
						<?php if ($row['plan_duration_type'] == "1") { ?>
						    Day(s)
						<?php } else if ($row['plan_duration_type'] == "30") { ?>
						    Month(s)
						<?php } else if ($row['plan_duration_type'] == "365") { ?>
						    Year(s)
						<?php }  ?>
					</td>
                    
                    <td><b><?php echo $settings_row2['currency_code'];?> <?php echo $row['plan_price'];?> -  <?php echo $settings_row2['currency_code'];?> <?php echo $row['plan_price_2'];?>  - <?php echo $settings_row2['currency_code'];?><?php echo $row['plan_price_3'];?></b></td>
                    
                    <td nowrap="">
                        <a href="edit_promote.php?promote_id=<?php echo $row['id'];?>"class="btn btn-primary btn_delete" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a>
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