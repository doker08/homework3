<?php
    //1. Общие настройки
    //2. Подключение файлов системы
    //3. Установка соединения с БД
    //4. Вызов Router

    //ini_set('display_errors', 1);
    //error_reporting(E_ALL);

    $_SESSION['auth_count'] = 0;

    session_start();

    define('ROOT', dirname(__FILE__));
    require_once(ROOT."/components/Router.php");
    require_once(ROOT."/components/Db.php");

    $router = new Router();
    $router->run();
?>