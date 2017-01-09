<?php

/**
 * Created by PhpStorm.
 * User: sokol_000
 * Date: 16.12.2016
 * Time: 3:03
 */
include_once(ROOT."/models/User.php");

class CabinetController
{
    /**
     * Action для подтверждение изменения почты
     */
    public function actionActivation($hash, $email){
        if(!$result = User::activateEmail($hash, $email)){
            $errors[] = 'Ошибка активации аккаунта.';
        }

        require_once(ROOT . '/views/user/activation.php');
        return true;
    }

    /**
     * Action для страницы "Кабинет пользователя"
     */
    public function actionIndex()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);

        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }

    /**
     * Action для страницы "Редактирование логина"
     */
    public function actionEditName()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);

        $name = $user['name'];

        $result = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];

            $errors = false;

            if (!User::checkLogin($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if ($errors == false) {
                $result = User::editName($userId, $name);
            }
        }
        require_once(ROOT . '/views/cabinet/edit/login.php');
        return true;
    }

    /**
     * Action для страницы "Редактирование пароля"
     */
    public function actionEditPassword()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);

        $result = false;

        if (isset($_POST['submit'])) {

            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            $errors = false;

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            if(!User::checkPasswordMatch($password, $password2)){
                $errors[] = 'Пароли не совпадают.';
            }

            if ($errors == false) {
                $result = User::editPassword($userId, $password);
            }
        }
        require_once(ROOT . '/views/cabinet/edit/password.php');
        return true;
    }

    /**
     * Редактирование почты от имени пользователя.
     *
     * @return bool
     */
    public function actionEditEmail()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);

        $email = $user['email'];

        $result = false;
        if (isset($_POST['submit'])) {
            $errors = false;
            $newemail = $_POST['email'];
            if (!User::checkEmail($newemail)) {
                $errors[] = 'Недопустимая почта.';
            }
            if ($errors == false) {
                $result = User::editEmail($userId, $email, $newemail);
            }
        }
        require_once(ROOT . '/views/cabinet/edit/email.php');
        return true;
    }

}