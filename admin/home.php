<?php
/**
* Company : Nemosofts
* Detailed : Software Development Company in Sri Lanka
* Developer : Thivakaran
* Contact : thivakaran829@gmail.com
* Contact : nemosofts@gmail.com
* Website : https://nemosofts.com
*/ 
 $page_title="Dashboard";
include("includes/header.php");

function thousandsNumberFormat($num){
    if ($num > 1000) {
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array(' K', ' M', ' B', ' T');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }
    return $num;
}

$qry_cat="SELECT COUNT(*) as num FROM tbl_category";
$total_category= mysqli_fetch_array(mysqli_query($mysqli,$qry_cat));
$total_category = $total_category['num'];

$qry_sub_cat="SELECT COUNT(*) as num FROM tbl_sub_category";
$total_sub_category= mysqli_fetch_array(mysqli_query($mysqli,$qry_sub_cat));
$total_sub_category = $total_sub_category['num'];

$qry_lant="SELECT COUNT(*) as num FROM tbl_city";
$total_lan= mysqli_fetch_array(mysqli_query($mysqli,$qry_lant));
$total_lan = $total_lan['num'];

$qry_post="SELECT COUNT(*) as num FROM tbl_post WHERE tbl_post.status='1' AND tbl_post.active='1'";
$total_post= mysqli_fetch_array(mysqli_query($mysqli,$qry_post));
$total_post = $total_post['num'];


$qry_post_app="SELECT COUNT(*) as num FROM tbl_post WHERE tbl_post.status='1' AND tbl_post.active='0'";
$total_post_app= mysqli_fetch_array(mysqli_query($mysqli,$qry_post_app));
$total_post_app = $total_post_app['num'];

$qry_views="SELECT SUM(total_views) as num FROM tbl_post";
$total_views= mysqli_fetch_array(mysqli_query($mysqli,$qry_views));
$total_views = $total_views['num'];

$qry_share="SELECT SUM(total_share) as num FROM tbl_post";
$total_share= mysqli_fetch_array(mysqli_query($mysqli,$qry_share));
$total_share = $total_share['num'];

$qry_urs="SELECT COUNT(*) as num FROM tbl_users";
$total_users= mysqli_fetch_array(mysqli_query($mysqli,$qry_urs));
$total_users = $total_users['num'];

$qry_reports="SELECT COUNT(*) as num FROM tbl_reports";
$total_reports = mysqli_fetch_array(mysqli_query($mysqli,$qry_reports));
$total_reports = $total_reports['num'];



$countStr='';
$no_data_status=false;
$count=$monthCount=0;

for ($mon=1; $mon<=12; $mon++) {

  if(date('n') < $mon){
    break;
  }

  $monthCount++;

  if(isset($_GET['filterByYear'])){
    $year=$_GET['filterByYear'];
    $month = date('M', mktime(0,0,0,$mon, 1, $year));
    $sql_user="SELECT `id` FROM tbl_users WHERE DATE_FORMAT(FROM_UNIXTIME(`registered_on`), '%c') = '$mon' AND DATE_FORMAT(FROM_UNIXTIME(`registered_on`), '%Y') = '$year'";
  }else{
    
    $month = date('M', mktime(0,0,0,$mon, 1, date('Y')));
    $sql_user="SELECT `id` FROM tbl_users WHERE DATE_FORMAT(FROM_UNIXTIME(`registered_on`), '%c') = '$mon'";
  }

  $count=mysqli_num_rows(mysqli_query($mysqli, $sql_user));
  $countStr.="['".$month."', ".$count."], ";

  if($count!=0){
    $count++;
  }

}

if($count!=0){
  $no_data_status=false;
}
else{
  $no_data_status=true;
}

$countStr=rtrim($countStr, ", ");

?>    


<?php 
$sql_smtp="SELECT * FROM tbl_smtp_settings WHERE id='1'";
$res_smtp=mysqli_query($mysqli,$sql_smtp);
$row_smtp=mysqli_fetch_assoc($res_smtp);

$smtp_warning=true;

if(!empty($row_smtp)){
  if($row_smtp['smtp_type']=='server'){
    if($row_smtp['smtp_host']!='' AND $row_smtp['smtp_email']!=''){
      $smtp_warning=false;
    }else{
      $smtp_warning=true;
    }  
  }
  else if($row_smtp['smtp_type']=='gmail'){
    if($row_smtp['smtp_ghost']!='' AND $row_smtp['smtp_gemail']!=''){
      $smtp_warning=false;
    }else{
      $smtp_warning=true;
    }  
  }
}

if($smtp_warning){
?>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <h4 id="oh-snap!-you-got-an-error!"><i class="fa fa-exclamation-triangle"></i> SMTP Setting is not config<a class="anchorjs-link" href="#oh-snap!-you-got-an-error!"><span class="anchorjs-icon"></span></a></h4>
        <p style="margin-bottom: 10px">Config the smtp setting otherwise <strong>forgot password</strong> OR <strong>email</strong> feature will not be work.</p> 
      </div>
    </div>
  </div>
<?php } ?>
<Style>

.rad-info-box:hover {
    color: #2196F3;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 5px rgba(0, 0, 0, 0.24);
    border: 1px solid #2196F3;
  }
          
.rad-info-box i{
	display:block;
	background-clip:padding-box;
	margin-right:15px;
	height:60px;
	width:60px;
	border-radius:100%;
	line-height:60px;
	text-align:center;
	font-size:4.4em;
	position:absolute;	
}

.rad-info-box .value,
.rad-info-box .heading{
	display:block;	
	position:relative;
	color: $text-color;
	text-align:right;
	z-index:10;
}

.rad-info-box .heading{
	font-size:1.2em;
	font-weight:300;
	text-transform:uppercase;
}

.rad-info-box .value{
	font-size:2.1em;
	font-weight:600;
	margin-top:5px;
}

.rad-txt-color1{
	color:#f44336;
}
.rad-txt-color2{
	color:#e91e63;
}
.rad-txt-color3{
	color:#9c27b0;
}
.rad-txt-color4{
	color:#673ab7;
}
.rad-txt-color5{
	color:#ff9800;
}
.rad-txt-color6{
	color:#4caf50;
}
.rad-txt-color7{
	color:#ffeb3b;
}

        </Style>
        
        
        
          <?php  if(DARK!="0"){?>
                      
                    <Style>

.rad-info-box {
    margin-bottom: 16px;
    padding: 20px;
    background: #262626;
    border: 1px solid #252525;
    border-radius: 10px;
}
                    </Style>
                    
                      <?php }else{?>
                      
                      <Style>
 .rad-info-box{
	margin-bottom:16px;
	padding:20px;
	background: #fff;
	border: 1px solid #dadce0;
	border-radius: 10px;
}
                      </Style>
                      
                     
                      <?php }?>  

        
<div class="row">

	


	

    <div class="col-lg-3 col-xs-6">
		<div class="rad-info-box my rad-txt-color7">
			<i class="fa fa-share-alt"></i>
			<span class="heading">Total Share</span>
			<span class="value"><span data-purecounter-duration="2.5" data-purecounter-end="<?php echo $total_share;?>"class="purecounter">0</span></span>
		</div>
	</div>
	
	<div class="col-lg-3 my col-xs-6">
		<div class="rad-info-box my rad-txt-color1">
			<i class="icon fa fa-user-md"></i>
			<span class="heading">Admin</span>
			<span class="value"><span>1</span></span>
		</div>
	</div>
	
    <div class="col-lg-3 my col-xs-6"> <a href="manage_report.php">
		<div class="rad-info-box my rad-txt-color2">
			<i class="icon fa fa-bug"></i>
			<span class="heading">Reports</span>
			<span class="value"><span data-purecounter-duration="1.0" data-purecounter-end="<?php echo $total_reports;?>"class="purecounter">0</span></span></span>
		</div>
		</a>
	</div>
</div>


<div class="row">
  <div class="col-lg-12">
    <div class="container-fluid" style="background: #FFF;box-shadow: 0px 0px 0px 0px #CCC;border: 1px solid #dadce0;border-radius: 10px;">
      <div class="col-lg-10">
        <h3>Users Analysis</h3>
        <p>New registrations</p>
      </div>
      <div class="col-lg-2" style="padding-top: 20px">
        <form method="get" id="graphFilter">
          <select class="form-control" name="filterByYear" style="box-shadow: none;height: auto;border-radius: 8px;font-size: 16px;">
            <?php 
            $currentYear=date('Y');
            $minYear=2020;

            for ($i=$currentYear; $i >= $minYear ; $i--) { 
              ?>
              <option value="<?=$i?>" <?=(isset($_GET['filterByYear']) && $_GET['filterByYear']==$i) ? 'selected' : ''?>><?=$i?></option>
              <?php
            }
            ?>
          </select>
        </form>
      </div>
      <div class="col-lg-12">
        <?php 
        if($no_data_status){
          ?>
          <h3 class="text-muted text-center" style="padding-bottom: 2em">No data found !</h3>
          <?php
        }
        else{
          ?>
          <div id="registerChart"></div>
          <?php    
        }
        ?>
      </div>
    </div>
  </div>
</div>
			
<script async src="dist/purecounter.js"></script>
<?php include("includes/footer.php");?>     



<?php 
if(!$no_data_status){
  ?>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript">
    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Month');
      data.addColumn('number', 'Users');

      data.addRows([<?=$countStr?>]);

      var options = {
        curveType: 'function',
        fontSize: 15,
        hAxis: {
          title: "Months of <?=(isset($_GET['filterByYear'])) ? $_GET['filterByYear'] : date('Y')?>",
          titleTextStyle: {
            color: '#000',
            bold:'true',
            italic: false
          },
        },
        vAxis: {
          title: "Nos of Users",
          titleTextStyle: {
            color: '#000',
            bold:'true',
            italic: false,
          },
          gridlines: { count: 5},
          format: '#',
          viewWindowMode: "explicit", viewWindow:{ min: 0 },
        },
        height: 400,
        chartArea:{
          left:100,top:20,width:'100%',height:'auto'
        },
        legend: {
          position: 'none'
        },
        lineWidth:4,
        animation: {
          startup: true,
          duration: 1200,
          easing: 'out',
        },
        pointSize: 5,
        pointShape: "circle",

      };
      var chart = new google.visualization.LineChart(document.getElementById('registerChart'));

      chart.draw(data, options);
    }

    $(document).ready(function () {
      $(window).resize(function(){
        drawChart();
      });
    });
  </script>

<?php } ?>

<script type="text/javascript">

  // filter of graph
  $("select[name='filterByYear']").on("change",function(e){
    $("#graphFilter").submit();
  });

</script>