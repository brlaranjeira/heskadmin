<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 06/06/18
 * Time: 17:02
 */


require_once (__DIR__ . '/../dao/Usuario.php');

$usr = Usuario::restoreFromSession();
if (!isset($usr) || !$usr->hasGroup(Usuario::GRUPO_DT)) {
    $http_response_header('403');
    die('{"error":"forbidden"}');
}

require_once (__DIR__ . '/../dao/HeskUser.php');
$users = array_map( function ( $user ) {
    return $user->asJSON();
}, HeskUser::getAll());
echo '[' . implode(',',$users) . ']';
