<?php
if(!defined('Footer')) {
   die('Direct access not permitted');
}
?>
<!-- begin:: Footer -->
<div class="kt-footer  kt-grid__item" id="kt_footer">
	<div class="kt-container  kt-container--fluid ">
		<div class="kt-footer__wrapper">
			<div class="kt-footer__copyright">
				<?php echo date("Y"); ?>&nbsp;&copy;&nbsp;<a href="#" target="_blank" class="kt-link">Redjic Solutions</a>
			</div>
			<div class="kt-footer__menu">
				<a href="#" target="_blank" class="kt-link">About</a>
				<a href="#" target="_blank" class="kt-link">Team</a>
				<a href="#" target="_blank" class="kt-link">Contact</a>
			</div>
		</div>
	</div>
</div>
<!-- end:: Footer -->

<?php
echo '<div id="msg" style="display:none">'.$_SESSION['msg'].'</div>';
echo '<div id="logout" style="display:none">'.$_SESSION['l'].'</div>';
echo '<div id="seconds" style="display:none">'.$_SESSION['seconds'].'</div>';
unset($_SESSION['msg']);
unset($_SESSION['l']);
unset($_SESSION['seconds']);
?> 