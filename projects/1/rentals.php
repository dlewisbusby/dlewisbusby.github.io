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

<div id="cost2">$0</div>
<br>
<a href="cart.php">
<input type="button" class="login" value="Checkout">
</a>
</div>
<div id="viewport"> <!-- VIEWPORT --> <!-- Bullshit starts here -->
<div class="barMain">
<h2>Welcome to the Car Rental Portal</h2>
Here at Busby Luxury Travel Service we guarantee that you will have a pleasant experience in your rental car. We only offer the very best to our customers. We have over 5 Michelin stars in 17 States, and growing. You will have the time of your life. You will never forget your experience with us. We have never received a complaint from an unhappy customer after driving one of our luxury rental cars.
<br>
<br>By submitting a car rental application via the Busby Luxury Travel Service online car rental web portal, you agree to the following:
<br>
<br>-You have read and agree to <b>ALL</b> conditions
<br>-You are above the age of majority in the country or territory that you are travelling to
<br>-You are licensed to drive in your place of residence
<br>-You are <b>NOT</b> a convinced felon
<br>-Busby Luxury Travel Service and Busby Premium Accident Recovery are <b>NOT</b> liable for any damage, injury, or loss of life caused by your rental
<br>-You assume all responsibility for your actions
<br>-You forfeit all of your posessions
<br>-Stacey is better off without you
<br>-More people voted for Joe Biden than Barack Obama
<br>-You will wear 2 masks at all times
<br>
</div><div class="barMain">
<h2>Enter Car Rental Info:</h2>
<br>
<div class="bar rental"> <!-- This is toolbar subsection 5: Pattern Insertion -->
<h4>Car Info:</h4>
<form name="rentalCar" id="rentalCar" action="cart.php" method="post">
Style: <select name="style" id="bstyle" onchange="styleChange()" required="true">
<option value="" disabled="true" selected="true">Style</option>
<option value="4Door">4 Door</option>
<option value="2Door">2 Door</option>
<option value="SUV">SUV</option>
</select><br>
Make: <select name="make" id="bmake" required="true" onchange="makeChange()">
</select><br>
Model: <select name="model" id="bmodel" required="true" onchange="calcPrice()">
</select><br>
Color: <select name="color" id="bcolor" required="true">
<option value="" disabled="true" selected="true">Color</option>
<option value="Red">Red</option>
<option value="Black">Black</option>
<option value="White">White</option>
</select><br>
<input type="hidden" name="cost" value="">
<input type="submit" value="Add to Cart">
</form>
</div>
<div class="rental">Total Cost: <div id="cost">$0<div></div>
</div>
</div>
</body>
</html>