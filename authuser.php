<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 30/05/18
 * Time: 12:47
 */


require_once ( __DIR__ . '/./dao/Usuario.php' );
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: withCredentials');

$request = json_decode(file_get_contents('php://input'));

$user = Usuario::auth($request->user,$request->password);
if (isset($user) && $user->hasGroup(Usuario::GRUPO_DT)) {
    echo $user;
    $user->saveToSession();
} else {
    echo '{}';
}
