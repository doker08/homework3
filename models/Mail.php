<?php

/**
 * Created by PhpStorm.
 * User: sokol_000
 * Date: 09.01.2017
 * Time: 14:00
 */
class Mail
{
    /**
     * Отправка почты через SMTP
     * @param $email
     * @param $body
     */
    public static function sendMail($email, $head, $body){
        require_once (ROOT.'/components/SendMailSmtpClass.php');

        $configPath = ROOT."/config/mail_config.php";
        $params = include($configPath);

        $mailSMTP = new SendMailSmtpClass($params['smtp_username'], $params['smtp_password'], $params['smtp_host'], $params['smtp_from'], $params['smtp_port']);

        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма

        $headers .= "From: Мой сайт <".$params['smtp_username'].">\r\n"; // от кого письмо
        //$result = $mailSMTP->send($email, 'Register', $body, $headers); // отправляем письмо
        $result = $mailSMTP->send($email, $head, $body, $headers); // отправляем письмо

        if($result === true){
            //echo "Письмо успешно отправлено";
        }else{
            //echo "Письмо не отправлено. Ошибка: " . $result;
        }
    }
}