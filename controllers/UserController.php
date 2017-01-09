<?php

/**
 * Created by PhpStorm.
 * User: sokol_000
 * Date: 16.12.2016
 * Time: 0:07
 */
include_once(ROOT."/models/User.php");

class UserController
{
    /**
     * Action для активации аккаунта
     */
    public function actionActivation($hash){
        if(!$result = User::activate($hash)){
            $errors[] = 'Ошибка активации аккаунта.';
        }

        require_once(ROOT . '/views/user/activation.php');
        return true;
    }

    /**
     * Action для страницы регистрации
     */
    public function actionRegister(){
        $name = false;
        $email = false;
        $password = false;
        $password2 = false;
        $result = false;
        if (isset($_POST['submit'])) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            $errors = false;

            if(!User::checkLogin($name)){
                $errors[] = 'Слишком короткое имя.';
            }

            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов и содержать символы верхнего регистра.';
            }

            if(!User::checkPasswordMatch($password, $password2)){
                $errors[] = 'Пароли не совпадают.';
            }

            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }

            if ($errors == false) {
                $result = User::register($name, $email, $password);
            }
        }

        require_once(ROOT . '/views/user/register.php');
        return true;
    }

    /**
     * Action для страницы входа
     */
    public function actionLogin(){
        $email = false;
        $password = false;
        $secret = false;

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Получаем данные из формы
            $email = $_POST['email'];
            $password = $_POST['password'];

            if(isset($_SESSION['auth_count']) && $_SESSION['auth_count'] >= 3){
                $secret = $_POST['g-recaptcha-response'];
            }

            $errors = false;
            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                $errors[] = 'Неправильные данные для входа на сайт.';

                if(!isset($_SESSION['auth_count'])){
                    $_SESSION['auth_count'] = 0;
                }

                $_SESSION['auth_count']++;
            } else if(!User::checkActivation($userId)){
                $errors[] = 'Аккаунт не активирован. Проверьте, пожалуйста, Вашу почту.';
            } else if($_SESSION['auth_count'] >= 3 && empty($secret)){
                $errors[] = 'Неверная капча.';
            }else {
                User::auth($userId);

                $_SESSION['auth_count'] = 0;

                header("Location: /cabinet");
            }
        }

        require_once(ROOT . '/views/user/login.php');
        return true;
    }

    /**
     * Action для выхода с аккаунта
     */
    public function actionLogout()
    {
        session_start();

        unset($_SESSION["user"]);
        unset($_SESSION["username"]);
        unset($_SESSION["usertype"]);

        header("Location: /");
    }
}