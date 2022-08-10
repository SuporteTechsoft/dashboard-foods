<?php
$response = array();

require_once __DIR__ . '/db_connect.php';

$result = query("SELECT * FROM vendedor where pwdmobile <> '' and ativo = 'X' ");


   if (mysqli_num_rows($result) > 0) {
        $response["vendedores"] = array();
    
        while ($row = mysqli_fetch_array($result)) {
            $vds = array();
      
            $vds ["id"] = $row["codigo"];
            $vds ["nome"] = $row["nomered"];
            $vds ["senha"] = $row["pwdmobile"];
        
            array_push($response["vendedores"], $vds);
        }
        
        http_response_code(200);
        $response["success"] = 1;

        echo json_encode($response);
    } else {
        http_response_code(404);
        $response["success"] = 0;
        $response["message"] = "Registros nao encontrados";
  
        echo json_encode($response);
    }


?>