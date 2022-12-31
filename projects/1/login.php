<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Busby's Game of Life</title>
<link href="life.css" type="text/css" rel="stylesheet"> <!-- CSS SHEET! -->
</head>
<body>
		<!-- PHP FUNCTIONS -->
		<?php
		function getuser($users)
		{
			$retno = -1;
			$userno = 0;
			foreach ($users as $line) 
			{
				$userno = $userno + 1;
				$values = explode(",",$line);
				if($values[0] == $_POST[uname])
				{
					if($values[1] == $_POST[pin]) { $retno = $userno;} // If our username and PIN pass, then this is our user
				}
			}
			return $retno;
		}?>
		<!-- MAIN PHP METHOD -->
		<?php 
		$entered = false; // If login info was entered
		$correct = false; // If login info was correct
		$userf = file('users.txt');
		$userno = -1;
		if( // IF: This is checking for submission of name & pin (if we submitted, we show results of submission)
		isset($_POST[uname]) && $_POST[uname]!="" && 
		isset($_POST[pin]) && $_POST[pin]!=""
		)
		{ $entered = true; $userno = getuser($userf); $correct = ($userno>-1);}
		else
		{ $entered = false; }
		?>
<div id="viewport"> <!-- VIEWPORT -->
</div>
<div id="toolbar"> <!-- TOOLBAR -->
<div class="bar"> <!-- This is toolbar subsection 1: Information -->
<h2><i>Busby's Game of Life</i></h2>
<a href="http://www.cs.gsu.edu/" target="_blank">Georgia State University</a><br>
<a href="http://codd.cs.gsu.edu/~dbusby1/index.html" target="_blank">Daniel's Homepage</a><br>
© 2021 by Daniel Busby
</div>
<div class="bar"> <!-- This is toolbar subsection 2, Login Panel -->
<h4>Login:</h4>
<?php
if($entered && $correct) // If we've entered login info and it's correct, then we establish session
{
?>
<br>Login Successful<br><br>
	<form action="main.php" method="post">
	<input type="hidden" name="uname" value="<?php echo $_POST[uname]; ?>">
	<input type="hidden" name="uno" value="<?php echo $userno; ?>">
	<input class="login" type="submit" value="Continue">
	</form>
<?php
} 
else // If we've either not entered info OR if it's incorrect
{
?>
<form action="login.php" method="post">
Username: <input type="text" name="uname" size="20"><br>
PIN: <input type="text" name="pin" placeholder="XXXX" pattern="[0-9]{4}" size="20"><br><br>
<h4><input type="submit" value="Login"></h4>
</form>
<?php
} ?>
</div>
<div class="bar"> <!-- This is toolbar subsection 3: Errors & Instructions -->
<h4>Instructions:</h4>
<div id="instructions">
<?php
if($correct) // If we've logged in successfully
{?>
Login was successful, press the Continue button.
<?php
}
else if($entered) // If we've entered login info
{?>
Error: Login info not recognized.
Please type in your Username & 4-digit PIN.
<?php
}
else // If we haven't tried to login yet.
{?>
	Please type in your Username & 4-digit PIN.
<?php } ?>
</div>
</div>
</div><div id="account"> <!-- ACCOUNT -->
<h4>User Account:</h4>
<?php
if($correct) // If we've logged in successfully
{?>
	<form action="main.php" method="post">
	<input type="hidden" name="uname" value="<?php echo $_POST[uname]; ?>">
	<input type="hidden" name="uno" value="<?php echo $userno; ?>">
	<input class="login" type="submit" value="<?php echo $_POST[uname];?>">
	</form>
	<form action="login.php" method="post">
	<input type="hidden" name="logout" value="true">
	<input class="login" type="submit" value="Logout">
	</form>
	<?php
}
else
{?>
<a href="main.php">
<input type="button" class="login" value="Go Back"> <!--I've replaced the login button with a Go Back button, so you can return without logging in -->
</a>
<a href="signup.php">
<input type="button" class="login" value="Signup">
<?php
}?>
</a>
</div>
</body>
</html>