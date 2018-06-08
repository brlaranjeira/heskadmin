<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 05/06/18
 * Time: 11:10
 */

require_once (__DIR__ . '/dao/Usuario.php');

if (isset($_POST) && isset($_POST['login']) && isset($_POST['password'])) {
    $usr = Usuario::auth($_POST['login'],$_POST['password']);
    $usr->saveToSession();
    if (isset($usr) && $usr->hasGroup(Usuario::GRUPO_DT)) {
        header('Location: ./main.php');
    } else {
        echo 'login incorreto ou usuário não autorizado';
    }
    //TODO
}
    $usr = Usuario::restoreFromSession();
    if (isset($usr) && $usr->hasGroup(Usuario::GRUPO_DT)) {
        header('Location: ./main.php');
    } else {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>HESKAdmin - login </title>
        </head>
        <body>
        <form action="" method="post">
            <label>Login</label>
            <input type="text" name="login" id="login"><br/>
            <label>Senha</label>
            <input type="password" name="password" id="password"><br/>
            <input type="submit" value="Entrar">
        </form>
        </body>
        </html>
        <?
    }


