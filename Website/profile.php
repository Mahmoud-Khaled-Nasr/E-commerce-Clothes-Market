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
         <link rel="shortcut icon" href="images/favicon.png" />
		<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
		<link rel="stylesheet" href="css/proStyle.css" type="text/css" media="all" />
	   
	 	<link rel="stylesheet" href="css/cart.css" type="text/css" media="all" />
	
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
						<li><a href="#" title="Login Email"> <span class="janan"> <?php echo "Your Email Is: ". "<i><b>".$_SESSION['username']."</b></i>" ;?> </span></a></li>
						
						
					       <li class="janan"><a href="logout.php"><span class="jananalibritish">Logout </span></a></li>
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
    echo ' <h4>(Your Shopping Cart Is Empty!!!)</h4>';
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
					
					<li><a href="profile.php" title="Profile">Profile</a></li>
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

         <br> <br>
			<!-- Begin Content -->
			<div id="content">
				<div class="post">
					<h2>Welcome!</h2>
					<img src="images/bm.png" alt="Post Image" height="160" width="260"/>
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
			<h2>Customer Information</h2>
						<div class="brands">
		 <div id="form_wrapper" class="form_wrapper">	
		<table>	
			   <tr> 		 
               <?php  
		$username = $_SESSION['username'];
		//$password = $_SESSION['password'];
		
		
		$service_url = 'http://samehisawesome.azurewebsites.net/Api/Customer';
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
			if($decoded[$i]->UserName==$username)
        {
		      ?> 
			
				 
                 <td><input name="username" type="hidden" id="namebox" value="<?php echo $decoded[$i]->CustomerID  ?>"/></td></tr> 
			  <tr> 
				  
                <td>  <label>Name:</label><input name="firstname"  type="text" id="namebox" value=" <?php echo $decoded[$i]->Name?> "/></td></tr> 
		       <tr> 
				  
               <td> <label>User Name:</label><input name="lastname"  type="text" id="namebox" value="<?php echo $decoded[$i]->UserName ?>"/></td></tr> 
			 <tr> 
				  
			 <td> <label>Password:</label><input name="password"  type="text" id="namebox" value=" <?php echo $decoded[$i]->Password ?>"/></td></tr> 
			  <tr> 
				  
                 <td> <label>SSN:</label><input name="ssn"  type="text" id="namebox" value="<?php echo $decoded[$i]->SSN ?>"/></td></tr> 
                   <tr> 
				   
                <td> <label>Gender:</label> <input name="gender"  type="text" id="namebox" value="<?php echo $decoded[$i]->Gender ?>"/></td></tr> 
				  <tr> 
				 
				  
                <td> <label>Age:</label> <input name="age"  type="text" id="namebox" value="<?php echo $decoded[$i]->Age ?>"/></td></tr> 
				 
				  
					<?php  
					$_SESSION['cid']=$decoded[$i]->CustomerID;
					} ?>
			</table> 
		
		 </div> 
			
		<div class="cl">&nbsp;</div>
						</div>
						
					</li>
				</ul>
			</div>
			<!-- End Sidebar -->
			<div class="cl">&nbsp;</div>
			
			

			
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

	</div>
	<!-- End Wrapper -->
</body>
</html>