<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 06/06/18
 * Time: 15:09
 */

require_once (__DIR__ . '/../dao/Usuario.php');

$usr = Usuario::restoreFromSession();
if (!isset($usr) || !$usr->hasGroup(Usuario::GRUPO_SSI)) {
    $http_response_header('403');
    die('{"error":"forbidden"}');
}

$id = str_replace('custom','',$_GET['id']);
require_once (__DIR__ . '/../dao/HeskCustomField.php');
$campos = HeskCustomField::getByAttr('category',"%$id%",'like');
$campos = array_map(function ( $x ) { return $x->asJSON(); }, $campos );
$str = '[' . implode(',',$campos) . ']';
echo $str;

