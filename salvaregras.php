<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 07/06/18
 * Time: 11:33
 */

require_once (__DIR__ . '/dao/Usuario.php');

$usr = Usuario::restoreFromSession();
if (!isset($usr) || !$usr->hasGroup(Usuario::GRUPO_SSI)) {
    header('Location: ./login.php');
}

$filePath = './regras.json';

$regrasSalvas = json_decode(file_get_contents($filePath));
$indexCategoria = -1;
for ($i = 0; $i < sizeof($regrasSalvas->conjuntos); $i ++) {
    if ($_POST['categoria'] == $regrasSalvas->conjuntos[$i]->categoria) {
        $indexCategoria = $i;
        break;
    }
}

$campos = $_POST['campo'];
$operadores = $_POST['operador'];
$valores = $_POST['valor'];
$responsaveis = $_POST['responsavel'];

$regrasNovas = array();
for ($i = 0; $i < sizeof($campos); $i++ ) {
    $regraNova = new stdClass();
    $condicao = new stdClass();

    $condicao->campo = $campos[$i];
    $condicao->operador = $operadores[$i];
    $condicao->valor = $valores[$i];

    $regraNova->condicao = $condicao;
    $regraNova->responsavel = $responsaveis[$i];
    $regrasNovas[] = $regraNova;
}

$regrasSalvas->conjuntos[$indexCategoria]->regras = $regrasNovas;

$arq = fopen($filePath, 'w');
fwrite($arq,json_encode($regrasSalvas));
fclose($arq);
header('Location: ./main.php?catid='.$_POST['categoria']);


