<?php
require_once __DIR__ . '/db_connect.php';

$duplicado = false;

$p = $_POST['produtos'];
gravaLog('teste', $p);
$json = false;

if(!isset($p)){
   $p = json_decode(file_get_contents('php://input'), true);
   $p = $p['produtos'];
   $json = true;
}

if(isset($p)){
    $produtos = array();
    $adicionais = array();
    $composicao = array();

    if($json){
       $produtos = $p;
    }else{
       $produtos = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $p), true);
    }
       $x = 1;
    //var q problema na supimpa
    $q = 1;

    $aux = $produtos[0];
    $m = $aux["mesa"];

    $q = query("SELECT mesaprinc FROM tabmesas WHERE mesa = ".$m);

    if(isset($q)){
        
        $t = mysqli_fetch_array($q);
        $princ =  $t["mesaprinc"];

        if($princ == 0){
            $certo = true;
            $ordem = maxordem($m);
            $controle = getControle($m);
        }else{
            $certo = false;
            $ordem = maxordem($princ);
            $controle = getControle($princ);
        }
    } 

    $chave = 0;

    $sql = "INSERT INTO mesaitem(mesa, ordem, codigo, descricao, obsprod, quantidade, vlunitario, precodig, vltotal, datahora, departamen, tsw, adicional, codvend, comiss, composic, controle) VALUES";

    foreach($produtos as $prd => $i) {
        $pp = $i["codigo"];
        $adcComp = False;

        $ordem = $ordem + 1;

        if($certo){
            $mesa = $i["mesa"];
        }else{
            $mesa = $princ;
        }

        $ordem = $ordem;
        $codigo = $i["codigo"];
        $descricao = $i["descricao"];
        $obs = $i["obsprod"];
        $departament = $i["departament"];
        $quant = $i["quantidade"];
        $valu = $i["vlunitario"];
        $vt = $i["vltotal"];
        $tsw = $i["tsw"];
        $dt = $i["datahora"];
        $cdVend = $i["codvend"];

        $result2 = query("SELECT EXISTS (SELECT * FROM mesaitem WHERE codigo = $codigo AND datahora = '$dt' AND mesa = $mesa) as existe");
        if (mysqli_num_rows($result2) > 0) {
            $exist = 0;
            while ($r = mysqli_fetch_array($result2)) {
                $exist = $r['existe'];
            }
            if($exist == 0){
                $adicionais = $i["adicionais"];
                $composicao = $i["composicao"];
                if(count($adicionais) > 0 || count($composicao) > 0){
                    $chave = gravarAdicionais($composicao, $adicionais, $codigo);
                   // echo $chave;
                }

                if($x == 1){
                    $sql =  $sql."('$mesa', '$ordem', '$codigo', '$descricao', '$obs', '$quant', '$valu', '$valu', '$vt', '$dt', '$departament', '$tsw', '0', '$cdVend', 'S', '$chave', '$controle')";
                }else{
                    $sql =  $sql.", ('$mesa', '$ordem', '$codigo', '$descricao', '$obs', '$quant', '$valu', '$valu', '$vt', '$dt', '$departament', '$tsw', '0', '$cdVend', 'S', '$chave', '$controle')";
                }
                
                 $x = $x + 1;         
                 $chave = 0;
            }else{
                $log = 'Produto '.$codigo.' - '.$descricao.' possivelmente duplicado, data: '.$dt.' mesa: '.$mesa;
                gravaLog($log, 'VERIFICACAO');
                $duplicado = true;
            }
        } 
        
       } 	

    if($duplicado){
        echo 'DUPLICIDADE 1';
    }else{

        $result = updel($sql.";");
        if($result){
            echo "TRUE MesaItem";
        }else{
            echo $result;
        }
   
        updel("update tabmesas set status = 'O', controle = '$controle', tsw = 0 where mesa = ".$mesa);
    }
       
}else{
    echo "deu n";
}

function getControle($mesa){
    $sql = "select controle from tabmesas where mesa =".$mesa;
    $result = query($sql);
    $row = mysqli_fetch_array($result);

    if(isset($row['controle']) && $row['controle'] != 0){
       $controle = $row['controle'];
    }else{
       date_default_timezone_set('America/Sao_Paulo');
       $date = date('YmdHis');
       $controle = $mesa.$date;
    }
    return $controle;
}

function maxordem($mesa){
    $slqOrdem = "select max(ordem) as max from mesaitem where mesa =".$mesa;
    $result = query($slqOrdem);
    $row = mysqli_fetch_array($result);

    if(isset($row['max'])){
       $o = $row['max'];
    }else{
       $o = 0;
    }
    return $o;
}

function gravarAdicionais($composicao, $adicionais, $pp){
    $s = "INSERT INTO itenscomp(chave, codigo, descricao, quantidade, vlunitario, tipo, datahora, prodprinc) VALUES";

    $chv = maxchave();

    $c = 0;
    if(count($composicao) > 0){    
        foreach ($composicao as $comp => $cp) {
            $codigo = $cp["codigo"];
            $desc   = $cp["descricao"];
            $quant  = $cp["quantidade"];
            $vlunt  = $cp["vlunitario"];
            $dth    = $cp["datahora"];
            $tipo   = "P";

            if($c > 0){
                $s = $s.", ";
            }

            $s = $s."('$chv', '$codigo', '$desc', '$quant', '$vlunt', '$tipo', '$dth', '$pp')";
            $c++;
        }
    }

    
    if(count($adicionais) > 0){
        if($c > 0){
            $s = $s.", ";
        }
        $c = 0;
        foreach ($adicionais as $adcs => $a) {
            $codigo = $a["codigo"];
            $desc   = $a["descricao"];
            $quant  = $a["quantidade"];
            $vlunt  = $a["vlunitario"];
            $dth    = $a["datahora"];
            $tipo   = "A";

            if($c > 0){
                $s = $s.", ";
            }

            $s = $s."('$chv', '$codigo', '$desc', '$quant', '$vlunt', '$tipo', '$dth', '$pp')";
            $c++;
        }
    }      
    

    $result = updel($s.";");
    if($result){
        return $chv;
    }else{
        return 0;
    }  
}

function maxchave(){
    $sql = "select max(chave) as max from itenscomp where chave > 999000000";
    $result = query($sql);
    $row = mysqli_fetch_array($result);

    if(isset($row['max'])){
       $o = $row['max'] + 1;
    }else{
       $o = 999000001;
    }
    return $o;
}
