<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 30/05/18
 * Time: 10:12
 */


require_once ( __DIR__ . '/dao/Usuario.php' );
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: withCredentials, Cookie');

$st = '';
foreach ($_COOKIE as $k => $v) {
    $st .= '
    '.$k . ':' . $v . '
';
}
trigger_error($st,E_USER_WARNING);
die();

$usuario = Usuario::restoreFromSession();
if (!isset($usuario)) {
    echo  '{}';
} else {
    echo $usuario;
}