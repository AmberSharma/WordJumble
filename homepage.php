<?php require_once "/var/www/WordJumble/trunk/libraries/constant.php"; ?>
<script src="<?php echo SITE_URL;?>/js/jquery.tools.min.js"></script>
<html>
<head>
<style>
table td 
{
	border:1px solid red;
	background-image:url('/images/abc.png');
	background-repeat:no-repeat;
	background-size:40px 40px;
}
</style>
</head>
<body>
<?php
$a = array("Taj mahal" , "Lotus temple" , "India Gate" , "Akshardham" , "Lal Kila");
echo "<pre>";
//print_r($a);
?>
<table cellspacing="10" cellpadding="40">


<?php
for($i = 0 ; $i < count($a) ; $i ++)
{
?>
	<tr>
<?php
	$number = range(0 , strlen($a[$i]));
	shuffle($number);
	for($j = 0 ; $j < count($number) ; $j ++)
	{
		echo "<td>";
		echo "<label>" . $a[$i][$number[$j]] . "</label>";
		echo "</td>";
	}
echo "</tr>";
	echo "<br />";
	
}

?>
</table>
</body>
</html>

