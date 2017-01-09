<?php

/**
 * Created by PhpStorm.
 * User: sokol_000
 * Date: 04.12.2016
 * Time: 20:06
 */
class Db
{
    public static function getConnection(){
        $configPath = ROOT."/config/db_config.php";
        $params = include($configPath);

        $dsn = "mysql:host={$params['host']}; dbname={$params['dbname']}; charset=utf8;";
        $db = false;

        try{
            $db = new PDO($dsn, $params['user'], $params['password']);
        }catch (Exception $e){
            die("Ошибка подключения к базе данных.");
        }

        return $db;
    }
}