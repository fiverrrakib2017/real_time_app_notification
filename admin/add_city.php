<?php
    /**
     * Company : Nemosofts
     * Detailed : Software Development Company in Sri Lanka
     * Developer : Thivakaran
     * Contact : thivakaran829@gmail.com
     * Contact : nemosofts@gmail.com
     * Website : https://nemosofts.com
     */
    $page_title=(isset($_GET['city_id'])) ? 'Edit City' : 'Add City';
    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");
    require_once("thumbnail_images.class.php");
    
    if(isset($_POST['submit']) and isset($_GET['add'])){
        $data = array( 
            'city_name'  =>  $_POST['city_name'],
        );		
        
        $qry = Insert('tbl_city',$data);	
        $lan_id=mysqli_insert_id($mysqli);	
        
        $_SESSION['msg']="10";
        $_SESSION['class']='success'; 
        header( "Location:manage_city.php");
        exit;	
    }
    
    if(isset($_GET['city_id'])){
        $qry="SELECT * FROM tbl_city where aid='".$_GET['city_id']."'";
        $result=mysqli_query($mysqli,$qry);
        $row=mysqli_fetch_assoc($result);
    }
    
    if(isset($_POST['submit']) and isset($_POST['city_id'])){
        $data = array(
            'city_name'  =>  $_POST['city_name']
        );	
        $category_edit=Update('tbl_city', $data, "WHERE aid = '".$_POST['city_id']."'");
        
        $_SESSION['msg']="11";
        $_SESSION['class']='success'; 
        header( "Location:add_city.php?city_id=".$_POST['city_id']);
        exit;
    }

?>
<div class="row">
    <?php
        if(isset($_GET['redirect'])){
            echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
        } else{
            echo '<a href="manage_language.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
        }
    ?>
    <div class="col-md-12">
        <div class="card">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title"><?=$page_title?></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="card-body mrg_bottom"> 
                <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <input  type="hidden" name="city_id" value="<?php echo $_GET['city_id'];?>" />
                    <div class="section">
                        <div class="section-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">City Name</label>
                                <div class="col-md-6">
                                    <input type="text" name="city_name" id="city_name" value="<?php if(isset($_GET['city_id'])){echo $row['city_name'];}?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include("includes/footer.php");?>