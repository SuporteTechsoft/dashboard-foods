<?php

$response = array();

require_once __DIR__ . '/../db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT);

$result = query("SELECT * FROM grupopro where exibeapp = 0");

if(isset($result)){
    if (mysqli_num_rows($result) > 0) {
        $response["categoria"] = array();

        while ($row = mysqli_fetch_array($result)) {
            $categoria = array();

            $categoria ["codigo"] = $row["codigo"];
            $categoria ["categoria"] = $row["descricao"];
            $categoria ["exibe"] = $row["exibeapp"];

            array_push($response["categoria"], $categoria);
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

?>
