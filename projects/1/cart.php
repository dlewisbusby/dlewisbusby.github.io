<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Busby's Luxury Travel Service</title>
<link href="life.css" type="text/css" rel="stylesheet"> <!-- CSS SHEET! -->
<script src="toolbar.js"></script> <!-- TOOLBAR JS -->
</head>
<body>
<div id="toolbar"> <!-- TOOLBAR -->
<div class="bar" id="bar1"> <!-- This is toolbar subsection 1: Logo Splash -->
<h2><i>Busby's Luxury Travel Service</i></h2>
<a href="http://www.cs.gsu.edu/" target="_blank">Georgia State University</a><br>
<a href="http://codd.cs.gsu.edu/~dbusby1/index.html" target="_blank">Daniel's Homepage</a><br>
© 2021 by Daniel Busby
</div>
<div class="bar" id="bar2"> <!-- This is toolbar subsection 4: Navigation -->
<h4>Navigation:</h4>
<div class="navpane">
<a href="index.php"><input type="button" class="nav" value="Home"></a>
<a href="rentals.php"><input type="button" class="nav" value="Rentals"></a>
<a href="parking.php"><input type="button" class="nav" value="Parking"></a>
<a href="about.php"><input type="button" class="nav" value="About"></a>
</div>
</div>
</div><div class="sidebox"> <!-- ACCOUNT -->
<h4>Members:</h4><br>
<a href="login.php">
<input type="button" class="login" value="Login">
</a>
<a href="signup.php">
<input type="button" class="login" value="Signup">
</a>
</div><div class="sidebox"> <!-- CART -->
<h4>Cart:</h4><br>

<!-- Put invisible form and PHP values here -->

<?php echo $_POST[cost];?>
<br><br>

<a href="cart.php">
<input type="button" class="login" value="Checkout">
</a>
</div>
<div id="viewport"> <!-- VIEWPORT --> <!-- Bullshit starts here -->
<div class="barMain">
<h2>Checkout</h2>
Please make sure your basket is full before you check out (there is no turning back)

<!-- Enter PHP values here, show our totals -->
		<!-- MAIN PHP METHOD -->
		<?php 
		$entered = false; // If car info was submitted
		$submitted = false; // If login info was correct
		if( // IF: This is checking for submission of car info
		isset($_POST[style]) && $_POST[style]!="" && 
		isset($_POST[make]) && $_POST[make]!="" && 
		isset($_POST[model]) && $_POST[model]!="" && 
		isset($_POST[color]) && $_POST[color]!="" && 
		isset($_POST[cost]) && $_POST[cost]!=""
		)
		{ $entered = true; }
		else
		{ $entered = false; }
		if( // IF: This is checking for submission of payment info
		isset($_POST[cc]) && $_POST[cc]!="" && 
		isset($_POST[carrier]) && $_POST[carrier]!="" && 
		isset($_POST[ex1]) && $_POST[ex1]!="" && 
		isset($_POST[ex2]) && $_POST[ex2]!="" && 
		isset($_POST[sec]) && $_POST[sec]!=""
		)
		{ $submitted = true; }
		else
		{ $submitted = false; }
		if($entered) { ?>
		<br>Style: <?php echo $_POST[style];?>
		<br>Make: <?php echo $_POST[make];?>
		<br>Model: <?php echo $_POST[model];?>
		<br>Color: <?php echo $_POST[color];?>
		<br>Cost: <?php echo $_POST[cost];?>
		<?php } if($submitted) { ?>
		<br><br>Your order is processing
		<?php } ?>

</div><div class="barMain">
<h2>Enter Payment Info:</h2>
<br>
<div class="bar rental"> <!-- This is toolbar subsection 5: Pattern Insertion -->
<h4>Payment Info:</h4>
<?php if($entered) { ?>
<form name="payment" id="payment" action="cart.php" method="post">
Card No: <input required="true" type="text" id="cc" name="cc" placeholder="1111222233334444" pattern="[0-9]{16}">	
<br>Carrier: <input type="radio" required="true" id="visa" name="carrier" value="visa">
			<label for="visa">Visa</label>
			<input type="radio" id="mastercard" name="carrier" value="mastercard">
			<label for="mastercard">Mastercard</label>
<br>Expiry: <input class="expiry" required="true" type="text" id="ex1" name="ex1" placeholder="04" pattern="[0-9]{2}"><input class="expiry" required="true" type="text" id="ex2" name="ex2" placeholder="2025" pattern="[0-9]{4}">
<br>Security Code: <input class="expiry" required="true" type="text" id="sec" name="sec" placeholder="000" pattern="[0-9]{3}">
<br><input type="submit" value="Submit Payment & Die">
</form>
<?php } else if($submitted) { ?>
Order Placed Successfully! <br><br> Your Order Number is #RC0017421
<?php } else { ?>
Nothing inside your cart!
<?php } ?>
</div>
</div>
</div>
</body>
</html>