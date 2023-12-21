<?php 
    /**
    * Company : Nemosofts
    * Detailed : Software Development Company in Sri Lanka
    * Developer : Thivakaran
    * Contact : thivakaran829@gmail.com
    * Contact : nemosofts@gmail.com
    * Website : https://nemosofts.com
    */
    $page_title="Settings";
    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");
	
    $qry="SELECT * FROM tbl_settings where id='1'";
    $result=mysqli_query($mysqli,$qry);
    $settings_row=mysqli_fetch_assoc($result);
    
    
    $qry2="SELECT * FROM payment_settings where id='1'";
    $result2=mysqli_query($mysqli,$qry2);
    $settings_row2=mysqli_fetch_assoc($result2);
  
    $_SESSION['class']="success";
    

  if(isset($_POST['submit'])){

    $img_res=mysqli_query($mysqli,"SELECT * FROM tbl_settings WHERE id='1'");
    $img_row=mysqli_fetch_assoc($img_res);
    
    if($_FILES['app_logo']['name']!=""){        
        unlink('images/'.$img_row['app_logo']);   
        
        $app_logo=$_FILES['app_logo']['name'];
        $pic1=$_FILES['app_logo']['tmp_name'];
        
        $tpath1='images/'.$app_logo;      
        copy($pic1,$tpath1);
        
        $data = array(      
            'app_name'  =>  $_POST['app_name'],
            'status'  =>  $_POST['status'],
            'app_logo'  =>  $app_logo                                
        );
    }else{
        $data = array(
        'app_name'  =>  $_POST['app_name'],
        'status'  =>  $_POST['status']
        );
    } 

    $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");
    
    if ($settings_edit > 0){
        $_SESSION['msg']="11";
        header( "Location:settings.php");
        exit;
    }   
  }
  
   if(isset($_POST['admob_submit'])){
        
         $data = array(
            'publisher_id'  =>  $_POST['publisher_id'],
            'interstital_ad'  => ($_POST['interstital_ad']) ? 'true' : 'false',
            'interstital_ad_id'  =>  $_POST['interstital_ad_id'],
            'interstital_ad_click'  =>  $_POST['interstital_ad_click'],
            'banner_ad'  =>  ($_POST['banner_ad']) ? 'true' : 'false',
            'banner_ad_id'  =>  $_POST['banner_ad_id'],
            'facebook_interstital_ad'  =>  ($_POST['facebook_interstital_ad']) ? 'true' : 'false',
            'facebook_interstital_ad_id'  =>  $_POST['facebook_interstital_ad_id'],
            'facebook_interstital_ad_click'  =>  $_POST['facebook_interstital_ad_click'],
            'facebook_banner_ad'  =>  ($_POST['facebook_banner_ad']) ? 'true' : 'false',
            'facebook_banner_ad_id'  =>  $_POST['facebook_banner_ad_id'],
            'facebook_native_ad'  =>  ($_POST['facebook_native_ad']) ? 'true' : 'false',
            'facebook_native_ad_id'  =>  $_POST['facebook_native_ad_id'],
            'facebook_native_ad_click'  =>  $_POST['facebook_native_ad_click'],
            'admob_nathive_ad'  =>  ($_POST['admob_nathive_ad']) ? 'true' : 'false',
            'admob_native_ad_id'  =>  $_POST['admob_native_ad_id'],
            'admob_native_ad_click'  =>  $_POST['admob_native_ad_click'],
            'banner_size'  =>  $_POST['banner_size'],
            'banner_size_fb'  =>  $_POST['banner_size_fb']
                );
        
        $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");
        
        $_SESSION['msg']="11";
        header( "Location:settings.php");
        exit;
  }

    else if(isset($_POST['app_pri_poly'])){

      $data = array(
        'app_privacy_policy'  =>  addslashes($_POST['app_privacy_policy']) 
      );

      $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

      $_SESSION['msg']="11";
      header( "Location:settings.php");
      exit;

    }
  
    if(isset($_POST['about_submit'])){

        $data = array(
            'company'  =>  $_POST['company'], 
            'email'  =>  $_POST['email'], 
            'website'  =>  $_POST['website'], 
            'contact'  =>  $_POST['contact'] 
        );
        
        $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");
        
        $_SESSION['msg']="11";
        header( "Location:settings.php");
        exit;
    }
    
   if(isset($_POST['home_submit'])){
        
        $data = array(
            'home_page'  => $_POST['home_page'],
            'currency_code' => $_POST['currency_code'],
            'currency_position' => ($_POST['currency_position']) ? 'true' : 'false',
            'auto_post' => ($_POST['auto_post']) ? '1' : '0',
            'isRTL' => ($_POST['isRTL']) ? 'true' : 'false',
            'ad_promote' => ($_POST['ad_promote']) ? 'true' : 'false',
            'facebook_login' => ($_POST['facebook_login']) ? 'true' : 'false',
            'google_login' => ($_POST['google_login']) ? 'true' : 'false',
        );
        
        $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");
        
        $_SESSION['msg']="11";
        header( "Location:settings.php");
        exit;
    }
    
    if(isset($_POST['payment_submit'])){
        
        $data = array(
            'currency_code' => $_POST['currency_code2'],
            
            'paypal_payment_on_off' => ($_POST['paypal_payment_on_off']) ? '1' : '0',
            'paypal_mode' => $_POST['paypal_mode'],
            'paypal_client_id' => $_POST['paypal_client_id'],
            'paypal_secret' => $_POST['paypal_secret'],
            
            'stripe_payment_on_off' => ($_POST['stripe_payment_on_off']) ? '1' : '0',
            'stripe_secret_key' => $_POST['stripe_secret_key'],
            'stripe_publishable_key' => $_POST['stripe_publishable_key'],
            
            'razorpay_payment_on_off' => ($_POST['razorpay_payment_on_off']) ? '1' : '0',
            'razorpay_key' => $_POST['razorpay_key'],
            'razorpay_secret' => $_POST['razorpay_secret'],
            
            'paystack_payment_on_off' => ($_POST['paystack_payment_on_off']) ? '1' : '0',
            'paystack_secret_key' => $_POST['paystack_secret_key'],
            'paystack_public_key' => $_POST['paystack_public_key'],
        );
        
        $settings_edit=Update('payment_settings', $data, "WHERE id = '1'");
        
        $_SESSION['msg']="11";
        header( "Location:settings.php");
        exit;
    }
?>

<style type="text/css">
  /* The switch - the box around the slider */
  .switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
  }

  /* Hide default HTML checkbox */
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  /* The slider */
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 5px;
    bottom: 3px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked + .slider {
    background-color: #e91e63;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #e91e63;
  }

  input:checked + .slider:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
  
  input:checked + .slider {
    background-color: #4CAF50;
}
  
</style>

<Style>
.admob_title_my {
    /* background: #1782de; */
    border: 1px solid #1782df6e;
    background-color: #f8f9fa;
    text-align: center;
    padding: 15px 10px;
    width: 100%;
    color: #1782de;
    font-size: 20px;
    font-weight: 500;
    position: relative;
    margin-bottom: 40px;
}
.col-md-6.my {
    border-left: 1px solid #1782df6e;
}
.my {
    float: right;
}
</Style>

	 <div class="row">
      <div class="col-md-12">
        <div class="card">
		   <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                  <div class="page_title"><?= $page_title ?></div>
                </div>
            </div>

        <div class="clearfix"></div>
          <div class="card-body mrg_bottom" style="padding: 0px">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#app_settings" aria-controls="app_settings" role="tab" data-toggle="tab">Admin Settings</a></li>
                
                <li role="presentation"><a href="#about" aria-controls="about" role="tab" data-toggle="tab"> About</a></li>
                <li role="presentation"><a href="#api_privacy_policy" aria-controls="api_privacy_policy" role="tab" data-toggle="tab">Privacy Policy</a></li>
                <li role="presentation"><a href="#admob_settings" aria-controls="admob_settings" role="tab" data-toggle="tab">Ads Settings</a></li>
            </ul>
            <div class="tab-content" style="padding-right: 15px;padding-left: 15px;">
                
                <div role="tabpanel" class="tab-pane active" id="app_settings">	  
                    <form action="" name="settings_from" method="post" class="form form-horizontal" enctype="multipart/form-data">
                        <div class="section">
                            <div class="section-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Dark and Light Mode</label>
                                    <div class="col-md-6">                       
                                        <select name="status" id="status" style="width:280px; height:25px;" class="select2" required>
                                            <option value="1" <?php if($settings_row['status']=='1'){?>selected<?php }?>>Dark Mode</option>
                                            <option value="0" <?php if($settings_row['status']=='0'){?>selected<?php }?>>Light Mode</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Name</label>
                                    <div class="col-md-6">
                                        <input type="text" name="app_name" id="app_name" value="<?php echo $settings_row['app_name'];?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Logo</label>
                                    <div class="col-md-6">
                                        <div class="fileupload_block">
                                            <input type="file" name="app_logo" accept=".png, .jpg, .JPG .PNG" onchange="fileValidation()" id="fileupload">
                                            <?php if($settings_row['app_logo']!="") {?>
                                                <div class="fileupload_img"><img type="image" src="images/<?php echo $settings_row['app_logo'];?>" alt="image" /></div>
                                            <?php } else {?>
                                                <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="image" /></div>
                                            <?php }?>
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
                
                <div role="tabpanel" class="tab-pane" id="app_home">
                    <form action="" name="verify_package_name" method="post" class="form form-horizontal" enctype="multipart/form-data" id="api_form">
                        <div class="section">
                            <div class="section-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Home Pane</label>
                                    <div class="col-md-6">                       
                                        <select name="home_page" id="home_page" style="width:280px; height:25px;" class="select2" required>
                                            <option value="true" <?php if($settings_row['home_page']=='true'){?>selected<?php }?>>Home Pane design 1</option>
                                            <option value="false" <?php if($settings_row['home_page']=='false'){?>selected<?php }?>>Home Pane design 2</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Currency Code* <br><small id="emailHelp" class="form-text text-muted">If you don't know <a href="https://developer.paypal.com/docs/api/reference/currency-codes/" target="_blank">click here</a></small></label>
                                    <div class="col-md-6">
                                        <input type="text" name="currency_code" id="currency_code" value="<?php echo $settings_row['currency_code'];?>" class="form-control">
                                    </div>
                                    </br>
                                    </br>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Currency Code View End or Start<br><small id="emailHelp" class="form-text text-muted">Example 100$ or $100</a></small></label>
                                    <div class="col-md-6">
                                    <label class="switch">
                                        <input type="checkbox" id="currency_position" name="currency_position" value="true" class="cbx hidden" <?php if($settings_row['currency_position']=='true'){ echo 'checked'; }?>/>
                                        <span class="slider round"></span>
                                    </label>
                                    </br>
                                    </br>
                                    </br>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Promote</label>
                                    <div class="col-md-6">
                                    <label class="switch">
                                        <input type="checkbox" id="ad_promote" name="ad_promote" value="true" class="cbx hidden" <?php if($settings_row['ad_promote']=='true'){ echo 'checked'; }?>/>
                                        <span class="slider round"></span>
                                    </label>
                                    </br>
                                    </br>
                                    </br>
                                    </div>
                                </div>
                                


                                <div class="form-group">
                                    <label class="col-md-3 control-label">Auto Post Approval</label>
                                    <div class="col-md-6">
                                    <label class="switch">
                                        <input type="checkbox" id="auto_post" name="auto_post" value="1" class="cbx hidden" <?php if($settings_row['auto_post']=='1'){ echo 'checked'; }?>/>
                                        <span class="slider round"></span>
                                    </label>
                                    </br>
                                    </br>
                                    </br>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">RTL</label>
                                    <div class="col-md-6">
                                    <label class="switch">
                                        <input type="checkbox" id="isRTL" name="isRTL" value="true" class="cbx hidden" <?php if($settings_row['isRTL']=='true'){ echo 'checked'; }?>/>
                                        <span class="slider round"></span>
                                    </label>
                                    </br>
                                    </br>
                                    </br>
                                    </div>
                                </div>

                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Enable Facebook Login</label>
                                    <div class="col-md-6">
                                    <label class="switch">
                                        <input type="checkbox" id="facebook_login" name="facebook_login" value="true" class="cbx hidden" <?php if($settings_row['facebook_login']=='true'){ echo 'checked'; }?>/>
                                        <span class="slider round"></span>
                                    </label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Enable Google Login</label>
                                    <div class="col-md-6">
                                    <label class="switch">
                                        <input type="checkbox" id="google_login" name="google_login" value="true" class="cbx hidden" <?php if($settings_row['google_login']=='true'){ echo 'checked'; }?>/>
                                        <span class="slider round"></span>
                                    </label>
                                    </div>
                                </div>
                  
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" name="home_submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <Style>
                    .m-b-5 {
                        margin-bottom: 5px !important;
                    }
                </Style>
                
                 <div role="tabpanel" class="tab-pane" id="payment_settings">
                    <form action="" name="settings_payment" method="post" class="form form-horizontal" enctype="multipart/form-data" id="api_form">
                        <div class="section">
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label">Currency Code*<br/><small id="emailHelp" class="form-text text-muted">If you don't know <a href="https://developer.paypal.com/docs/api/reference/currency-codes/" target="_blank">click here</a></small></label>
                                <div class="col-md-6">
                                        <input type="text" name="currency_code2" id="currency_code2" value="<?php echo $settings_row2['currency_code'];?>" class="form-control">
                                </div>
                            </div>
                            </br>
                            
                            
                            
                           <h5 class="m-b-5"><i class="fa fa-cc-paypal"></i><b> Paypal Settings</b></h5>
                           <small id="emailHelp" class="form-text text-muted">For more info <a href="https://developer.paypal.com/docs/integration/admin/manage-apps/#create-or-edit-sandbox-and-live-apps" target="_blank">click here</a></small> 
                           <div class="form-group">
                                <label class="col-md-3 control-label">Paypal Payment</label>
                                <div class="col-sm-8">
                                    <label class="switch">
                                        <input type="checkbox" id="paypal_payment_on_off" name="paypal_payment_on_off" value="1" class="cbx hidden" <?php if($settings_row2['paypal_payment_on_off']=='1'){ echo 'checked'; }?>/>
                                        <span class="slider round"></span>
                                    </label>
                                    </br>
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="col-md-3 control-label">Payment Mode</label>
                                <div class="col-md-6">                       
                                    <select name="paypal_mode" id="paypal_mode" style="width:280px; height:25px;" class="select2" required>
                                        <option value="sandbox" <?php if($settings_row2['paypal_mode']=='sandbox'){?>selected<?php }?>>Sandbox</option>
                                        <option value="live" <?php if($settings_row2['paypal_mode']=='live'){?>selected<?php }?>>Live</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Paypal Client ID</label>
                                <div class="col-md-6">
                                    <input type="text" name="paypal_client_id" id="paypal_client_id" value="<?php echo $settings_row2['paypal_client_id'];?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Paypal Secret</label>
                                <div class="col-md-6">
                                    <input type="text" name="paypal_secret" id="paypal_secret" value="<?php echo $settings_row2['paypal_secret'];?>" class="form-control">
                                </div>
                            </div>
                            <br/>
                            
                            
                            
                            
                           <h5 class="m-b-5"><i class="fa fa-cc-stripe"></i> <b>Stripe Settings</b></h5>
                           <small id="emailHelp" class="form-text text-muted">For more info <a href="https://support.stripe.com/questions/locate-api-keys" target="_blank">click here</a></small>
                           <div class="form-group">
                                <label class="col-md-3 control-label"> Stripe Payment</label>
                                <div class="col-sm-8">
                                    <label class="switch">
                                        <input type="checkbox" id="stripe_payment_on_off" name="stripe_payment_on_off" value="1" class="cbx hidden" <?php if($settings_row2['stripe_payment_on_off']=='1'){ echo 'checked'; }?>/>
                                        <span class="slider round"></span>
                                    </label>
                                    </br>
                               </div>
                           </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Stripe Secret Key</label>
                                <div class="col-md-6">
                                    <input type="text" name="stripe_secret_key" id="stripe_secret_key" value="<?php echo $settings_row2['stripe_secret_key'];?>" class="form-control">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-3 control-label">Stripe Publishable key</label>
                                <div class="col-md-6">
                                    <input type="text" name="stripe_publishable_key" id="stripe_publishable_key" value="<?php echo $settings_row2['stripe_publishable_key'];?>" class="form-control">
                                </div>
                            </div>
                            <br/>
                            
                            
                            <h5 class="m-b-5"><i class="fa fa-rupee"></i> <b> Razorpay Settings</b></h5>
                             <small id="emailHelp" class="form-text text-muted">For more info <a href="https://razorpay.com/docs/payment-gateway/dashboard-guide/settings/#api-keys" target="_blank">click here</a></small>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Razorpay Payment</label>
                                <div class="col-sm-8">
                                    <label class="switch">
                                        <input type="checkbox" id="razorpay_payment_on_off" name="razorpay_payment_on_off" value="1" class="cbx hidden" <?php if($settings_row2['razorpay_payment_on_off']=='1'){ echo 'checked'; }?>/>
                                        <span class="slider round"></span>
                                    </label>
                                    </br>
                               </div>
                           </div>
                           <div class="form-group">
                                <label class="col-md-3 control-label">Razorpay Key Id</label>
                                <div class="col-md-6">
                                    <input type="text" name="razorpay_key" id="razorpay_key" value="<?php echo $settings_row2['razorpay_key'];?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Razorpay Key Secret</label>
                                <div class="col-md-6">
                                    <input type="text" name="razorpay_secret" id="razorpay_secret" value="<?php echo $settings_row2['razorpay_secret'];?>" class="form-control">
                                </div>
                            </div>
                            <br/>
                            
                            <h5 class="m-b-5">₦ <b>Paystack Settings</b></h5>
                             <small id="emailHelp" class="form-text text-muted">For more info <a href="https://support.paystack.com/hc/en-us/articles/360009881600-Paystack-Test-Keys-Live-Keys-and-Webhooks" target="_blank">click here</a></small>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Paystack Payment</label>
                                <div class="col-sm-8">
                                    <label class="switch">
                                        <input type="checkbox" id="paystack_payment_on_off" name="paystack_payment_on_off" value="1" class="cbx hidden" <?php if($settings_row2['paystack_payment_on_off']=='1'){ echo 'checked'; }?>/>
                                        <span class="slider round"></span>
                                    </label>
                                    </br>
                               </div>
                           </div>
                           <div class="form-group">
                                <label class="col-md-3 control-label">Paystack Secret Key</label>
                                <div class="col-md-6">
                                    <input type="text" name="paystack_secret_key" id="paystack_secret_key" value="<?php echo $settings_row2['paystack_secret_key'];?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Paystack Public Key</label>
                                <div class="col-md-6">
                                    <input type="text" name="paystack_public_key" id="paystack_public_key" value="<?php echo $settings_row2['paystack_public_key'];?>" class="form-control">
                                </div>
                            </div>
                             <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" name="payment_submit" class="btn btn-primary">Save</button>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
       
                
                <div role="tabpanel" class="tab-pane" id="about">
                    <form action="" name="settings_api" method="post" class="form form-horizontal" enctype="multipart/form-data" id="api_form">
                        <div class="section">
                            <div class="section-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Company</label>
                                    <div class="col-md-6">
                                        <input type="text" name="company" id="company" value="<?php echo $settings_row['company'];?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Email</label>
                                    <div class="col-md-6">
                                        <input type="text" name="email" id="email" value="<?php echo $settings_row['email'];?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Website</label>
                                    <div class="col-md-6">
                                        <input type="text" name="website" id="website" value="<?php echo $settings_row['website'];?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Contact</label>
                                    <div class="col-md-6">
                                        <input type="text" name="contact" id="contact" value="<?php echo $settings_row['contact'];?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" name="about_submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div role="tabpanel" class="tab-pane" id="api_privacy_policy">   
                    <form action="" name="api_privacy_policy" method="post" class="form form-horizontal" enctype="multipart/form-data">
                      <div class="section">
                        <div class="section-body">
                          <?php 
                            if(file_exists('privacy_policy.php'))
                            {
                          ?>
                            <div class="form-group">
                              <label class="col-md-3 control-label">App Privacy Policy URL</label>
                              <div class="col-md-9">
                                <input type="text"  class="form-control" value="<?=getBaseUrl().'privacy_policy.php'?>">
                              </div>
                            </div>
                          <?php } ?>
                          <div class="form-group">
                            <label class="col-md-3 control-label">App Privacy Policy</label>
                            <div class="col-md-9">
                              <textarea name="app_privacy_policy" id="privacy_policy" class="form-control"><?php echo stripslashes($settings_row['app_privacy_policy']);?></textarea>
                              <script>CKEDITOR.replace( 'privacy_policy' );</script>
                            </div>
                          </div>
                          <br>
                          <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                              <button type="submit" name="app_pri_poly" class="btn btn-primary">Save</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                
                <div role="tabpanel" class="tab-pane" id="admob_settings">   
                        <form action="" name="admob_settings" method="post" class="form form-horizontal" enctype="multipart/form-data">
                            <div class="section">
                               
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-6">          
                                                <div class="col-md-12">
                                                    <div class="admob_title_my">Admob</div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Publisher ID</label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="publisher_id" id="publisher_id" value="<?php echo $settings_row['publisher_id'];?>" class="form-control">
                                                        </div>
                                                        <div style="height:60px;display:inline-block;position:relative"></div>
                                                    </div>

                                                    <div class="banner_ads_block">
                                                         
                                                        
                                                        <div class="banner_ad_item">
                                                            <label class="control-label">Banner Ads</label>
                                                            <div class="row toggle_btn" style="position: relative;margin-top: -8px;">
                                                                <label class="switch">
                                                                    <input type="checkbox" id="banner_ad" name="banner_ad" value="true" class="cbx hidden" <?php if($settings_row['banner_ad']=='true'){ echo 'checked'; }?>/>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>                               
                                                        </div>
                                                        <div class="col-md-12">
                                                           <div class="form-group">
                                                                <label class="col-md-3 control-label">AdSize</label>
                                                                <div class="col-md-9">
                                                                    <select name="banner_size" id="banner_size" class="select2">
                                                                        <option value="BANNER" <?php if($settings_row['banner_size']=='BANNER'){?>selected<?php }?>>BANNER</option>
                                                                        <option value="SMART_BANNER" <?php if($settings_row['banner_size']=='SMART_BANNER'){?>selected<?php }?>>SMART_BANNER</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label mr_bottom20">Banner ID</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" name="banner_ad_id" id="banner_ad_id" value="<?php echo $settings_row['banner_ad_id'];?>" class="form-control">
                                                                </div>
                                                            </div>                    
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="banner_ads_block">
                                                        <div class="interstital_ad_item">
                                                            <label class="control-label">Admob Interstital Ads</label>     
                                                            <div class="row toggle_btn" style="position: relative;margin-top: -8px;">
                                                                <label class="switch">
                                                                    <input type="checkbox" id="interstital_ad" name="interstital_ad" value="true" class="cbx hidden" <?php if($settings_row['interstital_ad']=='true'){ echo 'checked'; }?>/>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>   
                                                        </div>  
                                                        <div class="col-md-12"> 
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label mr_bottom20">Interstital ID</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" name="interstital_ad_id" id="interstital_ad_id" value="<?php echo $settings_row['interstital_ad_id'];?>" class="form-control">
                                                                </div>
                                                            </div>
                                                                         
                                                        </div>                  
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="banner_ads_block">
                                                        <div class="interstital_ad_item">
                                                            <label class="control-label">Admob Native Ads</label>     
                                                            <div class="row toggle_btn" style="position: relative;margin-top: -8px;">
                                                                <label class="switch">
                                                                    <input type="checkbox" id="admob_nathive_ad" name="admob_nathive_ad" value="true" class="cbx hidden" <?php if($settings_row['admob_nathive_ad']=='true'){ echo 'checked'; }?>/>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-12"> 
                                                           
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label mr_bottom20">Admob Native ID</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" name="admob_native_ad_id" id="admob_native_ad_id" value="<?php echo $settings_row['admob_native_ad_id'];?>" class="form-control">
                                                                </div>
                                                            </div>
                                                                         
                                                        </div>                  
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div> 
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-9">
                                            <button type="submit" name="admob_submit" class="btn btn-primary">Save</button>
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


<script type="text/javascript">
 
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
    document.title = $(this).text()+" | <?=APP_NAME?>";
  });

  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
  }
</script>