<?php

require_once __DIR__ . '/db_connect.php';
$response = array();

if (isset($_GET['mesa'])) {
    
    $mesa = $_GET['mesa'];
    $vend = (isset($_GET["vend"]) && $_GET["vend"] != null) ? $_GET["vend"] : "";

    if($vend == ""){
        $result = updel("UPDATE tabmesas SET comando = 'C', status = 'F', tsw = '0' WHERE mesa = $mesa");
    }else{
        $result = updel("UPDATE tabmesas SET comando = 'C', status = 'F', tsw = '0', obs = '$vend' WHERE mesa = $mesa");
    }

    if ($result) {
        $response["success"] = 1;
        $response["message"] = "Update Realizado com Sucesso.";
        
        echo json_encode($response);
    } else {
        $response["success"] = 0;
        $response["message"] = "Deu nao!";
        $response["error"] = $result;

        echo json_encode($response); 
    }
} else {
    
    $response["success"] = 0;
    $response["message"] = "Deu nao nem entro!";
    $response["error"] = $result;

    echo json_encode($response);
}
?>