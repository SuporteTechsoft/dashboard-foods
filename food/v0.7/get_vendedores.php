<?php
$response = array();

require_once __DIR__.'/../db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT);

if(isset($_GET['versao'])){
    $v = $_GET['versao'];


    if($v == version){
        $result = query("SELECT * FROM vendedor where pwdmobile <> '' and ativo = 'X' ");

        if(isset($result)){
            if (mysqli_num_rows($result) > 0) {
                $response["vendedores"] = array();

                while ($row = mysqli_fetch_array($result)) {
                    $vds = array();

                    $vds["id"] = $row["codigo"];
                    $vds["nome"] = $row["nomered"];
                    $vds["senha"] = $row["pwdmobile"];

                    array_push($response["vendedores"], $vds);
            }

                http_response_code(200);
                echo json_encode($response);
            } else {
                http_response_code(404);
                echo msgHttp404();
            }
        }else{
            http_response_code(500);
            echo msHttp500();
        }
    }else{
        http_response_code(505);
        echo msgHttp505();
    }
    
}else{
   http_response_code(400);
   echo msgHttp400();
}

?>