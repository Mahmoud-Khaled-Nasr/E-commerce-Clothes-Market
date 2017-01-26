<?php
session_start();
include('../config.php');

$url='http://samehisawesome.azurewebsites.net/Api/Database/Initiate';
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_respons = curl_exec($curl);



$service_url = 'http://samehisawesome.azurewebsites.net/Api/Order';

$da = array(
        'OrderID' => '50',
        'CustomerID' => $_SESSION['cid'],
        'ProductListID' => '2',
        'WarehouseID' => '3',
        'DeliveryID' => '4',
);
//$data=json_encode($da);
$curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($da));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
	
if(isset($response))
{
	if(isset($_SESSION["cart_session"]))
		foreach ($_SESSION["cart_session"] as $cart_itm)
		{
	$service_url = 'http://samehisawesome.azurewebsites.net/Api/Order?OrderID='.$response.'&BarCode='.$cart_itm['code'];
$ch = curl_init($service_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
$data = array("status" => 'R');
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
$response = curl_exec($ch);
if ($response === false) {
    $info = curl_getinfo($ch);
    curl_close($ch);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
}
curl_close($ch);
$decoded = json_decode($response);
if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
    die('error occured: ' . $decoded->response->errormessage);
}
		}
	session_start();
if(session_destroy())
{
 header("location: ../index.php");
 echo "1 payment method has been processed";
}
}

?> 
