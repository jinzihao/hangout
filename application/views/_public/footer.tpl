</div>
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="container">
		<div class="footer">
			<div class="footer-inner">
				2013 &copy; Hangout designed by Jinzihao, Daniel Sun. Theme Metronic by keenthemes.
			</div>
			<div class="footer-tools">
				<span class="go-top">
				<i class="fa fa-angle-up"></i>
				</span>
			</div>
		</div>
	</div>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->   
	<!--[if lt IE 9]>
	<script src="assets/plugins/respond.min.js"></script>
	<script src="assets/plugins/excanvas.min.js"></script> 
	<![endif]-->   
	<script src="assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>   
	<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
	<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN NEED PLUGINS -->
	<script src="assets/plugins/bootbox/bootbox.min.js" type="text/javascript" ></script>
	<script src="assets/plugins/bootstrap-toastr/toastr.min.js"></script>
	<script type="text/javascript" src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
	<!-- END NEED PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	{block name="footerplugin"}{/block} 
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN APP SCRIPTS -->
	<script src="assets/scripts/app.js" type="text/javascript"></script>
	<script src="assets/scripts/base.js" type="text/javascript"></script>
	<script src="assets/scripts/formAjax.js" type="text/javascript"></script>
	<!-- END APP SCRIPTS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	
	<!-- END PAGE LEVEL SCRIPTS -->  
	<script>
		jQuery(document).ready(function() {    
		   App.init(); // initlayout and core plugins
		});
	</script>
	{block name="footerjs"}{/block} 
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>