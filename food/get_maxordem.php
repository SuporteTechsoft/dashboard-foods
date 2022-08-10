<?php
$response = array();
include 'db_connect.php';

$mesa = $_GET['mesa'];		

if(isset($mesa)){
	$result = query("SELECT max(ordem) as ordem FROM mesaitem where mesa = ".$mesa);	
}else{
	$result = query("SELECT max(ordem) as ordem FROM mesaitem");
}
$retorno = array();
       
if (mysqli_num_rows($result) > 0){
   $row = mysqli_fetch_array($result);
   $x = $row['ordem'];
   if($x != null){
   	  $retorno['ordem'] = $x;
   }else{
   	  $retorno['ordem'] = 0;
   }    

}else{
   $retorno['ordem'] = 0;
}
echo json_encode($retorno);
  
?>
