<?php
include 'db_config.php';

error_reporting(0);
ini_set('display_errors', FALSE);

define("version", "0.8");

function query($sql)
{
    try {
        $server = (DB_SERVER);
        $user = (DB_USER);
        $pwd = (DB_PASSWORD);
        $dtb = (DB_DATABASE);

        $c = mysqli_connect($server, $user, $pwd, $dtb) or die(mysqli_error());
        $q = mysqli_query($c, $sql) or die(mysqli_error());
    } catch (mysqli_sql_exception $e) {
        return null;
    }

    mysqli_close($c);

    return $q;
}

function updel($sql)
{
    try {
        $server = (DB_SERVER);
        $user = (DB_USER);
        $pwd = (DB_PASSWORD);
        $dtb = (DB_DATABASE);

        gravaLog($sql, "insert");
        $c2 = mysqli_connect($server, $user, $pwd, $dtb) or die(mysqli_error());
        $q2 = mysqli_query($c2, $sql) or die(mysqli_error());
    } finally {
        mysqli_close($c2);
    }

    if ($q2) {
        return "True";
    } else {
        return "False";
    }
}

function gravaLog($log, $acao)
{

    date_default_timezone_set('America/Sao_Paulo');
    $d = date('Ymd');
    $date = date('Y-m-d H:i:s');

    $arquivo = "logs/" . "log" . $d . ".log";

    $l = $date . " - " . $acao . " - " . $log . "\n";
    $fp = fopen($arquivo, "a+");
    fwrite($fp, $l);

    fclose($fp);
}

function descriptografa($pwd)
{
    $ret = "";
    $key = "chavecript";

    $pwd = substr($pwd, 0, (strlen($pwd) - 2));
    $y = 0;

    for ($i = 0; $i < (strlen($pwd)); $i++) {
        $aux = $i % 2;
        if ($aux == 0) {
            $hex = substr($pwd, $i, 2);
            $nChr = hexdec($hex);
            $nCha = ord(substr($key, $y, 1)); //$key.charAt($y);
            $ret = $ret . chr($nChr ^ $nCha);
            $y++;
            if ($y > strlen($key) - 1) {
                $y = 0;
            }
        }
    }
    return $ret;
}

function msgHttp500()
{
    $response["message"] = "Processamento com retorno nulo, verifique API ou Banco";

    return json_encode($response);
}

function msgHttp404()
{
    $response["message"] = "Registros nao encontrados";

    return json_encode($response);
}

function msgHttp400()
{
    $response["message"] = "Solicitacao Invalida";

    return json_encode($response);
}

function msgHttp505()
{
    $response["message"] = "Verão da API incompativel com a do aplicativo, atualize app e/ou a API e tente novamente.";

    return json_encode($response);
}
