<?php

$response = array();

include 'db_connect.php';

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

if(!isset($mesa)){
   $result = query("SELECT mesa, status, nome, vlpago, vldesconto, mesaprinc FROM tabmesas where mesa <> 0".$fil);
}else{
   $result = query("SELECT mesa, status, nome, vlpago, vldesconto, mesaprinc FROM tabmesas where mesa <> 0 and (mesa like '$mesa%' or nome like '%$mesa%')".$fil);
}


if (mysqli_num_rows($result) > 0) {
    
    $response["mesa"] = array();
    
    while ($row = mysqli_fetch_array($result)) {

      $mesa = array();
      
      $mesa ["mesa"] = $row["mesa"];
      $st   = $row["status"];
      $nome = sanitizeString($row["nome"]);
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
      $mesa ["status"]    = $st;
      $mesa ["pago"]      = $pg;
      $mesa ["desconto"]  = $desc;
      $mesa ["mesaprinc"] = $row["mesaprinc"];
      array_push($response["mesa"], $mesa);

    }
     echo json_encode($response, JSON_UNESCAPED_UNICODE);
}else{
  $response['response'] = array();
  $response['response'] = 'nao encontrada';
  echo json_encode($response);
}
 
function sanitizeString($str) {
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);

    return $str;
}  
?>
