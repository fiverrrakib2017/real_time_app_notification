<?php 
    /**
    * Company : Nemosofts
    * Detailed : Software Development Company in Sri Lanka
    * Developer : Thivakaran
    * Contact : thivakaran829@gmail.com
    * Contact : nemosofts@gmail.com
    * Website : https://nemosofts.com
    */
    $page_title=(isset($_GET['banner_id'])) ? 'Edit Promos' : 'Add Promos';
    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");
    require_once("thumbnail_images.class.php");
    
    $mp3_qry="SELECT * FROM tbl_post WHERE tbl_post.active='1' ORDER BY tbl_post.id DESC"; 
    $mp3_result=mysqli_query($mysqli,$mp3_qry); 

	if(isset($_POST['submit']) and isset($_GET['add'])){
	
        $banner_image=rand(0,99999)."_".$_FILES['banner_image']['name'];
        
        //Main Image
        $tpath1='images/'.$banner_image; 			 
        $pic1=compress_image($_FILES["banner_image"]["tmp_name"], $tpath1, 80);
        
        $data = array( 
            'banner_title'  =>  $_POST['banner_title'],
            'banner_sort_info'  =>  $_POST['banner_sort_info'],
            'banner_image'  =>  $banner_image,
            'banner_songs'  =>  implode(',',$_POST['banner_songs']),
            'date_time'  =>  strtotime(date('d-m-Y h:i:s A'))
        );		
        
        $qry = Insert('tbl_banner',$data);	
        
        $_SESSION['msg']="10";
        $_SESSION['class']='success'; 
        header( "Location:manage_banners.php");
        exit;			 
	}
	
	if(isset($_GET['banner_id'])){
		$qry="SELECT * FROM tbl_banner where bid='".$_GET['banner_id']."'";
		$result=mysqli_query($mysqli,$qry);
		$row=mysqli_fetch_assoc($result);
	}
	
	if(isset($_POST['submit']) and isset($_POST['banner_id'])){
		if($_FILES['banner_image']['name']!=""){		
            $img_res=mysqli_query($mysqli,'SELECT * FROM tbl_banner WHERE bid='.$_GET['banner_id'].'');
            $img_res_row=mysqli_fetch_assoc($img_res);
            
            if($img_res_row['banner_image']!=""){
                unlink('images/'.$img_res_row['banner_image']);
            }
            
            $banner_image=rand(0,99999)."_".$_FILES['banner_image']['name'];
            
            //Main Image
            $tpath1='images/'.$banner_image; 			 
            $pic1=compress_image($_FILES["banner_image"]["tmp_name"], $tpath1, 80);
            
            $data = array(
                'banner_title'  =>  $_POST['banner_title'],
                'banner_sort_info'  =>  $_POST['banner_sort_info'],
                'banner_image'  =>  $banner_image,
                'banner_songs'  =>  implode(',',$_POST['banner_songs'])
            );
            
            $category_edit=Update('tbl_banner', $data, "WHERE bid = '".$_POST['banner_id']."'");

        }else{
            
            $data = array(
                'banner_title'  =>  $_POST['banner_title'],
                'banner_sort_info'  =>  $_POST['banner_sort_info'],
                'banner_songs'  =>  implode(',',$_POST['banner_songs'])
            );	
            
            $artist_edit=Update('tbl_banner', $data, "WHERE bid = '".$_POST['banner_id']."'");
        }
 
		$_SESSION['msg']="11";
        $_SESSION['class']='success'; 
		header( "Location:add_banner.php?banner_id=".$_POST['banner_id']);
		exit;
	}
?>
<div class="row">
        <?php
        if(isset($_GET['redirect'])){
            echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
        } else{
            echo '<a href="manage_banners.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
            	<input  type="hidden" name="banner_id" value="<?php echo $_GET['banner_id'];?>" />

              <div class="section">
                <div class="section-body">
               
                  <div class="form-group">
                    <label class="col-md-3 control-label">Title</label>
                    <div class="col-md-6">
                      <input type="text" name="banner_title" id="banner_title" value="<?php if(isset($_GET['banner_id'])){echo $row['banner_title'];}?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Sort Info</label>
                    <div class="col-md-6">
                      <input type="text" name="banner_sort_info" id="banner_sort_info" value="<?php if(isset($_GET['banner_id'])){echo $row['banner_sort_info'];}?>" class="form-control" required>
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label class="col-md-3 control-label">Post</label>
                    <div class="col-md-6">
                      <select name="banner_songs[]" id="banner_songs" class="select2 form-control" required multiple="multiple">
                        <?php
                            while($mp3_row=mysqli_fetch_array($mp3_result))
                            {
                        ?>   
                        <?php if(isset($_GET['banner_id'])){?>

                           <option value="<?php echo $mp3_row['id'];?>" <?php $songs_list=explode(",", $row['banner_songs']);
                  foreach($songs_list as $song_id)
                {if($mp3_row['id']==$song_id){?>selected<?php }}?>><?php echo $mp3_row['title'];?></option>
                            
                          </option>   

                        <?php }else{?>  

                          <option value="<?php echo $mp3_row['id'];?>"><?php echo $mp3_row['title'];?></option>
                            
                        <?php }?>   
                         
                        <?php
                          }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label">Image</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                          <input type="file" name="banner_image" accept=".png, .jpg, .JPG .PNG" onchange="fileValidation()" id="fileupload">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">&nbsp; </label>
                    <div class="col-md-6">
                      <?php if(isset($_GET['banner_id']) and $row['banner_image']!="") {?>
                            <div class="block_wallpaper"><img src="images/<?php echo $row['banner_image'];?>" alt="image" /></div>
                          <?php } ?>
                    </div>
                  </div><br>
                 
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
