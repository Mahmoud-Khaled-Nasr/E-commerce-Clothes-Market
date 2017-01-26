<?php
session_start();
include("../config.php");

$url='http://samehisawesome.azurewebsites.net/Api/Database/Initiate';
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_respons = curl_exec($curl);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<title> ClothesShop Groups </title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	   <link rel="shortcut icon" href="images/favicon.png" />
		<link rel="stylesheet" href="../css/style.css" type="text/css" media="all" />
		<link rel="stylesheet" href="../css/proStyle.css" type="text/css" media="all" />
	   	<link rel="stylesheet" href="../css/userlogin.css" type="text/css" media="all" />
	 	<link rel="stylesheet" href="../css/cart.css" type="text/css" media="all" />
	
	<script src="../js/jquery-1.6.2.min.js" type="text/javascript" charset="utf-8"></script>

	<script src="../js/cufon-yui.js" type="text/javascript"></script>
	<script src="../js/Myriad_Pro_700.font.js" type="text/javascript"></script>
	<script src="../js/jquery.jcarousel.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/functions.js" type="text/javascript" charset="utf-8"></script>
	
		 <!-- Linking scripts -->
     <script src="../js/jquery.js" type="text/javascript"></script>  
    <script src="../js/main.js" type="text/javascript"></script>
	
	
	        <link rel="stylesheet" href="../css/PaymentStyle.css" type="text/css" media="screen"/>
		   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
          <script type="text/javascript" src="../js/sliding.form.js"></script>
</head>

<style>
        span.reference{
            position:fixed;
            left:5px;
            top:5px;
            font-size:10px;
            text-shadow:1px 1px 1px #fff;
        }
        span.reference a{
            color:#555;
            text-decoration:none;
			text-transform:uppercase;
        }
        span.reference a:hover{
            color:#000;
            
        }
        h1{
            color:#ccc;
            font-size:36px;
            text-shadow:1px 1px 1px #fff;
            padding:20px;
        }
    </style>
	<?php 
	if(isset($_SESSION['username']))
	{
	?>
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
					
						<li><a href="#" title="Login UserName"> <span class="janan"> <?php echo "Your UserName Is: ". "<i><b>".$_SESSION['username']."</b></i>" ; ?> </span></a></li>
					       <li class="janan"><a href="../logout.php"><span class="jananalibritish">Logout </span></a></li>
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
					<li class="active"><a href="../index.php" title="index">Home</a></li>
					
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
		echo	'<a href="../products.php">Category</a>';
		echo	'<div class="dd">';
		echo	'<ul>';
		for($i=0;!empty($decoded[$i]);$i++)
        {
			echo	'<li>';
			echo    '<a href="../warehouse_1.php"> '.$decoded[$i]->CategoryName.'</a>';				
			echo	'</li>';
		}
		echo	'</ul>';
		echo	'</div>';	
		echo	'</li>';			
		?>
					   <li><a href="../products.php"> Products</a></li>
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
		echo	'<a href="../products.php">Brand</a>';
		echo	'<div class="dd">';
		echo	'<ul>';
		for($i=0;!empty($decoded[$i]);$i++)
        {
			echo	'<li>';
			echo    '<a href="../warehouse_1.php"> '.$decoded[$i]->BrandName.'</a>';				
			echo	'</li>';
		}
		echo	'</ul>';
		echo	'</div>';	
		echo	'</li>';			
		?>
					  <li><a href="../about.php">About Us</a></li>
				</ul>
				<div class="cl">&nbsp;</div>
			</div>
			<!-- End Shell -->
		</div>
		<!-- End Navigation -->

		<!-- Begin Main -->
		<div id="main" class="shell">
			
			<!-- Begin Content -->
			<div id="content">
			
			<br><br>
			
			        <div id="kcontent">
            <h1> ClothesShop Payment Method</h1>
            <div id="wwrapper">
                <div id="steps">
				
                    <form id="formElem" name="formElem"  action="InsertPayment.php" method="POST" class="myForm">
					
					
						<fieldset class="step">
                            <legend>Confirm
	<?php
   //current URL of the Page. cart_update.php redirects back to this URL
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    
if(isset($_SESSION["cart_session"]))
{
    $total = 0;
    echo '<ol>';
    foreach ($_SESSION["cart_session"] as $cart_itm)
    {
    
        $subtotal = ($cart_itm["Qiimaha"]*$cart_itm["TiradaProductTiga"]);
        $total = ($total + $subtotal) ."</br>"; 
    }
    echo '</ol>';
    echo '<h4 Align="right">Your Total Amount: <big style="color:green">'.$currency.$total.'</big></h4>';

}else{

}
?>
							</legend>
							<p>
								Sumbit the order.
							</p>
                            <p class="submit">
							
                                <button id="registerButton" type="submit"   name="submit"  title="Click On Payment Method"> Proceed</button>
                            </p>
                        </fieldset>
                    </form>
                </div>
                <div id="nav" style="display:none;">
                    <ul>
                        <li class="doortay">
                            <a href="#">Confirm</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
		
		
		
 <script>
<script type="text/javascript">

$(document).ready(function(){ 
    $("#registerButton").click(function() { 
     
        $.ajax({
        cache: false,
        type: 'POST',
        url: 'InsertPayment.php',
        data: $(".myForm").serialize(),
        success: function(d) {
            $("#someElement").html(d);
        }
        });
    }); 
});

</script>	
		
			</div>
			<!-- End Content -->
			
			
	
	
			
			
			
			
			<!-- Begin Sidebar -->
			<div id="sidebar">
				<ul>
					<li class="widget">
						<h2>TOP Brands</h2>
						<div class="brands">
							<ul>
								<li><a href="#" title="Brand 1"><img src="../images/brand-img1.jpg" alt="Brand 1" /></a></li>
								<li><a href="#" title="Brand 2"><img src="../images/brand-img2.jpg" alt="Brand 2" /></a></li>
								<li><a href="#" title="Brand 3"><img src="../images/brand-img3.jpg" alt="Brand 3" /></a></li>
								<li><a href="#" title="Brand 4"><img src="../images/brand-img4.jpg" alt="Brand 4" /></a></li>
							</ul>
							<div class="cl">&nbsp;</div>
						</div>
					</li>
				</ul>
			</div>
			
			<?php 
			
			} 
	
	else {        
		//echo '<span class="wacwayn"><p>Please Sign In or Sign Up first</p></span>';
		echo '<span class="wacwayn"><p href="../view_cart.php" title="index">Please Sign In or Sign Up first</p></span>';
	}
	
	?>
			
			<!-- End Sidebar -->
			<div class="cl">&nbsp;</div>
			<br><br>
	        <div class="post">
					<h2>Welcome!</h2>
					<img src="../images/bm.png" alt="Post Image" />
					<p>You can be confident when you're shopping online with ClothesShop. Our Secure online shopping website encrypts your personal and financial information to ensure your order information is protected.We use industry standard 128-bit encryption. Our Secure online shopping website locks all critical information passed from you to us,
                   such as personal information, in an encrypted envelope, making it extremely difficult for this information to be intercepted. </p>
					<div class="cl">&nbsp;</div>
				</div>
		</div>
		<!-- End Main -->

			<div class="boxes">
			
			<div class="copy">
				<!-- Begin Shell -->
				<div class="shell">
					<div class="carts">
						
					</div>	<p align="center">&copy; ClothesShop.com. Groups <a href="index.php"><i><font color="fefefe"> Welcome To <strong> ClothesShop</strong> Online Shopping Site </font></i></a></p>
					<div class="cl">&nbsp;</div>
				</div>
				<!-- End Shell -->
			</div>
		</div>

	<!-- End Wrapper -->
</body>
</html>