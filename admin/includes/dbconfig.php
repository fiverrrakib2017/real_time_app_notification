<?php
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  //Username, Password and Database
  $con = new mysqli("localhost:3306", "azacodes_root", "Aws045045", "azacodes_BoomVPN");
  $con->set_charset("utf8mb4");
} catch(Exception $e) {
  error_log($e->getMessage());
  //Should be a message a typical user could understand
}

?>

