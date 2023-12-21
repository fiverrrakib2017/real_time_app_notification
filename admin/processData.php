<?php 
/**
 * Company : Nemosofts
 * Detailed : Software Development Company in Sri Lanka
 * Developer : Thivakaran
 * Contact : thivakaran829@gmail.com
 * Contact : nemosofts@gmail.com
 * Website : https://nemosofts.com
 */

	require("includes/connection.php");
	require("includes/function.php");
	require("language/language.php");

	$response=array();

	$_SESSION['class'] = "success";

	switch ($_POST['action']) {
	    
	    case 'toggle_active':{
		    
				$id = $_POST['id'];
				$for_action = $_POST['for_action'];
				$column = $_POST['column'];
				$tbl_id = $_POST['tbl_id'];
				$table_nm = $_POST['table'];

				if ($for_action == 'active') {
					$data = array($column  =>  '1');
					$edit_status = Update($table_nm, $data, "WHERE $tbl_id = '$id'");
					$_SESSION['msg'] = "13";
				} else {
					$data = array($column  =>  '0');
					$edit_status = Update($table_nm, $data, "WHERE $tbl_id = '$id'");
					$_SESSION['msg'] = "14";
				}

				$response['status'] = 1;
				$response['action'] = $for_action;
				echo json_encode($response);
			}
			break;

		case 'toggle_status':{
		    
				$id = $_POST['id'];
				$for_action = $_POST['for_action'];
				$column = $_POST['column'];
				$tbl_id = $_POST['tbl_id'];
				$table_nm = $_POST['table'];

				if ($for_action == 'active') {
					$data = array($column  =>  '1');
					$edit_status = Update($table_nm, $data, "WHERE $tbl_id = '$id'");
					$_SESSION['msg'] = "13";
				} else {
					$data = array($column  =>  '0');
					$edit_status = Update($table_nm, $data, "WHERE $tbl_id = '$id'");
					$_SESSION['msg'] = "14";
				}

				$response['status'] = 1;
				$response['action'] = $for_action;
				echo json_encode($response);
			}
			break;

		case 'multi_action': {
		    
				$action = $_POST['for_action'];
				$ids = implode(",", $_POST['id']);
				$tbl_nm = $_POST['table'];

				if ($ids == '') {
					$ids = $_POST['id'];
				}

				if ($action == 'enable') {
					$sql = "UPDATE $tbl_nm SET `status`='1' WHERE `id` IN ($ids)";
					mysqli_query($mysqli, $sql);
					$_SESSION['msg'] = "13";

				} 
				else if ($action == 'disable') {
					$sql = "UPDATE $tbl_nm SET `status`='0' WHERE `id` IN ($ids)";
					if (mysqli_query($mysqli, $sql)) {
						$_SESSION['msg'] = "14";
					}
				}
				
				
				
				else if ($action == 'delete'){
					
					if($tbl_nm=='tbl_category'){
						$sql='SELECT * FROM tbl_category WHERE `cid` IN ('.$ids.')';
						$result=mysqli_query($mysqli,$sql);

						while ($cat_res_row=mysqli_fetch_assoc($result)){
							if($cat_res_row['category_image']!=""){
								unlink('images/'.$cat_res_row['category_image']);
							}
							Delete('tbl_category','cid='.$cat_res_row['cid'].'');

						}
						mysqli_free_result($result);
					}
					
					if($tbl_nm=='tbl_sub_category'){
						$sql='SELECT * FROM tbl_sub_category WHERE `sid` IN ('.$ids.')';
						$result=mysqli_query($mysqli,$sql);

						while ($cat_res_row=mysqli_fetch_assoc($result)){
							if($cat_res_row['sub_category_image']!=""){
								unlink('images/'.$cat_res_row['sub_category_image']);
							}
							Delete('tbl_sub_category','sid='.$cat_res_row['sid'].'');

						}
						mysqli_free_result($result);
					}
					
				
        			
        			if($tbl_nm=='tbl_city'){
        				$deleteSql="DELETE FROM tbl_city WHERE `aid` IN ($ids)";
        				mysqli_query($mysqli, $deleteSql);
        			}
        			
        			if($tbl_nm=='tbl_post'){
        				$sql="SELECT * FROM tbl_post WHERE `id` IN ($ids)";
        				$res=mysqli_query($mysqli, $sql);
        				while ($row=mysqli_fetch_assoc($res)){
        					if($row['image_1']!=""){
        						unlink('images/'.$row['image_1']);
        					}
        					if($row['image_2']!=""){
        						unlink('images/'.$row['image_2']);
        					}
        					if($row['image_3']!=""){
        						unlink('images/'.$row['image_3']);
        					}
        					if($row['image_4']!=""){
        						unlink('images/'.$row['image_4']);
        					}
        					if($row['image_5']!=""){
        						unlink('images/'.$row['image_5']);
        					}
        				}
        				$deleteSql="DELETE FROM tbl_post WHERE `id` IN ($ids)";
        				mysqli_query($mysqli, $deleteSql);
        			}
        			
        			
        			if($tbl_nm=='tbl_reports'){
						$deleteSql = "DELETE FROM $tbl_nm WHERE `id` IN ($ids)";
						mysqli_query($mysqli, $deleteSql);
					}
					
					if($tbl_nm=='tbl_banner'){
        				$sql="SELECT * FROM tbl_banner WHERE `bid` IN ($ids)";
        				$res=mysqli_query($mysqli, $sql);
        				while ($row=mysqli_fetch_assoc($res)){
        					if($row['banner_image']!=""){
        						unlink('images/'.$row['banner_image']);
        					}
        				}
        				$deleteSql="DELETE FROM tbl_banner WHERE `bid` IN ($ids)";
        				mysqli_query($mysqli, $deleteSql);
        			}
					
			
					if($tbl_nm=='tbl_users'){
					
						$deleteSql = "DELETE FROM tbl_reports WHERE `user_id` IN ($ids)";
						mysqli_query($mysqli, $deleteSql);

						$deleteSql = "DELETE FROM tbl_active_log WHERE `user_id` IN ($ids)";
						mysqli_query($mysqli, $deleteSql);

						$deleteSql = "DELETE FROM $tbl_nm WHERE `id` IN ($ids)";
						mysqli_query($mysqli, $deleteSql);
						
						$sql="SELECT * FROM tbl_post WHERE `user_id` IN ($ids)";
        				$res=mysqli_query($mysqli, $sql);
        				while ($row=mysqli_fetch_assoc($res)){
        					if($row['image_1']!=""){
        						unlink('images/'.$row['image_1']);
        					}
        					if($row['image_2']!=""){
        						unlink('images/'.$row['image_2']);
        					}
        					if($row['image_3']!=""){
        						unlink('images/'.$row['image_3']);
        					}
        					if($row['image_4']!=""){
        						unlink('images/'.$row['image_4']);
        					}
        					if($row['image_5']!=""){
        						unlink('images/'.$row['image_5']);
        					}
        				}
        				$deleteSql="DELETE FROM tbl_post WHERE `user_id` IN ($ids)";
        				mysqli_query($mysqli, $deleteSql);
					}
					
					$_SESSION['msg'] = "12";
				}

				$response['status'] = 1;
				echo json_encode($response);
			}
			break;
		
		default:
			# code...
			break;
	}

?>