<?php
   include('config.php');
//session_start();
   
$url='http://samehisawesome.azurewebsites.net/Api/Database/Initiate';
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_respons = curl_exec($curl);
   
   $un = $_POST['magaca'];
   $up = $_POST['furaha'];
   
		$service_url = 'http://samehisawesome.azurewebsites.net/Api/Customer?UserName='.$un.'&Password='.$up;
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
			
$service_url = 'http://samehisawesome.azurewebsites.net/Api/Customer';

$da = array(
        'CustomerID' => '50',
        'UserName' => $_POST['magaca'],
        'Password' => $_POST['furaha'],
        'SSN' => $_POST['ssn'],
        'Name' => $_POST['name'],
        'Gender' => $_POST['gender'],
        'Age' => $_POST['age']
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
header("location: index.php");
echo "1 record added";
   }
			}	
?> 