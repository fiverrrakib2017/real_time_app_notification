<?php //error_reporting(0);
/**
	 * Company : Nemosofts
	* Detailed : Software Development Company in Sri Lanka
	* Developer : Thivakaran
	* Contact : info.nemosofts@gmail.com
	* Website : https://nemosofts.com
    */
    
    function generateStrongPassword1($length = 8, $add_dashes = false, $available_sets = 'ld'){
    	$sets = array();
    	if(strpos($available_sets, 'l') !== false)
    		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
    
    	if(strpos($available_sets, 'd') !== false)
    		$sets[] = '23456789';
    	
    
    	$all = '';
    	$password = '';
    	foreach($sets as $set){
    		$password .= $set[array_rand(str_split($set))];
    		$all .= $set;
    	}
    
    	$all = str_split($all);
    	for($i = 0; $i < $length - count($sets); $i++)
    		$password .= $all[array_rand($all)];
    
    	$password = str_shuffle($password);
    
    	if(!$add_dashes)
    		return $password;
    
    	$dash_len = floor(sqrt($length));
    	$dash_str = '';
    	while(strlen($password) > $dash_len){
    		$dash_str .= substr($password, 0, $dash_len) . '-';
    		$password = substr($password, $dash_len);
    	}
    	$dash_str .= $password;
    	return $dash_str;
    }

    function generateStrongPassword2($length = 4, $add_dashes = false, $available_sets = 'ld'){
    	$sets = array();
    	if(strpos($available_sets, 'l') !== false)
    		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
    
    	if(strpos($available_sets, 'd') !== false)
    		$sets[] = '23456789';
    	
    
    	$all = '';
    	$password = '';
    	foreach($sets as $set){
    		$password .= $set[array_rand(str_split($set))];
    		$all .= $set;
    	}
    
    	$all = str_split($all);
    	for($i = 0; $i < $length - count($sets); $i++)
    		$password .= $all[array_rand($all)];
    
    	$password = str_shuffle($password);
    
    	if(!$add_dashes)
    		return $password;
    
    	$dash_len = floor(sqrt($length));
    	$dash_str = '';
    	while(strlen($password) > $dash_len){
    		$dash_str .= substr($password, 0, $dash_len) . '-';
    		$password = substr($password, $dash_len);
    	}
    	$dash_str .= $password;
    	return $dash_str;
    }

    function generateStrongPassword3($length = 12, $add_dashes = false, $available_sets = 'ld'){
    	$sets = array();
    	if(strpos($available_sets, 'l') !== false)
    		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
    
    	if(strpos($available_sets, 'd') !== false)
    		$sets[] = '23456789';
    	
    
    	$all = '';
    	$password = '';
    	foreach($sets as $set){
    		$password .= $set[array_rand(str_split($set))];
    		$all .= $set;
    	}
    
    	$all = str_split($all);
    	for($i = 0; $i < $length - count($sets); $i++)
    		$password .= $all[array_rand($all)];
    
    	$password = str_shuffle($password);
    
    	if(!$add_dashes)
    		return $password;
    
    	$dash_len = floor(sqrt($length));
    	$dash_str = '';
    	while(strlen($password) > $dash_len){
    		$dash_str .= substr($password, 0, $dash_len) . '-';
    		$password = substr($password, $dash_len);
    	}
    	$dash_str .= $password;
    	return $dash_str;
    }

    function generateStrongPassword(){
    	$key = generateStrongPassword1()."-".generateStrongPassword2()."-".generateStrongPassword2()."-".generateStrongPassword2()."-".generateStrongPassword3();
    	return $key;
    }
?>