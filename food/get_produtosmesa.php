<?php


$response = array();

require_once __DIR__ . '/db_connect.php';

$mesa = $_GET['mesa'];

$result = query("SELECT * FROM mesaitem where mesa = $mesa and chave = 0 order by descricao");
echo 'teste';

if (mysqli_num_rows($result) > 0) {
    
    $response["produtos"] = array();
    
    while ($row = mysqli_fetch_array($result)) {

      $produtos = array();
      
        $produtos ["ordem"] = $row["ordem"];
    	$produtos ["codigo"] = $row["codigo"];
		$produtos ["descricao"] = $row["descricao"];
		$produtos ["obsprod"] = $row["obsprod"];
		$produtos ["quantidade"] = $row["quantidade"];
        $produtos ["vlunitario"] = $row["precodig"];
        $produtos ["vltotal"] = $row["vltotal"];
        $produtos ["datahora"] = $row["datahora"];
        $produtos ["adicional"] = $row["adicional"];
        $produtos ["codvend"] = $row["codvend"];


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
