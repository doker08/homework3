<?php

/**
 * Created by PhpStorm.
 * User: sokol_000
 * Date: 16.12.2016
 * Time: 0:18
 */
include_once(ROOT."/models/Mail.php");

class User
{
    /**
     * Проверка аутентификации пользователя
     * @return bool
     */
    public static function isUser(){
        if(isset($_SESSION['usertype']))
            return true;

        return false;
    }

    /**
     * Активация аккаунта через почту.
     * @param string $hash
     * @return bool
     */
    public static function activate($hash){
        $db = Db::getConnection();

        $sql = 'SELECT id FROM users WHERE activation_hash=:activation_hash LIMIT 1';

        $result = $db->prepare($sql);
        $result->bindParam(':activation_hash', $hash);
        $result ->execute();

        if(!$row = $result->fetch()){
            return false;
        }
        $id = $row['id'];

        $sql = "UPDATE users SET status='OK' WHERE status='BLOCK' AND id=:id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id);
        $result ->execute();

        return true;
    }

    /**
     * Подтверждение изменение эл. почты через почту.
     * @param string $hash
     * @param string $email
     * @return bool
     */
    public static function activateEmail($hash, $email){
        $db = Db::getConnection();

        $sql = 'SELECT id FROM users WHERE activation_hash=:activation_hash LIMIT 1';

        $result = $db->prepare($sql);
        $result->bindParam(':activation_hash', $hash);
        $result ->execute();

        if(!$row = $result->fetch()){
            return false;
        }
        $id = $row['id'];

        self::setEmail($id, $email);

        return true;
    }

    /**
     * Установка почты без подтверждения.
     * Используется для администратора.
     * @param $id
     * @param $email
     * @return bool
     */
    public static function setEmail($id, $email){
        $db = Db::getConnection();

        $sql = "UPDATE users SET email=:email WHERE id=:id LIMIT 1;";

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email);
        $result->bindParam(':id', $id);
        $result->execute();
        return true;
    }

    /**
     * Выполнение регистрации
     * @param $login
     * @param $email
     * @param $password
     * @return bool
     */
    public static function register($name, $email, $password)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД

        $password = md5($password);
        $status = "BLOCK";
        $hash = md5(rand(99999,999999999));

        $sql = "INSERT INTO users (name, password, email, status, activation_hash) "
            . "VALUES (:name, :password, :email, :status, :activation_hash)";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name);
        $result->bindParam(':email', $email);
        $result->bindParam(':password', $password);
        $result->bindParam(':status', $status);
        $result->bindParam(':activation_hash', $hash);
        //$result->bindParam(':password', $password, PDO::PARAM_STR);

        $header = "Регистрация";
        $body = "Вы успешно зарегистрировались. Подтвердите регистрацию по ссылке - <a href='http://".$_SERVER['HTTP_HOST']."/user/activation/".$hash."'>ссылка</a>.";
        Mail::sendMail($email, $header, $body);

        return $result->execute();
    }

    /**
     * Запоминаем пользователя
     * @param integer $userId <p>id пользователя</p>
     */
    public static function auth($userId)
    {
        // Записываем идентификатор пользователя в сессию
        $_SESSION['user'] = $userId;

        $user = self::getUserById($userId);
        $_SESSION['username'] = $user['name'];
        $_SESSION['usertype'] = $user['user_type'];
    }

    /**
     * Проверяем существует ли пользователь с заданными $email и $password
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Пароль</p>
     * @return mixed : integer user id or false
     */
    public static function checkUserData($email, $password)
    {
        // Соединение с БД
        //$db = Db::getConnection();

        if(!$db = Db::getConnection())
            return true;

        $password = md5($password);
        // Текст запроса к БД
        $sql = 'SELECT * FROM users WHERE email = :email AND password = :password';
        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);
        $result->execute();
        // Обращаемся к записи
        $user = $result->fetch();
        if ($user) {
            // Если запись существует, возвращаем id пользователя
            return $user['id'];
        }
        return false;
    }

    /**
     * Проверка активирован ли аккаунт.
     * @param $id
     * @return bool
     */
    public static function checkActivation($id){
        // Соединение с БД
        $db = Db::getConnection();

        $sql = 'SELECT status FROM users WHERE id = :id LIMIT 1';
        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        // Обращаемся к записи
        $row = $result->fetch();
        if ($row['status'] == 'OK') {
            // Если запись существует, возвращаем id пользователя
            return true;
        }
        return false;
    }

    public static function checkLogin($login)
    {
        if (strlen($login) >= 4) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет пароль: не меньше, чем 6 символов
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkPassword($password)
    {
        if(!preg_match("([A-Z]+)",$password)){
            return false;
        }

        if (!(strlen($password) >= 6)) {
            return false;
        }
        return true;
    }

    /**
     * Проверяет совпадение паролей.
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkPasswordMatch($password, $password2){
        if($password == $password2){
            return true;
        }

        return false;
    }

    /**
     * Проверяет email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет не занят ли email другим пользователем
     * @param type $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmailExists($email)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'SELECT COUNT(*) FROM users WHERE email = :email';
        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();
        if ($result->fetchColumn())
            return true;
        return false;
    }

    /**
     * Вошел ли пользователь?
     * @return mixed
     */
    public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        header("Location: /user/login");
    }

    /**
     * Получение пользователя по Id
     * @param $id
     * @return mixed
     */
    public static function getUserById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'SELECT * FROM users WHERE id = :id';
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }

    /**
     * Редактирование логина
     * @param $id
     * @param $login
     * @return bool
     */
    public static function editLogin($id, $login)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = "UPDATE users
            SET login = :login 
            WHERE id = :id";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':login', $login, PDO::PARAM_STR);

        $_SESSION['username'] = $login;

        return $result->execute();
    }

    /**
     * Редактирование логина
     * @param $id
     * @param $login
     * @return bool
     */
    public static function editName($id, $name)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = "UPDATE users
            SET name = :name 
            WHERE id = :id";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);

        if($_SESSION['user'] == $id)
            $_SESSION['username'] = $name;

        return $result->execute();
    }

    /**
     * Редактирование пароля
     * @param $id
     * @param $password
     * @return bool
     */
    public static function editPassword($id, $password)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД

        $password = md5($password);

        $sql = "UPDATE users
            SET password = :password 
            WHERE id = :id";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Измениение почты
     * @param $id
     * @param $email
     * @param $newemail
     * @return bool
     */
    public static function editEmail($id, $email, $newemail, $confirm = true)
    {
        // Соединение с БД
        $db = Db::getConnection();

        $hash = md5(rand(99999,999999999));

        $sql = "UPDATE users "
            ."SET activation_hash=:activation_hash "
            ."WHERE id=:id;";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id);
        $result->bindParam(':activation_hash', $hash);

        if($confirm){
            $header = "Activation";
            $body = "Подтвердите изменение почты. Подтвердите по ссылке - <a href='http://".$_SERVER['HTTP_HOST']."/cabinet/activation/".$hash."/".$newemail."'>ссылка</a>.";

            Mail::sendMail($email, $header, $body);
        }

        return $result->execute();
    }

    /**
     * Заблокировать пользователя.
     *
     * @param $id
     * @return bool
     */
    public static function block($id){
        $db = Db::getConnection();

        $status = "BLOCK";

        $sql = "UPDATE users "
            ."SET status=:status "
            ."WHERE id=:id;";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id);
        $result->bindParam(':status', $status);
        $result->execute();

        return true;
    }

    /**
     * Разблокировать пользователя.
     *
     * @param $id
     * @return bool
     */
    public static function unblock($id){
        $db = Db::getConnection();

        $status = "OK";

        $sql = "UPDATE users "
            ."SET status=:status "
            ."WHERE id=:id;";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id);
        $result->bindParam(':status', $status);
        $result->execute();

        return true;
    }
}