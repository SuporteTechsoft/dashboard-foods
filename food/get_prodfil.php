<?php
$response = array();

require_once __DIR__ . '/db_connect.php';
$filtro = $_GET['filtro'];

$result = query("SELECT * FROM produtos where (situacao = 'A') and descricao like '%$filtro%' ");

if (mysqli_num_rows($result) > 0) {
    
    $response["produtos"] = array();
    
    while ($row = mysqli_fetch_array($result)) {

      $produtos = array();
      
    	$produtos ["codigo"] = $row["codigo"];
		$produtos ["descricao"] = $row["descricao"];
		$produtos ["precovenda"] = $row["precovenda"];
    
        array_push($response["produtos"], $produtos);
    }

    $response["success"] = 1;

    echo json_encode($response);
} else {

    $response["success"] = 0;
    $response["message"] = "Registros nao encontrados";

  
    echo json_encode($response);
}
?>
