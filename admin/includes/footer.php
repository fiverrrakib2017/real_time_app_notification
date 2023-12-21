    <footer class="app-footer">
        <div class="navbar-collapse collapse in">
            <div class="row">
                <div class="col-xs-12">
                    <div class="footer-copyright">Copyright © <?php echo date('Y');?> <a href="http://www.AzaCodes.com" target="_blank">Azacodes.com</a>. All Rights Reserved.</div>
                </div>
            </div>
        </div>
    </footer>
  </div>
</div>
<!--===============================================================================================-->
<script type="text/javascript" src="assets/js/nemosofts.js"></script> 
<!--===============================================================================================-->
<script type="text/javascript" src="assets/js/app.js"></script>
<!--===============================================================================================-->
<script>
if($(".dropdown-li").hasClass("active")){
	    var _test='<?php echo $active_page; ?>';
	    $("."+_test).next(".cust-dropdown-container").show();
	    $("."+_test).find(".title").next("i").removeClass("fa-angle-right");
	    $("."+_test).find(".title").next("i").addClass("fa-angle-down");
	  }
	  $(document).ready(function(e){
	    var _flag=false;
	    $(".dropdown-a").click(function(e){
	      $(this).parents("ul").find(".cust-dropdown-container").slideUp();
	      $(this).parents("ul").find(".title").next("i").addClass("fa-angle-right");
	      $(this).parents("ul").find(".title").next("i").removeClass("fa-angle-down");
	      if($(this).parent("li").next(".cust-dropdown-container").css('display') !='none'){
	          $(this).parent("li").next(".cust-dropdown-container").slideUp();
	          $(this).find(".title").next("i").addClass("fa-angle-right");
	          $(this).find(".title").next("i").removeClass("fa-angle-down");
	      }else{
	        $(this).parent("li").next(".cust-dropdown-container").slideDown();
	        $(this).find(".title").next("i").removeClass("fa-angle-right");
	        $(this).find(".title").next("i").addClass("fa-angle-down");
	      }
	   });
});
</script>
<!--===============================================================================================-->
<script src="assets/js/notify.min.js"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="assets/sweetalert/sweetalert.min.js"></script>
<!--===============================================================================================-->
<?php if (isset($_SESSION['msg'])) { ?>
  <script type="text/javascript">
    $('.notifyjs-corner').empty();
    $.notify(
      '<?php echo $client_lang[$_SESSION["msg"]]; ?>', {
        position: "top center",
        className: '<?= $_SESSION["class"] ?>'
      }
    );
  </script>
<?php
  unset($_SESSION['msg']);
  unset($_SESSION['class']);
}
?>
<!--===============================================================================================-->
<script type="text/javascript">
  function fileValidation(){
    var fileInput = document.getElementById('fileupload');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.png|.PNG|.jpg|.JPG)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Please upload file having extension .png, .jpg, .PNG, .JPG only.');
        fileInput.value = '';
        return false;
    }else{
        //image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('uploadPreview').innerHTML = '<img src="'+e.target.result+'" style="width:100px;height:100px"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
  }
</script>
<!--===============================================================================================-->
</body>
</html>