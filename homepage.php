<?php require_once "/var/www/WordJumble/trunk/libraries/constant.php"; ?>
<script src="<?php echo SITE_URL;?>/js/jquery.tools.min.js"></script>
<!--<script src="<?php echo SITE_URL;?>/js/jquery-1.9.1.js"></script>-->

<script src="<?php echo SITE_URL;?>/js/jquery.ui.core.js"></script>
<script src="<?php echo SITE_URL;?>/js/jquery.ui.widget.js"></script>
<script src="<?php echo SITE_URL;?>/js/jquery.ui.mouse.js"></script>
<script src="<?php echo SITE_URL;?>/js/jquery.ui.draggable.js"></script>
<script src="<?php echo SITE_URL;?>/js/jquery.ui.sortable.js"></script>
<style>
	.apple_overlay {

    /* initially overlay is hidden */
    display:none;

    /* growing background image */
    background-image:url(/media/img/overlay/white.png);

    /*
      width after the growing animation finishes
      height is automatically calculated
      */
    width:640px;

    /* some padding to layout nested elements nicely  */
    padding:35px;

    /* a little styling */
    font-size:11px;
}

/* default close button positioned on upper right corner */
.apple_overlay .close {
    background-image:url(/media/img/overlay/close.png);
    position:absolute; right:5px; top:5px;
    cursor:pointer;
    height:35px;
    width:35px;
}
body
{
	background-image:url("images/backgroundimage.jpg");
	background-repeat:no-repeat;
	background-size:100% auto;
}
#petrol {
    background-image:url(images/rulespopup.png);
    background-repeat:no-repeat;
    background-size:50% 50%;
    width:600px;
    height:700px;
}
#chances
{
	border:1px solid red;
	width:210px;
	margin-left:36%;
	margin-top:3%;
	padding:2px;
	height:245px;
}
#chance1
{
	width:200px;
	margin-top:8px;
	padding:2px;
	margin-left:2px;
	height:20px;
	float:left;
	border:1px solid red;
}
#chance2
{
	width:200px;
	margin-top:25px;
	margin-left:2px;
	padding:2px;
	height:20px;
	float:left;
	border:1px solid red;
}
#chance3
{
	width:200px;
	margin-top:25px;
	margin-left:2px;
	padding:2px;
	height:20px;
	float:left;
	border:1px solid red;
}
#chance4
{
	width:200px;
	margin-top:25px;
	padding:2px;
	margin-left:2px;
	height:20px;
	float:left;
	border:1px solid red;
}
#chance5
{
	width:200px;
	margin-top:25px;
	margin-left:2px;
	padding:2px;
	height:20px;
	float:left;
	border:1px solid red;
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
#hints
{
	border:1px solid red;
	width:200px;
	margin-left:18%;
	margin-top:-18.5%;
	float:left;
	height:250px;
}
#hint1
{
	border:1px solid red;
	height:30px;
	margin:2px;
	margin-top:6px;
	width:195px;
	text-align:center;
}
#hint2
{
	border:1px solid red;
	height:30px;
	margin:2px;
	margin-top:19px;
	width:195px;
	text-align:center;
}
#hint3
{
	border:1px solid red;
	height:30px;
	margin:2px;
	margin-top:19px;
	width:195px;
	text-align:center;
}
#hint4
{
	border:1px solid red;
	height:30px;
	margin:2px;
	margin-top:19px;
	width:195px;
	text-align:center;
}
#hint5
{
	border:1px solid red;
	height:30px;
	margin:2px;
	margin-top:19px;
	width:195px;
	text-align:center;
}
#container
{
	height:250px;
	width:430px;
	border:1px solid green;
	float:left;
	margin-left:3%;
	margin-top:3%;
}
#submitscore
{
	border:1px solid green;
	width:230px;
	margin-top:-18.5%;
	margin-left:1%;
	float:left;
	height:250px;
	text-align:center;
}
#outerdiv
{
	height:50%;
	border:1px solid blue;
	width:100%;
}
#rules
{
	border:1px solid green;
	width:150px;
	margin-top:-18.5%;
	margin-right:1.5%;
	float:right;
	height:250px;
	text-align:center;
}
</style>
<?php
$arr = array("TAJ MAHAL" , "LOTUS TEMPLE" , "INDIA GATE" , "AKSHARDHAM" , "LAL KILA");
echo "<div id='outerdiv'>";
echo "<div id = 'container'>";
for($i =0 ; $i < count($arr) ; $i ++)
{
	echo "<div id='".($i + 1)."' style='border:1px solid blue;height:40px;width:420px;' class='sortable'>";
	$shuffle = range(0, (strlen($arr[$i]) - 1));
	shuffle($shuffle);
	for($j = 0 ; $j < count($shuffle) ; $j ++)
	{
		echo "<div class='ui-state-default' id='".$i.$shuffle[$j].$arr[$i][$shuffle[$j]]."' >". $arr[$i][$shuffle[$j]] ."</div>";
	}
	echo "</div>";	
}
echo "</div>";
echo "<div id='chances'>";
	echo "<div id='chance1'></div>";
	echo "<div id='chance2'></div>";
	echo "<div id='chance3'></div>";
	echo "<div id='chance4'></div>";
	echo "<div id='chance5'></div>";
echo "</div>";
echo "<div id='hints'>";
	echo "<div id='hint1'><input type='button' id='hintof1' value='Show Hint' onclick='showhint(this.id)'/></div>";
	echo "<div id='hint2'><input type='button' id='hintof2' value='Show Hint' onclick='showhint(this.id)'/></div>";
	echo "<div id='hint3'><input type='button' id='hintof3' value='Show Hint' onclick='showhint(this.id)'/></div>";
	echo "<div id='hint4'><input type='button' id='hintof4' value='Show Hint' onclick='showhint(this.id)'/></div>";
	echo "<div id='hint5'><input type='button' id='hintof5' value='Show Hint' onclick='showhint(this.id)'/></div>";
echo "</div>";
echo "<div id='submitscore'>";
echo "<a href='javascript:void(0)' onclick='findscore()'><img src='images/submit.png' height=60 width=150 style='margin-top:80px;'/></a>";
echo "</div>";
echo "<div id='rules'>";
echo "<a href='javascript:void(0)' ><img src='images/rules.png' rel='#petrol' height=60 width=150 style='margin-top:80px;' /></a>";
echo "</div>";
echo "</div>";
echo '<div class="apple_overlay" id="petrol">';
echo "Hi";
echo '</div>';
?>
<script>
var choosenouterdiv;
var score =0;
var correctsequence = new Array();
var correctsequencewithindex = new Array();
var changedsequencewithindex = new Array();
var jumbledsequence = new Array();
var changedsequence = new Array();
var lightsequence = new Array('111','121','131','211','221','231','311','321','331','411','421','431','511','521','531');
var hints = new Array('Monument' ,'Monument' ,'Monument' ,'Monument' ,'Monument');
$(function() {
	$("img[rel]").overlay({mask: '#000', effect: 'apple'});
	for(var i = 1 ; i <= 5 ; i ++)
	{
		
		for(var j = 1 ; j <= 3 ; j ++)
		{
			if(j == 1)
			$("#chance"+i).html('<img src="images/greenlight.png" height=20 width=20 style="margin-left:20px;margin-right:20px;" id="'+ i + j +'"/>');
			else
			$("#chance"+i).append('<img src="images/greenlight.png" height=20 width=20 style="margin-left:20px;margin-right:20px;" id="'+ i + j +'"/>');
		}
	}
	$( ".sortable" ).sortable({
		revert: true,
		update: function(event, ui) 
		{ 
			console.log('update: '+ui.item.index())
			var position = ui.item.index();				
			var k =0 ;
			changedsequence = new Array();
			$("#"+choosenouterdiv +" > div").map(function() 
			{
				if(typeof $(this).attr("id") == "string")
				{
					changedsequence[k ++] = $(this).attr("id");
				}
			});
			// Creating an array with the changed sequence with the id of div with the complete word as id.
			changedsequencewithindex[choosenouterdiv] = changedsequence;
			if(changedsequence[position].length == 3)
			{
				if(position.toString.length == 2)
				{
					if(changedsequence[position][2] == correctsequence[position][3])
					{
						score += 5;
					}
					else
					{
						var pos = (choosenouterdiv - 1) * 3;
						for(var k = 0 ; k < 3 ; k ++)
						{
							if(parseInt(lightsequence[pos + k][2]) == 1)
							{
								
								lightsequence[pos + k] = lightsequence[pos + k].replaceAt(2, "0");
								
								break;
							}
						}
						$("#chance"+ choosenouterdiv).html(' ');
						for(var l = 0 ; l < 3 ; l ++)
						{
							
							if(parseInt(lightsequence[pos + l][2]) == 0)
							{
								$("#chance"+ choosenouterdiv).append('<img src="images/redlight.png" height=20 width=20 style="margin-left:20px;margin-right:20px;" id="'+ choosenouterdiv + (k+1) +'"/>');
							}
							else
							{
								$("#chance"+ choosenouterdiv).append('<img src="images/greenlight.png" height=20 width=20 style="margin-left:20px;margin-right:20px;" id="'+ choosenouterdiv + (k+1) +'"/>');
							}
						}
					}
				}
				else
				{
					
					if(changedsequence[position][2] == correctsequence[position][2])
					{
						score += 5;
					}
					else
					{
						var pos = (choosenouterdiv - 1) * 3;
						
						for(var k = 0 ; k < 3 ; k ++)
						{
							if(parseInt(lightsequence[pos + k][2]) == 1)
							{
								
								lightsequence[pos + k] = lightsequence[pos + k].replaceAt(2, "0");
								
								break;
							}
						}
						$("#chance"+ choosenouterdiv).html(' ');
						for(var l = 0 ; l < 3 ; l ++)
						{
							if(parseInt(lightsequence[pos + l][2]) == 0)
							{
								$("#chance"+ choosenouterdiv).append('<img src="images/redlight.png" height=20 width=20 style="margin-left:20px;margin-right:20px;" id="'+ choosenouterdiv + (k+1) +'"/>');
								if(l == 2)
								{
									$('#'+choosenouterdiv+' div').fadeOut('20000');
									$('#chance'+choosenouterdiv+' img').fadeOut("9000");
									$('#hint'+choosenouterdiv+' input').fadeOut("9000");
									$('#hint'+choosenouterdiv+' a').fadeOut("9000");
									
								}
							}
							else
							{
								$("#chance"+ choosenouterdiv).append('<img src="images/greenlight.png" height=20 width=20 style="margin-left:20px;margin-right:20px;" id="'+ choosenouterdiv + (k+1) +'"/>');
							}
						}
					}
				}
			}
			else
			{
				if(position.toString.length == 2)
				{
					if(changedsequence[position][3] == correctsequence[position][3])
					{
						score += 5;
					}
					else
					{
						var pos = (choosenouterdiv - 1) * 3;
						
						for(var k = 0 ; k < 3 ; k ++)
						{
							if(parseInt(lightsequence[pos + k][2]) == 1)
							{
								
								lightsequence[pos + k] = lightsequence[pos + k].replaceAt(2, "0");
								
								break;
							}
						}
						$("#chance"+ choosenouterdiv).html(' ');
						for(var l = 0 ; l < 3 ; l ++)
						{
							if(parseInt(lightsequence[pos + l][2]) == 0)
							{
								$("#chance"+ choosenouterdiv).append('<img src="images/redlight.png" height=20 width=20 style="margin-left:20px;margin-right:20px;" id="'+ choosenouterdiv + (k+1) +'"/>');
							}
							else
							{
								$("#chance"+ choosenouterdiv).append('<img src="images/greenlight.png" height=20 width=20 style="margin-left:20px;margin-right:20px;" id="'+ choosenouterdiv + (k+1) +'"/>');
							}
						}
						
					}
				}
				else
				{
					
					
					if(changedsequence[position][3] == correctsequence[position][2])
					{
						score += 5;
					}
					else
					{
						
						var pos = (choosenouterdiv - 1) * 3;
						
						for(var k = 0 ; k < 3 ; k ++)
						{
							if(parseInt(lightsequence[pos + k][2]) == 1)
							{
								
								lightsequence[pos + k] = lightsequence[pos + k].replaceAt(2, "0");
								
								break;
							}
						}
						$("#chance"+ choosenouterdiv).html(' ');
						for(var l = 0 ; l < 3 ; l ++)
						{
							if(parseInt(lightsequence[pos + l][2]) == 0)
							{
								$("#chance"+ choosenouterdiv).append('<img src="images/redlight.png" height=20 width=20 style="margin-left:20px;margin-right:20px;" id="'+ choosenouterdiv + (k+1) +'"/>');
							}
							else
							{
								$("#chance"+ choosenouterdiv).append('<img src="images/greenlight.png" height=20 width=20 style="margin-left:20px;margin-right:20px;" id="'+ choosenouterdiv + (k+1) +'"/>');
							}
						}
					}
				}
			}
		},
		start: function(event, ui) 
		{ 
			// The id of the div in which a complete word is jumbled.
			choosenouterdiv = $(this).attr("id");
			var k = 0 ;
			correctsequence = new Array();
			jumbledsequence = new Array();
			// Choosing all the divs inside the div selected.
			$("#"+choosenouterdiv +" > div").map(function() 
			{
				if(typeof $(this).attr("id") == "string")
				{
					correctsequence[k] = $(this).attr("id");
					jumbledsequence[k] = $(this).attr("id");
					k ++;
				}
			});
			// Sorting the ids in correctsequence array to get the correct answer in the array
			sortarray(correctsequence);
			// Creating the array with id of teh div with complete word as an id.
			correctsequencewithindex[choosenouterdiv] =  correctsequence;
			console.log('start: ' + ui.item.index())
		}
	});
});

String.prototype.replaceAt=function(index, character) {
      return this.substr(0, index) + character + this.substr(index+character.length);
   }
function sortarray(arr)
{
	for(var i = 0 ; i < arr.length ; i ++)
	{
		var temp;
		for(var j = i + 1  ; j < arr.length ; j ++)
		{
			
			var abc = 0;
			var def = 0;
			if(arr[j].length == 3)
			{
				if(arr[i].length == 4)
				{
					for(var k = 1 ; k < 3 ; k ++)
					{
						def = (def * 10) + parseInt(arr[i][k]);
					}
					
					if(arr[j][1] < def)
					{
						temp = arr[i];
						arr[i] = arr[j];
						arr[j] = temp;
						
					}
				}
				else
				{	
					if(arr[j][1] < arr[i][1])
					{
					
						temp = arr[i];
						arr[i] = arr[j];
						arr[j] = temp;
						
					}
				}
			}
			else if(arr[j].length == 4)
			{
				
				if(arr[i].length == 4)
				{
					for(var k = 1 ; k < 3 ; k ++)
					{
						
						def = (def * 10) + parseInt(arr[i][k]);
					}
					for(var k = 1 ; k < 3 ; k ++)
					{
						abc = (abc * 10) + parseInt(arr[j][k]);
					}
					if(abc < def)
					{
						temp = arr[i];
						arr[i] = arr[j];
						arr[j] = temp;
						
					}
				}
				else
				{
					for(var k = 1 ; k < 4 ; k ++)
					{
						abc = (abc * 10) + parseInt(arr[j][k]);
					}
					if(abc < arr[i][1])
					{
						temp = arr[i];
						arr[i] = arr[j];
						arr[j] = temp;
						
					}
				}
				
			}
			
		}
	}
	correctsequence = arr;
}


function showhint(id)
{
	$("#hint" + id[6]).html(hints[id[6] - 1]);
	score -= 2;
}

function findscore()
{
	for(var i = 1 ; i < correctsequencewithindex.length ; i ++)
	{
		//alert(correctsequencewithindex[i]);
		if(correctsequencewithindex[i] != undefined)
		{
			for(var j = 0 ; j < correctsequencewithindex[i].length  ; j ++)
			{
				if(correctsequencewithindex[i][j][2] == changedsequencewithindex[i][j][2])
				{
					score ++;
					score ++;
				}
				//alert(correctsequencewithindex[i][j]);
			}
			//alert(changedsequencewithindex[i]);
		}
	}
	for(var i = 0 ; i < lightsequence.length ; i ++)
	{
		if(lightsequence[i][2] == "0")
		{
			score -= 3; 
		}
	}
	var r = confirm("Your Score is = "+ score);
	if(r == true)
		location.reload(); 
	
}
</script>
  
