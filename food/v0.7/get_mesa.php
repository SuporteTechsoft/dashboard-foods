<?php

$response = array();

require_once __DIR__.'/../db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT);

if(isset($_GET['mesa']) && isset($_GET['status'])){
   $mesa = $_GET['mesa'];
   $status = $_GET['status'];

   if(!isset($status) || $status == "T"){
     $fil = '';
   }else{
     if($status == "L"){
       $fil = " and status = '".$status."' and mesaprinc = 0" ;
     }else{
       $fil = " and (status = 'O' or status = 'F' or mesaprinc <> 0) " ;
     }
   }

   if(isset($mesa)){
     $sql = "SELECT mesa, status, nome, vlpago, vldesconto, mesaprinc FROM tabmesas where mesa <> 0".$fil;
     $result = query($sql);
   }else{
     $sql = "SELECT mesa, status, nome, vlpago, vldesconto, mesaprinc FROM tabmesas where mesa <> 0 and (mesa like '$mesa%' or nome like '%$mesa%')".$fil;
     $result = query($sql);
   }

    if(isset($result)){
     if (mysqli_num_rows($result) > 0) {

      $response["mesa"] = array();

      while ($row = mysqli_fetch_array($result)) {

        $mesa = array();

        $mesa ["numero"] = $row["mesa"];
        $st   = $row["status"];
        $nome = $row["nome"];
        $pg   = $row["vlpago"];
        $desc = $row["vldesconto"];

        if($st == 'L' && $nome == null){
          $nome = "Livre";  
        }
        if($st == 'O' && $nome == null){
          $nome = "Ocupado";  
        }

        if($pg == null) $pg = 0;

        $mesa ["nome"]      = $nome;
        $mesa ["situacao"]  = $st;
        $mesa ["vlPago"]    = $pg;
        $mesa ["desconto"]  = $desc;
        $mesa ["mesaprinc"] = $row["mesaprinc"];
        array_push($response["mesa"], $mesa);

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
