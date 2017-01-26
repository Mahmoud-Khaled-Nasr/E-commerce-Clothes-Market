<?php 

//include config.php to connect to the database
	include("config.php"); 
	//include("Sign_In");
    //session_start();
$url='http://samehisawesome.azurewebsites.net/Api/Database/Initiate/';
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_respons = curl_exec($curl);
{
	$magaca=$_POST['magaca'];
	$furaha=$_POST['furaha'];
	
			$url = 'http://samehisawesome.azurewebsites.net/Api/Customer?UserName='.$magaca.'&Password='.$furaha;
			$headers = array('Content-Type: application/json');
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			$response = curl_exec($curl);
			$decoded = json_decode($response);
			if(isset($decoded))
			{
				session_start();
				$_SESSION['username']= $decoded->UserName;
				header("location: home.php");
				break;
			}
			else {
				header('Location: Sign_In.php');
			}
		//}
}
?>
