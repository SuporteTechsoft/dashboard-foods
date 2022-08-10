<?php
include 'db_connect.php';

$response = array();

$mesaP = $_POST['mesaprinc'];
$mesaJ = $_POST['mesajuntar'];
$tipo  = $_POST['tipo'];

if ($tipo == 'J'){
    if (isset($mesaP) && isset($mesaJ)) {
        $result = updel("UPDATE tabmesas SET mesaprinc = $mesaP WHERE mesa = $mesaP");
        $result = updel("UPDATE tabmesas SET mesaprinc = $mesaP WHERE mesa = $mesaJ");

        if ($result) {
            $response["success"] = 1;
            $response["message"] = "Update Realizado com Sucesso.";
        
            echo json_encode($response);
        } else {
            $response["success"] = 0;
            $response["message"] = "Deu nao!";
        }
    } else {
        $response["success"] = 0;
        $response["message"] = "Deu nao!";

        echo json_encode($response);    
    }
}else{
    if (isset($mesaP) && isset($mesaJ)) {
        if($mesaP == $mesaJ){
            $result = updel("UPDATE tabmesas SET mesaprinc = 0 WHERE mesaprinc = $mesaP");
        }else{
            $result = updel("UPDATE tabmesas SET mesaprinc = 0 WHERE mesa = $mesaJ");
        }

        if ($result) {
            $result = query('select count(mesa) as numero from tabmesas where mesaprinc = '.$mesaP);
            $row = mysqli_fetch_array($result);
            $x = $row['numero'];
            if ($x == 1){
                echo 'entro';
                $result = updel("UPDATE tabmesas SET mesaprinc = 0 WHERE mesaprinc = $mesaP");  
            }

        } else {
            $response["success"] = 0;
            $response["message"] = "Deu nao!";
        }
    } else {
        $response["success"] = 0;
        $response["message"] = "Deu nao!";

        echo json_encode($response);    
    }
}

?>