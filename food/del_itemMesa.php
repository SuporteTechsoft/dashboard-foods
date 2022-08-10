<?php
$response = array();

if (isset($_POST['mesa']) && isset($_POST['cod']) && isset($_POST['ordem'])) {
    
    $mesa = $_POST['mesa'];
    $cod = $_POST['cod'];
    $ordem = $_POST['ordem'];
    
    require_once __DIR__ . '/db_connect.php';
    
    $result = updel("delete from mesaitem WHERE mesa = $mesa and codigo = $cod and ordem = $ordem");

    if ($result) {
        $response["success"] = 1;
        $response["message"] = "Update Realizado com Sucesso.";

        $result = updel("update tabmesas set tsw = 0 where mesa = $mesa");

        if($result){
            echo 'Ok';
        }else{
            echo 'Falha ao atualizar mesa';
        }
        
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