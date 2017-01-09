<?php

/**
 * Created by PhpStorm.
 * User: sokol_000
 * Date: 05.01.2017
 * Time: 21:14
 */
include_once(ROOT."/models/Admin.php");
include_once(ROOT."/models/User.php");

class AdminController
{
    /**
     * Домашня страница администратора. Меню.
     *
     * @return bool
     */
    function actionIndex(){
        if(!Admin::isAdmin()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        require_once(ROOT . '/views/admin/index.php');
        return true;
    }

    /**
     * Отобразить все посещения пациентов к врачам.
     *
     * @return bool
     */
    function actionShowVisits(){
        if(!Admin::isAdmin()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        if (isset($_POST['submit'])) {
            $sort = $_POST['sort'];
            $logs = Admin::getVisitsLog($sort);
        }else{
            $logs = Admin::getVisitsLog();
        }

        require_once(ROOT . '/views/admin/visits.php');
        return true;
    }

    /**
     * Отобразить всех пользователей.
     *
     * @return bool
     */
    function actionShowUsers(){
        if(!Admin::isAdmin()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        $users = Admin::getUsers();
        require_once(ROOT . '/views/admin/users.php');
        return true;
    }

    /**
     * Отобразить меню управления пользователем.
     *
     * @param $id
     * @return bool
     */
    function actionManageUser($id){
        if(!Admin::isAdmin()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        $user = User::getUserById($id);

        require_once(ROOT . '/views/admin/user/user.php');
        return true;
    }

    /**
     * Страница редактироования почты пользователя от
     * имени администратора.
     *
     * @param $id
     * @return bool
     */
    function actionEditUserMail($id){
        if(!Admin::isAdmin()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        $result = false;
        if (isset($_POST['submit'])) {
            $newmail = $_POST['email'];

            $result = User::setEmail($id, $newmail);
        }

        $user = User::getUserById($id);
        $email = $user['email'];

        require_once(ROOT . '/views/admin/user/edit_mail.php');

        return true;
    }

    /**
     * Страница редактирования имени пользователя от имени администратора.
     *
     *
     * @param $id
     * @return bool
     */
    function actionEditUserName($id){
        if(!Admin::isAdmin()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        $result = false;
        if (isset($_POST['submit'])) {
            $newname = $_POST['name'];
            $result = User::editName($id, $newname);
        }

        $user = User::getUserById($id);
        $name = $user['name'];

        require_once(ROOT . '/views/admin/user/edit_name.php');

        return true;
    }

    /**
     * Заблокировать пользователя.
     *
     * @param $id
     * @return bool
     */
    function actionBlockUser($id){
        if(!Admin::isAdmin()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        $result = User::block($id);

        $this->actionManageUser($id);
        return true;
    }

    /**
     * Разблокировать пользователя.
     *
     * @param $id
     * @return bool
     */
    function actionUnBlockUser($id){
        if(!Admin::isAdmin()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        $result = User::unblock($id);

        $this->actionManageUser($id);
        return true;
    }
}