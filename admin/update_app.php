<?php 
    /**
    * Company : Nemosofts
    * Detailed : Software Development Company in Sri Lanka
    * Developer : Thivakaran
    * Contact : info.nemosofts@gmail.com
    * Website : https://nemosofts.com
    */
    $page_title="Update";
    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");

    $page_title="Apps Update";

    $qry="SELECT * FROM tbl_update where id='1'";
    $result=mysqli_query($mysqli,$qry);
    $settings_row=mysqli_fetch_assoc($result);

    if(isset($_POST['verify_package_name'])){

        $data = array(
            'version' => trim($_POST['version']),
            'version_name' => trim($_POST['version_name']),
            'description' => trim($_POST['description']),
            'url' => trim($_POST['url']),
        );
        
        $settings_edit=Update('tbl_update', $data, "WHERE id = '1'");
        
        $_SESSION['class']="success";
        $_SESSION['msg']="11";
        header( "Location:update_app.php");
        exit;
    }
?>

<style type="text/css">
  .field_lable {
    margin-bottom: 10px;
    margin-top: 10px;
    color: #666;
    padding-left: 15px;
    font-size: 14px;
    line-height: 24px;
  }
</style>
 
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="page_title_block">
         <div class="page_title"><?=$page_title?></div>
      </div>
      <div class="clearfix"></div>
      <div class="card-body mrg_bottom" >
       <div class="tab-content">
          <!-- android app verify -->
          <div role="tabpanel" class="tab-pane active" id="android_verify">   
             <form action="" name="verify_package_name" method="post" class="form form-horizontal" enctype="multipart/form-data" id="api_form">
                <div class="section">
                    <div class="section-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">New App Version Code</label>
                            <div class="col-md-6">
                                <input type="text" name="version" id="version" value="<?php echo $settings_row['version'];?>" class="form-control">
                            </div>
                        </div>  
                         <div class="form-group">
                            <label class="col-md-3 control-label">New App Version Name</label>
                            <div class="col-md-6">
                                <input type="text" name="version_name" id="version_name" value="<?php echo $settings_row['version_name'];?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Description</label>
                            <div class="col-md-6">
                                <input type="text" name="description" id="description" value="<?php echo $settings_row['description'];?>" class="form-control">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-md-3 control-label">App Link</label>
                            <div class="col-md-6">
                                <input type="text" name="url" id="url" value="<?php echo $settings_row['url'];?>" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <button type="submit" name="verify_package_name" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
          </div>
        </div>   
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php");?>