<?php
include 'db_connect.php';
$response = array();
 
$empresa = false;
if(isset($_GET['empresa'])){
	$empresa = $_GET['empresa'];	
}

$response["status"] = "alive";
if($empresa == 'true'){
	try{
		$result = query("SELECT valor FROM cfgini where secao = 'Empresa' and ident = 'Nome'");
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_array($result);
			$response["empresa"] = $row['valor'];
		}
	}catch(\Exception $e){
		$response["empresa"] = '';
	}
}

echo json_encode($response);
?>
