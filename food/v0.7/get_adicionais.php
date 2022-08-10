<?php

$response = array();

require_once __DIR__ . '/../db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT);

if(isset($prod)){
    $result = query("SELECT distinct * FROM itensadc where produto = $prod ");
    
    if(isset($result)){
        if (mysqli_num_rows($result) > 0) {
            $response["adcs"] = array();

            while ($row = mysqli_fetch_array($result)) {
                $item = $row["item"];
                $result2 = query("SELECT distinct * FROM produtos where codigo = $item and situacao = 'A'");
                if (mysqli_num_rows($result) > 0) {
                    $produtos = array();

                    while ($row2 = mysqli_fetch_array($result2)) {
                        $produtos ["codigo"] = $row2["codigo"];
                        $produtos ["descricao"] = $row2["descricao"];
                        $produtos ["precovenda"] = $row2["precovenda"];

                        array_push($response["adcs"], $produtos);
                    }

                }      
            }
            http_response_code(200);
            echo json_encode($response);

        }else{
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

  
?>
