<?php
session_start();
include("config.php");

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<title> ClothesShop Group </title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="images/favicon.png" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
		<link rel="stylesheet" href="css/proStyle.css" type="text/css" media="all" />
	
	 	<link rel="stylesheet" href="css/cart.css" type="text/css" media="all" />
	 <link rel="stylesheet" href="css/chatStyle.css" type="text/css" media="screen" /> 
	 
	 
	 <link rel="stylesheet" href="css/audioplayer.css"  type="text/css" media="screen" />

		<script>
			/*
				VIEWPORT BUG FIX
				iOS viewport scaling bug fix, by @mathias, @cheeaun and @jdalton
			*/
			(function(doc){var addEvent='addEventListener',type='gesturestart',qsa='querySelectorAll',scales=[1,1],meta=qsa in doc?doc[qsa]('meta[name=viewport]'):[];function fix(){meta.content='width=device-width,minimum-scale='+scales[0]+',maximum-scale='+scales[1];doc.removeEventListener(type,fix,true);}if((meta=meta[meta.length-1])&&addEvent in doc){fix();scales=[.25,1.6];doc[addEvent](type,fix,true);}}(document));
		</script>
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
					<li class="active"><a href="home.php" title="Home">Home</a></li>
					
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
		<!-- Begin Slider -->
		<div id="slider">
						<!-- Begin Shell -->
			<div class="shell">
				<ul class="slider-items">
					<li>
						<img src="images/s1.png" alt="Slide Image" />
						<div class="slide-entry">
							<h2><span> Islamic</span> Woman Abaya</h2>
					
							<a href="products.php" class="button" title="Buy now"><span>Buy now</span></a>
						</div>
					</li>
					<li>
						<img src="images/s2.png" alt="Slide Image" />
						<div class="slide-entry">
							<h4><span>Man</span><span class="small"></span>&nbsp;Dresses</h4>
							
							<a href="products.php" class="button" title="Buy now"><span>Buy now</span></a>
						</div>
					</li>
					<li>
						<img src="images/s3.png" alt="Slide Image" />
						<div class="slide-entry">
							<h3><span>Suits</span><span class="small"> And Coats</span></h3> 
					
						
							<a href="products.php" class="button" title="Buy now"><span>Buy now</span></a>
						</div>
					</li>
				
					<li>
						<img src="images/drs.png" alt="Slide Image" />
						<div class="slide-entry">
							<h2><span>Woman</span> Dresses</h2>
						
							<a href="products.php" class="button" title="Buy now"><span>Buy now</span></a>
						</div>
					</li>
				</ul>
				<div class="cl">&nbsp;</div>
				<div class="slider-nav">
					
				</div>
			</div>
			<!-- End Shell -->
		</div>
		<!-- End Slider -->
		<!-- Begin Main -->
		<div id="main" class="shell">
			<!-- Begin Content -->
			<div id="content">
				<div class="post">
						<h2>Welcome!</h2>
					<img src="images/bm.jpg" alt="Post Image" height="160" width="260"/>
					You can be confident when you're shopping online with ClothesShop. Our Secure online shopping website encrypts your personal and financial information to ensure your order information is protected.We use industry standard 128-bit encryption. Our Secure online shopping website locks all critical information passed from you to us,
                   such as personal information, in an encrypted envelope, making it extremely difficult for this information to be intercepted.. <a href="#" class="more" title="Read More">Read More</a></p>
					<div class="cl">&nbsp;</div>
				</div>
			</div>
			<!-- End Content -->
			<!-- Begin Sidebar -->
			<div id="sidebar">
				<ul>
					<li class="widget">
						<h2>TOP Products</h2>
						<div class="brands">
							<ul>
								<li><a href="warehouse_1.php" title="Brand 1"><img src="images/k.png" width="103" height="51" alt="Brand 1" /></a></li>
								<li><a href="warehouse_2.php" title="Brand 2"><img src="images/b.png" width="103" height="51" alt="Brand 2" /></a></li>
								<li><a href="warehouse_3.php" title="Brand 3"><img src="images/ab.png" width="103" height="51" alt="Brand 3" /></a></li>
								<li><a href="warehouse_4.php" title="Brand 4"><img src="images/33.png" width="103" height="51" alt="Brand 4" /></a></li>
							</ul>
							<div class="cl">&nbsp;</div>
						</div>
						<a href="products.php" class="more" title="More Brands">All Products</a>
					</li>
				</ul>
			</div>
			<!-- End Sidebar -->
			<div class="cl">&nbsp;</div>
		<!-- Begin Products -->
			
				<div id="products">
				<h2>Featured Products</h2>

	      <div class="section group">
		  
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
			echo '<div class="grid_1_of_4 images_1_of_4">'; 
            echo '<form method="post" action="cart_update.php">';
			echo '<div class="product-thumb"><img src="images/bm.jpg"></div>';
            echo '<div class="product-content"><h2><b>'.$decoded[$i]->Gender.'</b> </h2>';
            echo '<div class="product-desc">'.$decoded[$i]->ProductStatus.'</div>';
            echo '<div class="product-info">';
			echo '<p><span class="price"> Price:<big style="color:green">'.$currency.$decoded[$i]->Price.'</big></span></p>';
			echo '<div class="button"><span><img src="images/cart.jpg" alt="" /><button class="cart-button"  class="add_to_cart">Add to Cart</button></span> </div>';
			echo '</div></div>';
            echo '<input type="hidden" name="Product_ID" value="'.$decoded[$i]->BarCode.'" />';
            echo '<input type="hidden" name="type" value="add" />';
			echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
            echo '</form>';
            echo '</div>';			
        }
    ?>
    </div>
				<div class="cl">&nbsp;</div>
			</div>
			
			<!-- End Products -->			
			
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
			
		</div>
		<!-- End Main -->
		<!-- Begin Footer -->
		<div id="footer">
			<div class="boxes">
				<!-- Begin Shell -->
				<div class="shell">
					<div class="box post-box">
						<h2>About ClothesShop</h2>
						<div class="box-entry">
							<img src="images/bm.jpg" alt="ClothesShop" width="160" height="80"/>
							<p>You can be confident when you're shopping online with ClothesShop. Our Secure online shopping website encrypts your personal and financial information to ensure your order information is protected.We use industry standard 128-bit encryption. Our Secure online shopping website locks all critical information passed from you to us,
                             such as personal information, in an encrypted envelope, making it extremely difficult for this information to be intercepted. </p>
							<div class="cl">&nbsp;</div>
						</div>
					</div>
					
					<div class="cl">&nbsp;</div>
				</div>
				<!-- End Shell -->
			</div>
			<div class="copy">
				<!-- Begin Shell -->
				<div class="shell">
						<p>&copy; ClothesShop.com. Groups <a href="index.php"><i><font color="fefefe"> Welcome To ClothesShop Online Shopping Site </font></i></a></p>
					<div class="cl">&nbsp;</div>
				</div>
				<!-- End Shell -->
			</div>
		</div>
		<!-- End Footer -->
		
		
	</div>
	<!-- End Wrapper -->
</body>
</html>