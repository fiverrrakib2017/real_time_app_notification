<?php
    /**
    * Company : Nemosofts
    * Detailed : Software Development Company in Sri Lanka
    * Developer : Thivakaran
    * Contact : thivakaran829@gmail.com
    * Contact : nemosofts@gmail.com
    * Website : https://nemosofts.com
    */
    
    $page_title=(isset($_GET['post_id'])) ? 'Edit post' : 'Add post';
    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");
    require_once("thumbnail_images.class.php");
    date_default_timezone_set("Asia/Colombo");
    
    $cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
    $cat_result=mysqli_query($mysqli,$cat_qry); 
    
    $scat_qry="SELECT * FROM tbl_sub_category ORDER BY sub_category_name";
    $scat_result=mysqli_query($mysqli,$scat_qry);

    $lan_qry="SELECT * FROM tbl_city ORDER BY city_name";
    $lan_result=mysqli_query($mysqli,$lan_qry); 
    
    if(isset($_POST['submit']) and isset($_GET['add'])){
        if($_FILES['image1']['name']!=""){
            $image1=rand(0,99999)."_".$_FILES['image1']['name'];
            $tpath1='images/'.$image1; 			 
            $pic1=compress_image($_FILES["image1"]["tmp_name"], $tpath1, 80);
        }else{
            $image1 = "";
        }
        
        if($_FILES['image2']['name']!=""){
            $image2=rand(0,99999)."_".$_FILES['image2']['name'];
            $tpath2='images/'.$image2; 			 
            $pic2=compress_image($_FILES["image2"]["tmp_name"], $tpath2, 80);
        }else{
            $image2 = "";
        }
        
        if($_FILES['image3']['name']!=""){
            $image3=rand(0,99999)."_".$_FILES['image3']['name'];
            $tpath3='images/'.$image3; 			 
            $pic3=compress_image($_FILES["image3"]["tmp_name"], $tpath3, 80);
        }else{
            $image3 = "";
        }
        
        if($_FILES['image4']['name']!=""){
            $image4=rand(0,99999)."_".$_FILES['image4']['name'];
            $tpath4='images/'.$image4; 			 
            $pic4=compress_image($_FILES["image4"]["tmp_name"], $tpath4, 80);
        }else{
            $image4 = "";
        }
        
        if($_FILES['image5']['name']!=""){
            $image5=rand(0,99999)."_".$_FILES['image5']['name'];
            $tpath5='images/'.$image5; 			 
            $pic5=compress_image($_FILES["image5"]["tmp_name"], $tpath5, 80);
        }else{
            $image5 = "";
        }
        
        $data = array( 
            'title'  =>  $_POST['title'],
            'description'  =>  addslashes($_POST['description']),
            'money'  =>  $_POST['money'],
            'phone_1'  =>  $_POST['phone_1'],
            'phone_2'  =>  $_POST['phone_2'],
            'image_1'  =>  $image1,
            'image_2'  =>  $image2,
            'image_3'  =>  $image3,
            'image_4'  =>  $image4,
            'image_5'  =>  $image5,
            'con'  =>  $_POST['con'],
            'cat_id'  =>  $_POST['cat_id'],
            'cit_id'  =>  $_POST['cit_id'],
            'scat_id'  =>  $_POST['scat_id'],
            'user_id'  =>  '1',
            'date_time'  =>  strtotime(date('d-m-Y h:i:s A')),
        );		
        
        $qry = Insert('tbl_post',$data);	
        
        $_SESSION['msg']="11";
        $_SESSION['class']='success'; 
        header( "Location:add_post.php?add=yes");
        exit;	
    }
    
    if(isset($_GET['post_id'])){
        $qry="SELECT * FROM tbl_post where id='".$_GET['post_id']."'";
        $result=mysqli_query($mysqli,$qry);
        $row=mysqli_fetch_assoc($result);
    }
    
    if(isset($_POST['submit']) and isset($_POST['post_id'])){
        if($_FILES['image1']['name']!=""){
            $image1=rand(0,99999)."_".$_FILES['image1']['name'];
            $tpath1='images/'.$image1; 			 
            $pic1=compress_image($_FILES["image1"]["tmp_name"], $tpath1, 80);
        }else{
            $image1 = $_POST['text_thumbnail_1'];
        }
        
        if($_FILES['image2']['name']!=""){
            $image2=rand(0,99999)."_".$_FILES['image2']['name'];
            $tpath2='images/'.$image2; 			 
            $pic2=compress_image($_FILES["image2"]["tmp_name"], $tpath2, 80);
        }else{
            $image2 = $_POST['text_thumbnail_2'];
        }
        
        if($_FILES['image3']['name']!=""){
            $image3=rand(0,99999)."_".$_FILES['image3']['name'];
            $tpath3='images/'.$image3; 			 
            $pic3=compress_image($_FILES["image3"]["tmp_name"], $tpath3, 80);
        }else{
            $image3 = $_POST['text_thumbnail_3'];
        }
        
        if($_FILES['image4']['name']!=""){
            $image4=rand(0,99999)."_".$_FILES['image4']['name'];
            $tpath4='images/'.$image4; 			 
            $pic4=compress_image($_FILES["image4"]["tmp_name"], $tpath4, 80);
        }else{
            $image4 = $_POST['text_thumbnail_4'];
        }
        
        if($_FILES['image5']['name']!=""){
            $image5=rand(0,99999)."_".$_FILES['image5']['name'];
            $tpath5='images/'.$image5; 			 
            $pic5=compress_image($_FILES["image5"]["tmp_name"], $tpath5, 80);
        }else{
            $image5 = $_POST['text_thumbnail_5'];
        }
        
        $data = array( 
            'title'  =>  $_POST['title'],
            'description'  =>  addslashes($_POST['description']),
            'money'  =>  $_POST['money'],
            'phone_1'  =>  $_POST['phone_1'],
            'phone_2'  =>  $_POST['phone_2'],
            'image_1'  =>  $image1,
            'image_2'  =>  $image2,
            'image_3'  =>  $image3,
            'image_4'  =>  $image4,
            'image_5'  =>  $image5,
            'con'  =>  $_POST['con'],
            'cat_id'  =>  $_POST['cat_id'],
            'cit_id'  =>  $_POST['cit_id'],
            'scat_id'  =>  $_POST['scat_id'],
        );	
        
        $artist_edit=Update('tbl_post', $data, "WHERE id = '".$_POST['post_id']."'");
        
        $_SESSION['msg']="11"; 
        $_SESSION['class']='success'; 
        header( "Location:add_post.php?post_id=".$_POST['post_id']);
        exit;
    }
?>

<div class="row">
    <?php
        if(isset($_GET['redirect'])){
            echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
        } else{
            echo '<a href="manage_post.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
                <input  type="hidden" name="post_id" value="<?php echo $_GET['post_id'];?>" />
                <div class="section">
                    <div class="section-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Category</label>
                        <div class="col-md-6">
                            <select name="cat_id" name="cat_id" id="cat_id" class="select2">
                                <option value="">--Select Category--</option>
                                <?php
                                while($cat_row=mysqli_fetch_array($cat_result))
                                {
                                ?>          						 
                                <option value="<?php echo $cat_row['cid'];?>" <?php if($cat_row['cid']==$row['cat_id']){?>selected<?php }?>><?php echo $cat_row['category_name'];?></option>	          							 
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-md-3 control-label">Sub Category</label>
                        <div class="col-md-6">
                            <select name="scat_id" id="scat_id" class="select2">
                                <option value="">--Select Sub Category--</option>
                                <?php
                                while($scat_row=mysqli_fetch_array($scat_result))
                                {
                                ?>          						 
                                <option value="<?php echo $scat_row['sid'];?>" <?php if($scat_row['sid']==$row['scat_id']){?>selected<?php }?>><?php echo $scat_row['sub_category_name'];?></option>	          							 
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Districts</label>
                        <div class="col-md-6">
                            <select name="cit_id" id="cit_id" class="select2">
                                <option value="">--Select Districts--</option>
                                <?php
                                while($lan_row=mysqli_fetch_array($lan_result))
                                {
                                ?>          						 
                                    <option value="<?php echo $lan_row['aid'];?>" <?php if($lan_row['aid']==$row['cit_id']){?>selected<?php }?>><?php echo $lan_row['city_name'];?></option>	          							 
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Title</label>
                        <div class="col-md-6">
                            <input type="text" name="title" id="title" value="<?php if(isset($_GET['post_id'])){echo $row['title'];}?>" class="form-control" required>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-md-3 control-label">Description</label>
                        <div class="col-md-6">
                            <textarea name="description" id="description" class="form-control"><?php echo stripslashes($row['description']);?></textarea>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-md-3 control-label">money</label>
                        <div class="col-md-6">
                            <input type="text" name="money" id="money" value="<?php if(isset($_GET['post_id'])){echo $row['money'];}?>" class="form-control" required>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-md-3 control-label">phone 1</label>
                        <div class="col-md-6">
                            <input type="text" name="phone_1" id="phone_1" value="<?php if(isset($_GET['post_id'])){echo $row['phone_1'];}?>" class="form-control" required>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-md-3 control-label">phone 2</label>
                        <div class="col-md-6">
                            <input type="text" name="phone_2" id="phone_2" value="<?php if(isset($_GET['post_id'])){echo $row['phone_2'];}?>" class="form-control" required>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-md-3 control-label">Condition</label>
                        <div class="col-md-6">                       
                            <select name="con" id="con" style="width:280px; height:25px;" class="select2" required>
                                <option value="Use" <?php if($row['con']=='Use'){?>selected<?php }?>>Use</option>
                                <option value="New" <?php if($row['con']=='New'){?>selected<?php }?>>New</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Select Image 1:-</label>
                        <div class="col-md-6">
                            <div class="fileupload_block">
                                <input type="file" name="image1" accept=".png, .jpg, .JPG .PNG" onchange="fileValidation()" id="fileupload">
                                <?php if(isset($_GET['post_id']) and $row['image_1']!="") {?>
                                    <div class="block_wallpaper"><img src="images/<?php echo $row['image_1'];?>" alt="image" /></div>
                                    <input type="hidden" name="text_thumbnail_1" id="text_thumbnail_1" value="<?php echo $row['image_1'];?>">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Select Image 2:-</label>
                        <div class="col-md-6">
                            <div class="fileupload_block">
                                <input type="file" name="image2" accept=".png, .jpg, .JPG .PNG" onchange="fileValidation()" id="fileupload">
                                <?php if(isset($_GET['post_id']) and $row['image_2']!="") {?>
                                    <div class="block_wallpaper"><img src="images/<?php echo $row['image_2'];?>" alt="image" /></div>
                                    <input type="hidden" name="text_thumbnail_2" id="text_thumbnail_2" value="<?php echo $row['image_2'];?>">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Select Image 3:-</label>
                        <div class="col-md-6">
                            <div class="fileupload_block">
                                <input type="file" name="image3" accept=".png, .jpg, .JPG .PNG" onchange="fileValidation()" id="fileupload">
                                <?php if(isset($_GET['post_id']) and $row['image_3']!="") {?>
                                    <div class="block_wallpaper"><img src="images/<?php echo $row['image_3'];?>" alt="image" /></div>
                                    <input type="hidden" name="text_thumbnail_3" id="text_thumbnail_3" value="<?php echo $row['image_3'];?>">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Select Image 4:-</label>
                        <div class="col-md-6">
                            <div class="fileupload_block">
                                <input type="file" name="image4" accept=".png, .jpg, .JPG .PNG" onchange="fileValidation()" id="fileupload">
                                <?php if(isset($_GET['post_id']) and $row['image_4']!="") {?>
                                    <div class="block_wallpaper"><img src="images/<?php echo $row['image_4'];?>" alt="image" /></div>
                                    <input type="hidden" name="text_thumbnail_4" id="text_thumbnail_4" value="<?php echo $row['image_4'];?>">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Select Image 5:-</label>
                        <div class="col-md-6">
                            <div class="fileupload_block">
                                <input type="file" name="image5" accept=".png, .jpg, .JPG .PNG" onchange="fileValidation()" id="fileupload">
                                <?php if(isset($_GET['post_id']) and $row['image_5']!="") {?>
                                    <div class="block_wallpaper"><img src="images/<?php echo $row['image_5'];?>" alt="image" /></div>
                                    <input type="hidden" name="text_thumbnail_5" id="text_thumbnail_5" value="<?php echo $row['image_5'];?>">
                                <?php } ?>
                            </div>
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