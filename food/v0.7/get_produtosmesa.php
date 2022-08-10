<?php

$response = array();

require_once __DIR__ . '/../db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT);

if(isset($_GET['mesa'])){
    $mesa = $_GET['mesa'];

    if($mesa > 0){
        $result = query("SELECT * FROM mesaitem where mesa = $mesa order by descricao");

        if(isset($result)){
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

                http_response_code(200);
                echo json_encode($response);
            } else {
                http_response_code(404);
                echo msgHttp404();
            }
        }else{
            http_response_code(500);
            echo msgHttp500();
        }
    }else{
       http_response_code(400);
       echo msgHttp400(); 
    }
    
}else{
    http_response_code(400);
    echo msgHttp400();
}


?>
