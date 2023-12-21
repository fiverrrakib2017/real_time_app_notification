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
    include("includes/session_check.php");
    include("includes/config.php");
    
    $currentFile = $_SERVER["SCRIPT_NAME"];
    $parts = Explode('/', $currentFile);
    $currentFile = $parts[count($parts) - 1];       
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="">
<meta name="description" content="">
<meta name="viewport"content="width=device-width, initial-scale=1.0">
<link rel="icon" href="images/<?php echo APP_LOGO;?>" sizes="32x32">
<link rel="icon" href="images/<?php echo APP_LOGO;?>" sizes="192x192">
<link rel="apple-touch-icon-precomposed" href="images/<?php echo APP_LOGO;?>">
<meta name="msapplication-TileImage" content="images/<?php echo APP_LOGO;?>">
<title><?php echo (isset($page_title)) ? $page_title.' | '.APP_NAME : APP_NAME; ?></title></title>


<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="assets/css/nemosofts.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="assets/css/new.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="assets/sweetalert/sweetalert.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="assets/css/checkbox.css">
<!--===============================================================================================-->
<?php if(DARK!="0"){?>
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="assets/css/bootstrapDark.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="assets/css/bootstrapDark_new.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--=========
===================================================================

===================-->
<style>
    .checkbox {
    color: #fff;
}

.card.card-tab .card-header > ul, .card.card-tab ul.nav-tabs {
    background-color: #1e1e1e;
    border-bottom: 1px solid #151515;
}
.card.card-tab .card-header > ul > li.active, .card.card-tab ul.nav-tabs > li.active {
    border-left: 1px solid #151515;
    border-right: 1px solid #151515;
    background-color: #151515;
}
.card.card-tab .card-header {
    background-color: #151515;
}
.form-control {
    color: #fff;
    background-color: #151515;
    border: 1px solid #6b6b6b;
}
.select2-container--default .select2-selection--multiple {
    border: 1px solid #2f2f2f;
    background-color: #151515;
}
label.col-sm-3.col-form-label {
    color: #fff;
}
i.fa.fa-cc-paypal {
    color: #fff;
}
h5.m-b-5 {
    color: #fff;
}
b {
    font-weight: 600;
}
</style>

<?php }else{?>
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="assets/css/bootstrapLight.min.css">

<!--===============================================================================================-->
<?php }?>
<!--===============================================================================================-->
<script src="assets/ckeditor/ckeditor.js"></script>
<!--===============================================================================================-->
<style>
    table.table > tbody > tr td, table.table > tbody > tr th, table.table > thead > tr td {
    font-size: 14px;
    font-family: "Poppins", sans-serif;
}
</style>
<Style>
    .btn {
    padding: 10px 30px;
    border-radius: 3px;
    border-width: 1px;
    border-style: solid;
    border-color: transparent;
    /* border-radius: 3px; */
    box-shadow: 0 2px 3px rgba(223, 230, 232, 0.3);
    margin-bottom: 5px;
    transition: all .3s ease;
}
.btn.btn-primary {
	border-color: #e91e63;
	background-color:#e91e63;
	box-shadow: 0 2px 3px rgba(9, 80, 119, 0.3);
}
.btn.btn-primary:hover {
	box-shadow: 0 4px 6px rgba(9, 80, 119, 0.15);
}
.btn.btn-success {
	border-color: #39a2e9;
	border-bottom-color: #18aa4a;
	background-color: #39a2e9;
	box-shadow: 0 2px 3px rgba(41, 199, 95, 0.3);
}
.btn.btn-success:hover {
	box-shadow: 0 4px 6px rgba(41, 199, 95, 0.15);
}
.btn.btn-warning {
	border-color: #fc8229;
	border-bottom-color: #eb6b0e;
	background-color: #fc8229;
	box-shadow: 0 2px 3px rgba(252, 130, 41, 0.3);
}
.btn.btn-warning:hover {
	box-shadow: 0 4px 6px rgba(252, 130, 41, 0.15);
}
.btn.btn-danger {
	border-color: #E74C3C;
	border-bottom-color: #d73727;
	background-color: #E74C3C;
	box-shadow: 0 2px 3px rgba(231, 76, 60, 0.3);
}
.btn.btn-danger:hover {
	box-shadow: 0 4px 6px rgba(231, 76, 60, 0.15);
}
.btn.btn-info {
	border-color: #39c3da;
	border-bottom-color: #20a3b9;
	background-color: #39c3da;
	box-shadow: 0 2px 3px rgba(57, 195, 218, 0.3);
}
.btn.btn-info:hover {
	box-shadow: 0 4px 6px rgba(57, 195, 218, 0.15);
}
.btn.btn-social {
	color: #FFF;
}
</Style>
</head>
<body>
<div class="app app-default">
    <aside class="app-sidebar" id="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
        <div class="sidebar-header"> <a class="sidebar-brand" href="home.php"><img src="images/<?php echo APP_LOGO;?>" alt="app logo" /></a>
            <button type="button" class="sidebar-toggle"> <i class="fa fa-times"></i> </button>
        </div>
        
        <div class="sidebar-menu">
            <ul class="sidebar-nav">
                <li <?php if($currentFile=="home.php"){?>class="active"<?php }?>> 
                    <a href="home.php">
                        <div class="icon"> <i class="fa fa-dashboard" aria-hidden="true"></i></div>
                        <div class="title">Dashboard</div>
                    </a> 
                </li>
                
                
                
                <li <?php if($currentFile=="add_server.php" or $currentFile=="add_server.php"){?>class="active"<?php }?>> 
                    <a href="add_server.php">
                        <div class="icon"> <i class="fa fa-sitemap" aria-hidden="true"></i> </div>
                        <div class="title">Add Server</div>
                    </a> 
                </li>
                
                
                
                <li <?php if($currentFile=="manage_servers.php" or $currentFile=="manage_servers.php"){?>class="active"<?php }?>> 
                    <a href="manage_servers.php">
                        <div class="icon"> <i class="fa fa-sitemap" aria-hidden="true"></i> </div>
                        <div class="title">Manage Servers</div>
                    </a> 
                </li>
                
                
                
                
                
                
                
                
                
              
                
                
                
                
                
                
                
                
                
                
        
                
                
                        
                <li <?php if ($currentFile == "manage_users.php" or $currentFile == "add_user.php" or $currentFile == "user_profile.php") { ?>class="active" <?php } ?>> <a href="manage_users.php">
                  <div class="icon"> <i class="fa fa-users" aria-hidden="true"></i> </div>
                  <div class="title">Users</div>
                </a>
                </li>




        
                <li <?php if($currentFile=="send_notification.php"){?>class="active"<?php }?>> 
                    <a href="send_notification.php">
                        <div class="icon"> <i class="fa fa-bell" aria-hidden="true"></i> </div>
                        <div class="title">Notification</div>
                    </a> 
                </li>
                
                
                
                
                <li <?php if($currentFile=="smtp_settings.php"){?>class="active"<?php }?>> <a href="smtp_settings.php">
                  <div class="icon"> <i class="fa fa-envelope" aria-hidden="true"></i> </div>
                  <div class="title">SMTP Settings</div>
                  </a> 
                </li>
                
                
                
                
                <li <?php if($currentFile=="settings.php"){?>class="active"<?php }?>> 
                    <a href="settings.php">
                        <div class="icon"> <i class="fa fa-cog" aria-hidden="true"></i> </div>
                        <div class="title">Settings</div>
                    </a> 
                </li>
                
                
                
                
                <li <?php if($currentFile=="update_app.php"){?>class="active"<?php }?>> 
                    <a href="update_app.php">
                        <div class="icon"> <i class="fa fa-cloud-upload" aria-hidden="true"></i> </div>
                        <div class="title">Update</div>
                    </a> 
                </li>




                
        
         <?php if(file_exists('speed_api.php')){?>
          <li <?php if($currentFile=="api_urls.php"){?>class="active"<?php }?>> 
            <a href="api_urls.php">
              <div class="icon"> <i class="fa fa-exchange" aria-hidden="true"></i> </div>
              <div class="title">API URLS</div>
            </a> 
          </li> 
          
          
          
          
        <?php }?>
                
            </ul>
        </div>
    </aside>  

    <div class="app-container">
        <nav class="navbar navbar-default" id="navbar">
            <div class="container-fluid">
                <div class="navbar-collapse collapse in">
                    <ul class="nav navbar-nav navbar-mobile">
                        <li>
                            <button type="button" class="sidebar-toggle"> <i class="fa fa-bars"></i> </button>
                        </li>
                        <li class="logo"> <a class="navbar-brand" href="#"><?php echo APP_NAME;?></a> </li>
                        <li>
                            <button type="button" class="navbar-toggle">
                                <?php if(PROFILE_IMG){?>               
                                    <img class="profile-img" src="images/<?php echo PROFILE_IMG;?>">
                                <?php }else{?>
                                    <img class="profile-img" src="assets/images/profile.png">
                                <?php }?>
                            </button>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-left">
                        <Style>
                            titel, .titel {
                            font-size: 25px;
                            text-align: center;
                            color: #1782de;
                            font-weight: 600;
                                
                            }
                        </Style>
                        <titel><?php echo APP_NAME;?></titel>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown profile"> 
                            <a href="profile.php" class="dropdown-toggle" data-toggle="dropdown"> 
                                <?php if(PROFILE_IMG){?>               
                                    <img class="profile-img" src="images/<?php echo PROFILE_IMG;?>">
                                <?php }else{?>
                                    <img class="profile-img" src="assets/images/profile2.png">
                                <?php }?>
                                <div class="title">Profile</div>
                            </a>
                            <div class="dropdown-menu">
                                <ul class="action">
                                    <li><a href="profile.php">Profile</a></li>                  
                                    <li><a href="logout.php">Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>