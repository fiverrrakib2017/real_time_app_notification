<?php 
    /**
    * Company : Nemosofts
    * Detailed : Software Development Company in Sri Lanka
    * Developer : Thivakaran
    * Contact : info.nemosofts@gmail.com
    * Website : https://nemosofts.com
    */
    
    $page_title=(isset($_GET['cat_id'])) ? 'Edit Sub Category' : 'Add Sub Category';
    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");
    require_once("thumbnail_images.class.php");
    
    $cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
    $cat_result=mysqli_query($mysqli,$cat_qry); 
    
    if(isset($_POST['submit']) and isset($_GET['add'])){
        
        $category_image=rand(0,99999)."_".$_FILES['sub_category_image']['name'];
	    $tpath1='images/'.$category_image; 		
	    $pic1=move_uploaded_file($_FILES["sub_category_image"]["tmp_name"],$tpath1);
        
        $data = array( 
            'sub_cat_id'  =>  $_POST['sub_cat_id'],
            'sub_category_name'  =>  $_POST['sub_category_name'],
            'sub_category_image'  =>  $category_image
        );		
        
        $qry = Insert('tbl_sub_category',$data);	
        $cat_id=mysqli_insert_id($mysqli);	
        
        $_SESSION['msg']="10";
        $_SESSION['class']='success';
        header( "Location:manage_sub_category.php");
        exit;	
    }
    
    if(isset($_GET['cat_id'])){
        $qry="SELECT * FROM tbl_sub_category where sid='".$_GET['cat_id']."'";
        $result=mysqli_query($mysqli,$qry);
        $row=mysqli_fetch_assoc($result);
    }
    
    if(isset($_POST['submit']) and isset($_POST['cat_id'])){
    
        if($_FILES['sub_category_image']['name']!=""){		
        
            $img_res=mysqli_query($mysqli,'SELECT * FROM tbl_sub_category WHERE sid='.$_GET['cat_id'].'');
            $img_res_row=mysqli_fetch_assoc($img_res);
            
            if($img_res_row['sub_sub_category_image']!=""){
                unlink('images/'.$img_res_row['sub_sub_category_image']);
            }
            
            $category_image=rand(0,99999)."_".$_FILES['sub_category_image']['name'];
    	    $tpath1='images/'.$category_image; 		
    	    $pic1=move_uploaded_file($_FILES["sub_category_image"]["tmp_name"],$tpath1);
	    
            $data = array(
                'sub_cat_id'  =>  $_POST['sub_cat_id'],
                'sub_category_name'  =>  $_POST['sub_category_name'],
                'sub_category_image'  =>  $category_image
            );
            
            $category_edit=Update('tbl_sub_category', $data, "WHERE sid = '".$_POST['cat_id']."'");
        }else{
            $data = array(
                'sub_cat_id'  =>  $_POST['sub_cat_id'],
                'sub_category_name'  =>  $_POST['sub_category_name']
            );	
            
            $category_edit=Update('tbl_sub_category', $data, "WHERE sid = '".$_POST['cat_id']."'");
        }
        
        $_SESSION['msg']="11";
        $_SESSION['class']='success';
        header( "Location:add_sub_category.php?cat_id=".$_POST['cat_id']);
        exit;
    
    }

?>
<div class="row">
    <?php
        if(isset($_GET['redirect'])){
            echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
        }
        else{
            echo '<a href="manage_category.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
                    <input  type="hidden" name="cat_id" value="<?php echo $_GET['cat_id'];?>" />
                    <div class="section">
                        <div class="section-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Category</label>
                                <div class="col-md-6">
                                    <select name="sub_cat_id" id="sub_cat_id" class="select2">
                                        <option value="">--Select Category--</option>
                                        <?php
                                        while($cat_row=mysqli_fetch_array($cat_result))
                                        {
                                        ?>          						 
                                        <option value="<?php echo $cat_row['cid'];?>" <?php if($cat_row['cid']==$row['sub_cat_id']){?>selected<?php }?>><?php echo $cat_row['category_name'];?></option>	          							 
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="form-group">
                                <label class="col-md-3 control-label">Sub Category Name</label>
                                <div class="col-md-6">
                                    <input type="text" name="sub_category_name" id="sub_category_name" value="<?php if(isset($_GET['cat_id'])){echo $row['sub_category_name'];}?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Select Image :-</label>
                                <div class="col-md-6">
                                    <div class="fileupload_block">
                                        <input type="file" name="sub_category_image" value="fileupload" accept=".png, .jpg, .JPG .PNG" onchange="fileValidation()" id="fileupload">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-6">
                                    <?php if(isset($_GET['cat_id']) and $row['sub_category_image']!="") {?>
                                    <div class="fileupload_block">
                                        <div class="fileupload_img"><img type="image" src="images/<?php echo $row['sub_category_image'];?>" alt="category image" /></div>
                                    </div>
                                    <?php } else {?>
                                    <?php }?>
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