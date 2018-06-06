<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 05/06/18
 * Time: 11:38
 */

session_start();
session_destroy();
session_commit();
header('Location: ./login.php');