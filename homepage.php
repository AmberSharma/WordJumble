<?php require_once "/var/www/WordJumble/trunk/libraries/constant.php"; ?>
<script src="<?php echo SITE_URL;?>/js/jquery.tools.min.js"></script>
<script src="<?php echo SITE_URL;?>/js/jquery-1.9.1.js"></script>
<script src="<?php echo SITE_URL;?>/js/jquery.ui.core.js"></script>
<script src="<?php echo SITE_URL;?>/js/jquery.ui.widget.js"></script>
<script src="<?php echo SITE_URL;?>/js/jquery.ui.mouse.js"></script>
<script src="<?php echo SITE_URL;?>/js/jquery.ui.draggable.js"></script>
<script src="<?php echo SITE_URL;?>/js/jquery.ui.sortable.js"></script>
<script>
var choosenouterdiv;
var correctsequence = new Array();
var jumbledsequence = new Array();
var changedsequence = new Array();
	$(function() {
		
		$( ".sortable" ).sortable({
			revert: true,
			update: function(event, ui) 
			{ 
				console.log('update: '+ui.item.index())
				var position = ui.item.index();
				var k =0 ;
				$("#"+choosenouterdiv +" > div").map(function() 
				{
	  				changedsequence[k ++] = $(this).attr("id");
				});
				if(position.toString().length == 1)
				{
					if(changedsequence[position][2] == correctsequence[position][2])
					{
		            			alert("correct");
					}
					else
					{
						alert("wrong");
					}
				}
				else
				{
					alert(changedsequence[position][3]);
				}
        		},
        		start: function(event, ui) 
			{ 
				choosenouterdiv = $(this).attr("id");
				
				var k = 0 ;
				$("#"+choosenouterdiv +" > div").map(function() 
				{
	  				correctsequence[k] = $(this).attr("id");
					jumbledsequence[k] = $(this).attr("id");
					k ++;
				});
				correctsequence.sort();
				console.log('start: ' + ui.item.index())
        		}
		});
	});
function abc()
{
	alert("hello");
}
</script>
<style>
#chances
{
	border:1px solid red;
	width:30%;
	margin-left:430px;
	padding:2px;
	height:240px;
}
.sortable
{
	width:420px;
	margin:2px;
	padding:2px;
	float:left;	
}
.ui-state-default
{
	height:20px;
	width:20px;
	float:left;
	border:1px solid red;
	margin:2px;
	text-align:center;
	background-image:url('images/abc.png');
	padding:1px;
	
}
#container
{
	height:250px;
	width:700px;
	border:1px solid green;
}
</style>
<?php
$arr = array("TAJ MAHAL" , "LOTUS TEMPLE" , "INDIA GATE" , "AKSHARDHAM" , "LAL KILA");
echo "<div id = 'container'>";
for($i =0 ; $i < count($arr) ; $i ++)
{
	echo "<div id='".($i + 1)."' style='border:1px solid blue;height:40px;' class='sortable'>";
	$shuffle = range(0, (strlen($arr[$i]) - 1));
	shuffle($shuffle);
	for($j = 0 ; $j < count($shuffle) ; $j ++)
	{
		echo "<div class='ui-state-default' id='".$i.$shuffle[$j].$arr[$i][$shuffle[$j]]."' onchange='abc()'>". $arr[$i][$shuffle[$j]] ."</div>";
	}
	echo "</div>";
	
	
}
echo "<div id='chances'>";
echo "</div>";
echo "</div>";
?>
<script>

</script>
