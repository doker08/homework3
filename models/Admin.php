<?php
class Admin{
    /**
     * Проверка статуса пользователя.
     *
     * @return bool
     */
    public static function isAdmin(){
        if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == "admin")
            return true;

        return false;
    }

    /**
     * Получить список всех пользователей.
     *
     * @return array
     */
    public static function getUsers(){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM users';

        $users = array();

        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        while($row = $result->fetch())
            $users[] = $row;

        return $users;
    }

    /**
     * Получить список посещений пациентов к врачам.
     *
     * @param string $sort
     * @return array
     */
    public static function getVisitsLog($sort = "id"){
        switch ($sort){
            case "patients":
                $sort = "patient_name";
                break;
            case "doctors":
                $sort = "doctor_name";
                break;
        }

        $db = Db::getConnection();
        $sql = 'SELECT
                visiting.id,
                (select name from users where id=visiting.doctor_id) as doctor_name,
                (select name from users where id=visiting.patient_id) as patient_name,
                visiting.`status`,
                visiting.date,
                visiting.notice
                FROM
                visiting
                ORDER BY '. $sort.' ASC';

        $log = array();

        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        $x = 0;
        while($row = $result->fetch()){
            $log[$x] = $row;
            $x++;
        }

        return $log;
    }
}