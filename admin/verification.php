<?php 
    /**
    * Company : Nemosofts
    * Detailed : Software Development Company in Sri Lanka
    * Developer : Thivakaran
    * Contact : info.nemosofts@gmail.com
    * Website : https://nemosofts.com
    */
    $page_title="Envato Verify Purchase";
    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");
    require("includes/generate.php");

    $qry="SELECT * FROM tbl_settings where id='1'";
    $result=mysqli_query($mysqli,$qry);
    $settings_row=mysqli_fetch_assoc($result);
    
    if(isset($_POST['verify_package_name'])){

         $key = generateStrongPassword();
         $envato_buyer= verify_envato_purchase_code(trim($_POST['envato_purchase_code']));

        if($_POST['envato_buyer_name']!='' AND $envato_buyer->buyer==$_POST['envato_buyer_name'] AND $envato_buyer->item->id==$Item_ID){
            
            $key2 = $key;
            
            $data = array(
                'envato_buyer_name' => trim($_POST['envato_buyer_name']),
                'envato_purchase_code' => trim($_POST['envato_purchase_code']),
                'envato_purchased_status' => 1,
                'app_api_key' => $key2,
                'package_name' => trim($_POST['package_name'])
            );

            $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

            $config_file_path= $config_file_name;
            $config_file = file_get_contents($config_file_default);
            $f = @fopen($config_file_path, "w+");
            if(@fwrite($f, $config_file) > 0){
            }
            
            $admin_url = getBaseUrl();
            $type = 'android';
            
            verify_data_on_server($type,$envato_buyer->item->id,$envato_buyer->buyer,trim($_POST['envato_purchase_code']),$key2,$envato_buyer->license,$admin_url,trim($_POST['package_name']));
            
            $_SESSION['class']="success";
            $_SESSION['msg']="19";
            header( "Location:verification.php");
            exit;
        }
        else{
        
            $data = array(
                'envato_buyer_name' => trim($_POST['envato_buyer_name']),
                'envato_purchase_code' => trim($_POST['envato_purchase_code']),
                'envato_purchased_status' => 0,
                'app_api_key' => '',
                'package_name' => trim($_POST['package_name'])
            );

            $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

            $_SESSION['class']="error";
            $_SESSION['msg']="18";
            header( "Location:verification.php");
            exit;
        }
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
          <div class="page_title"><?=$page_title ?></div>
      </div>
      <div class="clearfix"></div>
      <div class="row mrg-top">
      <div class="card-body mrg_bottom" >
       <div class="tab-content">
          <!-- android app verify -->
          <div role="tabpanel" class="tab-pane active" id="android_verify">   
             <form action="" name="verify_package_name" method="post" class="form form-horizontal" enctype="multipart/form-data" id="api_form">
                <div class="section">
                    <div class="section-body">
                        <div class="form-group">
                          <label class="col-md-4 control-label">Envato Username :-
                          </label>
                          <div class="col-md-6">
                            <input type="text" name="envato_buyer_name" value="<?php echo $settings_row['envato_buyer_name'];?>" class="form-control" placeholder="nemosofts">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-4 control-label">Envato Purchase Code :-

                            <p class="control-label-help">(<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">Where Is My Purchase Code?</a>)</p>
                          </label>
                          <div class="col-md-6">
                            <input type="text" name="envato_purchase_code" value="<?php echo $settings_row['envato_purchase_code'];?>" class="form-control" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-4 control-label">ApiKey :-</label>
                          <div class="col-md-6">
                            <input type="text" name="app_api_key" value="<?php echo $settings_row['app_api_key'];?>" class="form-control" placeholder="Click the Save button. You will see the api key">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 control-label">Android Package Name :-
                            <p class="control-label-help">(More info in Android Doc)</p>
                          </label>
                          <div class="col-md-6">
                            <input type="text" name="package_name" id="package_name" value="<?php echo $settings_row['package_name'];?>" class="form-control" placeholder="com.example.myapp">
                          </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-9 col-md-offset-4">
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