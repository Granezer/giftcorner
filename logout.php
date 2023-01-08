<?php
require_once 'constants.php';
?>
<!DOCTYPE html>
<html>
<head>
	<base href="">
	<title>Logout</title>
	<script src="js/pages/general/general.js?pp=<?php echo rand(12345,99999);?>" type="text/javascript"></script>
</head>
<body>

</body>
</html>

<script src="https://code.jquery.com/jquery.min.js"></script>
    
<!-- Bootstrap JS form CDN -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="js/pages/logout/logout.js" type="text/javascript"></script>

<script type="text/javascript">
	jQuery(document).ready(function() {
	    logout();
	});
</script>