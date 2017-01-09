<?php

/**
 * Created by PhpStorm.
 * User: sokol_000
 * Date: 06.01.2017
 * Time: 14:36
 */

class Patient
{
    /**
     * Получить докторов у которых лечится пациент.
     * @param $id
     * @return array
     */
    static function getDoctorsByPatientId($id, $sort = "id"){
        switch ($sort){
            case "doctors":
                $sort = "name";
                break;
        }

        $db = Db::getConnection();
        $sql = 'SELECT
                visiting.id,
                visiting.doctor_id,
                visiting.patient_id,
                visiting.`status`,
                visiting.date,
                visiting.notice,
                users.`name`
                FROM
                visiting
                INNER JOIN users ON visiting.doctor_id = users.id
                WHERE
                visiting.patient_id = :id
                ORDER BY '.$sort.' ASC';

        $doctors = array();

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id);
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
     * Добавление посещения к доктору.
     * @param $patientId
     * @param $doctorId
     * @param $date
     * @return bool
     */
    static function addVisiting($patientId, $doctorId, $date){
        $db = Db::getConnection();
        $sql = 'INSERT INTO visiting 
              (doctor_id,patient_id,status,date)
              VALUES 
              (:doctor_id,:patient_id,:status, :date)';

        $status = "Ожидание";

        $result = $db->prepare($sql);
        $result->bindParam(':doctor_id', $doctorId);
        $result->bindParam(':patient_id', $patientId);
        $result->bindParam(':status', $status);
        $result->bindParam(':date', $date);
        $result->execute();

        return true;
    }
}