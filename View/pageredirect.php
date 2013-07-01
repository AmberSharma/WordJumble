<?php require_once "/var/www/SnakeandLadder/trunk/libraries/constant.php"; ?>
<script src="<?php echo SITE_URL;?>/js/jquery.tools.min.js"></script>
<script>
$(document).ready(function()
{
	<?php 
		if(!empty($_REQUEST['name']) && !empty($_REQUEST['turn']) && !empty($_REQUEST['method'])) 
		{
			if($_REQUEST['method'] == "Automatic")
			{
	?>
			window.location.href= "automatic.php?name="+<?php echo "'".$_REQUEST['name']."'";?>+"&turn="+<?php echo "'" .$_REQUEST['turn']."'";?>+"&avatar="+<?php echo "'" .$_REQUEST['avatar']."'" ;?>+"&opponent="+<?php echo $_REQUEST['opponent'] ; ?>+"&method="+<?php echo "'" .$_REQUEST['method']."'" ;?>;
	<?php
			}
			else if($_REQUEST['method'] == "Manual")
			{
	?>
			window.location.href="manual.php?name="+<?php echo "'".$_REQUEST['name']."'";?>+"&turn="+<?php echo "'" .$_REQUEST['turn']."'";?>+"&avatar="+<?php echo "'" .$_REQUEST['avatar']."'" ;?>+"&opponent="+<?php echo $_REQUEST['opponent'] ; ?>+"&method="+<?php echo "'" .$_REQUEST['method']."'" ;?>;
	<?php
				
			}
		}
	?>
});

</script>
