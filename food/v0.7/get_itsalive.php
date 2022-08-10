<?php

require_once __DIR__.'/../db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT);

$response = array();
$response["API"] = "alive";

try{
	$result = query("select count(codigo) from vendedor");
}catch(mysqli_sql_exception $e){
	echo $e -> getMessage();
}


if(!isset($result)){
	http_response_code(500);
	$response["BANCO"] = "not alive (banco de bados incorreto ou arquivo api nao configurado)";
}else{
	http_response_code(200);
	$response["BANCO"] = "alive";
}

echo json_encode($response);
?>
