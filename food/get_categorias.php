<?php

$response = array();

require_once __DIR__ . '/db_connect.php';

$result = query("SELECT * FROM grupopro where exibeapp = 0 order by descricao");

if (mysqli_num_rows($result) > 0) {
    
    $response["categoria"] = array();
    
    while ($row = mysqli_fetch_array($result)) {

      $categoria = array();
      
        $categoria ["codigo"] = $row["codigo"];
      	$categoria ["categoria"] = $row["descricao"];
        $categoria ["exibe"] = $row["exibeapp"];

        array_push($response["categoria"], $categoria);
    }

    $response["success"] = 1;

    echo json_encode($response);
} else {

    $response["success"] = 0;
    $response["message"] = "Registros nao encontrados";

  
    echo json_encode($response);
}
?>
