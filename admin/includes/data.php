<?php
    /**
     * Company : Nemosofts
     * Detailed : Software Development Company in Sri Lanka
     * Developer : Thivakaran
     * Contact : thivakaran829@gmail.com
     * Contact : nemosofts@gmail.com
     * Website : https://nemosofts.com
     */
     
     // Update Data, Where clause is left optional
    function Update($table_name, $form_data, $where_clause = ''){
        global $mysqli;
        // check for optional where clause
        $whereSQL = '';
        if (!empty($where_clause)) {
            // check to see if the 'where' keyword exists
            if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
                // not found, add key word
                $whereSQL = " WHERE " . $where_clause;
            } else {
                $whereSQL = " " . trim($where_clause);
            }
        }
        // start the actual SQL statement
        $sql = "UPDATE " . $table_name . " SET ";
    
        // loop and build the column /
        $sets = array();
        foreach ($form_data as $column => $value) {
            $sets[] = "`" . $column . "` = '" . $value . "'";
        }
        $sql .= implode(', ', $sets);
    
        // append the where statement
        $sql .= $whereSQL;
    
        // run and return the query result
        return mysqli_query($mysqli, $sql);
    }
    
    //Delete Data, the where clause is left optional incase the user wants to delete every row!
    function Delete($table_name, $where_clause = ''){
        global $mysqli;
        // check for optional where clause
        $whereSQL = '';
        if (!empty($where_clause)) {
            // check to see if the 'where' keyword exists
            if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
                // not found, add keyword
                $whereSQL = " WHERE " . $where_clause;
            } else {
                $whereSQL = " " . trim($where_clause);
            }
        }
        // build the query
        $sql = "DELETE FROM " . $table_name . $whereSQL;
    
        // run and return the query result resource
        return mysqli_query($mysqli, $sql);
    }

    $license_filename="includes/.lic";
	$activate="activate/index.php";
	$install="install/index.php";
	$filename_data="includes/.lic";
	$Item_ID="254754724";
    $config_file_name= "api.php"; 
?> 