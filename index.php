<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 05/06/18
 * Time: 11:07
 */

require_once (__DIR__ . '/dao/Usuario.php');

$usr = Usuario::restoreFromSession();
if (isset($usr) && $usr->hasGroup(Usuario::GRUPO_DT)) {
    header('Location: ./main.php');
} else {
    header('Location: ./login.php');
}
