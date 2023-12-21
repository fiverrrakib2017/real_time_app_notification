<?php
    /**
     * Company : Nemosofts
     * Detailed : Software Development Company in Sri Lanka
     * Developer : Thivakaran
     * Contact : thivakaran829@gmail.com
     * Contact : nemosofts@gmail.com
     * Website : https://nemosofts.com
     */
    $page_title="API URL";
    include("includes/header.php");
    include("includes/connection.php");
    include("includes/function.php"); 	
    
    $file_path = getBaseUrl();
?>
<div class="row">
  <div class="col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-header">
          Example API url
        </div>
            <div class="card-body no-padding">
                <pre><code class="html">
                <br><b>API URL</b> <?php echo $file_path;?>
                </code></pre>
            </div>
        </div>
    </div>
</div>
<br/>
<div class="clearfix"></div>
<?php include("includes/footer.php");?>