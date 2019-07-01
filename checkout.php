<html>
<?php
	session_start();
	include('dbcon.php');
	$_SESSION['haveVisitedCart'] = false;
		$item;
		if(isset($_GET['submitt'])) {
			$item = $_GET['item'];
			$_SESSION['item'] = $item;
			$query = "select * from fooditems where itemname ='".$_SESSION['item'] . "';";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$price = $row['price'];
			}
			#echo $item;
		}

		if(isset( $_POST['submit'])) {
			$item = $_POST['item'];
			$_SESSION['item'] = $item;
			$quantity = 1;
			$query = "select * from fooditems where itemname ='".$_SESSION['item'] . "';";

			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				 while($row = $result->fetch_assoc()) {
				 	$price = $row['price'];
				}
			}
		}
?>

<head>
	<title> CheckOut </title>
	<link rel="stylesheet" type="text/css" href="MyStyle.css">

	 <script>
	    function setQuantity(upordown) {
		    var quantity = document.getElementById('quantity');

		    if (quantity.value > 1) {
		        if (upordown == 'up') {
		        	++document.getElementById('quantity').value;
		        }
		        else if (upordown == 'down'){
		        	--document.getElementById('quantity').value;
		        }}
		    else if (quantity.value == 1) {
		        if (upordown == 'up'){
		        	++document.getElementById('quantity').value;
		        }}
		    else { 
		    	document.getElementById('quantity').value=1;
		    }

		    document.getElementById('quanty').value =document.getElementById('quantity').value ;

		    document.getElementById('price').innerHTML =parseFloat(parseFloat(document.getElementById('quantity').value).toFixed(2)*<?php echo $price ?>).toFixed(2);

		    document.getElementById('price2').value =parseFloat(parseFloat(document.getElementById('quantity').value).toFixed(2)*<?php echo $price ?>).toFixed(2);
		}
		function login() {
			location.href='login2.php';
		}
		function logout() {
			location.href = 'logout.php';
		}
		function check_empty() {
			if (document.getElementById('name').value == "" || document.getElementById('email').value == "" || document.getElementById('msg').value == "") {
				alert("Fill All Fields !");
			}
			else {
				document.getElementById('form').submit();
				alert("Form Submitted Successfully...");
			}
		}
		function div_show() {
			document.getElementById('abc').style.display = "block";
		}
		function div_hide() {
			document.getElementById('abc').style.display = "none";
		}
		function submitForm(e) {
			//document.getElementById('item').value=e;
			//document.getElementById('soupform').submit();
			location.href = 'items.php?type='+e;
		}
		function AddToCart() {
			location.href = 'cart.php?submit=true';
		}
	</script>

	<style type="text/css">
		body{

			background-image: url("../img/checkout.jpg");
			background-size: 100% 100%;
			background-repeat: no-repeat;
			background-attachment: fixed;
		}
	</style>
	

</head>
<body>

	<div id="abc">
		<div id="popupContact">
			<form action="#" id="form" method="post" name="form">
				<img id="close" src="../img/cross.jpg" height="20" width="20" onclick ="div_hide()">
				<h2>Contact Us</h2>
				<hr>
				<input style="border:1px solid #ccc;font-family:raleway;" id="name" name="name" placeholder="Name" type="text">
				<input id="email" name="email" placeholder="Email" type="text">
				<textarea id="msg" name="message" placeholder="Message"></textarea>
				<a href="javascript:%20check_empty()" id="submit">Send</a>
			</form>
		</div>
	</div>
			<form id="soupform" action="items.php" method="POST">
					<input id='item' type="hidden" name="type" value="Soups">
			</form>
	<nav class="menu-bar">
				<li class="navbar-content">
					<div class="dropdown">
					  <button class="dropbtn">Eat & Drink</button>
						  <div class="dropdown-content">
							<a href="javascript:{}" onclick="submitForm('Soups');"> Soups </a>
						  	<a href="javascript:{}" onclick="submitForm('Beverages');">Beverages</a>
						    <a href="javascript:{}" onclick="submitForm('Desserts');">
						  	Desserts & Milkshakes</a>
						</div>
					</div>
				</li>
				<li class="navbar-content">
					<div class="dropdown">
					  <button class="dropbtn">Meals</button>
						  <div class="dropdown-content">
						  <a href="javascript:{}" onclick="submitForm('Breakfast');">Breakfast</a>
						  <a href="javascript:{}" onclick="submitForm('Meals');">Meals & Biryanis</a>
						</div>
					</div>
				</li>
				<li class="navbar-content">
					<div class="dropdown">
					  <button class="dropbtn">INDIAN FOOD</button>
						  <div class="dropdown-content">
						  <a href="javascript:{}" onclick="submitForm('Tamilnadu');">Tamilnadu</a>
						  <a href="javascript:{}" onclick="submitForm('Punjab');"> Punjab</a>
						  <a href="javascript:{}" onclick="submitForm('Bengal');">Bengali</a>
						  <a href="javascript:{}" onclick="submitForm('Karnataka');">Karnataka</a>
						</div>
					</div>
				</li>
				<li class="navbar-content">
					<div class="dropdown">
					  <button class="dropbtn">FOREIGN FOOD</button>
						  <div class="dropdown-content">
						  <a href="javascript:{}" onclick="submitForm('French');">French</a>
						  <a href="javascript:{}" onclick="submitForm('Chinese');">Chinese</a>
						</div>
					</div>
				</li>

				<li class="navbar-content">
					  <button onclick="div_show()" class="dropbtn">CONTACT US</button>
				</li>
				<li class="navbar-content">
					<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']){ ?>
						<button id='logout' name="logout" onclick="logout()" class="dropbtn">Logout</button>
					<?php } else { ?>
							<button id='login' name="login" onclick="login()" class="dropbtn">Login</button>
					<?php } ?>
				</li>

			</nav>
	<div class="confirm-div"> 
		<div class="checkout">
				<div class="content-div">
					<?php 
						$result = $conn->query($query);
						$row = $result->fetch_assoc();
						$price = $row['price'];
						echo "<img class='order-image' src='". $row['img'] . "'' height='300px' width='200px'>"; ?>
					<div id="itemname" style="padding-top: 5%;"> 
						<h1>
							<?php echo $item ?>
						</h1>
						<?php if($row['discount']!=0.00) {

							$price = $price - $price*$row['discount']/100;
						?>
						<h4> Discount of <?php echo $row['discount'] ?> % only for you </h4>
						<h3>Price: <label id="price" style="font-size: 30px;">
							₹<?php echo $price.' '; ?></label>
							<strike> ₹<?php echo $row['price'] ?> </strike>
						</h3>

						<h4> <?php echo $row['discount'] .'% '; ?> off </h4>

						<?php } else ?>
							<h2> Price: ₹<?php echo $row['price']; ?> </h2>

					</div>
			</div>
			<br>
			<div>
			<!--
				<font size="5">Quantity: </font>
				<span id="quantity-field" >
			        <button class="button" id="down" onclick="setQuantity('down');">-</button>
			        <input class="quantity" type="text" id="quantity" value="1">
			        <button class="button" id="up" onclick="setQuantity('up');">+</button>
			    </span>
			    <br>
			   -->
				    <input type="text" name="" maxlength="6" placeholder="enter delivery pincode">
				    <br><b>usually delivered in 3-4 hours</b>
					<center>
						<button class="buy" name="AddToCart" onclick="AddToCart()">Add To Cart</button>
					</center>
			</div>
		</div>
		<div style="float: left; width: 40%;">
				<center><h2>Order </h2> </center>
		</div>
	</div>
	
	
</body>
</html>


