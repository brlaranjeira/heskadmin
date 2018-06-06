<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 05/06/18
 * Time: 16:58
 */

require_once (__DIR__ . '/../dao/Usuario.php');

$usr = Usuario::restoreFromSession();
if (!isset($usr) || !$usr->hasGroup(Usuario::GRUPO_SSI)) {
    $http_response_header('403');
    die('{"error":"forbidden"}');
}

$id = str_replace('custom','',$_GET['id']);
require_once (__DIR__ . '/../dao/HeskCustomField.php');
$campo = HeskCustomField::getById($id);
$valores = $campo->getValue()->select_options;
echo json_encode($valores);

