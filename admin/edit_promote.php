<?php
    /**
     * Company : Nemosofts
     * Detailed : Software Development Company in Sri Lanka
     * Developer : Thivakaran
     * Contact : thivakaran829@gmail.com
     * Contact : nemosofts@gmail.com
     * Website : https://nemosofts.com
     */
    $page_title=(isset($_GET['promote_id'])) ? 'Edit promote' : 'Add promote';
    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");
    require_once("thumbnail_images.class.php");
 
    if(isset($_GET['promote_id'])){
        $qry="SELECT * FROM subscription_plan where id='".$_GET['promote_id']."'";
        $result=mysqli_query($mysqli,$qry);
        $row=mysqli_fetch_assoc($result);
    }
    
    if(isset($_POST['submit']) and isset($_POST['promote_id'])){
         $data = array(
            'plan_name'  =>  $_POST['plan_name'],
            'plan_details'  =>  $_POST['plan_details'],
            
            'plan_duration'  =>  $_POST['plan_duration'],
            'plan_duration_type'  =>  $_POST['plan_duration_type'],
            'plan_price'  =>  $_POST['plan_price'],
            
            'plan_duration_2'  =>  $_POST['plan_duration_2'],
            'plan_duration_type_2'  =>  $_POST['plan_duration_type_2'],
            'plan_price_2'  =>  $_POST['plan_price_2'],
            
            'plan_duration_3'  =>  $_POST['plan_duration_3'],
            'plan_duration_type_3'  =>  $_POST['plan_duration_type_3'],
            'plan_price_3'  =>  $_POST['plan_price_3'],
            
            'status'  =>  $_POST['status']
            );	
            $category_edit=Update('subscription_plan', $data, "WHERE id = '".$_POST['promote_id']."'");
        $_SESSION['msg']="11";
        $_SESSION['class']='success'; 
        header( "Location:edit_promote.php?promote_id=".$_POST['promote_id']);
        exit;
    }

?>
<div class="row">
    <?php
        if(isset($_GET['redirect'])){
            echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
        } else{
            echo '<a href="manage_promote.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
                    <input  type="hidden" name="promote_id" value="<?php echo $_GET['promote_id'];?>" />
                    <div class="section">
                        <div class="section-body">
  
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Plan Name*</label>
                            <div class="col-sm-8">
                              <input type="text" name="plan_name" value="<?php if(isset($_GET['promote_id'])){echo $row['plan_name'];}?>" class="form-control">
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Plan Details*</label>
                            <div class="col-sm-8">
                              <input type="text" name="plan_details" value="<?php if(isset($_GET['promote_id'])){echo $row['plan_details'];}?>" class="form-control">
                            </div>
                          </div>
                          
                          </br>
                          <div class="page_title_block"></div>
                          </br>
                          </br>
        
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Duration Day(s)*</label>
                            <div class="col-sm-8">
                              <input type="number" name="plan_duration" value="<?php if(isset($_GET['promote_id'])){echo $row['plan_duration'];}?>" class="form-control" placeholder="7">
                            </div>
                            
                          </div>
                          
        
        
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Price* <br/><small id="emailHelp" class="form-text text-muted">The minimum amount for processing a transaction through Stripe in USD is $0.50. For more info <a href="https://support.chargebee.com/support/solutions/articles/228511-transaction-amount-limit-in-stripe" target="_blank">click here</a></small></label>
                            <div class="col-sm-8">
                              <input type="text" name="plan_price" value="<?php if(isset($_GET['promote_id'])){echo $row['plan_price'];}?>" class="form-control" placeholder="9.99">
                            </div>
                          </div>   
                          
                          </br>
                          <div class="page_title_block"></div>
                          </br>
                          </br>
                          
                          
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Duration Day(s)*</label>
                            <div class="col-sm-8">
                              <input type="number" name="plan_duration_2" value="<?php if(isset($_GET['promote_id'])){echo $row['plan_duration_2'];}?>" class="form-control" placeholder="7">
                            </div>
                        
                          </div>

        
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Price* <br/><small id="emailHelp" class="form-text text-muted">The minimum amount for processing a transaction through Stripe in USD is $0.50. For more info <a href="https://support.chargebee.com/support/solutions/articles/228511-transaction-amount-limit-in-stripe" target="_blank">click here</a></small></label>
                            <div class="col-sm-8">
                              <input type="text" name="plan_price_2" value="<?php if(isset($_GET['promote_id'])){echo $row['plan_price_2'];}?>" class="form-control" placeholder="9.99">
                            </div>
                          </div>   
                          
                          </br>
                          <div class="page_title_block"></div>
                          </br>
                          </br>
                          
                          
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Duration Day(s)*</label>
                            <div class="col-sm-8">
                              <input type="number" name="plan_duration_3" value="<?php if(isset($_GET['promote_id'])){echo $row['plan_duration_3'];}?>" class="form-control" placeholder="7">
                            </div>
                            
                          </div>

        
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Price* <br/><small id="emailHelp" class="form-text text-muted">The minimum amount for processing a transaction through Stripe in USD is $0.50. For more info <a href="https://support.chargebee.com/support/solutions/articles/228511-transaction-amount-limit-in-stripe" target="_blank">click here</a></small></label>
                            <div class="col-sm-8">
                              <input type="text" name="plan_price_3" value="<?php if(isset($_GET['promote_id'])){echo $row['plan_price_3'];}?>" class="form-control" placeholder="9.99">
                            </div>
                          </div>   
                          
                          </br>
                          <div class="page_title_block"></div>
                          </br>
                          </br>
        
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Status</label>
                              <div class="col-sm-8">
                                   <select name="status" id="status" style="width:280px; height:25px;" class="select2" required>
                                    <option value="1" <?php if($settings_row['status']=='1'){?>selected<?php }?>>Active</option>
                                    <option value="0" <?php if($settings_row['status']=='0'){?>selected<?php }?>>Inactive</option>
                                </select>
                              </div>
                          </div>


        
                          <div class="form-group">
                            <div class="offset-sm-3 col-sm-9">
                              <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light"> Save </button>                      
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