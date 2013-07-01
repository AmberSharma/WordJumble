<?php require_once "/var/www/SnakeandLadder/trunk/libraries/constant.php"; ?>
<script src="<?php echo SITE_URL;?>/js/jquery.tools.min.js"></script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Snake and ladder</title>
<style type='text/css'>

table td {
	height: 10%;
	width: 10%;
}

#roll {
	clear: left;
	float: left;
	width: 520px;
	height: 24pt;
	margin: 40px 0 0 0;
	font-size: 18pt;
	font-weight: bold;
	border-style: outset;
	background: white;
}

.snakeandladder {
	background-image: url(<?php echo SITE_URL;?>/images/snakeandladder.jpg);
	background-position: center;
	background-size: 102% 102%;
	background-repeat: no-repeat;
}

.container {
	background-image: url(<?php echo SITE_URL;?>/images/rolldicelogo.gif);
	background-repeat: no-repeat;
	background-size: 100% 100%;
}

.bubble {
	background-color: #FFAB00;
	border: 2px solid #333;
	border-radius: 5px;
	color: #333;
	display: inline-block;
	font: 16px/24px sans-serif;
	padding: 12px 24px;
	position: relative;
}

.bubble:after,.bubble:before {
	border-left: 20px solid transparent;
	border-right: 20px solid transparent;
	border-top: 20px solid #FFAB00;
	bottom: -20px;
	content: '';
	left: 50%;
	margin-left: -20px;
	position: absolute;
}

/* Styling for second triangle (border) */
.bubble:before {
	border-left: 23px solid transparent;
	border-right: 23px solid transparent;
	border-top: 23px solid;
	border-top-color: inherit;
	/* Can't be included in the shorthand to work */
	bottom: -23px;
	margin-left: -23px;
}

#left
{
	height:100%;
	width:20%;
	float:left;
	
}
#center
{
	height:100%;
	width:59%;
	float:left;
}
#right
{
	height:100%;
	width:21%;
	float:right;
	background-image: url(<?php echo SITE_URL;?>/images/messagebox.jpg);
	background-position: center;
	background-size: 100% 100%;
	background-repeat: no-repeat;
}	

#message
{
	width:80%;
	margin-top:80%;
}
</style>
<script>
var name = new Array() ;
var userpositions = new Array("0") ;
var useravatar = new Array() ;
var previousposition = new Array();
var attempt = 0;
var temp = 0;
var turntemp = 0;
var pos = 0;
var Timer1;
var user;
var turn;
var avatar;
var opponent;
var method;
var message1 = "Ok Let's Start the Game!!!";
var message2 = "Waiting for Compatible Opponents to turn Up!!!";
var message3 = "Please Roll The dice Again!!!";
var message4 = "Oh Its a Snake!!!";
var message5 = "Hurray!!! Its a Ladder!!!";
var message6 = "Sorry!!! It total is Over hundred!!!";
var message7 = "Hurray!!! You Have Won!!!";
var message8 = "Sorry!!! You Have Lost!!!";
$(document).ready(function()
{
	<?php 
		if(!empty($_REQUEST['name']) && !empty($_REQUEST['turn'])) 
		{
	?>
			$("#die1").hide();
			$("#die2").hide();
			$("#dicerollbutton").hide();
			user = <?php echo "'".$_REQUEST['name']."'";?>;
			turn = <?php echo "'" .$_REQUEST['turn']."'";?>;
			avatar = <?php echo "'" .$_REQUEST['avatar']."'" ;?>;
			opponent = <?php echo $_REQUEST['opponent'] ; ?>;
			method = <?php echo "'" . $_REQUEST['method'] . "'" ; ?>;
			$.ajax
			({
				type: "POST",
        			url: '../controller/controller.php?method=insertUser&user='+user+"&turn="+turn+"&avatar="+avatar+"&method1="+method,
     				success: function(data)
     				{
     					if($.trim(data) == "1")
					{
						$(".player").attr("id",user);
						$("#"+user).html("<img src='<?php echo SITE_URL;?>/images/"+ avatar + "' height='50' width='50' class='draggable2'/>");
						Timer1 = setInterval(fetchUser, 5000);
					}
					else
					{
						window.location.href = "bendrules.php";
					}
				}
				
			});		
	<?php
		}
		else
		{
			header('Location: bendrules.php');
		}
	?>
});



function fetchUser()
{
	$.ajax
			({
				type: "POST",
        			url: '../controller/controller.php?method=fetchUser&user='+user+"&turn="+turn+"&avatar="+avatar+"&opponent="+opponent+"&method1="+method,
     				success: function(data)
     				{
					if($.trim(data) != "1")
					{
						var resp=jQuery.parseJSON($.trim(data));
						var k = 0 ;  
						$.each(resp, function(key, val) 
						{
							temp = 1;
							if(key % 2 == 0)
							{
								name[k] = val;
								k ++;
							}
							else
							{
								$("#"+user).append("<img src='<?php echo SITE_URL;?>/images/"+ val + "' height='50' width='50' id='"+ name[key - 1] +"'/>");
							}
							
						});
					}
					else
					{
						$("#message").fadeIn();
						$("#message").html("<span class='bubble'>"+ message2 +"</span>");
						$("#message").fadeOut(4000);
					}
     				},
				complete:function()
				{	
					if(temp == 1)
     					{
						$("#message").html("<span class='bubble'>"+ message1 +"</span>");
						$("#message").fadeOut(8000);
						clearInterval(Timer1);
						name[opponent] = user;
						$.ajax
						({
							type: "POST",
        						url: '../controller/controller.php?method=updateUser&users='+name,
							success:function(data)
							{
								if($.trim(data) == "1")
								{
									setChance();
									Timer2 = setInterval(getChance, 5000);
								}
								if($.trim(data) == "-1")
								{
									Timer2 = setInterval(getChance, 5000);
								}
								
							}
     						});
					}
				}
				
			});
}

function getChance()
{
	$.ajax
	({
		type: "POST",
		url: '../controller/controller.php?method=getChance',
		success: function(data)
		{
			if($.trim(data) != "-1")
			{
				
				var resp=jQuery.parseJSON($.trim(data));
				if(resp == user)
				{
					$("#die1").show();
					$("#die2").show();
					$("#dicerollbutton").show();
				}
				else
				{
					$("#message").fadeIn();
					$("#message").html("<span class='bubble'> It is "+ resp +"'s Turn!!!</span>");
					$("#message").fadeOut(4000);
				}
				if(attempt == 0)
				{
					Timer3 = setInterval(getPosition, 4000);
					attempt = 1;
				}
			}
		}
		
	});
}

function getPosition()
{
	$.ajax
	({
		type: "POST",
		url: '../controller/controller.php?method=getPosition&user='+user,
		success: function(data)
		{
			if($.trim(data) != "-1")
			{
				var usernames = new Array();
				var resp=jQuery.parseJSON($.trim(data));
				var ua = 0;
				var un = 0;
				var up = 0;
				$.each(resp, function(key, val) 
				{
					if(key % 3 == 0)
					{
						usernames[un] = val;
						un ++; 
					}
					else if(key % 3 == 1)
					{
						useravatar[ua] = val;
						ua ++; 
					}
					else
					{
						userpositions[up] = val;
						if(userpositions[up] >=  100)
						{
							if (confirm(message8)) 
							{
								clearInterval(Timer2);
								clearInterval(Timer3);
								clearTimer(Timer4);
								window.location.href= "bendrules.php?name="+user;
							}
						}
						if(userpositions[up] != -1)
						{
							if(typeof previousposition[usernames[un - 1]] !== 'undefined')
							$("#"+previousposition[usernames[un - 1]]).html(" ");
						}
						$("#"+ val).html("<img src='<?php echo SITE_URL;?>/images/"+ useravatar[ua - 1] + "' height='50' width='50' id='"+usernames[un - 1]+"' />");
						previousposition[usernames[un - 1]] = val;
						up ++;
					}
				});
				
			}
		}
		
	});
}
function setChance()
{
	$.ajax
	({
		type: "POST",
		url: '../controller/controller.php?method=setChance&users='+name,				
	});
}
</script>
<script type='text/javascript'> 
var pos = 0;
var firstturn = 0;
var printed = 0;
var previous = 0;
var Timer4;
var inside = 1;
var snakeface = new Array(17,54,62,64,87,93,95,98 );
var snakepath = {17: [5,6,7], 54:[53,48,47,34], 62:[58,42,43,38,22,23,18,19], 64:[63,58,59,60], 87:[74,67,55,45,36,24], 93:[88,89,72,73], 95:[96,85,86,75], 98:[82,83,78,79]};
var snaketail = new Array(7,34,19,60,24,73,75,79 );
var laddertail = new Array(1,4,9,21,28,51,71,80 );
var ladderface = new Array(38,14,31,42,84,67,91,100);
var ladderpath = {1:[19,22,38], 4:[5,15,14], 9:[12,30,31], 21:[39,42], 28:[34,47,55,65,76,84], 51:[52,68,67], 71:[90,91], 80:[81,100]};
var last;

     function animateRoll(times)
     {
        times = times || 1;
        
        var roll = generateRoll();
        drawRoll(roll[0], roll[1]);
         
         if (times > 10)
         {
		var sum = checkRoll(roll[0], roll[1]);
		if(turn == 'Yes')
		{
			if(sum == 6)
			{
				firstturn += sum ; 
				$("#message").fadeIn();
				$("#message").html("<span class='bubble'>" + message3 + " </span>");
				$("#message").fadeOut();
				return ; 
			}
			else
			{
				if(pos)
				{
					$(".player").html(" ");
				}
				Timer4 = setTimeout('func(' + (pos + 1) + ')', 1000);
				if(firstturn)
				{
					last = (pos + sum + firstturn); 
					pos += (sum + firstturn);
				}
				else
				{
					last = (pos + sum); 
					pos += sum;
				}
				for(var i = 0 ; i < snakeface.length ; i ++)
				{
					
					if(pos == snakeface[i])
					{
						
						$("#message").fadeIn();
						$("#message").html("<span class='bubble'>" + message4 + " </span>");
						$("#message").fadeOut(8000);
						//previous = pos;
       						//setTimeout('func1('+ pos + ')', 1000);
    						pos = snaketail[i]; 
						$("#message").fadeIn();
						$("#message").html("<span class='bubble'> You can come down to " + pos + " position</span>");
						$("#message").fadeOut(8000);
						turntemp = 1;
					}
				}
				for(var i = 0 ; i < laddertail.length ; i ++)
				{
					if(pos == laddertail[i])
					{
						
						$("#message").fadeIn();
						$("#message").html("<span class='bubble'>" + message5 + " </span>");
						$("#message").fadeOut(8000);
						//previous = pos;
       						//setTimeout('func2('+ pos + ')', 1000);
						pos = ladderface[i];
						$("#message").fadeIn();
						$("#message").html("<span class='bubble'> You can Move up to" + pos + "position</span>");
						$("#message").fadeOut(8000);
						turntemp = 1;
					}
				}
				if(turntemp == 0 )
				{
					$("#message").fadeIn();
					if(firstturn)
					{
						$("#message").html("<span class='bubble'>Please Move " + (firstturn + sum) + " positions Forward </span>");
					}
					else
					{
						$("#message").html("<span class='bubble'>Please Move " + sum + " positions Forward </span>");
					}
					$("#message").fadeOut(8000);
					
				}
				if(pos >= 100)
				{
					if (confirm(message7)) 
					{
						clearInterval(Timer2);
						clearInterval(Timer3);
						clearTimer(Timer4);
						window.location.href="bendrules.php?name="+user;
					}
					
					
				}
				firstturn = 0;
				return;
			}
		}
		else
		{
			if(pos)
			{
				$(".player").html(" ");
			}
			Timer4 = setTimeout('func(' + (pos + 1) + ')', 1000);
			last = (pos + sum); 
			pos += sum;
			for(var i = 0 ; i < snakeface.length ; i ++)
			{
				
				if(pos == snakeface[i])
				{
					
					$("#message").fadeIn();
					$("#message").html("<span class='bubble'>" + message4 + " </span>");
					$("#message").fadeOut(8000);
					//previous = pos;
					//setTimeout('func1('+ pos + ')', 1000);
					pos = snaketail[i]; 
					$("#message").fadeIn();
					$("#message").html("<span class='bubble'> You can come down to " + pos + " position</span>");
					$("#message").fadeOut(8000);
					turntemp = 1;
				}
			}
			for(var i = 0 ; i < laddertail.length ; i ++)
			{
				if(pos == laddertail[i])
				{
					
					$("#message").fadeIn();
					$("#message").html("<span class='bubble'>" + message5 + " </span>");
					$("#message").fadeOut(8000);
					//previous = pos;
					//setTimeout('func2('+ pos + ')', 1000);
					pos = ladderface[i];
					$("#message").fadeIn();
					$("#message").html("<span class='bubble'> You can Move up to" + pos + "position</span>");
					$("#message").fadeOut(8000);
					turntemp = 1;
				}
			}
			if(turntemp == 0 )
			{
				$("#message").fadeIn();
				$("#message").html("<span class='bubble'>Please Move " + sum + " positions Forward </span>");
				$("#message").fadeOut(8000);
				
			}
			if(pos >= 100)
			{
				if (confirm(message7)) 
				{
					clearInterval(Timer2);
					clearInterval(Timer3);
					clearTimer(Timer4);
					window.location.href= "bendrules.php?name="+user;
				}
			}
			return;
		}
               
          }
         
         setTimeout('animateRoll(' + (times + 1) + ')', 200);
     }
function func(attempt)
{
	if(attempt <= last)
	{
		$("#"+(attempt-1)).html("");
		$("#"+attempt).html("<img src='<?php echo SITE_URL;?>/images/"+avatar+"' height='30' width='30'/>");
		Timer4 = setTimeout('func(' + (attempt + 1) + ')', 500);
	}
	else
	{

		for(var i = 0 ; i < snakeface.length ; i ++)
		{
			if(last == snakeface[i])
			{
				$("#"+last).html("");	
				func1(last);
				inside = 0 ;
				break;	
				
			}
		}

		for(var i = 0 ; i < laddertail.length ; i ++)
		{
			if(last == laddertail[i])
			{
				$("#"+(last)).html("");		
				func2(last);
				inside = 0 ;
				break;
				
			}
		}
		if(inside == 1)
		{
			$.ajax
			({
				type: "POST",
				url: '../controller/controller.php?method=updateUserPosition&users='+name+"&user="+user+"&pos="+last,				
				success:function(data)
				{
					if($.trim(data) == 1)
					{
						$("#die1").hide();
						$("#die2").hide();
						$("#dicerollbutton").hide();
					}
				}				
			});
			setChance();
		}
		inside = 1;
	}
}

function func1(pos)
{
	snake = snakepath[pos];
	if(printed != snake.length)
	{
		$("#"+previous).html("");
		$("#"+snake[printed]).html("<img src='<?php echo SITE_URL;?>/images/"+avatar+"' height='30' width='30'/>");
		previous = snake[printed] ;
		printed ++ ;
		setTimeout('func1(' + pos + ')', 500);
	}
	else
	{
		last = snake[printed -  1] ;
		$.ajax
		({
			
			type: "POST",
			url: '../controller/controller.php?method=updateUserPosition&users='+name+"&user="+user+"&pos="+snake[printed -  1],				
			success:function(data)
			{
				if($.trim(data) == 1)
				{
					$("#die1").hide();
					$("#die2").hide();
					$("#dicerollbutton").hide();
				}
			}				
		});
		setChance();
		printed = 0;
	}
}
function func2(pos)
{
	ladder = ladderpath[pos];
	if(printed != ladder.length)
	{
		$("#"+previous).html("");
		$("#"+ladder[printed]).html("<img src='<?php echo SITE_URL;?>/images/"+avatar+"' height='30' width='30'/>");
		previous = ladder[printed] ;
		printed ++ ;
		setTimeout('func2(' + pos + ')', 500);
	}
	else
	{
		last = ladder[printed - 1] ; 
		$.ajax
			({
				type: "POST",
				url: '../controller/controller.php?method=updateUserPosition&users='+name+"&user="+user+"&pos="+ladder[printed - 1],				
				success:function(data)
				{
					if($.trim(data) == "1")
					{
						$("#die1").hide();
						$("#die2").hide();
						$("#dicerollbutton").hide();
					}
				}				
			});
			setChance();
			printed = 0;
	}
	
}
     function generateRoll()
     {
         return [ Math.floor(Math.random()*6) + 1, Math.floor(Math.random()*6) + 1 ];
     }

     function drawRoll(die1, die2)
     {
         document.getElementById('die1').innerHTML = '<img src="<?php echo SITE_URL;?>/images/Dice_' + die1 +'.png" />';
         document.getElementById('die2').innerHTML = '<img src="<?php echo SITE_URL;?>/images/Dice_' + die2 +'.png" />';
     }

     function checkRoll(die1, die2)
     {
         var sum = die1 + die2;
         return sum;
     }  
          
      
  </script>
</head>

<body>

	<div id="left" class="container" >
	<div style="margin-top: 70%; height: 10%;" class="player"></div>
	<div id="Diceroll">
		<div id='die1' style="width: 39%; height: 18%; margin-left: 10%; float: left;"></div>
		<div id='die2' style="width: 39%; height: 18%; margin-left: 51%;"></div>
		<div style='clear: left; width: 100%; margin-top: 20%;' id = "dicerollbutton">
			<a href="javascript:void(0)" onClick='animateRoll()' style="margin-left:9%;"><img src="<?php echo SITE_URL ?>/images/rolldice.jpg" height='60' width='220'/></a>
		</div>
	</div>

</div>
<div id="center" class="snakeandladder">
<table style="width: 100%; height: 100%; text-align: center; white-space: normal;" cellspacing="0" cellpadding="0">
<?php

$k = 10;
$m = 9;
for($j = 0; $j < 10; $j ++) {
	
	if ($j % 2 == 0) {
		for($i = 10; $i > 0; $i --) {
			if ($i % 10 == 0) {
				?>			
					<tr>
<?php
			}
			?>
				<td id="<?php echo ($i + ($k * $m)); ?>"></td>
<?php
			if ($i % 10 == 1) {
				?>
					</tr>
<?php
			}
		}
	} else {
		for($i = 0; $i < 10; $i ++) {
			if ($i % 10 == 0) {
				?>
					<tr>
<?php
			}
			?>
					<td id="<?php echo ($i + ($k * $m) +1); ?>"></td>
<?php
			if ($i % 10 == 9) {
				?>
					</tr>
<?php
			}
		}
	}
	$m --;
}

?>


</table>
	</div>
</div>
<div id ="right">
<center><div id="message"></div></center>
</div>
</body>
</html>
