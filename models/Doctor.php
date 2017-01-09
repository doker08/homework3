<?php

/**
 * Created by PhpStorm.
 * User: sokol_000
 * Date: 06.01.2017
 * Time: 14:19
 */

require_once("./models/Patient.php");
require_once("./models/Mail.php");
require_once("./models/User.php");

class Doctor
{
    /**
     * Проверка аутентификации.
     * @return bool
     */
    public static function isDoctor(){
        if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == "doctor")
            return true;

        return false;
    }

    /**
     * Получить пациетов доктора по $id
     * @param $id
     * @return array
     */
    static function getPatientsByDoctorId($id){
        $db = Db::getConnection();
        $sql = '
        SELECT
        visiting.id,
        visiting.doctor_id,
        visiting.patient_id,
        visiting.`status`,
        visiting.date,
        visiting.notice,
        users.`name` as patient_name
        FROM
        visiting
        INNER JOIN users ON visiting.patient_id = users.id
        WHERE
        visiting.doctor_id = :id';

        $patients = array();

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        $x = 0;
        while($row = $result->fetch()){
            $patients[$x] = $row;
            $x++;
        }

        return $patients;
    }

    /**
     * Получить список всех докторов.
     * @return array
     */
    static function getDoctorsList(){
        $db = Db::getConnection();
        $sql = 'SELECT
                users.`name` as name,
                doctors.post,
                users.id
                FROM
                users
                INNER JOIN doctors ON users.id = doctors.id';

        $doctors = array();

        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        $x = 0;
        while($row = $result->fetch()){
            $doctors[$x] = $row;
            $x++;
        }

        return $doctors;
    }

    /**
     * Получить запись о приеме пациента.
     * @param $id
     * @return mixed
     */
    static function getNote($id){
        $db = Db::getConnection();
        $sql = 'SELECT * FROM visiting WHERE id=:id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

    /**
     * Удалить запись о приеме пациента.
     * @param $id
     * @return bool
     */
    static function deleteNote($id){
        $db = Db::getConnection();
        $sql = 'DELETE FROM visiting WHERE id=:id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return true;
    }

    /**
     * Обновить запись о приеме пациента.
     * @param $id
     * @param $status
     * @param $date
     * @param $notice
     * @return bool
     */
    static function updateNote($id, $status, $date, $notice){
        $db = Db::getConnection();
        $sql = 'UPDATE visiting SET 
        status= :status,
        date= :date,
        notice= :notice
        WHERE id=:id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id);
        $result->bindParam(':status', $status);
        $result->bindParam(':date', $date);
        $result->bindParam(':notice', $notice);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        $note = self::getNote($id);
        $patient = User::getUserById($note['patient_id']);
        $email = $patient['email'];

        $header = "Обновлена запись #".$id;
        $body = "<b>Доктор</b>: ".$_SESSION['username']
                ."<br><b>Статус</b>: ".$status
                ."<br><b>Время</b>: ".$date
                ."<br><b>Примечание</b>: ".$notice;

        Mail::sendMail($email, $header, $body);

        return true;
    }

    /**
     * Проверка свободен ли доктор с интервалом 1 час.
     * @param $date
     * @return bool
     */
    static function checkDoctorTime($date){
        $db = Db::getConnection();
        $sql = 'SELECT
                    COUNT(*) as count
                FROM
                    visiting
                WHERE
                    date > \''.$date.'\' - INTERVAL 30 MINUTE
                AND date < \''.$date.'\' + INTERVAL 30 MINUTE';

        $result = $db->prepare($sql);
        $result->execute();
        $row = $result->fetch();

        if($row['count'] > 0){
            return false;
        }

        return true;
    }

    /**
     * Проверка на рабочие часы.
     * @param $date
     * @return bool
     */
    static function isWorkHours($date){
        $hour = date("H", strtotime($date));
        $minute = date("i", strtotime($date));

        //Рабочий день
        if($hour < 6 || $hour > 18){
            return false;
        }

        //Обед
        /*
        if($hour >= 12 && $hour < 13){
            return false;
        }
        */

        if(($hour >= 11 && $minute > 30) && $hour < 13){
            return false;
        }

        return true;
    }

    /**
     * Проверка на "не выходной".
     * @param $date
     * @return bool
     */
    static function isWorkDay($date){
        $day = strftime("%a", strtotime($date));

        if($day == "Sat" || $day == "Sun"){
            return false;
        }

        return true;
    }
}