<?php
    /**
    * Company : Nemosofts
    * Detailed : Software Development Company in Sri Lanka
    * Developer : Thivakaran
    * Contact : thivakaran829@gmail.com
    * Contact : nemosofts@gmail.com
    * Website : https://nemosofts.com
    */
    include("includes/connection.php");
    include("includes/function.php");
    include("language/app_language.php");
    include("smtp_email.php"); 
    require('stripe-php/init.php'); 

    $file_path = getBaseUrl();
    define("APP_FROM_EMAIL",$settings_details['email_from']);	
    define("PACKAGE_NAME",$settings_details['package_name']);
    date_default_timezone_set("Asia/Colombo");
    $live_date = date('Y-m-d');

    function generateRandomPassword($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	
	function generateRandomOTP($length = 10) {
	    $characters2 = '0123456789';
	    $charactersLength2 = strlen($characters2);
	    $randomString2 = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString2 .= $characters2[rand(0, $charactersLength2 - 1)];
	    }
	    return $randomString2;
	}
    
    function get_total_post($cat_id){
 		global $mysqli;
 		$qry_cat="SELECT COUNT(*) as num FROM tbl_post WHERE cat_id='".$cat_id."'";
		$total_cat = mysqli_fetch_array(mysqli_query($mysqli,$qry_cat));
		$total_cat = $total_cat['num'];
		return $total_cat;
	}
	
	 function get_total_post_city($cit_id){
 		global $mysqli;
 		$qry_city="SELECT COUNT(*) as num FROM tbl_post WHERE cit_id='".$cit_id."'";
		$total_city = mysqli_fetch_array(mysqli_query($mysqli,$qry_city));
		$total_city = $total_city['num'];
		return $total_city;
	}
	
	function get_total_post_scat_id($scat_id){
 		global $mysqli;
 		$qry_city="SELECT COUNT(*) as num FROM tbl_post WHERE scat_id='".$scat_id."'";
		$total_city = mysqli_fetch_array(mysqli_query($mysqli,$qry_city));
		$total_city = $total_city['num'];
		return $total_city;
	}
	
    function get_thumb($filename,$thumb_size){	
    	$file_path = getBaseUrl();
    	return $thumb_path=$file_path.'thumb.php?src='.$filename.'&size='.$thumb_size;
    }
    
    $get_method = checkSignSalt($_POST['data']);
    
    if($get_method['method_name']=="home"){
        $jsonObj= array();	
     	$page_limit=10;
    	$limit=($get_method['page']-1) * $page_limit;
    	
    	$query="SELECT * FROM tbl_post
    	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
    	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
    	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
        WHERE tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_city.status='1' 
        ORDER BY tbl_post.id DESC LIMIT $limit, $page_limit";
        	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
    	while($data = mysqli_fetch_assoc($sql)){
            $row['id'] = $data['id'];
            $row['title'] = $data['title'];
            $row['description'] = $data['description'];
            $row['money'] = $data['money'];
            $row['phone_1'] = $data['phone_1'];
            $row['phone_2'] = $data['phone_2'];
            $row['condition'] = $data['con'];
            
            $row['thumbnail_1'] = get_thumb('images/'.$data['image_1'],'300x300');
            $row['thumbnail_2'] = get_thumb('images/'.$data['image_2'],'300x300');
            $row['thumbnail_3'] = get_thumb('images/'.$data['image_3'],'300x300');
            $row['thumbnail_4'] = get_thumb('images/'.$data['image_4'],'300x300');
            $row['thumbnail_5'] = get_thumb('images/'.$data['image_5'],'300x300');
            
            $row['image_1'] = $file_path.'images/'.$data['image_1'];
            $row['image_2'] = $file_path.'images/'.$data['image_2'];
            $row['image_3'] = $file_path.'images/'.$data['image_3'];
            $row['image_4'] = $file_path.'images/'.$data['image_4'];
            $row['image_5'] = $file_path.'images/'.$data['image_5'];

            $row['cat_id'] = $data['cat_id'];
        	$row['category_name'] = $data['category_name'];
        	$row['sub_cat_id'] = $data['sub_cat_id'];
        	$row['sub_category_name'] = $data['sub_category_name'];
            $row['cit_id'] = $data['cit_id'];
            $row['city_name'] = $data['city_name'];
            $row['user_id'] = $data['user_id'];
            $row['active'] = $data['active'];
            $row['date_time'] = calculate_time_span($data['date_time'],true);
            $row['total_views'] = $data['total_views'];
            $row['total_share'] = $data['total_share'];
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    else if($get_method['method_name']=="spotlight_post"){
        $jsonObj= array();	
        
        $spotLight_exp_date = "tbl_post_promote.spotLight_exp_date > '".$live_date."'";

		$query="SELECT * FROM tbl_post
		LEFT JOIN tbl_post_promote ON tbl_post.id= tbl_post_promote.pt_id 
    	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
    	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
    	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
    	WHERE ".$spotLight_exp_date." 
    	AND tbl_post.status='1'  AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_sub_category.status='1' AND tbl_city.status='1' 
        ORDER BY rand() DESC LIMIT 10";
        	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
    	while($data = mysqli_fetch_assoc($sql)){
            $row['id'] = $data['id'];
            $row['title'] = $data['title'];
            $row['description'] = $data['description'];
            $row['money'] = $data['money'];
            $row['phone_1'] = $data['phone_1'];
            $row['phone_2'] = $data['phone_2'];
            $row['condition'] = $data['con'];
            
            $row['thumbnail_1'] = get_thumb('images/'.$data['image_1'],'300x300');
            $row['thumbnail_2'] = get_thumb('images/'.$data['image_2'],'300x300');
            $row['thumbnail_3'] = get_thumb('images/'.$data['image_3'],'300x300');
            $row['thumbnail_4'] = get_thumb('images/'.$data['image_4'],'300x300');
            $row['thumbnail_5'] = get_thumb('images/'.$data['image_5'],'300x300');
            
            $row['image_1'] = $file_path.'images/'.$data['image_1'];
            $row['image_2'] = $file_path.'images/'.$data['image_2'];
            $row['image_3'] = $file_path.'images/'.$data['image_3'];
            $row['image_4'] = $file_path.'images/'.$data['image_4'];
            $row['image_5'] = $file_path.'images/'.$data['image_5'];

            $row['cat_id'] = $data['cat_id'];
        	$row['category_name'] = $data['category_name'];
        	$row['sub_cat_id'] = $data['sub_cat_id'];
        	$row['sub_category_name'] = $data['sub_category_name'];
            $row['cit_id'] = $data['cit_id'];
            $row['city_name'] = $data['city_name'];
            $row['user_id'] = $data['user_id'];
            $row['active'] = $data['active'];
            $row['date_time'] = calculate_time_span($data['date_time'],true);
            $row['total_views'] = $data['total_views'];
            $row['total_share'] = $data['total_share'];
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    
    else if($get_method['method_name']=="filter_post"){
        $jsonObj= array();	
     	$page_limit=10;
    	$limit=($get_method['page']-1) * $page_limit;
        $sortBy = $get_method['sort'];
        $city_id=$get_method['city_id'];
        $cat_id=$get_method['cat_id'];
        $scat_id=$get_method['scat_id'];
       
        
        if ($city_id != "") {
          $who = "AND tbl_post.cit_id =". $city_id ."";
        }else {
            $who = "AND tbl_post.cit_id";
        }
        
        if ($scat_id != "") {
          $scat = "AND tbl_post.scat_id =". $scat_id ."";
        }else {
            $scat = "AND tbl_post.scat_id";
        }

        if ($cat_id != "") {
            $cat = "AND tbl_post.cat_id =". $cat_id ."";
        }else {
            $cat = "AND tbl_post.cat_id";
        }
        
        if($sortBy == "newest"){
            $sort = "ORDER BY tbl_post.id DESC";
		}else if($sortBy == "oldest"){
		     $sort = "ORDER BY tbl_post.id ASC";
		}else if($sortBy =="highest"){
		     $sort = "ORDER BY CAST(tbl_post.money AS int) ASC";
		}else if($sortBy =="lowest"){
		     $sort = "ORDER BY  CAST(tbl_post.money AS int) DESC";
		}

		if ($scat_id != "") {
            $query="SELECT * FROM tbl_post
        	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
        	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
        	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
            WHERE tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_city.status='1' 
            ". $who." ". $scat." ". $sort."
            LIMIT $limit, $page_limit";
        }else {
            $query="SELECT * FROM tbl_post
        	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
        	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
        	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
        	WHERE  tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_city.status='1'
            ". $who." ". $cat." ". $sort." 
            LIMIT $limit, $page_limit";
        }
        

    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
    	while($data = mysqli_fetch_assoc($sql)){
            $row['id'] = $data['id'];
            $row['title'] = $data['title'];
            $row['description'] = $data['description'];
            $row['money'] = $data['money'];
            $row['phone_1'] = $data['phone_1'];
            $row['phone_2'] = $data['phone_2'];
            $row['condition'] = $data['con'];
            
            $row['thumbnail_1'] = get_thumb('images/'.$data['image_1'],'300x300');
            $row['thumbnail_2'] = get_thumb('images/'.$data['image_2'],'300x300');
            $row['thumbnail_3'] = get_thumb('images/'.$data['image_3'],'300x300');
            $row['thumbnail_4'] = get_thumb('images/'.$data['image_4'],'300x300');
            $row['thumbnail_5'] = get_thumb('images/'.$data['image_5'],'300x300');
            
            $row['image_1'] = $file_path.'images/'.$data['image_1'];
            $row['image_2'] = $file_path.'images/'.$data['image_2'];
            $row['image_3'] = $file_path.'images/'.$data['image_3'];
            $row['image_4'] = $file_path.'images/'.$data['image_4'];
            $row['image_5'] = $file_path.'images/'.$data['image_5'];

            $row['cat_id'] = $data['cat_id'];
        	$row['category_name'] = $data['category_name'];
        	$row['sub_cat_id'] = $data['sub_cat_id'];
        	$row['sub_category_name'] = $data['sub_category_name'];
            $row['cit_id'] = $data['cit_id'];
            $row['city_name'] = $data['city_name'];
            $row['user_id'] = $data['user_id'];
            $row['active'] = $data['active'];
            $row['date_time'] = calculate_time_span($data['date_time'],true);
            $row['total_views'] = $data['total_views'];
            $row['total_share'] = $data['total_share'];
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
     else if($get_method['method_name']=="topad_daily_post"){
        $jsonObj= array();
        $jsonObj2= array();	
         
        $city_id=$get_method['city_id'];
        $cat_id=$get_method['cat_id'];
        $scat_id=$get_method['scat_id'];
        $mDays = date('d-m-Y');
        
        if ($city_id != "") {
          $who = "AND tbl_post.cit_id =". $city_id ."";
        }else {
            $who = "AND tbl_post.cit_id";
        }
        
        if ($cat_id != "") {
            $cat = "AND tbl_post.cat_id =". $cat_id ."";
        }else {
            $cat = "AND tbl_post.cat_id";
        }
        
        if ($scat_id != "") {
          $scat = "AND tbl_post.scat_id =". $scat_id ."";
        }else {
            $scat = "AND tbl_post.scat_id";
        }
        
        $topAd_exp_date = "tbl_post_promote.topAd_exp_date > '".$live_date."'";
        
        $daily_exp_date = "tbl_post_promote.dailyBumpUp_exp_date > '".$live_date."'";


		if ($scat_id != "") {
            $queryTopAd="SELECT * FROM tbl_post
            LEFT JOIN tbl_post_promote ON tbl_post.id= tbl_post_promote.pt_id 
        	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
        	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
        	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
        	WHERE ".$topAd_exp_date." 
            AND tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_city.status='1'
            ". $who." ". $scat."
            ORDER BY rand() DESC LIMIT 2";
            
            $queryDaily="SELECT * FROM tbl_post
            LEFT JOIN tbl_post_promote ON tbl_post.id= tbl_post_promote.pt_id 
        	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
        	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
        	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
            WHERE ".$daily_exp_date." 
        	AND tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_city.status='1'
            ". $who." ". $scat."
            ORDER BY rand() DESC LIMIT 2";
        }else {
            $queryTopAd="SELECT * FROM tbl_post
            LEFT JOIN tbl_post_promote ON tbl_post.id= tbl_post_promote.pt_id 
        	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
        	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
        	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
        	WHERE ". $topAd_exp_date." 
        	AND tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_city.status='1'
            ". $who." ". $cat."
            ORDER BY rand() DESC LIMIT 2";
           
            $queryDaily="SELECT * FROM tbl_post
            LEFT JOIN tbl_post_promote ON tbl_post.id= tbl_post_promote.pt_id 
        	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
        	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
        	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
        	WHERE ". $daily_exp_date."
        	AND tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_city.status='1'
            ". $who." ". $cat."
            ORDER BY rand() DESC LIMIT 2";
        }



		$sql = mysqli_query($mysqli,$queryTopAd)or die(mysqli_error());
		while($data = mysqli_fetch_assoc($sql)){
            $row['id'] = $data['id'];
            $row['title'] = $data['title'];
            $row['description'] = $data['description'];
            $row['money'] = $data['money'];
            $row['phone_1'] = $data['phone_1'];
            $row['phone_2'] = $data['phone_2'];
            $row['condition'] = $data['con'];
            
            $row['thumbnail_1'] = get_thumb('images/'.$data['image_1'],'300x300');
            $row['thumbnail_2'] = get_thumb('images/'.$data['image_2'],'300x300');
            $row['thumbnail_3'] = get_thumb('images/'.$data['image_3'],'300x300');
            $row['thumbnail_4'] = get_thumb('images/'.$data['image_4'],'300x300');
            $row['thumbnail_5'] = get_thumb('images/'.$data['image_5'],'300x300');
            
            $row['image_1'] = $file_path.'images/'.$data['image_1'];
            $row['image_2'] = $file_path.'images/'.$data['image_2'];
            $row['image_3'] = $file_path.'images/'.$data['image_3'];
            $row['image_4'] = $file_path.'images/'.$data['image_4'];
            $row['image_5'] = $file_path.'images/'.$data['image_5'];

            $row['cat_id'] = $data['cat_id'];
        	$row['category_name'] = $data['category_name'];
        	$row['sub_cat_id'] = $data['sub_cat_id'];
        	$row['sub_category_name'] = $data['sub_category_name'];
            $row['cit_id'] = $data['cit_id'];
            $row['city_name'] = $data['city_name'];
            $row['user_id'] = $data['user_id'];
            $row['active'] = $data['active'];
            $row['date_time'] = calculate_time_span($data['date_time'],true);
            $row['total_views'] = $data['total_views'];
            $row['total_share'] = $data['total_share'];
			array_push($jsonObj,$row);
		}
		$row['top_ad_list']=$jsonObj;
		
	
		$sql2 = mysqli_query($mysqli,$queryDaily)or die(mysqli_error());
		while($data2 = mysqli_fetch_assoc($sql2)){
            $row2['id'] = $data2['id'];
            $row2['title'] = $data2['title'];
            $row2['description'] = $data2['description'];
            $row2['money'] = $data2['money'];
            $row2['phone_1'] = $data2['phone_1'];
            $row2['phone_2'] = $data2['phone_2'];
            $row2['condition'] = $data2['con'];
            
            $row2['thumbnail_1'] = get_thumb('images/'.$data2['image_1'],'300x300');
            $row2['thumbnail_2'] = get_thumb('images/'.$data2['image_2'],'300x300');
            $row2['thumbnail_3'] = get_thumb('images/'.$data2['image_3'],'300x300');
            $row2['thumbnail_4'] = get_thumb('images/'.$data2['image_4'],'300x300');
            $row2['thumbnail_5'] = get_thumb('images/'.$data2['image_5'],'300x300');
            
            $row2['image_1'] = $file_path.'images/'.$data2['image_1'];
            $row2['image_2'] = $file_path.'images/'.$data2['image_2'];
            $row2['image_3'] = $file_path.'images/'.$data2['image_3'];
            $row2['image_4'] = $file_path.'images/'.$data2['image_4'];
            $row2['image_5'] = $file_path.'images/'.$data2['image_5'];

            $row2['cat_id'] = $data2['cat_id'];
        	$row2['category_name'] = $data2['category_name'];
        	$row2['sub_cat_id'] = $data2['sub_cat_id'];
        	$row2['sub_category_name'] = $data2['sub_category_name'];
            $row2['cit_id'] = $data2['cit_id'];
            $row2['city_name'] = $data2['city_name'];
            $row2['user_id'] = $data2['user_id'];
            $row2['active'] = $data2['active'];
            $row2['date_time'] = calculate_time_span($data2['date_time'],true);
            $row2['total_views'] = $data2['total_views'];
            $row2['total_share'] = $data2['total_share'];
			array_push($jsonObj2,$row2);
		}
		$row['daily_list']=$jsonObj2;

        $set['BUY_AND_SELL'] = $row;
        header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        die();
    }

    else if($get_method['method_name']=="list")	{	

	   $jsonObj= array();	
        $query="SELECT * FROM tbl_category 
    	    WHERE tbl_category.status='1'  ORDER BY tbl_category.cid DESC";
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
		while($data = mysqli_fetch_assoc($sql)){
            $row1['cid'] = $data['cid'];
    		$row1['category_name'] = $data['category_name'];
			array_push($jsonObj,$row1);
		}
		$row['cat_list']=$jsonObj;
		
		$jsonObj_3= array();	
        $query3="SELECT * FROM tbl_sub_category 
    	    WHERE tbl_sub_category.status='1'  ORDER BY tbl_sub_category.sid DESC";
		$sql3 = mysqli_query($mysqli,$query3)or die(mysqli_error());
		while($data3 = mysqli_fetch_assoc($sql3)){
            $row3['sid'] = $data3['sid'];
    		$row3['sub_category_name'] = $data3['sub_category_name'];
			array_push($jsonObj_3,$row3);
		}
		$row['scat_list']=$jsonObj_3;

		$jsonObj_2= array();	
        $query_city="SELECT * FROM tbl_city 
    	    WHERE tbl_city.status='1'  ORDER BY tbl_city.aid DESC";
		$sql_city = mysqli_query($mysqli,$query_city)or die(mysqli_error());
		while($data_city = mysqli_fetch_assoc($sql_city)){
            $row2['aid'] = $data_city['aid'];
    		$row2['city_name'] = $data_city['city_name'];
			array_push($jsonObj_2,$row2);
		}
		$row['city_list']=$jsonObj_2; 
		
		
	
        $set['BUY_AND_SELL'] = $row;
        header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        die();
    }
    
    else if($get_method['method_name']=="cat_list_home"){
     	$jsonObj= array();
    	$query="SELECT * FROM tbl_category 
    	    WHERE tbl_category.status='1'  ORDER BY rand() DESC LIMIT 8";
    	$sql = mysqli_query($mysqli,$query)or die(mysql_error());
    	while($data = mysqli_fetch_assoc($sql)){
    		$row['cid'] = $data['cid'];
    		$row['category_name'] = $data['category_name'];
    		$row['category_image'] = $file_path.'images/'.$data['category_image'];
			$row['category_total_post'] = get_total_post($data['cid']);
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
	
	else if($get_method['method_name']=="cat_list"){
     	$jsonObj= array();
    	$query="SELECT * FROM tbl_category 
    	    WHERE tbl_category.status='1'  ORDER BY tbl_category.cid DESC";
    	$sql = mysqli_query($mysqli,$query)or die(mysql_error());
    	while($data = mysqli_fetch_assoc($sql)){
    		$row['cid'] = $data['cid'];
    		$row['category_name'] = $data['category_name'];
    		$row['category_image'] = $file_path.'images/'.$data['category_image'];
    		$row['category_total_post'] = get_total_post($data['cid']);
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    else if($get_method['method_name']=="scat_list_cid"){
     	$jsonObj= array();
     	$scat_id=$get_method['scat_id'];
    	$query="SELECT * FROM tbl_sub_category 
    	    WHERE tbl_sub_category.sub_cat_id='".$scat_id."' AND tbl_sub_category.status='1'  ORDER BY tbl_sub_category.sid DESC";
    	$sql = mysqli_query($mysqli,$query)or die(mysql_error());
    	while($data = mysqli_fetch_assoc($sql)){
    		$row['cid'] = $data['sid'];
    		$row['category_name'] = $data['sub_category_name'];
    		$row['category_image'] = $file_path.'images/'.$data['sub_category_image'];
    		$row['category_total_post'] = get_total_post_scat_id($data['sid']);
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    else if($get_method['method_name']=="city_list"){
     	$jsonObj= array();
    	$query="SELECT * FROM tbl_city 
    	    WHERE tbl_city.status='1'  ORDER BY tbl_city.aid DESC";
    	$sql = mysqli_query($mysqli,$query)or die(mysql_error());
    	while($data = mysqli_fetch_assoc($sql)){
    		$row['aid'] = $data['aid'];
    		$row['city_name'] = $data['city_name'];
    		$row['city_total_post'] = get_total_post_city($data['aid']);
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    else if($get_method['method_name']=="filter_list"){
     	$jsonObj= array();
     	
     	$type=$get_method['type'];
     	$id=$get_method['id'];
     	
     	if($type == "tbl_city"){
     	    $query="SELECT * FROM tbl_city WHERE tbl_city.status='1'  ORDER BY tbl_city.aid DESC";
        	$sql = mysqli_query($mysqli,$query)or die(mysql_error());
        	while($data = mysqli_fetch_assoc($sql)){
        		$row['mid'] = $data['aid'];
        		$row['name'] = $data['city_name'];
        		array_push($jsonObj,$row);
        	}
     	}
     	else if($type == "tbl_category"){
     	    $query="SELECT * FROM tbl_category WHERE tbl_category.status='1'  ORDER BY tbl_category.cid DESC";
        	$sql = mysqli_query($mysqli,$query)or die(mysql_error());
        	while($data = mysqli_fetch_assoc($sql)){
        		$row['mid'] = $data['cid'];
        		$row['name'] = $data['category_name'];
        		array_push($jsonObj,$row);
        	}
     	}
     	else if($type == "tbl_sub_category"){
        	$query="SELECT * FROM tbl_sub_category 
        	WHERE tbl_sub_category.sub_cat_id='".$id."' AND tbl_sub_category.status='1'  ORDER BY tbl_sub_category.sid DESC";
        	$sql = mysqli_query($mysqli,$query)or die(mysql_error());
        	while($data = mysqli_fetch_assoc($sql)){
        		$row['mid'] = $data['sid'];
        		$row['name'] = $data['sub_category_name'];
        		array_push($jsonObj,$row);
        	}
     	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    else if($get_method['method_name']=="promotions_list"){
     	$jsonObj= array();
    	$query="SELECT * FROM subscription_plan WHERE subscription_plan.status='1'  ORDER BY subscription_plan.id ASC";
    	$sql = mysqli_query($mysqli,$query)or die(mysql_error());
    	while($data = mysqli_fetch_assoc($sql)){
    		$row['id'] = $data['id'];
    		$row['plan_name'] = $data['plan_name'];
    		$row['plan_details'] = $data['plan_details'];
    		
    		$row['plan_days'] = $data['plan_days'];
    		$row['plan_duration'] = $data['plan_duration'];
    		$row['plan_duration_type'] = $data['plan_duration_type'];
    		$row['plan_price'] = $data['plan_price'];
    		
    		if ($row['plan_duration_type'] == "1") {
    		    $row['days'] = "Days";
    		} else if ($row['plan_duration_type'] == "30") {
    		    $row['days'] = "Months";
    		} else if ($row['plan_duration_type'] == "365") {
    		    $row['days'] = "Years";
    		}

    		$row['plan_days_2'] = $data['plan_days_2'];
    		$row['plan_duration_2'] = $data['plan_duration_2'];
    		$row['plan_duration_type_2'] = $data['plan_duration_type_2'];
    		$row['plan_price_2'] = $data['plan_price_2'];
    		
    		if ($row['plan_duration_type_2'] == "1") {
    		    $row['days2'] = "Days";
    		} else if ($row['plan_duration_type_2'] == "30") {
    		    $row['days2'] = "Months";
    		} else if ($row['plan_duration_type_2'] == "365") {
    		    $row['days2'] = "Years";
    		}
    		
    		$row['plan_days_3'] = $data['plan_days_3'];
    		$row['plan_duration_3'] = $data['plan_duration_3'];
    		$row['plan_duration_type_3'] = $data['plan_duration_type_3'];
    		$row['plan_price_3'] = $data['plan_price_3'];
    		
    		if ($row['plan_duration_type_3'] == "1") {
    		    $row['days3'] = "Days";
    		} else if ($row['plan_duration_type_3'] == "30") {
    		    $row['days3'] = "Months";
    		} else if ($row['plan_duration_type_3'] == "365") {
    		    $row['days3'] = "Years";
    		}
    		
    		$row['promote_image'] = get_thumb('assets/images/'.$data['promote_image'],'100x100');

    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    else if($get_method['method_name']=="scat_id"){
        $jsonObj= array();	
     	$page_limit=10;
    	$limit=($get_method['page']-1) * $page_limit;
    	$scat_id=$get_method['scat_id'];
    	
		$query="SELECT * FROM tbl_post
    	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
    	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
    	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
        WHERE tbl_post.scat_id='".$scat_id."' AND tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_sub_category.status='1' AND tbl_city.status='1' 
        ORDER BY tbl_post.id DESC LIMIT $limit, $page_limit";
        	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
    	while($data = mysqli_fetch_assoc($sql)){
            $row['id'] = $data['id'];
            $row['title'] = $data['title'];
            $row['description'] = $data['description'];
            $row['money'] = $data['money'];
            $row['phone_1'] = $data['phone_1'];
            $row['phone_2'] = $data['phone_2'];
            $row['condition'] = $data['con'];
            
            $row['thumbnail_1'] = get_thumb('images/'.$data['image_1'],'300x300');
            $row['thumbnail_2'] = get_thumb('images/'.$data['image_2'],'300x300');
            $row['thumbnail_3'] = get_thumb('images/'.$data['image_3'],'300x300');
            $row['thumbnail_4'] = get_thumb('images/'.$data['image_4'],'300x300');
            $row['thumbnail_5'] = get_thumb('images/'.$data['image_5'],'300x300');
            
            $row['image_1'] = $file_path.'images/'.$data['image_1'];
            $row['image_2'] = $file_path.'images/'.$data['image_2'];
            $row['image_3'] = $file_path.'images/'.$data['image_3'];
            $row['image_4'] = $file_path.'images/'.$data['image_4'];
            $row['image_5'] = $file_path.'images/'.$data['image_5'];

            $row['cat_id'] = $data['cat_id'];
        	$row['category_name'] = $data['category_name'];
        	$row['sub_cat_id'] = $data['sub_cat_id'];
        	$row['sub_category_name'] = $data['sub_category_name'];
            $row['cit_id'] = $data['cit_id'];
            $row['city_name'] = $data['city_name'];
            $row['user_id'] = $data['user_id'];
            $row['active'] = $data['active'];
            $row['date_time'] = calculate_time_span($data['date_time'],true);
            $row['total_views'] = $data['total_views'];
            $row['total_share'] = $data['total_share'];
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    else if($get_method['method_name']=="cat_id"){
        $jsonObj= array();	
     	$page_limit=10;
    	$limit=($get_method['page']-1) * $page_limit;
    	$cat_id=$get_method['cat_id'];
    	
		$query="SELECT * FROM tbl_post
    	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
    	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
    	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
        WHERE tbl_post.cat_id='".$cat_id."' AND tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_sub_category.status='1' AND tbl_city.status='1' 
        ORDER BY tbl_post.id DESC LIMIT $limit, $page_limit";
        	
    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
    	while($data = mysqli_fetch_assoc($sql)){
            $row['id'] = $data['id'];
            $row['title'] = $data['title'];
            $row['description'] = $data['description'];
            $row['money'] = $data['money'];
            $row['phone_1'] = $data['phone_1'];
            $row['phone_2'] = $data['phone_2'];
            $row['condition'] = $data['con'];
            
            $row['thumbnail_1'] = get_thumb('images/'.$data['image_1'],'300x300');
            $row['thumbnail_2'] = get_thumb('images/'.$data['image_2'],'300x300');
            $row['thumbnail_3'] = get_thumb('images/'.$data['image_3'],'300x300');
            $row['thumbnail_4'] = get_thumb('images/'.$data['image_4'],'300x300');
            $row['thumbnail_5'] = get_thumb('images/'.$data['image_5'],'300x300');
            
            $row['image_1'] = $file_path.'images/'.$data['image_1'];
            $row['image_2'] = $file_path.'images/'.$data['image_2'];
            $row['image_3'] = $file_path.'images/'.$data['image_3'];
            $row['image_4'] = $file_path.'images/'.$data['image_4'];
            $row['image_5'] = $file_path.'images/'.$data['image_5'];

            $row['cat_id'] = $data['cat_id'];
        	$row['category_name'] = $data['category_name'];
        	$row['sub_cat_id'] = $data['sub_cat_id'];
        	$row['sub_category_name'] = $data['sub_category_name'];
            $row['cit_id'] = $data['cit_id'];
            $row['city_name'] = $data['city_name'];
            $row['user_id'] = $data['user_id'];
            $row['active'] = $data['active'];
            $row['date_time'] = calculate_time_span($data['date_time'],true);
            $row['total_views'] = $data['total_views'];
            $row['total_share'] = $data['total_share'];
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    else if($get_method['method_name']=="city_id"){
        $jsonObj= array();	
     	$page_limit=10;
    	$limit=($get_method['page']-1) * $page_limit;
    	$city_id=$get_method['city_id'];
    	
    	$query="SELECT * FROM tbl_post
    	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
    	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
    	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
        WHERE tbl_post.cit_id='".$city_id."' AND tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_sub_category.status='1' AND tbl_city.status='1' 
        ORDER BY tbl_post.id DESC LIMIT $limit, $page_limit";

    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
    	while($data = mysqli_fetch_assoc($sql)){
           $row['id'] = $data['id'];
            $row['title'] = $data['title'];
            $row['description'] = $data['description'];
            $row['money'] = $data['money'];
            $row['phone_1'] = $data['phone_1'];
            $row['phone_2'] = $data['phone_2'];
            $row['condition'] = $data['con'];
            
            $row['thumbnail_1'] = get_thumb('images/'.$data['image_1'],'300x300');
            $row['thumbnail_2'] = get_thumb('images/'.$data['image_2'],'300x300');
            $row['thumbnail_3'] = get_thumb('images/'.$data['image_3'],'300x300');
            $row['thumbnail_4'] = get_thumb('images/'.$data['image_4'],'300x300');
            $row['thumbnail_5'] = get_thumb('images/'.$data['image_5'],'300x300');
            
            $row['image_1'] = $file_path.'images/'.$data['image_1'];
            $row['image_2'] = $file_path.'images/'.$data['image_2'];
            $row['image_3'] = $file_path.'images/'.$data['image_3'];
            $row['image_4'] = $file_path.'images/'.$data['image_4'];
            $row['image_5'] = $file_path.'images/'.$data['image_5'];

            $row['cat_id'] = $data['cat_id'];
        	$row['category_name'] = $data['category_name'];
        	$row['sub_cat_id'] = $data['sub_cat_id'];
        	$row['sub_category_name'] = $data['sub_category_name'];
            $row['cit_id'] = $data['cit_id'];
            $row['city_name'] = $data['city_name'];
            $row['user_id'] = $data['user_id'];
            $row['active'] = $data['active'];
            $row['date_time'] = calculate_time_span($data['date_time'],true);
            $row['total_views'] = $data['total_views'];
            $row['total_share'] = $data['total_share'];
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    else if($get_method['method_name']=="similar"){
        $jsonObj= array();	
     	$page_limit=10;
     	$scat_id=$get_method['scat_id'];
     	$limit=($get_method['page']-1) * $page_limit;
     	
     	$query="SELECT * FROM tbl_post
    	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
    	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
    	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
    	WHERE tbl_post.scat_id='".$scat_id."' 
        AND tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_sub_category.status='1' AND tbl_city.status='1' 
        ORDER BY tbl_post.id DESC LIMIT $limit, $page_limit";

    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
    	while($data = mysqli_fetch_assoc($sql)){
            $row['id'] = $data['id'];
            $row['title'] = $data['title'];
            $row['description'] = $data['description'];
            $row['money'] = $data['money'];
            $row['phone_1'] = $data['phone_1'];
            $row['phone_2'] = $data['phone_2'];
            $row['condition'] = $data['con'];
            
            $row['thumbnail_1'] = get_thumb('images/'.$data['image_1'],'300x300');
            $row['thumbnail_2'] = get_thumb('images/'.$data['image_2'],'300x300');
            $row['thumbnail_3'] = get_thumb('images/'.$data['image_3'],'300x300');
            $row['thumbnail_4'] = get_thumb('images/'.$data['image_4'],'300x300');
            $row['thumbnail_5'] = get_thumb('images/'.$data['image_5'],'300x300');
            
            $row['image_1'] = $file_path.'images/'.$data['image_1'];
            $row['image_2'] = $file_path.'images/'.$data['image_2'];
            $row['image_3'] = $file_path.'images/'.$data['image_3'];
            $row['image_4'] = $file_path.'images/'.$data['image_4'];
            $row['image_5'] = $file_path.'images/'.$data['image_5'];

            $row['cat_id'] = $data['cat_id'];
        	$row['category_name'] = $data['category_name'];
        	$row['sub_cat_id'] = $data['sub_cat_id'];
        	$row['sub_category_name'] = $data['sub_category_name'];
            $row['cit_id'] = $data['cit_id'];
            $row['city_name'] = $data['city_name'];
            $row['user_id'] = $data['user_id'];
            $row['active'] = $data['active'];
            $row['date_time'] = calculate_time_span($data['date_time'],true);
            $row['total_views'] = $data['total_views'];
            $row['total_share'] = $data['total_share'];
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    else if($get_method['method_name']=="search"){
        $jsonObj= array();	
     	$page_limit=10;
     	$limit=($get_method['page']-1) * $page_limit;
     	
     	$query="SELECT * FROM tbl_post
    	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
    	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
    	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
    	WHERE tbl_post.title like '%".addslashes($get_method['search_text'])."%'
        AND tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_sub_category.status='1' AND tbl_city.status='1' 
        ORDER BY tbl_post.id DESC LIMIT $limit, $page_limit";

    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
    	while($data = mysqli_fetch_assoc($sql)){
            $row['id'] = $data['id'];
            $row['title'] = $data['title'];
            $row['description'] = $data['description'];
            $row['money'] = $data['money'];
            $row['phone_1'] = $data['phone_1'];
            $row['phone_2'] = $data['phone_2'];
            $row['condition'] = $data['con'];
            
            $row['thumbnail_1'] = get_thumb('images/'.$data['image_1'],'300x300');
            $row['thumbnail_2'] = get_thumb('images/'.$data['image_2'],'300x300');
            $row['thumbnail_3'] = get_thumb('images/'.$data['image_3'],'300x300');
            $row['thumbnail_4'] = get_thumb('images/'.$data['image_4'],'300x300');
            $row['thumbnail_5'] = get_thumb('images/'.$data['image_5'],'300x300');
            
            $row['image_1'] = $file_path.'images/'.$data['image_1'];
            $row['image_2'] = $file_path.'images/'.$data['image_2'];
            $row['image_3'] = $file_path.'images/'.$data['image_3'];
            $row['image_4'] = $file_path.'images/'.$data['image_4'];
            $row['image_5'] = $file_path.'images/'.$data['image_5'];

            $row['cat_id'] = $data['cat_id'];
        	$row['category_name'] = $data['category_name'];
        	$row['sub_cat_id'] = $data['sub_cat_id'];
        	$row['sub_category_name'] = $data['sub_category_name'];
            $row['cit_id'] = $data['cit_id'];
            $row['city_name'] = $data['city_name'];
            $row['user_id'] = $data['user_id'];
            $row['active'] = $data['active'];
            $row['date_time'] = calculate_time_span($data['date_time'],true);
            $row['total_views'] = $data['total_views'];
            $row['total_share'] = $data['total_share'];
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    else if($get_method['method_name']=="my_post"){
      
        $jsonObj= array();	
     	$page_limit=10;
    	$limit=($get_method['page']-1) * $page_limit;
    	$user_id=$get_method['user_id'];
    	
    	$query="SELECT * FROM tbl_post
    	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
    	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
    	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
    	WHERE tbl_post.user_id='$user_id' 
        AND tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_sub_category.status='1' AND tbl_city.status='1' 
        ORDER BY tbl_post.id DESC LIMIT $limit, $page_limit";

    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
    	while($data = mysqli_fetch_assoc($sql)){
            $row['id'] = $data['id'];
            $row['title'] = $data['title'];
            $row['description'] = $data['description'];
            $row['money'] = $data['money'];
            $row['phone_1'] = $data['phone_1'];
            $row['phone_2'] = $data['phone_2'];
            $row['condition'] = $data['con'];
            
            $row['thumbnail_1'] = get_thumb('images/'.$data['image_1'],'300x300');
            $row['thumbnail_2'] = get_thumb('images/'.$data['image_2'],'300x300');
            $row['thumbnail_3'] = get_thumb('images/'.$data['image_3'],'300x300');
            $row['thumbnail_4'] = get_thumb('images/'.$data['image_4'],'300x300');
            $row['thumbnail_5'] = get_thumb('images/'.$data['image_5'],'300x300');
            
            $row['image_1'] = $file_path.'images/'.$data['image_1'];
            $row['image_2'] = $file_path.'images/'.$data['image_2'];
            $row['image_3'] = $file_path.'images/'.$data['image_3'];
            $row['image_4'] = $file_path.'images/'.$data['image_4'];
            $row['image_5'] = $file_path.'images/'.$data['image_5'];

            $row['cat_id'] = $data['cat_id'];
        	$row['category_name'] = $data['category_name'];
        	$row['sub_cat_id'] = $data['sub_cat_id'];
        	$row['sub_category_name'] = $data['sub_category_name'];
            $row['cit_id'] = $data['cit_id'];
            $row['city_name'] = $data['city_name'];
            $row['user_id'] = $data['user_id'];
            $row['active'] = $data['active'];
            $row['date_time'] = calculate_time_span($data['date_time'],true);
            $row['total_views'] = $data['total_views'];
            $row['total_share'] = $data['total_share'];
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    else if($get_method['method_name']=="my_post2"){
      
        $jsonObj= array();	
     	$page_limit=10;
    	$limit=($get_method['page']-1) * $page_limit;
    	$user_id=$get_method['user_id'];
    	
    	$query="SELECT * FROM tbl_post
    	LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
    	LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
    	LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
    	WHERE tbl_post.user_id='$user_id' 
        AND tbl_post.status='1' AND tbl_category.status='1' AND tbl_sub_category.status='1' AND tbl_city.status='1' 
        ORDER BY tbl_post.id DESC LIMIT $limit, $page_limit";

    	$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
    	while($data = mysqli_fetch_assoc($sql)){
            $row['id'] = $data['id'];
            $row['title'] = $data['title'];
            $row['description'] = $data['description'];
            $row['money'] = $data['money'];
            $row['phone_1'] = $data['phone_1'];
            $row['phone_2'] = $data['phone_2'];
            $row['condition'] = $data['con'];
            
            $row['thumbnail_1'] = get_thumb('images/'.$data['image_1'],'300x300');
            $row['thumbnail_2'] = get_thumb('images/'.$data['image_2'],'300x300');
            $row['thumbnail_3'] = get_thumb('images/'.$data['image_3'],'300x300');
            $row['thumbnail_4'] = get_thumb('images/'.$data['image_4'],'300x300');
            $row['thumbnail_5'] = get_thumb('images/'.$data['image_5'],'300x300');
            
            $row['image_1'] = $file_path.'images/'.$data['image_1'];
            $row['image_2'] = $file_path.'images/'.$data['image_2'];
            $row['image_3'] = $file_path.'images/'.$data['image_3'];
            $row['image_4'] = $file_path.'images/'.$data['image_4'];
            $row['image_5'] = $file_path.'images/'.$data['image_5'];

            $row['cat_id'] = $data['cat_id'];
        	$row['category_name'] = $data['category_name'];
        	$row['sub_cat_id'] = $data['sub_cat_id'];
        	$row['sub_category_name'] = $data['sub_category_name'];
            $row['cit_id'] = $data['cit_id'];
            $row['city_name'] = $data['city_name'];
            $row['user_id'] = $data['user_id'];
            $row['active'] = $data['active'];
            $row['date_time'] = calculate_time_span($data['date_time'],true);
            $row['total_views'] = $data['total_views'];
            $row['total_share'] = $data['total_share'];
    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
    if($get_method['method_name']=="promos"){
        $jsonObj_new= array();	
    	$query_new="SELECT * FROM tbl_banner WHERE status='1' ORDER BY tbl_banner.bid DESC";
    	$sql_new = mysqli_query($mysqli,$query_new);
    	while($data_new = mysqli_fetch_assoc($sql_new)){
    		$row_new['bid'] = $data_new['bid'];
     		$row_new['banner_title'] = $data_new['banner_title'];
     		$row_new['banner_sort_info'] = $data_new['banner_sort_info'];
    		$row_new['banner_image'] = $file_path.'images/'.$data_new['banner_image'];
    		$row_new['banner_image_thumb'] = get_thumb('images/'.$data_new['banner_image'],'300x300');
			$row_new['banner_date_time'] = calculate_time_span($data_new['date_time'],true);
    		$songs_list=explode(",", $data_new['banner_songs']);
    		$row_new['total_songs'] =count($songs_list);

    		foreach($songs_list as $song_id){

                $query01="SELECT * FROM tbl_post
                        LEFT JOIN tbl_category ON tbl_post.cat_id= tbl_category.cid 
                        LEFT JOIN tbl_sub_category ON tbl_post.scat_id= tbl_sub_category.sid 
                        LEFT JOIN tbl_city ON tbl_post.cit_id = tbl_city.aid
                        WHERE tbl_post.id ='$song_id' 
                        AND tbl_post.status='1' AND tbl_post.active='1' AND tbl_category.status='1' AND tbl_city.status='1' 
                        ORDER BY tbl_post.id DESC";

    			$sql01 = mysqli_query($mysqli,$query01);
    			while($data01 = mysqli_fetch_assoc($sql01)){

                    $row01['id'] = $data01['id'];
                    $row01['title'] = $data01['title'];
                    $row01['description'] = $data01['description'];
                    $row01['money'] = $data01['money'];
                    $row01['phone_1'] = $data01['phone_1'];
                    $row01['phone_2'] = $data01['phone_2'];
                    $row01['condition'] = $data01['con'];
                    
                    $row01['thumbnail_1'] = get_thumb('images/'.$data01['image_1'],'300x300');
                    $row01['thumbnail_2'] = get_thumb('images/'.$data01['image_2'],'300x300');
                    $row01['thumbnail_3'] = get_thumb('images/'.$data01['image_3'],'300x300');
                    $row01['thumbnail_4'] = get_thumb('images/'.$data01['image_4'],'300x300');
                    $row01['thumbnail_5'] = get_thumb('images/'.$data01['image_5'],'300x300');
                    
                    $row01['image_1'] = $file_path.'images/'.$data01['image_1'];
                    $row01['image_2'] = $file_path.'images/'.$data01['image_2'];
                    $row01['image_3'] = $file_path.'images/'.$data01['image_3'];
                    $row01['image_4'] = $file_path.'images/'.$data01['image_4'];
                    $row01['image_5'] = $file_path.'images/'.$data01['image_5'];

                    $row01['cat_id'] = $data01['cat_id'];
                    $row01['category_name'] = $data01['category_name'];
                    $row01['sub_cat_id'] = $data01['sub_cat_id'];
                    $row01['sub_category_name'] = $data01['sub_category_name'];
                    $row01['cit_id'] = $data01['cit_id'];
                    $row01['city_name'] = $data01['city_name'];
                    $row01['user_id'] = $data01['user_id'];
                    $row01['active'] = $data01['active'];
                    $row01['date_time'] = calculate_time_span($data01['date_time'],true);
                    $row01['total_views'] = $data01['total_views'];
                    $row01['total_share'] = $data01['total_share'];

    				$row_new['songs_list'][]=$row01;
    			}
            }
    		array_push($jsonObj_new,$row_new);
    		unset($row_new['songs_list']);
    	}
    	$row['home_banner']=$jsonObj_new;
        $set['BUY_AND_SELL'] = $row;
        header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        die();
    }	
    
    else if($get_method['method_name']=="post_ad_new"){
         
         if($get_method['title']!="" && $get_method['description']!="" && $get_method['phone_1']!="" && $get_method['money']!="" && $get_method['cat_id']!="" && $get_method['cit_id']!="" && $get_method['user_id']!=""){
            $title = $get_method['title'];	
            $description = $get_method['description'];  
            $phone_1 = $get_method['phone_1'];  
            if($get_method['phone_2']!=""){
                $phone_2 = $get_method['phone_2'];
            }else{
                $phone_2='';
            }
            $money = $get_method['money'];  
            $cat_id = $get_method['cat_id']; 
            $scat_id = $get_method['scat_id'];  
            $cit_id = $get_method['cit_id'];
            $user_id = $get_method['user_id']; 
            $con = $get_method['con']; 
        
            if($_FILES['song_image1']['name']!=""){
                $image1=rand(0,99999)."_".$_FILES['song_image1']['name'];
                $tpath1='images/'.$image1;  
                $pic1=compress_image($_FILES["song_image1"]["tmp_name"], $tpath1, 80);
            }else{
                $image1='';
            }
        
            if($_FILES['song_image2']['name']!=""){
                $image2=rand(0,99999)."_".$_FILES['song_image2']['name'];
                $tpath2='images/'.$image2;        
                $pic2=compress_image($_FILES["song_image2"]["tmp_name"], $tpath2, 80);
            }else{
                $image2='';
            }
        
            if($_FILES['song_image3']['name']!=""){
                $image3=rand(0,99999)."_".$_FILES['song_image3']['name'];
                $tpath3='images/'.$image3;        
                $pic3=compress_image($_FILES["song_image3"]["tmp_name"], $tpath3, 80);
            }else{
                $image3='';
            }
        
            if($_FILES['song_image4']['name']!=""){
                $image4=rand(0,99999)."_".$_FILES['song_image4']['name'];
                $tpath4='images/'.$image4;        
                $pic4=compress_image($_FILES["song_image4"]["tmp_name"], $tpath4, 80);
            }else{
                $image4='';
            }
        
            if($_FILES['song_image5']['name']!=""){
                $image5=rand(0,99999)."_".$_FILES['song_image5']['name'];
                $tpath5='images/'.$image5;        
                $pic5=compress_image($_FILES["song_image5"]["tmp_name"], $tpath5, 80);
            }else{
                $image5='';
            }
        
            $data = array( 
                'title'  =>  $title,
                'description'  =>  addslashes($description),
                'money'  =>  $money,
                'phone_1'  =>  $phone_1,
                'phone_2'  =>  $phone_2,
                'image_1'  =>  $image1,
                'image_2'  =>  $image2,
                'image_3'  =>  $image3,
                'image_4'  =>  $image4,
                'image_5'  =>  $image5,
                'con'  =>  $con,
                'cat_id'  =>  $cat_id,
                'scat_id'  =>  $scat_id,
                'cit_id'  =>  $cit_id,
                'user_id'  =>  $user_id,
                'date_time'  =>  strtotime(date('d-m-Y h:i:s A')),
                'active'  =>  AUTO_POST
            );	
        
            $qry = Insert('tbl_post',$data);
        
            $set['BUY_AND_SELL'][] = array('MSG' => $app_lang['add_success'],'success'=>'1');
         }else{
             $set['BUY_AND_SELL'][] = array('MSG' => $app_lang['update_fail'],'success'=>'0');
         }

        header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        die();
    }
    
    else if($get_method['method_name']=="get_promote_load"){
        
        if($get_method['post_id']!=""){
            
            $post_id = $get_method['post_id'];

            $jsonObj= array();
            
            $query="SELECT * FROM tbl_post_promote WHERE pt_id ='$post_id' ";
            $sql = mysqli_query($mysqli,$query)or die(mysql_error());
            while($data = mysqli_fetch_assoc($sql)){
                
                
                if($data['dailyBumpUp_exp_date'] > $live_date){
                    $row['dailyBumpUp'] = '1';
                }else{
                    $row['dailyBumpUp'] = '0';
                }
                
                if($data['topAd_exp_date'] > $live_date){
                    $row['topAd'] = '1';
                }else{
                    $row['topAd'] = '0';
                }
                
                if($data['spotLight_exp_date'] > $live_date){
                    $row['spotLight'] = '1';
                }else{
                    $row['spotLight'] = '0';
                }
            
            	array_push($jsonObj,$row);
            }
            $set['BUY_AND_SELL'] = $jsonObj;
            header( 'Content-Type: application/json; charset=utf-8' );
            echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            die();
        }else{
            $set['BUY_AND_SELL'][] = array('MSG' => "post_id",'success'=>'-1');
        }
         

    }
    
    else if($get_method['method_name']=="transaction_add"){	
    
    
    if($get_method['daily_bump_up']!="" && $get_method['top_ad']!="" && $get_method['spot_light']!="" && $get_method['user_id']!="" && $get_method['post_id']!="" && $get_method['payment_id']!=""
     && $get_method['gateway']!="" && $get_method['daily_bump_up_duration']!="" && $get_method['top_ad_duration']!=""  && $get_method['spot_light_duration']!="" && $get_method['payment_amount']!=""){
         
        $user_id = $get_method['user_id'];	
        $post_id = $get_method['post_id'];

        $paymentId = $get_method['payment_id'];   
        $paymentGateway = $get_method['gateway'];  
        
        $dailyBumpUp = $get_method['daily_bump_up'];  
        $dailyBumpUpDuration = $get_method['daily_bump_up_duration'];  
        
        $topAd = $get_method['top_ad'];   
        $topAdDuration = $get_method['top_ad_duration'];   
        
        $spotLight = $get_method['spot_light'];
        $spotLightDuration = $get_method['spot_light_duration'];
        
        $amount = $get_method['payment_amount'];
        
        $sql="SELECT * FROM tbl_post_promote WHERE (`pt_id` = '$post_id')";
		$res=mysqli_query($mysqli,$sql);
		$num_rows = mysqli_num_rows($res);
 		$row = mysqli_fetch_assoc($res);

 		
 	    if($dailyBumpUp == 1){
            $StartDays_d = $live_date;
            $EndDays_d = calculate_end_days($live_date, $dailyBumpUpDuration);
        }else{
            $StartDays_d = $live_date;
            $EndDays_d = $live_date;
        }
        
        if($topAd == 1){
            $StartDays_t = $live_date;
            $EndDays_t = calculate_end_days($live_date, $topAdDuration);
        }else{
            $StartDays_t = $live_date;
            $EndDays_t = $live_date;
        }
        
        if($spotLight == 1){
            $StartDays_s = $live_date;
            $EndDays_s = calculate_end_days($live_date, $spotLightDuration);
        }else{
            $StartDays_s = $live_date;
            $EndDays_s = $live_date;
        }
 		
 		if($num_rows == 0){
 		    
             $data = array(

                'pt_id'  =>  $post_id,
                'us_id'  =>  $user_id,

                'dailyBumpUp_start_date'  =>  $StartDays_d,
                'dailyBumpUp_exp_date'  =>  $EndDays_d,

                'topAd_start_date'  =>  $StartDays_t,
                'topAd_exp_date'  =>  $EndDays_t,

                'spotLight_start_date'  =>  $StartDays_s,
                'spotLight_exp_date'  =>  $EndDays_s,
            );	
            $qry = Insert('tbl_post_promote',$data);
            
 		}else{
 		    
 		    if($dailyBumpUp == 1){
		        $data_update_1 = array(
                    'dailyBumpUp_start_date'  =>  $StartDays_d,
                    'dailyBumpUp_exp_date'  =>  $EndDays_d,
                );
                $Update1=Update('tbl_post_promote', $data_update_1, "WHERE pt_id = '".$get_method['post_id']."'");
            }

            if($topAd == 1){
                $data_update_2 = array(
                    'topAd_start_date'  =>  $StartDays_t,
                    'topAd_exp_date'  =>  $EndDays_t,
                );	
                $Update2=Update('tbl_post_promote', $data_update_2, "WHERE pt_id = '".$get_method['post_id']."'");
            }
            
            if($spotLight == 1){
                $data_update_3 = array(
                    'spotLight_start_date'  =>  $StartDays_s,
                    'spotLight_exp_date'  =>  $EndDays_s,
                );	
                $Update3=Update('tbl_post_promote', $data_update_3, "WHERE pt_id = '".$get_method['post_id']."'");
            }
            
 		    
 		}

 		$data5 = array(
            'user_id'  =>  $user_id,
            'post_id'  =>  $post_id,
            'payment_id'  => $paymentId,
            'gateway'  =>  $paymentGateway,
            
            'daily_bump_up'  =>  $dailyBumpUp,
            'top_ad'  =>  $topAd,
            'spot_light'  =>  $spotLight,
            'payment_amount'  =>  $amount,
            'date_time'  =>  strtotime(date('d-m-Y h:i:s A')),
        );	
        $Update5 = Insert('transaction',$data5);
        
        $set['BUY_AND_SELL'][] = array('MSG' => $app_lang['add_success'],'success'=>'1');
        
    }else{
        $set['BUY_AND_SELL'][] = array('MSG' => 'Error','success'=>'-1');
    }

    header( 'Content-Type: application/json; charset=utf-8' );
    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    die();
    }
    
    else if($get_method['method_name']=="post_ads_update"){	

        $title = $get_method['title'];	
        $description = $get_method['description'];  
        $phone_1 = $get_method['phone_1'];  
        $phone_2 = $get_method['phone_2'];   
        $money = $get_method['money'];  
        
        $data = array( 
            'titel'  =>  $title,
            'description'  =>  addslashes($description),
            'money'  =>  $money,
            'phone_1'  =>  $phone_1,
            'phone_2'  =>  $phone_2
        );		
        
        $edit=Update('tbl_post', $data, "WHERE id = '".$get_method['post_id']."'");
    
        $set['BUY_AND_SELL'][] = array('MSG' => $app_lang['update_success'],'success'=>'1');
    
        header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        die();
    }
    
    else if($get_method['method_name']=="post_comments"){
        
	    $post_id = $get_method['post_id'];
  		$user_id = $get_method['user_id']; 
  		$user_name = $get_method['user_name']; 
  		$comment = $get_method['comment']; 
  		
  		 $data = array( 
            'p_id'  =>  $post_id,
            'u_id'  =>  $user_id,
            'u_name'  =>  $user_name,
            'comment'  =>  $comment,
            'time'  =>  strtotime(date('d-m-Y h:i:s A')),
        );		

        $qry = Insert('tbl_comments',$data);	
  		
		$set['BUY_AND_SELL'][] = array('MSG' => $app_lang['report_success'],'success'=>'1');


  		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
  }
  
   else if($get_method['method_name']=="post_comments_delete"){

        $jsonObj= array();
     	$data = array(
                'comment'  =>  'This comment is currently being reviewed.'
        );	
            
        $category_edit=Update('tbl_comments', $data, "WHERE cid = '".$get_method['comments_id']."'");

		$set['BUY_AND_SELL'][] = array('MSG' => $app_lang['report_success'],'success'=>'1');

  		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
  }
  
   else if($get_method['method_name']=="get_comments"){
 		$jsonObj= array();
     	
     	$query="SELECT * FROM tbl_comments
    	LEFT JOIN tbl_users ON tbl_comments.u_id = tbl_users.id 
        WHERE p_id ='".$get_method['post_id']."' AND tbl_users.status='1' 
        ORDER BY tbl_comments.cid ASC ";
     	
    	$sql = mysqli_query($mysqli,$query)or die(mysql_error());
    	while($data = mysqli_fetch_assoc($sql)){
    		$row['id'] = $data['cid'];
    		$row['user_id'] = $data['u_id'];
    		$row['user_name'] = $data['u_name'];
    		$row['images'] = get_thumb('images/users/'.$data['images'],'200x200');
    		$row['comment'] = $data['comment'];
    		$row['date_time'] = calculate_time_span($data['time'],true);
    		$row['status'] = $data['status'];

    		array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();
    }
    
   else if($get_method['method_name']=="post_delete"){
     	$jsonObj= array();
     	
     	$post_id = $get_method['post_id'];
    	
    	$sql="SELECT * FROM tbl_post WHERE `id` IN ($post_id)";
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
		$deleteSql="DELETE FROM tbl_post WHERE `id` IN ($post_id)";
		mysqli_query($mysqli, $deleteSql);
    	
        $set['BUY_AND_SELL'][] = array('MSG' => $app_lang['delete_success'],'success'=>'1');
    
        header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        die();
    }
    
    else if($get_method['method_name']=="account_delete"){
     	$jsonObj= array();
     	$ids = $get_method['user_id'];
     	
     	if($get_method['user_id']!=""){
			$deleteSql1 = "DELETE FROM tbl_reports WHERE `user_id` IN ($ids)";
    		mysqli_query($mysqli, $deleteSql1);
    
    		$deleteSql2 = "DELETE FROM tbl_active_log WHERE `user_id` IN ($ids)";
    		mysqli_query($mysqli, $deleteSql2);
    
    		$deleteSql3 = "DELETE FROM tbl_users WHERE `id` IN ($ids)";
    		mysqli_query($mysqli, $deleteSql3);
    		
    		
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
    		$deleteSql4="DELETE FROM tbl_post WHERE `user_id` IN ($ids)";
    		mysqli_query($mysqli, $deleteSql4);
    		$set['BUY_AND_SELL'][] = array('MSG' => $app_lang['delete_success'],'success'=>'1');
		}else{
		    $set['BUY_AND_SELL'][] = array('MSG' => 'Delete Error','success'=>'-1');
		}
        header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        die();
    }

   else if($get_method['method_name']=="post_view"){
      
        $jsonObj= array();	
		$view_qry=mysqli_query($mysqli,"UPDATE tbl_post SET total_views = total_views + 1 WHERE id = '".$get_method['post_id']."'");

    	$total_dw_sql="SELECT * FROM tbl_post WHERE id='".$get_method['post_id']."'";
	    $total_dw_res=mysqli_query($mysqli,$total_dw_sql);
	    $total_dw_row=mysqli_fetch_assoc($total_dw_res);
	         
        $jsonObj = array( 'total_views' => $total_dw_row['total_views']);

        $set['BUY_AND_SELL'][] = $jsonObj;
        
        header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
  }
  
   else if($get_method['method_name']=="post_share"){
      
        $jsonObj= array();	
		$view_qry=mysqli_query($mysqli,"UPDATE tbl_post SET total_share = total_share + 1 WHERE id = '".$get_method['post_id']."'");

    	$total_dw_sql="SELECT * FROM tbl_post WHERE id='".$get_method['post_id']."'";
	    $total_dw_res=mysqli_query($mysqli,$total_dw_sql);
	    $total_dw_row=mysqli_fetch_assoc($total_dw_res);
	         
        $jsonObj = array( 'total_share' => $total_dw_row['total_share']);

        $set['BUY_AND_SELL'][] = $jsonObj;
        
        header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
  }
  
   else if($get_method['method_name']=="post_profile"){
      
        $jsonObj= array();	
		
		$user_id=$get_method['user_id'];
		$qry = "SELECT * FROM tbl_users WHERE id = '$user_id'"; 
		$result = mysqli_query($mysqli,$qry);
		$row = mysqli_fetch_assoc($result);	

		$data['success']="1";
		$data['user_id'] = $row['id'];
		$data['name'] = $row['name'];
		$data['email'] = $row['email'];
		$data['phone'] = $row['phone'];
		$data['registered_on'] = date('d-m-Y',$row['registered_on']);
		$data['images'] = get_thumb('images/users/'.$row['images'],'200x200');
		$data['images_bg'] = get_thumb('images/users/'.$row['images_bg'],'500x400');
		$data['otp_status']= $row['otp_status'];

		array_push($jsonObj,$data);

		$set['BUY_AND_SELL'] = $jsonObj;
				 
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
		die();
  }
    
   else if($get_method['method_name']=="user_profile"){
      
        $jsonObj= array();	
		
		$user_id=$get_method['user_id'];
		$qry = "SELECT * FROM tbl_users WHERE id = '$user_id'"; 
		$result = mysqli_query($mysqli,$qry);
		$row = mysqli_fetch_assoc($result);	

		$data['success']="1";
		$data['user_id'] = $row['id'];
		$data['name'] = $row['name'];
		$data['email'] = $row['email'];
		$data['phone'] = $row['phone'];
		$data['images'] = get_thumb('images/users/'.$row['images'],'200x200');
		$data['images_bg'] = get_thumb('images/users/'.$row['images_bg'],'500x400');
		$data['otp_status']= $row['otp_status'];
		
		array_push($jsonObj,$data);

		$set['BUY_AND_SELL'] = $jsonObj;
				 
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
		die();
  }
  
  else if($get_method['method_name']=="user_profile_update"){
      
        $jsonObj= array();	
		
		$qry = "SELECT * FROM tbl_users WHERE id = '".$get_method['user_id']."'"; 
		$result = mysqli_query($mysqli,$qry);
		$row = mysqli_fetch_assoc($result);
 	 
 	 	if (!filter_var($get_method['email'], FILTER_VALIDATE_EMAIL)) {
			$set['BUY_AND_SELL'][]=array('MSG' => $app_lang['invalid_email_format'],'success'=>'0');

			header( 'Content-Type: application/json; charset=utf-8' );
			$json = json_encode($set);
			echo $json;
			 exit;
		}
		else if($row['email']==$get_method['email'] AND $row['id']!=$get_method['user_id']){
			$set['BUY_AND_SELL'][]=array('MSG' => $app_lang['email_exist'],'success'=>'0');

			header( 'Content-Type: application/json; charset=utf-8' );
			$json = json_encode($set);
			echo $json;
			exit;
		}
 	 	else if($get_method['password']!=""){
			$data = array(
			'name'  =>  $get_method['name'],
			'email'  =>  $get_method['email'],
			'password'  => md5(trim($get_method['password'])),
			'phone'  =>  $get_method['phone'],
			);
		}
		else{
			$data = array(
			'name'  =>  $get_method['name'],
			'email'  =>  $get_method['email'],			 
			'phone'  =>  $get_method['phone'] 
			);
		}
 
		$user_edit=Update('tbl_users', $data, "WHERE id = '".$get_method['user_id']."'");
	 		 
		$set['BUY_AND_SELL'][]=array('MSG'=>$app_lang['update_success'],'success'=>'1');

		header( 'Content-Type: application/json; charset=utf-8' );
		$json = json_encode($set);
		echo $json;
		exit;
  }
  
    else if($get_method['method_name']=="user_images_update"){	
    	
		if($_FILES['song_image']['name']!=""){
		    
			$song_image=rand(0,99999)."_".$_FILES['song_image']['name'];
			
            //Main Image
            $tpath1='images/users/'.$song_image;        
            $pic1=compress_image($_FILES["song_image"]["tmp_name"], $tpath1, 80);

            $data = array( 
                'images'  =>  $song_image
            );		
        
            $user_update =Update('tbl_users', $data, "WHERE id = '".$get_method['user_id']."'");
        
            $set['BUY_AND_SELL'][] = array('MSG' => $app_lang['update_success'],'success'=>'1');
		}

  		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
    }
  
    else if($get_method['method_name']=="user_images_update_bg"){	
    	
		if($_FILES['song_image']['name']!=""){
		    
			$song_image=rand(0,99999)."_".$_FILES['song_image']['name'];
			
            //Main Image
            $tpath1='images/users/'.$song_image;        
            $pic1=compress_image($_FILES["song_image"]["tmp_name"], $tpath1, 80);

            $data = array( 
                'images_bg'  =>  $song_image
            );		
        
            $user_update =Update('tbl_users', $data, "WHERE id = '".$get_method['user_id']."'");
        
            $set['BUY_AND_SELL'][] = array('MSG' => $app_lang['update_success'],'success'=>'1');
		}

  		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
  }
  
    else if($get_method['method_name']=="post_report"){		
  		
  		$post_id = $get_method['post_id'];
  		$user_id = $get_method['user_id']; 
  		$titel = $get_method['titel']; 
  		$report = $get_method['report']; 
  		
  		 $data = array( 
            'post_id'  =>  $post_id,
            'user_id'  =>  $user_id,
            'titel'  =>  $titel,
            'report'  =>  $report,
            'date_time'  =>  strtotime(date('d-m-Y h:i:s A')),
        );		
        
        $qry = Insert('tbl_reports',$data);	
  		
		$set['BUY_AND_SELL'][] = array('MSG' => $app_lang['report_success'],'success'=>'1');

  		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
    }
    
    else if($get_method['method_name']=="app_update"){
    	$jsonObj= array();	
    	$query="SELECT * FROM tbl_update WHERE id='1'";
    	$sql = mysqli_query($mysqli,$query);
    	while($data = mysqli_fetch_assoc($sql)){
        	$row['version'] = $data['version'];
        	$row['version_name'] = $data['version_name'];
        	$row['description'] = $data['description'];
        	$row['url'] = $data['url'];
        	array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();	
    }
    
    else if($get_method['method_name']=="otp_pass"){
        
        $email=addslashes(trim($get_method['user_email']));

		$qry = "SELECT * FROM tbl_users WHERE email = '$email' AND `user_type`='Normal' AND `id` <> 0"; 
		$result = mysqli_query($mysqli,$qry);
		$row = mysqli_fetch_assoc($result);
		
		if($row['email']!=""){
		    
			$password=generateRandomOTP(4);
			
            $password_new = $password;

			$to = $row['email'];
			$recipient_name=$row['name'];
			// subject
			$subject = str_replace('###', APP_NAME, $app_lang['forgot_otp_sub_lbl']);
 			
			$message='<div style="background-color: #f9f9f9;" align="center"><br />
					  <table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
					    <tbody>
					      <tr>
					        <td colspan="2" bgcolor="#FFFFFF" align="center"><img src="'.$file_path.'images/'.APP_LOGO.'" alt="header" style="width:100px;height:auto; padding: 10px;"/></td>
					      </tr>
					      <tr>
					      <br>
					      <br>
					      <tr>
					        <td colspan="2" bgcolor="#FFFFFF" align="center" style="padding-top:25px;">
					          <img src="'.$file_path.'assets/images/otp.png" alt="header" auto-height="100" width="50%"/>
					        </td>
					      </tr>
					        <td width="600" valign="top" bgcolor="#FFFFFF"><br>
					          <table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
					            <tbody>
					              <tr>
					                <td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
					                    <tbody>
					                      <tr>
					                        <td>
					                        <p style="color: #262626; font-size: 24px; margin-top:0px;"><strong>'.$app_lang['dear_lbl'].' '.$row['name'].'</strong></p>
					                          <p style="color:#262626; font-size:20px; line-height:32px;font-weight:500;margin-top:5px;"><br>'.$app_lang['your_otp_lbl'].': <span style="font-weight:500; font-weight: bold; color:#e91e63">'.$password_new.'</span></p>
					                          <p style="color:#262626; font-size:17px; line-height:32px;font-weight:500;margin-bottom:30px;">'.$app_lang['thank_you_lbl'].' '.APP_NAME.'</p>

					                        </td>
					                      </tr>
					                    </tbody>
					                  </table></td>
					              </tr>
					               
					            </tbody>
					          </table></td>
					      </tr>
					      <tr>
					        <td style="color: #262626; padding: 20px 0; font-size: 18px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">'.$app_lang['email_copyright'].' '.APP_NAME.'.</td>
					      </tr>
					    </tbody>
					  </table>
					</div>';

			send_email($to,$recipient_name,$subject,$message);
			
		    $data = array(
		       'app_otp'  =>  '0',
			   'app_otp'  =>  $password_new
			);
 
            $user_edit=Update('tbl_users', $data, "WHERE id = '".$row['id']."'");

			$set['BUY_AND_SELL'][]=array('MSG' => $password_new ,'success'=>'1');
		}
		else{  	 
			$set['BUY_AND_SELL'][]=array('MSG' => 'email_not_found','success'=>'0');		
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
		die();
    }
    
    else if($get_method['method_name']=="otp_verified"){
        
        $email=addslashes(trim($get_method['user_email']));
        $otp=addslashes(trim($get_method['user_otp']));
        

		$qry = "SELECT * FROM tbl_users WHERE email = '$email' AND `user_type`='Normal' AND `id` <> 0"; 
		$result = mysqli_query($mysqli,$qry);
		$row = mysqli_fetch_assoc($result);
		
		if($row['email']!=""){
		    
		    if($row['app_otp']==$otp){
		        $data = array(
			        'otp_status'  =>  1
			    );
 
                $user_edit=Update('tbl_users', $data, "WHERE id = '".$row['id']."'");
    
    			$set['BUY_AND_SELL'][]=array('MSG' => $app_lang['otp_success'],'success'=>'1');
		    }
		    else{  	 
			$set['BUY_AND_SELL'][]=array('MSG' => $app_lang['invalid_otp'],'success'=>'0');		
		    }

		}
		else{  	 
			$set['BUY_AND_SELL'][]=array('MSG' => $app_lang['email_not_found'],'success'=>'0');		
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
		die();
    }
    
    else if($get_method['method_name']=="forgot_pass"){
        
        $email=addslashes(trim($get_method['user_email']));

		$qry = "SELECT * FROM tbl_users WHERE email = '$email' AND `user_type`='Normal' AND `id` <> 0"; 
		$result = mysqli_query($mysqli,$qry);
		$row = mysqli_fetch_assoc($result);
		
		if($row['email']!=""){
		    
			$password=generateRandomPassword(7);
			
            $password_new = $password;

			$to = $row['email'];
			$recipient_name=$row['name'];
			// subject
			$subject = str_replace('###', APP_NAME, $app_lang['forgot_password_sub_lbl']);
 			
			$message='<div style="background-color: #f9f9f9;" align="center"><br />
					  <table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
					    <tbody>
					      <tr>
					        <td colspan="2" bgcolor="#FFFFFF" align="center"><img src="'.$file_path.'images/'.APP_LOGO.'" alt="header" style="width:100px;height:auto"/></td>
					      </tr>
					      <tr>
					        <td width="600" valign="top" bgcolor="#FFFFFF"><br>
					          <table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
					            <tbody>
					              <tr>
					                <td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
					                    <tbody>
					                      <tr>
					                        <td>
					                        <p style="color: #262626; font-size: 24px; margin-top:0px;"><strong>'.$app_lang['dear_lbl'].' '.$row['name'].'</strong></p>
					                          <p style="color:#262626; font-size:20px; line-height:32px;font-weight:500;margin-top:5px;"><br>'.$app_lang['your_password_lbl'].': <span style="font-weight:400;">'.$password_new.'</span></p>
					                          <p style="color:#262626; font-size:17px; line-height:32px;font-weight:500;margin-bottom:30px;">'.$app_lang['thank_you_lbl'].' '.APP_NAME.'</p>

					                        </td>
					                      </tr>
					                    </tbody>
					                  </table></td>
					              </tr>
					               
					            </tbody>
					          </table></td>
					      </tr>
					      <tr>
					        <td style="color: #262626; padding: 20px 0; font-size: 18px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">'.$app_lang['email_copyright'].' '.APP_NAME.'.</td>
					      </tr>
					    </tbody>
					  </table>
					</div>';

			send_email($to,$recipient_name,$subject,$message);
			
			 $data = array(
			'password'  =>  md5(trim($password_new))
			);
 
            $user_edit=Update('tbl_users', $data, "WHERE id = '".$row['id']."'");

			$set['BUY_AND_SELL'][]=array('MSG' => $app_lang['password_sent_mail'],'success'=>'1');
		}
		else{  	 
			$set['BUY_AND_SELL'][]=array('MSG' => $app_lang['email_not_found'],'success'=>'0');		
		}

		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
		die();
    }
    
    else if($get_method['method_name']=="user_register"){

  		$user_type=trim($get_method['type']); //Google, Normal, Facebook

		$email=addslashes(trim($get_method['email']));
		$auth_id=addslashes(trim($get_method['auth_id']));

		$to = $get_method['email'];
		$recipient_name=$get_method['name'];
		// subject

		$subject = str_replace('###', APP_NAME, $app_lang['register_mail_lbl']);

		if($user_type=='Google' || $user_type=='google'){
			// register with google

			$sql="SELECT * FROM tbl_users WHERE (`email` = '$email' OR `auth_id`='$auth_id') AND `user_type`='Google'";
			$res=mysqli_query($mysqli,$sql);
			$num_rows = mysqli_num_rows($res);
 			$row = mysqli_fetch_assoc($res);
		
    		if($num_rows == 0){
    			// data is not available
    			$data = array(
					'user_type'=>'Google',
					'name'  => addslashes(trim($get_method['name'])),				    
					'email'  =>  addslashes(trim($get_method['email'])),
					'password'  =>  trim($get_method['password']),
					'phone'  =>  addslashes(trim($get_method['phone'])),
					'registered_on'  =>  strtotime(date('d-m-Y h:i:s A')), 
					'status'  =>  '1',
					'otp_status'  =>  1
				);		
	 			 
				$qry = Insert('tbl_users',$data);

				$user_id=mysqli_insert_id($mysqli);

				$sql_activity_log="SELECT * FROM tbl_active_log WHERE `user_id`='$user_id'";
                $res_activity_log=mysqli_query($mysqli, $sql_activity_log);

                if(mysqli_num_rows($res_activity_log) == 0){
                    // insert active log

                    $data_log = array(
                        'user_id'  =>  $user_id,
                        'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
                    );

                    $qry = Insert('tbl_active_log',$data_log);

                }
                else{
                    // update active log
                    $data_log = array(
                        'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
                    );

                    $update=Update('tbl_active_log', $data_log, "WHERE user_id = '$user_id'");  
                }

                mysqli_free_result($res_activity_log);

				$message='<div style="background-color: #eee;" align="center"><br />
							  <table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
							    <tbody>
							      <tr>
							        <td colspan="2" bgcolor="#FFFFFF" align="center" ><img src="'.$file_path.'images/'.APP_LOGO.'" alt="logo" style="width:100px;height:auto"/></td>
							      </tr>
							      <br>
							      <br>
							      <tr>
							        <td colspan="2" bgcolor="#FFFFFF" align="center" style="padding-top:25px;">
							          <img src="'.$file_path.'assets/images/thankyoudribble.gif" alt="header" auto-height="100" width="50%"/>
							        </td>
							      </tr>
							      <tr>
							        <td width="600" valign="top" bgcolor="#FFFFFF">
							          <table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
							            <tbody>
							              <tr>
							                <td valign="top">
							                  <table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
							                    <tbody>
							                      <tr>
							                        <td>
							                          <p style="color: #717171; font-size: 24px; margin-top:0px; margin:0 auto; text-align:center;"><strong>'.$app_lang['welcome_lbl'].', '.addslashes(trim($get_method['name'])).'</strong></p>
							                          <br>
							                          <p style="color:#15791c; font-size:18px; line-height:32px;font-weight:500;margin-bottom:30px; margin:0 auto; text-align:center;">'.$app_lang['google_register_MSG'].'<br /></p>
							                          <br/>
							                          <p style="color:#999; font-size:17px; line-height:32px;font-weight:500;">'.$app_lang['thank_you_lbl'].' '.APP_NAME.'</p>
							                            </td>
							                      </tr>
							                    </tbody>
							                  </table>
							                </td>
							              </tr>
							            </tbody>
							          </table>
							        </td>
							      </tr>
							      <tr>
							        <td style="color: #262626; padding: 20px 0; font-size: 18px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">'.$app_lang['email_copyright'].' '.APP_NAME.'.</td>
							      </tr>
							    </tbody>
							  </table>
							</div>';

				$set['BUY_AND_SELL'][]=array('user_id' => strval($user_id),'name'=>$get_method['name'],'email'=>$get_method['email'], 'success'=>'1', 'MSG' =>'', 'auth_id' => $auth_id);
    		}
    		else{
    			$data = array(
		            'auth_id'  =>  $auth_id,
		        ); 
   
		        $update=Update('tbl_users', $data, "WHERE id = '".$row['id']."'");

		        $user_id=$row['id'];

				$sql_activity_log="SELECT * FROM tbl_active_log WHERE `user_id`='$user_id'";
                $res_activity_log=mysqli_query($mysqli, $sql_activity_log);

                if(mysqli_num_rows($res_activity_log) == 0){
                    // insert active log

                    $data_log = array(
                        'user_id'  =>  $user_id,
                        'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
                    );
                    $qry = Insert('tbl_active_log',$data_log);
                }
                else{
                    // update active log
                    $data_log = array(
                        'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
                    );
                    $update=Update('tbl_active_log', $data_log, "WHERE user_id = '$user_id'");  
                }

                mysqli_free_result($res_activity_log);

				if($row['status']==0){
					$set['BUY_AND_SELL'][]=array('MSG' =>$app_lang['account_deactive'],'success'=>'0');
				} else{
					$set['BUY_AND_SELL'][]=array('user_id' => $row['id'], 'name'=>$row['name'], 'email'=>$row['email'], 'MSG' => $app_lang['login_success'], 'auth_id' => $auth_id, 'success'=>'1');
				}
    		}

		}
		else if($user_type=='Facebook' || $user_type=='facebook'){

			// register with facebook

			$sql="SELECT * FROM tbl_users WHERE (`email` = '$email' OR `auth_id`='$auth_id') AND `user_type`='Facebook'";
			$res=mysqli_query($mysqli,$sql);
			$num_rows = mysqli_num_rows($res);
 			$row = mysqli_fetch_assoc($res);
		
    		if($num_rows == 0)
    		{
    			// data is not available
    			$data = array(
					'user_type'=>'Facebook',
					'name'  => addslashes(trim($get_method['name'])),				    
					'email'  =>  addslashes(trim($get_method['email'])),
					'password'  =>  trim($get_method['password']),
					'phone'  =>  addslashes(trim($get_method['phone'])),
					'registered_on'  =>  strtotime(date('d-m-Y h:i:s A')), 
					'status'  =>  '1',
					'otp_status'  =>  1
				);		
	 			 
				$qry = Insert('tbl_users',$data);

				$user_id=mysqli_insert_id($mysqli);

				$sql_activity_log="SELECT * FROM tbl_active_log WHERE `user_id`='$user_id'";
                $res_activity_log=mysqli_query($mysqli, $sql_activity_log);

                if(mysqli_num_rows($res_activity_log) == 0){
                    // insert active log

                    $data_log = array(
                        'user_id'  =>  $user_id,
                        'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
                    );

                    $qry = Insert('tbl_active_log',$data_log);

                }
                else{
                    // update active log
                    $data_log = array(
                        'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
                    );

                    $update=Update('tbl_active_log', $data_log, "WHERE user_id = '$user_id'");  
                }

                mysqli_free_result($res_activity_log);

				$message='<div style="background-color: #eee;" align="center"><br />
							  <table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
							    <tbody>
							      <tr>
							        <td colspan="2" bgcolor="#FFFFFF" align="center" ><img src="'.$file_path.'images/'.APP_LOGO.'" alt="logo" style="width:100px;height:auto"/></td>
							      </tr>
							      <br>
							      <br>
							      <tr>
							        <td colspan="2" bgcolor="#FFFFFF" align="center" style="padding-top:25px;">
							          <img src="'.$file_path.'assets/images/thankyoudribble.gif" alt="header" auto-height="100" width="50%"/>
							        </td>
							      </tr>
							      <tr>
							        <td width="600" valign="top" bgcolor="#FFFFFF">
							          <table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
							            <tbody>
							              <tr>
							                <td valign="top">
							                  <table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
							                    <tbody>
							                      <tr>
							                        <td>
							                          <p style="color: #717171; font-size: 24px; margin-top:0px; margin:0 auto; text-align:center;"><strong>'.$app_lang['welcome_lbl'].', '.addslashes(trim($get_method['name'])).'</strong></p>
							                          <br>
							                          <p style="color:#15791c; font-size:18px; line-height:32px;font-weight:500;margin-bottom:30px; margin:0 auto; text-align:center;">'.$app_lang['facebook_register_MSG'].'<br /></p>
							                          <br/>
							                          <p style="color:#999; font-size:17px; line-height:32px;font-weight:500;">'.$app_lang['thank_you_lbl'].' '.APP_NAME.'</p>
							                            </td>
							                      </tr>
							                    </tbody>
							                  </table>
							                </td>
							              </tr>
							            </tbody>
							          </table>
							        </td>
							      </tr>
							      <tr>
							        <td style="color: #262626; padding: 20px 0; font-size: 18px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">'.$app_lang['email_copyright'].' '.APP_NAME.'.</td>
							      </tr>
							    </tbody>
							  </table>
							</div>';

				$set['BUY_AND_SELL'][]=array('user_id' => strval($user_id),'name'=>$get_method['name'],'email'=>$get_method['email'], 'success'=>'1', 'MSG' =>'', 'auth_id' => $auth_id);
    		}
    		else{
    			$data = array(
		            'auth_id'  =>  $auth_id,
		        ); 
   
		        $update=Update('tbl_users', $data, "WHERE id = '".$row['id']."'");

		        $user_id=$row['id'];

				$sql_activity_log="SELECT * FROM tbl_active_log WHERE `user_id`='$user_id'";
                $res_activity_log=mysqli_query($mysqli, $sql_activity_log);

                if(mysqli_num_rows($res_activity_log) == 0){
                    // insert active log

                    $data_log = array(
                        'user_id'  =>  $user_id,
                        'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
                    );
                    $qry = Insert('tbl_active_log',$data_log);
                }
                else{
                    // update active log
                    $data_log = array(
                        'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
                    );
                    $update=Update('tbl_active_log', $data_log, "WHERE user_id = '$user_id'");  
                }

                mysqli_free_result($res_activity_log);

				if($row['status']==0){
					$set['BUY_AND_SELL'][]=array('MSG' =>$app_lang['account_deactive'],'success'=>'0');
				} else{
					$set['BUY_AND_SELL'][]=array('user_id' => $row['id'], 'name'=>$row['name'], 'email'=>$row['email'], 'MSG' => $app_lang['login_success'], 'auth_id' => $auth_id, 'success'=>'1');
				}
    		}

		}
		else{
			// for normal registration

			$sql = "SELECT * FROM tbl_users WHERE email = '$email' AND `user_type`='Normal'";
			$result = mysqli_query($mysqli, $sql);
			$row = mysqli_fetch_assoc($result);
			
			if (!filter_var($get_method['email'], FILTER_VALIDATE_EMAIL)) {
				$set['BUY_AND_SELL'][]=array('MSG' => $app_lang['invalid_email_format'],'success'=>'0');
			}
			else if($row['email']!=""){
				$set['BUY_AND_SELL'][]=array('MSG' => $app_lang['email_exist'],'success'=>'0');
			}
			else{	
				$data = array(
					'user_type'=>'Normal',											 
					'name'  => addslashes(trim($get_method['name'])),				    
					'email'  =>  addslashes(trim($get_method['email'])),
					'password'  =>  md5(trim($get_method['password'])),
					'phone'  =>  addslashes(trim($get_method['phone'])),
					'registered_on'  =>  strtotime(date('d-m-Y h:i:s A')),
					'status'  =>  '1'
				);		
	 			 
				$qry = Insert('tbl_users',$data);

				$message='<div style="background-color: #eee;" align="center"><br />
							  <table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
							    <tbody>
							      <tr>
							        <td colspan="2" bgcolor="#FFFFFF" align="center" ><img src="'.$file_path.'images/'.APP_LOGO.'" alt="logo" style="width:100px;height:auto"/></td>
							      </tr>
							      <br>
							      <br>
							      <tr>
							        <td colspan="2" bgcolor="#FFFFFF" align="center" style="padding-top:25px;">
							          <img src="'.$file_path.'assets/images/thankyoudribble.gif" alt="header" auto-height="100" width="50%"/>
							        </td>
							      </tr>
							      <tr>
							        <td width="600" valign="top" bgcolor="#FFFFFF">
							          <table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
							            <tbody>
							              <tr>
							                <td valign="top">
							                  <table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
							                    <tbody>
							                      <tr>
							                        <td>
							                        	<p style="color: #717171; font-size: 24px; margin-top:0px; margin:0 auto; text-align:center;"><strong>'.$app_lang['welcome_lbl'].', '.addslashes(trim($get_method['name'])).'</strong></p>
							                          	<br>
							                          	<p style="color:#15791c; font-size:18px; line-height:32px;font-weight:500;margin-bottom:30px; margin:0 auto; text-align:center;">'.$app_lang['normal_register_MSG'].'<br /></p>
							                          	<br/>
							                          	<p style="color:#999; font-size:17px; line-height:32px;font-weight:500;">'.$app_lang['thank_you_lbl'].' '.APP_NAME.'</p>
							                            </td>
							                      </tr>
							                    </tbody>
							                  </table>
							                </td>
							              </tr>
							            </tbody>
							          </table>
							        </td>
							      </tr>
							      <tr>
							        <td style="color: #262626; padding: 20px 0; font-size: 18px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">'.$app_lang['email_copyright'].' '.APP_NAME.'.</td>
							      </tr>
							    </tbody>
							  </table>
							</div>';
					
				$set['BUY_AND_SELL'][]=array('MSG' => $app_lang['register_success'],'success'=>'1');
			}
		}
		//send_email($to,$recipient_name,$subject,$message);

		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
  	}
    
    else if($get_method['method_name']=="user_login"){
		$email= htmlentities(trim($get_method['email']));
		$password = htmlentities(trim($get_method['password']));
		$auth_id = htmlentities(trim($get_method['auth_id']));
		$user_type = htmlentities(trim($get_method['type']));

		if($user_type=='normal' OR $user_type=='Normal'){

			// simple login
			$qry = "SELECT * FROM tbl_users WHERE email = '$email' AND (`user_type`='Normal' OR `user_type`='normal') AND `id` <> 0"; 
			$result = mysqli_query($mysqli,$qry);
			$num_rows = mysqli_num_rows($result);
			
			if($num_rows > 0){
				$row = mysqli_fetch_assoc($result);

				if($row['status']==1){
					if($row['password']==md5($password)){

						$user_id=$row['id'];

						$sql_activity_log="SELECT * FROM tbl_active_log WHERE `user_id`='$user_id'";
	                    $res_activity_log=mysqli_query($mysqli, $sql_activity_log);

	                    if(mysqli_num_rows($res_activity_log) == 0){
	                        // insert active log

	                        $data_log = array(
	                            'user_id'  =>  $user_id,
	                            'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
	                        );
	                        $qry = Insert('tbl_active_log',$data_log);

	                    }else{
	                        // update active log
	                        $data_log = array(
	                            'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
	                        );
	                        $update=Update('tbl_active_log', $data_log, "WHERE user_id = '$user_id'");  
	                    }

	                    mysqli_free_result($res_activity_log);
						$set['BUY_AND_SELL'][]=array('user_id' => $row['id'], 'name'=>$row['name'], 'email'=>$row['email'], 'images'=> get_thumb('images/users/'.$row['images'],'200x200'),'images_bg'=> get_thumb('images/users/'.$row['images_bg'],'500x400'), 'otp_status'=>$row['otp_status'], 'MSG' => $app_lang['login_success'], 'auth_id' => '', 'success'=>'1');
					}else{
						// invalid password
						$set['BUY_AND_SELL'][]=array('MSG' =>$app_lang['invalid_password'],'success'=>'0');
					}
				}else{
					// account is deactivated
					$set['BUY_AND_SELL'][]=array('MSG' =>$app_lang['account_deactive'],'success'=>'0');
				}
			}
			else{
				// email not found
				$set['BUY_AND_SELL'][]=array('MSG' =>$app_lang['email_not_found'],'success'=>'0');	
			}
		}
		else if($user_type=='google' OR $user_type=='Google'){
        
            // login with google
            $sql = "SELECT * FROM tbl_users WHERE (`email` = '$email' OR `auth_id`='$auth_id') AND (`user_type`='Google' OR `user_type`='google')";
            $res=mysqli_query($mysqli, $sql);
        
            if(mysqli_num_rows($res) > 0){
                $row = mysqli_fetch_assoc($res);
                if($row['status']==0){
                    $set['BUY_AND_SELL'][]=array('MSG' => $app_lang['account_deactive'],'success'=>'0');
                }
                else{
                    $user_id=$row['id'];
                    $sql_activity_log="SELECT * FROM tbl_active_log WHERE `user_id`='$user_id'";
                    $res_activity_log=mysqli_query($mysqli, $sql_activity_log);
        
                    if(mysqli_num_rows($res_activity_log) == 0){
                        // insert active log
                        $data_log = array(
                            'user_id'  =>  $user_id,
                            'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
                        );
                        $qry = Insert('tbl_active_log',$data_log);
                    }
                    else{
                        // update active log
                        $data_log = array(
                            'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
                        );
                        $update=Update('tbl_active_log', $data_log, "WHERE user_id = '$user_id'");  
                    }
                    mysqli_free_result($res_activity_log);
                    $set['BUY_AND_SELL'][]=array('user_id' => $row['id'], 'name'=>$row['name'], 'email'=>$row['email'], 'images'=> get_thumb('images/users/'.$row['images'],'200x200'),'images_bg'=> get_thumb('images/users/'.$row['images_bg'],'500x400'), 'otp_status'=>$row['otp_status'], 'MSG' => $app_lang['login_success'], 'auth_id' => $auth_id, 'success'=>'1');
        
                    $data = array(
                        'auth_id'  =>  $auth_id
                    );  
                    $updatePlayerID=Update('tbl_users', $data, "WHERE `id` = '".$row['id']."'");
                }
            }
            else{
                $set['BUY_AND_SELL'][]=array('MSG' => $app_lang['email_not_found'],'success'=>'0');
            }
        }
        else if($user_type=='facebook' OR $user_type=='Facebook'){
        
            // login with facebook
            $sql = "SELECT * FROM tbl_users WHERE (`email` = '$email' OR `auth_id`='$auth_id') AND (`user_type`='Facebook' OR `user_type`='facebook')";
            $res=mysqli_query($mysqli, $sql);
        
            if(mysqli_num_rows($res) > 0){
                $row = mysqli_fetch_assoc($res);
                if($row['status']==0){
                    $set['BUY_AND_SELL'][]=array('MSG' => $app_lang['account_deactive'],'success'=>'0');
                }	
                else{
                    $user_id=$row['id'];
                    $sql_activity_log="SELECT * FROM tbl_active_log WHERE `user_id`='$user_id'";
                    $res_activity_log=mysqli_query($mysqli, $sql_activity_log);
        
                    if(mysqli_num_rows($res_activity_log) == 0){
                        // insert active log
                        $data_log = array(
                            'user_id'  =>  $user_id,
                            'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
                        );
                        $qry = Insert('tbl_active_log',$data_log);
                    }
                    else{
                        // update active log
                        $data_log = array(
                            'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
                        );
                        $update=Update('tbl_active_log', $data_log, "WHERE user_id = '$user_id'");  
                    }
                    mysqli_free_result($res_activity_log);
                    $set['BUY_AND_SELL'][]=array('user_id' => $row['id'], 'name'=>$row['name'], 'email'=>$row['email'], 'images'=> get_thumb('images/users/'.$row['images'],'200x200'),'images_bg'=> get_thumb('images/users/'.$row['images_bg'],'500x400'), 'otp_status'=>$row['otp_status'], 'MSG' => $app_lang['login_success'], 'auth_id' => $auth_id, 'success'=>'1');
                    $data = array(
                        'auth_id'  =>  $auth_id
                    );  
                    $updatePlayerID=Update('tbl_users', $data, "WHERE `id` = '".$row['id']."'");
                }
            }
            else{
                $set['BUY_AND_SELL'][]=array('MSG' => $app_lang['email_not_found'],'success'=>'0');
            }
        }
		else{
			$set['BUY_AND_SELL'][]=array('success'=>'0', 'MSG' =>$app_lang['invalid_user_type']);
		}
		header( 'Content-Type: application/json; charset=utf-8' );
		echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
	}
	
	else if($get_method['method_name']=="payment_settings"){
        $jsonObj= array();	
    	$query="SELECT * FROM payment_settings WHERE id='1'";
    	$sql = mysqli_query($mysqli,$query);
    	while($data = mysqli_fetch_assoc($sql)){
    	    
            $row['currency_code'] = $data['currency_code'];
            
            
            if ($data['paypal_payment_on_off'] != "0") {
                $row['paypal_payment_on_off'] = 'true';
            } else {
                $row['paypal_payment_on_off'] = 'false';
            }
	
            $row['paypal_mode'] = $data['paypal_mode'];
            $row['paypal_client_id'] = $data['paypal_client_id'];
            
            if ($data['stripe_payment_on_off'] != "0") {
                $row['stripe_payment_on_off'] = 'true';
            } else {
                $row['stripe_payment_on_off'] = 'false';
            }
            $row['stripe_publishable_key'] = $data['stripe_publishable_key'];
            
            if ($data['razorpay_payment_on_off'] != "0") {
                $row['razorpay_payment_on_off'] = 'true';
            } else {
                $row['razorpay_payment_on_off'] = 'false';
            }
            $row['razorpay_key'] = $data['razorpay_key'];
            
            if ($data['paystack_payment_on_off'] != "0") {
                $row['paystack_payment_on_off'] = 'true';
            } else {
                $row['paystack_payment_on_off'] = 'false';
            }
            $row['paystack_public_key'] = $data['paystack_public_key'];
            
        	array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();	
    }
    
    else if($get_method['method_name']=="stripe_token_get"){
    
        $amount=$get_method['amount'];
        
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

        $currency_code= CURRENCY_PAY ? CURRENCY_PAY :'USD';
        
        $intent = \Stripe\PaymentIntent::create([
                'amount' => $amount * 100,
                'currency' => $currency_code,
        ]);

        if (!isset($intent->client_secret)){
            $set['BUY_AND_SELL'][]=array('MSG' =>"The Stripe Token was not generated correctly",'success'=>'0');
        }else{
            $client_secret = $intent->client_secret;

            $set['BUY_AND_SELL'][]=array("stripe_payment_token"=>$client_secret,'MSG' =>"Stripe Token",'success'=>'1');
        }  
        
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();	
    }
	
	else if($get_method['method_name']=="app_details"){
        $jsonObj= array();	
    	$query="SELECT * FROM tbl_settings WHERE id='1'";
    	$sql = mysqli_query($mysqli,$query);
    	while($data = mysqli_fetch_assoc($sql)){
        	$row['publisher_id'] = $data['publisher_id'];
        	$row['interstital_ad'] = $data['interstital_ad'];
        	$row['interstital_ad_id'] = $data['interstital_ad_id'];
        	$row['interstital_ad_click'] = $data['interstital_ad_click'];
        	$row['banner_ad'] = $data['banner_ad'];
        	$row['banner_ad_id'] = $data['banner_ad_id'];
            $row['facebook_interstital_ad'] = $data['facebook_interstital_ad'];
            $row['facebook_interstital_ad_id'] = $data['facebook_interstital_ad_id'];
        	$row['facebook_interstital_ad_click'] = $data['facebook_interstital_ad_click'];		
        	$row['facebook_banner_ad'] = $data['facebook_banner_ad'];
        	$row['facebook_banner_ad_id'] = $data['facebook_banner_ad_id'];
        	$row['facebook_native_ad'] = $data['facebook_native_ad'];
            $row['facebook_native_ad_id'] = $data['facebook_native_ad_id'];
    		$row['facebook_native_ad_click'] = $data['facebook_native_ad_click'];		
    		$row['admob_nathive_ad'] = $data['admob_nathive_ad'];
    		$row['admob_native_ad_id'] = $data['admob_native_ad_id'];
    		$row['admob_native_ad_click'] = $data['admob_native_ad_click'];
         	$row['company'] = $data['company'];
        	$row['email'] = $data['email'];
        	$row['website'] = $data['website'];
        	$row['contact'] = $data['contact'];
            $row['currency_code'] = $data['currency_code'];
            $row['currency_position'] = $data['currency_position'];
    	    $row['banner_size'] = $data['banner_size'];
            $row['banner_size_fb'] = $data['banner_size_fb'];
            $row['facebook_login'] = $data['facebook_login'];
            $row['google_login'] = $data['google_login'];
            $row['home_page'] = $data['home_page'];
            $row['ad_promote'] = $data['ad_promote'];
            $row['isRTL'] = $data['isRTL'];
			$row['envato_purchase_code'] = $data['envato_purchase_code'];
            $row['app_api_key'] = $data['app_api_key'];
        	array_push($jsonObj,$row);
    	}
    	$set['BUY_AND_SELL'] = $jsonObj;
    	header( 'Content-Type: application/json; charset=utf-8' );
        echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    	die();	
    }	

    else{
    	$get_method = checkSignSalt($_POST['data']);
    }
?>