<html>
<?php 
	session_start();
	include('dbcon.php');
	$price =0;
	$n = 0;
	if(isset($_GET['submit']) && !$_SESSION['haveVisitedCart']) {
		$item = $_SESSION['item'];
		if(!$_SESSION['loggedin']) {
			header('location: login2.php?item='.$item);
		}
		$_SESSION['haveVisitedCart'] = true;
		$getItem = "select * from fooditems where itemname ='".$_SESSION['item'] . "';";
		$result = $conn->query($getItem);

		if($result->num_rows>0) {
			$fooditem = $result->fetch_assoc();
		}
		$quantity = 1;


		$AddToCart = "insert into cart values('". $_SESSION['username'] . "','".$_SESSION['item']. "'," . $fooditem['price'].",$quantity);";
		$result = $conn->query($AddToCart);

		echo 'Added to cart succesfully';
		$user = $_SESSION['username'];
		$query = "select * from cart where username = $user";
	}
?>
<head>
	<title>Cart</title>
	<link rel="stylesheet" type="text/css" href="MyStyle3.css">
	<script>
	    function setQuantity(upordown,n) {
		    //var quantity = document.getElementById('quantity');
		    var quantity = document.getElementsByClassName('quantity')[n-1];

		    if (quantity.value > 1) {
		        if (upordown == 'up') {
		        	++document.getElementsByClassName('quantity')[n-1].value;
		        }
		        else if (upordown == 'down'){
		        	--document.getElementsByClassName('quantity')[n-1].value;
		        }}
		    else if (quantity.value == 1) {
		        if (upordown == 'up'){
		        	++document.getElementsByClassName('quantity')[n-1].value;
		        }}
		    else { 
		    	document.getElementByClassName('quantity')[n-1].value=1;
		    }

		    var quanty = document.getElementsByClassName('quantity')[n-1].value;
		    var cost = document.getElementsByClassName('original-price')[n-1].innerHTML;
		    

		    document.getElementsByClassName('item-price')[n-1].innerHTML=parseFloat(parseFloat(cost)*quanty).toFixed(2);

		    //const orig = document.getElementsByClassName('orig-price')[n-1].innerHTML;
		    
		    //document.getElementById('price').innerHTML = "1";
		    /*
		    document.getElementById('price').innerHTML = parseFloat(parseFloat(document.getElementById('quantity').value).toFixed(2)*<?php echo $price ?>).toFixed(2);
			*/
		    //document.getElementById('price2').value =parseFloat(parseFloat(document.getElementById('quantity').value).toFixed(2)*<?php echo $price ?>).toFixed(2);
		}
	</script>
</head>

<body>
	<?php
		$getItemsFromCart = "select * from cart where username='".$_SESSION['username']. "';";
		$cartItems = $conn->query($getItemsFromCart);
	?>
	<div class="container">
		<div class="heading">
			<h3 class="My-Cart">My Cart (<?php echo  $cartItems->num_rows ?>)</h3>
		</div>
		<div class="cart-items">
	<?php
		
		if($cartItems->num_rows>0) {
		 	while($itemResults = $cartItems->fetch_assoc()) {
		 		$ItemInfo = "select * from fooditems where itemname='" . $itemResults['itemname']."';"; 
		 		$images = $conn->query($ItemInfo);
		 		$Img = $images->fetch_assoc();
		 		$price = $Img['price'] ;$n++;?>


		 			<!--echo " <div class='cart-item'>
		 				<img src='" . $Img['img'] . "' width='200' height='200'>
		 				<h1> " . $Img['price'] ." </h1>
		 			</div>
		 			";-->
		 			
		 		<div class="item-div">
		 			<div style="float: left;">
		 				<img class="item-img" src="<?php echo $Img['img']; ?>" >
		 			</div>
		 			<div class="item-details" style="float: left;">
		 				<span> <?php echo $Img['itemname'] ?> </span> <br><br>
		 				<font> Seller: Blue Moon Restaurant </font> <br><br>
		 				<?php if($Img['discount']!=0.00) {
							$price = $Img['price'] - $Img['price']*$Img['discount']/100;
						}?>

						<!--<font class="price" style="display:none;"><?php echo $price?></font>
		 				<span id="price" class="item-price">₹<?php  echo $price?> </span>&nbsp&nbsp-->
		 				<!--<span class="item-price">  ₹<?php  echo $Img['price'] ?> </span>-->

		 				<font style="font-size:20px;">₹</font>
		 				<span class="original-price" style="display: none;">
		 					<?php echo $price ?>
		 				</span>

		 				<span class='orig-price' style="display: none;">
		 					<?php echo $Img['price'] ?>
		 				</span>

		 				<span class="item-price"><?php echo $price ?> </span>&nbsp&nbsp
		 				
		 				<?php if($Img['discount']!=0.00) {?>
		 					
		 				<span class='strike' style="opacity: 0.5;text-decoration: line-through;">
		 					₹<?php echo $Img['price'] ?>
		 				</span> <font style="font-size: 20px;"> /Item </font>&nbsp&nbsp

		 				<span class="discount">
							<?php echo $Img['discount'] ?>% Off
						</span>
		 				<?php } ?>
		 				
		 				<br><br>
		 				<font size="3">Quantity: </font>
						<span id="quantity-field" >
					        <button class="quantity-button" id="down" onclick="setQuantity('down',<?php echo $n ?>);">-</button>
					        <input class="quantity" type="text" id="quantity" value="1">
					        <button class="quantity-button" id="up" onclick="setQuantity('up',<?php echo $n ?>);">+</button>
					    </span>
		 			</div>
		 		</div>
		 		<?php }}
		 			else {
		 				echo "Cart Is Empty";
		 			}
				?>
			<div class="Options-div">
				<button class="Continue" onclick="conShop()"><span class="continue-span">
					Continue Shopping</span>
				</button>
				<button class="Place-Order"> <span class="order-span">Place Order</span></button>
			</div>
	</div>
		<footer>Policies:Return Policy|Terms of use|Security</footer>
	</div>
</body>
</html>