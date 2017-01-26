<?php
session_start();
include("config.php");

$url='http://samehisawesome.azurewebsites.net/Api/Database/Initiate';
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_respons = curl_exec($curl);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<title> ClothesShop Group </title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
		<link rel="stylesheet" href="css/proStyle.css" type="text/css" media="all" />
	 	<link rel="stylesheet" href="css/cart.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="images/favicon.png" />
	<script src="js/jquery-1.6.2.min.js" type="text/javascript" charset="utf-8"></script>

	<script src="js/cufon-yui.js" type="text/javascript"></script>
	<script src="js/Myriad_Pro_700.font.js" type="text/javascript"></script>
	<script src="js/jquery.jcarousel.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/functions.js" type="text/javascript" charset="utf-8"></script>
	
	
		 <!-- Linking scripts -->
    <script src="js/main.js" type="text/javascript"></script>
	
</head>
<body>
	<!-- Begin Wrapper -->
	<div id="wrapper">
		<!-- Begin Header -->
		<div id="header">
			<!-- Begin Shell -->
			<div class="shell">
				<h1 id="logo"><a class="notext" href="#" title="ClothesShop">ClothesShop</a></h1>
				<div id="top-nav">
					<ul>
					<?php
					    if(isset($_SESSION['username']))
						{
							?>
							<li><a href="#" title="Login UserName"> <span class="janan"> <?php echo "Your UserName Is: ". "<i><b>".$_SESSION['username']."</b></i>" ; ?> </span></a></li>
					       <li class="janan"><a href="logout.php"><span class="jananalibritish">Logout </span></a></li>
						<?php
						}
						else {
							?>
						<li><a href="customer.php"" title="Sign Up"><span>Sign Up</span></a></li>
						<li><a href="Sign_In.php" title="Sign In"><span>Sign In</span></a></li>
						<?php
						}
						?>
					</ul>
				</div>
				<div class="cl">&nbsp;</div>
<div class="shopping-cart"  id="cart" id="right" >
<dl id="acc">	
<dt class="active">								
<p class="shopping" >Shopping Cart &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
</dt>
<dd class="active" style="display: block;">
<?php
   //current URL of the Page. cart_update.php redirects back to this URL
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

if(isset($_SESSION["cart_session"]))
{
    $total = 0;
    echo '<ul>';
    foreach ($_SESSION["cart_session"] as $cart_itm)
    {
        echo '<li class="cart-itm">';
        echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>'."</br>";
        echo '<h3  style="color: green" ><big> '.$cart_itm["name"].' </big></h3>';
        echo '<div class="p-code"><b><i>ID:</i></b><strong style="color: #d7565b" ><big> '.$cart_itm["code"].' </big></strong></div>';
		echo '<span><b><i>Shopping Cart</i></b>( <strong style="color: #d7565b" ><big> '.$cart_itm["TiradaProductTiga"].'</big></strong>) </span>';
        echo '<div class="p-price"><b><i>Price:</b></i> <strong style="color: #d7565b" ><big>'.$currency.$cart_itm["Qiimaha"].'</big></strong></div>';
        echo '</li>';
        $subtotal = ($cart_itm["Qiimaha"]*$cart_itm["TiradaProductTiga"]);
        $total = ($total + $subtotal) ."</br>"; 
    }
    echo '</ul>';
    echo '<span class="check-out-txt"><strong style="color:green" ><i>Total:</i> <big style="color:green" >'.$currency.$total.'</big></strong> <a   class="a-btnjanan"  href="view_cart.php"> <span class="a-btn-text">Check Out</span></a></span>';
	echo '&nbsp;&nbsp;<a   class="a-btnjanan"  href="cart_update.php?emptycart=1&return_url='.$current_url.'"><span class="a-btn-text">Clear Cart</span></a>';
}else{
    echo ' <h4>(Your Shopping Cart Is Empty)</h4>';
}
?>

</dd>
</dl>
</div>
 <div class="clear"></div>
			</div>
			<!-- End Shell -->
		</div>
		<!-- End Header -->
	<!-- Begin Navigation -->
		<div id="navigation">
			<!-- Begin Shell -->
			<div class="shell">
				<ul>
					<li class="active"><a href="index.php" title="index.php">Home</a></li>
						<?php
		$service_url = 'http://samehisawesome.azurewebsites.net/Api/Category/';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
			$info = curl_getinfo($curl);
			curl_close($curl);
			die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
			die('error occured: ' . $decoded->response->errormessage);
		}
		echo	'<li>';
		echo	'<a href="products.php">Category</a>';
		echo	'<div class="dd">';
		echo	'<ul>';
		for($i=0;!empty($decoded[$i]);$i++)
        {
			echo	'<li>';
			echo    '<a href="warehouse_1.php"> '.$decoded[$i]->CategoryName.'</a>';				
			echo	'</li>';
		}
		echo	'</ul>';
		echo	'</div>';	
		echo	'</li>';			
		?>
					   <li><a href="products.php"> Products</a></li>
		<?php
		$service_url = 'http://samehisawesome.azurewebsites.net/Api/Brand/';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
			$info = curl_getinfo($curl);
			curl_close($curl);
			die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
			die('error occured: ' . $decoded->response->errormessage);
		}
		echo	'<li>';
		echo	'<a href="products.php">Brand</a>';
		echo	'<div class="dd">';
		echo	'<ul>';
		for($i=0;!empty($decoded[$i]);$i++)
        {
			echo	'<li>';
			echo    '<a href="warehouse_1.php"> '.$decoded[$i]->BrandName.'</a>';				
			echo	'</li>';
		}
		echo	'</ul>';
		echo	'</div>';	
		echo	'</li>';			
		?>
			
					  <li><a href="about.php">About Us</a></li>
				</ul>
				<div class="cl">&nbsp;</div>
			</div>
			<!-- End Shell -->
		</div>
		<!-- End Navigation -->

		<!-- Begin Main -->
		<div id="main" class="shell">
     <br>
	
<div class="viewcart">
 	<?php
    $current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	if(isset($_SESSION["cart_session"]))
    {
	    $total = 0;
		
		echo '<form method="post" action="cart_update.php">';
		echo '<table cellspacing="0">';
			  echo   '<thead>';
		  echo '<tr>';
		  echo '<td>Check:</td>';
		  echo '<td>Product:</td>';
		 echo ' <td>Status:</td>';
		  echo '<td>Price:</td>';
		  //echo '<td>Action:</td>';
		  echo '</tr>';
		  echo '</thead>';
		  
		$cart_items = 0;
		foreach ($_SESSION["cart_session"] as $cart_itm)
        {
           $Product_ID  = $cart_itm["code"];
		   $service_url = 'http://samehisawesome.azurewebsites.net/Api/Product?BarCode='.$Product_ID;
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
			$info = curl_getinfo($curl);
			curl_close($curl);
			die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
			die('error occured: ' . $decoded->response->errormessage);
		}
			$decoded = json_decode($curl_response);
			if(isset($decoded)) { 
		    echo '<tr class="cart-itm">';
            echo '<td><input type="checkbox"></td>';
			echo '<td><h3>'.$decoded->BrandName.' '.$decoded->Size.' '.$decoded->Gender.' (Code :'.$Product_ID.')</h3></td> ';
            
            echo '<td>'.$decoded->ProductStatus.'</td>';
		    echo '<td class="p-price" style="color:green"><b>'.$currency.$decoded->Price.'</b></td>';
			echo '<td><span class="remove-check"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span></td>';
            echo '</tr>';
			$subtotal = ($cart_itm["Qiimaha"]*$cart_itm["TiradaProductTiga"]);
			$total = ($total + $subtotal);

			

			echo '<input type="hidden" name="item_name['.$cart_items.']" value="'.$decoded->Gender.'" />';
			echo '<input type="hidden" name="item_code['.$cart_items.']" value="'.$Product_ID.'" />';
			echo '<input type="hidden" name="item_desc['.$cart_items.']" value="'.$decoded->ProductStatus.'" />';
			echo '<input type="hidden" name="item_qty['.$cart_items.']" value="'.$cart_itm["TiradaProductTiga"].'"/>';
			$cart_items ++;
			      		    }}

    
		echo '<span class="midigta"><a  class="a-btn" href="products.php?emptycart=1&return_url='.$current_url.'"><span class="a-btn-text">Continue Shopping</span></a></span>';
		echo '<span class="check-out-txt">';

    	echo '</table>';
		echo '<span> <h4 class="pricewayn"> Grand Total : <big style="color:green">'.$currency.$total.'</big> </h4></span> ';

		echo '<span class="midigta"> <a  class="a-btn" href="somstore checkout/process.php"> <span class="a-btn-text"> Proceed</span></a></span>';
		echo '</span>';
		echo '</form>'; 

   }else{        
		echo '<span class="wacwayn"><i>Your Cart is empty</i></span>';
	}
	
    ?>
    </div><br><br><br>

			
				<!-- Begin Products Slider -->
			<div id="product-slider">
				<h2>Best Products</h2>
				<ul>
				
				<?php
		  
		 
	    $service_url = 'http://samehisawesome.azurewebsites.net/Api/Product/';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
			$info = curl_getinfo($curl);
			curl_close($curl);
			die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
			die('error occured: ' . $decoded->response->errormessage);
		}
		//echo 'response ok! ';
		//print_r($decoded);
			
        //fetch results set as object and output HTML
        for($i=0;!empty($decoded[$i]);$i++)
        {	
					echo'<li>';
					echo'	<a href="products.php" title="Product Link"><img src="images/prod.jpg"  /></a>';
						echo'<div class="info">';
							echo'<h4><b>'.$decoded[$i]->Gender.'</b></h4>';
							echo'<span class="number"><span>Price:<big style="color:green">'.$currency.$decoded[$i]->Price.'</big></span></span>';
					
							echo'<div class="cl">&nbsp;</div>';
							 
						echo'</div>';
					echo'</li>';
		}
		?>
				</ul>
				<div class="cl">&nbsp;</div>
			</div>
			<!-- End Products Slider -->		
			<br> <br> <br> <br> 
			<!-- Begin Content -->
			<div id="content">
				<div class="post">
					<h2>Welcome!</h2>
					<img src="images/logo.png" alt="Post Image" height="160" width="260"/>
					You can be confident when you're shopping online with ClothesShop. Our Secure online shopping website encrypts your personal and financial information to ensure your order information is protected.We use industry standard 128-bit encryption. Our Secure online shopping website locks all critical information passed from you to us,
                   such as personal information, in an encrypted envelope, making it extremely difficult for this information to be intercepted. </p>
					<div class="cl">&nbsp;</div>
				</div>
			</div>
			<!-- End Content -->

			<div class="cl">&nbsp;</div>
			
			
		</div>
		<!-- End Main -->

	</div>
	<!-- End Wrapper -->
</body>
</html>