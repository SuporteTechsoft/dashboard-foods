<?php

$response = array();

if (isset($_POST['id'])) {
    
    $id = $_POST['id'];
    $nome = strtoupper($_POST['nome']);
   
    require_once __DIR__ . '/db_connect.php';

    $result = updel("UPDATE tabmesas SET nome = '$nome', tsw = '0' WHERE mesa = $id");

    if ($result) {
        $response["success"] = 1;
        $response["message"] = "Update Realizado com Sucesso.";
        
        echo json_encode($response);
    } else {
        
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Deu nao!";

    echo json_encode($response);
}
?>