<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Busby's Game of Life</title>
<link href="life.css" type="text/css" rel="stylesheet"> <!-- CSS SHEET! -->
<script src="toolbar.js"></script> <!-- TOOLBAR JS -->
</head>
<body>
		<!-- PHP FUNCTIONS -->
		<?php
		function getind($manifest, $state)
		{
			$retind = -1;
			foreach ($manifest as $line) 
			{
				$values = explode(",",$line);
				if($values[0] == $_POST[uname] && $values[1] == $state) // We check if user matches, and if name matches
				{
					$retind = $values[2];
				}
			}
			return $retind;
		}
		function doSave()
		{
			$gridsf = file('grids.txt');
			$lineno = 0;
			foreach ($gridsf as $line) 
			{
				$lineno = $lineno + 1; // returns the length, not the last line index; returns hypothetical next line index
			}
			file_put_contents("stats.txt", "$_POST[statp]\n", FILE_APPEND);
			file_put_contents("grids.txt", "$_POST[gridp]\n", FILE_APPEND);
			file_put_contents("manifest.txt", "$_POST[uname],$_POST[svname],$lineno,\n", FILE_APPEND);
		}
		function doLoad()
		{
			$gridval = "";
			$manifest = file('manifest.txt');
			$gridsf = file('grids.txt');
			$gridind = getind($manifest, $_POST[ldname]);
			$lineno = 0;
			foreach ($gridsf as $line) 
			{
				$lineno = $lineno + 1;
				if($lineno == $grindind) { $gridval = explode(",",$line); }
			}
			return $gridval;
		}
		function loadStats()
		{
			$statsval = "";
			$manifest = file('manifest.txt');
			$statsf = file('stats.txt');
			$gridind = getind($manifest, $_POST[ldname]);
			$lineno = 0;
			foreach ($statsf as $line) 
			{
				$lineno = $lineno + 1;
				if($lineno == $grindind) { $statsval = explode(",",$line); }
			}
			return $statsval;
		}?>
	<?php // This is our login checker
		$entered = false; // If login info was entered
		if( // IF: This is checking for session established
		isset($_POST[uname]) && $_POST[uname]!="" && 
		isset($_POST[uno]) && $_POST[uno]!=""
		)
		{ $entered = true; }
		else
		{ $entered = false; }
	?>
<div id="viewport"> <!-- VIEWPORT -->
<div id="outwrapper">
<div id="inwrapper">
<table cellspacing=0 id="grid">  <!-- The whole viewport is literally this one table. Javascript adds in all of the actual contents. :^) -->
</table>
</div></div></div>
<div id="toolbar"> <!-- TOOLBAR -->
<div class="bar"> <!-- This is toolbar subsection 7: Information -->
<h2><i>Busby's Game of Life</i></h2>
<a href="http://www.cs.gsu.edu/" target="_blank">Georgia State University</a><br>
<a href="http://codd.cs.gsu.edu/~dbusby1/index.html" target="_blank">Daniel's Homepage</a><br>
© 2021 by Daniel Busby
</div>
<div class="bar"> <!-- This is toolbar subsection 1, Game Controls -->
<form name="newgame" onsubmit="return newGame()">
<h4>New Game:</h4>
# of Rows: <input type="number" name="rows" value="25"><br>
# of Columns: <input type="number" name="cols" value="25"><br>
Population: <input type="number" name="pop" value="100"><br>
<input type="submit" value="Let's Go!">
</form>
</div>
<div class="bar"> <!-- This is toolbar subsection 2: Time Controls -->
<h4>Time Controls:</h4>
<input type="button" class="time" onclick="makeGo()" value="▶">
<input type="button" class="time" onclick="makePause()" value="⏸">
<form name="skipf" onsubmit="return skip()">
Skip Gens: <input type="number" name="gens" value="1">
<input type="submit" value="⏭">
</form>
<form name="ffwd" onsubmit="return fastForward()">
Timescale: <input type="range" min="1" max="40" value="10" name="timescale">
<input type="submit" value="▶">
</form>
</div>
<div class="bar"> <!-- This is toolbar subsection 3: Viewport Controls -->
<h4>Viewport Controls:</h4>
<form name="view" onsubmit="return viewport()">
Alive Color:<input type="color" name="color1" value="#ff0000"><br>
Dead Color:<input type="color" name="color2" value="#808080"><br>
Zoom: <input type="range" min="1" max="30" value="10" name="zoom">
<input type="submit" value="🔍"><br>
</form>
</div>
<div id="bdata" class="bar"> <!-- This is toolbar subsection 4: Game Data -->
<h4>Game Data:</h4>
<div id="data1">Generation:<br>Population:</div>
<div id="data2"><div class="data" id="dgen">0</div><br><div class="data" id="dpop">0</div></div>
</div>
<div class="bar"> <!-- This is toolbar subsection 5: Pattern Insertion -->
<h4>Insert Pattern:</h4>
<form name="ipatts" onsubmit="return insertPattern()">
Row: <input type="number" name="irow" value="1"><br>
Column: <input type="number" name="icol" value="1"><br>
Type: <select name="pattern" id="bpatt">
<option value="bee">Beehive</option>
<option value="pulsar">Pulsar</option>
<option value="glider">Glider</option>
<option value="gun">Gun</option>
</select><br>
<input type="submit" value="Insert">
</form>
</div>
<div class="bar"> <!-- This is toolbar subsection 6: Save States -->
<h4>Local Save States:</h4>
<form name="svst" onsubmit="return saveState()">
Save State: <input type="number" name="grno" value="1">
<input type="submit" value="Save">
</form>
<form name="ldst" onsubmit="return loadState()">
Load State: <input type="number" name="grno" value="1">
<input type="submit" value="Load">
</form>
</div>
<div class="bar"> <!-- This is toolbar subsection 6: Save States -->
<h4>Server Save States:</h4>
<?php
if($entered) // If we've logged in successfully
{?>
		<?php // This is our JUST SAVED checker
		if(
		isset($_POST[svname]) && $_POST[svname]!="" &&
		isset($_POST[gridp]) && $_POST[gridp]!=""
		)
		{
			$manifest = file('manifest.txt');
			$gridind = getind($manifest, $_POST[svname]); $oldgrid = ($gridind>-1); // If this is an old grid, it will already have an index
			if($oldgrid == false)
			{
				doSave();
			}
		}
		if(
		isset($_POST[ldname]) && $_POST[ldname]!=""
		)
		{
			$manifest = file('manifest.txt');
			$gridind = getind($manifest, $_POST[ldname]); $oldgrid = ($gridind>-1); // If this is an old grid, it will already have an index
			if($oldgrid == true)
			{
				$setgrid = doLoad();
				$setstats = loadStats();
			}
		}
		?>
	
	<form action="main.php" method="post" name="svstp" onsubmit="return saveStatePHP()">
	Save State: <input type="text" name="svname" size="5" value="1">
	<input type="hidden" name="gridp" value="">
	<input type="hidden" name="statp" value="">
	<input type="hidden" name="uname" value="<?php echo $_POST[uname]; ?>"> <!-- We need to pass our login every time we move pages... sigh -->
	<input type="hidden" name="uno" value="<?php echo $_POST[uno]; ?>">
	<input type="submit" value="Save">
	</form>
	<form action="main.php" method="post" name="ldstp"> <!-- Load script runs after PHP runs -->
	Load State: <input type="text" name="ldname" size="5" value="1">
	<input type="hidden" name="gridp" value="<?php if(isset($_POST[svname])) { echo $_POST[gridp]; } if(isset($_POST[ldname])) { echo $setgrid; } ?>"> <!-- PHP places these loaded values into the HTML form, so JS can retrieve them, on SAVE and LOAD -->
	<input type="hidden" name="statp" value="<?php if(isset($_POST[svname])) { echo $_POST[statp]; } if(isset($_POST[ldname])) { echo $setstats; } ?>">
	<input type="hidden" name="uname" value="<?php echo $_POST[uname]; ?>"> <!-- We need to pass our login every time we move pages... sigh -->
	<input type="hidden" name="uno" value="<?php echo $_POST[uno]; ?>">
	<input type="submit" value="Load">
	</form>
	
	
	<?php 
		if(
		(isset($_POST[svname]) && $_POST[svname]!="") ||
		(isset($_POST[ldname]) && $_POST[ldname]!="")
		)
		{
	?>
	<script>loadStatePHP();</script> <!-- If we've just LOADed, we need to activate our JS to populate the grid. There is no harm in this script running, as long as we are logged in -->
	<?php } ?>
<?php
}
else
{?>
<br>
<i>(Login to save states to server)</i>
<?php } ?>
</div>
</div><div id="account"> <!-- ACCOUNT -->
<h4>User Account:</h4>
<?php
if($entered) // If we've logged in successfully
{?>
	<input type="button" class="login" value="<?php echo $_POST[uname];?>"> <!--The link is removed from this button -->
	<form action="main.php" method="post">
	<input type="hidden" name="logout" value="true">
	<input class="login" type="submit" value="Logout">
	</form>
	<?php
}
else
{?>
<a href="login.php">
<input type="button" class="login" value="Login">
</a>
<a href="signup.php">
<input type="button" class="login" value="Signup">
<?php } ?>
</a>
</div>
</body>
</html>