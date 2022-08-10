<?php
$response = array();

require_once __DIR__.'/../db_connect.php';

$prod = $_GET['codigo'];

if($prod > 0){
    $result = query("SELECT codauxili2, descricao FROM produtos where codigo = $prod and tipo = 'P'");

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_array($result);
        $ref = $row["codauxili2"];
        $nome = $row["descricao"];

        $sql = "SELECT codigo, descricao, precovenda, fracionado, tipo, departamen FROM produtos where codauxili2 = '$ref' and (situacao = 'A')  and tipo = 'M' order by descricao";
        $result2 = query($sql);
    
        $pizza = true;
        $adc = true;

        $response["produtos"] = array();
        if (mysqli_num_rows($result2) > 0) {
           
            while ($row2 = mysqli_fetch_array($result2)) {
                $produtos = array();

                $produtos ["codigo"] = $row2["codigo"];
                $produtos ["descricao"] = trim(str_replace($nome, "", $row2["descricao"]));
                $produtos ["precovenda"] = $row2["precovenda"];
                $produtos ["fracionado"] = $row2["fracionado"];
    
                $produtos ["tipo"] = $row2["tipo"];
                $dep = $row2["departamen"];
      
                $produtos ["idDepartamento"] = $dep;
    
                array_push($response["produtos"], $produtos);
            } 

        }else{
            $pizza = false;
        }

        $sql = "SELECT P.codigo, P.descricao, P.precovenda, C.* FROM produtos P, itensadc C WHERE P.codigo = C.item and C.produto = $prod order by descricao";
        $result2 = query($sql);

        $response["adicionais"] = array();
        if (mysqli_num_rows($result2) > 0) {
    
            while ($row2 = mysqli_fetch_array($result2)) {
               $adc = array();
      
               $adc ["codigo"] = $row2["codigo"];
               $adc ["descricao"] = $row2["descricao"];
               $adc ["precovenda"] = $row2["precovenda"];
               $adc ["tipo"] = "A";
               $adc ["fracionado"] = ""; 
               $adc ["idDepartamento"] = "0"; 

               array_push($response["adicionais"], $adc); 
            }

        }else{
            $adc = false;
        }

        if($pizza || $adc){
           echo json_encode($response);
        }else{
           $response["success"] = 0;
           $response["message"] = "Registros nao encontrados";

           echo json_encode($response); 
        }

    }else{
        $response["success"] = 0;
        $response["message"] = "Registros nao encontrados";

        echo json_encode($response);
    }
      
}else{
    $response["success"] = 0;
    $response["message"] = "Registros nao encontrados";

    echo json_encode($response);
}

?>