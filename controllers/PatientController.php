<?php

/**
 * Created by PhpStorm.
 * User: sokol_000
 * Date: 06.01.2017
 * Time: 13:23
 */
include_once(ROOT."/models/Doctor.php");
include_once(ROOT."/models/Patient.php");
include_once(ROOT."/models/User.php");

class PatientController
{
    /**
     * Домашняя страница пациента. Меню.
     *
     * @return bool
     *
     */
    function actionIndex(){
        if(!User::isUser()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        require_once(ROOT . '/views/patient/index.php');
        return true;
    }

    /**
     * Отобразить таблицу докторов, к которым можно записаться.
     *
     * @return bool
     */
    function actionDoctors(){
        if(!User::isUser()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        $doctors = array();
        $doctors = Doctor::getDoctorsList();

        require_once(ROOT . '/views/patient/visiting_doctors.php');

        return true;
    }

    /**
     * Отобразить таблицу расписания пациента.
     *
     * @return bool
     */
    function actionTimeTable(){
        if(!User::isUser()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        $doctors = array();

        if (isset($_POST['submit'])) {
            $sort = $_POST['sort'];
            $doctors = Patient::getDoctorsByPatientId($_SESSION['user'], $sort);
        }else{
            $doctors = Patient::getDoctorsByPatientId($_SESSION['user']);
        }

        require_once(ROOT . '/views/patient/visiting_timetable.php');

        return true;
    }

    /**
     * Добавление запипи на прием к врачу.
     *
     * @param $id
     * @return bool
     */
    function actionAddVisiting($id){
        if(!User::isUser()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        $doctor = array();
        $doctor = User::getUserById($id);

        $result = false;
        if (isset($_POST['submit'])) {
            $patientId = $_POST['patient_id'];
            $doctorId = $_POST['doctor_id'];
            $date = $_POST['date'];

            $errors = false;
            if(!Doctor::checkDoctorTime($date)){
                $errors[] = "Доктор в этом время занят.";
            }elseif(!Doctor::isWorkHours($date)){
                $errors[] = "Доктор в это время не работает.";
            }elseif (!Doctor::isWorkDay($date)){
                $errors[] = "Люди в выходные дни дома сидят!";
            }else{
                $result = Patient::addVisiting($patientId, $doctorId, $date);
            }
        }

        require_once(ROOT . '/views/patient/visiting_add.php');

        return true;
    }
}