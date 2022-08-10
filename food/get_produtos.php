<?php
$response = array();

require_once __DIR__ . '/db_connect.php';

$grupo = $_GET['grupo'];

if($grupo != 0){
    $result = query("SELECT codigo, descricao, precovenda, fracionado, tipo, departamen, grupo FROM produtos where grupo = $grupo and (situacao = 'A')  order by descricao ");
}else{
    $result = query("SELECT codigo, descricao, precovenda, fracionado, tipo, departamen, grupo FROM produtos where (situacao = 'A')  order by descricao "); 
}

if (mysqli_num_rows($result) > 0) {
    
    $response["produtos"] = array();
    
    while ($row = mysqli_fetch_array($result)) {

      $produtos = array();
      
    	$produtos ["codigo"] = $row["codigo"];
		$produtos ["descricao"] = $row["descricao"];
		$produtos ["precovenda"] = $row["precovenda"];
		$produtos ["fracionado"] = $row["fracionado"];
		//$produtos ["codbarras"] = $row["codbarra1"];
        $produtos ["tipo"] = $row["tipo"];

		$grp = $row["grupo"];
		$dep = $row["departamen"];
	    //$produtos ["idGrupo"] = $grp;		
		$produtos ["idDepartamento"] = $dep;
        $produtos ["grupo"] = $grp;
    
        array_push($response["produtos"], $produtos);
    }

    $response["success"] = 1;

    echo json_encode($response);
} else {

    $response["success"] = 0;
    $response["message"] = "Registros nao encontrados";

  
    echo json_encode($response);
}
?>
