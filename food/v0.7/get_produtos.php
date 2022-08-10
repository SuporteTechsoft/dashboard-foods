<?php
$response = array();

require_once __DIR__.'/../db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT);

if(isset($_GET['grupo'])){
   $grupo = $_GET['grupo'];

   if($grupo != 0){
        $result = query("SELECT codigo, descricao, precovenda, fracionado, tipo, departamen, tamcompalm FROM produtos where grupo = $grupo and (situacao = 'A') and (tipo = 'N' or tipo = 'P') order by descricao ");
   }else{
        $result = query("SELECT codigo, descricao, precovenda, fracionado, tipo, departamen, tamcompalm FROM produtos where (situacao = 'A') and (tipo = 'N' or tipo = 'P') order by descricao "); 
   }

   if(isset($result)){
       if (mysqli_num_rows($result) > 0) {
            $response["produtos"] = array();
    
            while ($row = mysqli_fetch_array($result)) {
                $produtos = array();
        
                $produtos ["codigo"] = $row["codigo"];
                $produtos ["descricao"] = $row["descricao"];
                $produtos ["precovenda"] = $row["precovenda"];
                $produtos ["fracionado"] = $row["fracionado"];

                $tam = $row["tamcompalm"];
                if($tam == null){
                   $tam = 0; 
                }
                $produtos ["tamanho"] = $tam;
                $produtos ["tipo"] = $row["tipo"];

                $dep = $row["departamen"];
                $produtos ["idDepartamento"] = $dep;

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

?>
