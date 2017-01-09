<?php

/**
 * Created by PhpStorm.
 * User: sokol_000
 * Date: 06.01.2017
 * Time: 13:23
 */
include_once(ROOT."/models/Doctor.php");

class DoctorController
{
    /**
     * Домашняя страница доктора. Меню.
     *
     * @return bool
     */
    function actionIndex(){
        if(!Doctor::isDoctor()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        $visits = array();
        $visits = Doctor::getPatientsByDoctorId($_SESSION['user']);

        require_once(ROOT . '/views/doctor/index.php');
        return true;
    }

    /**
     * Удаление записи о посещении пациента.
     *
     * @param $id
     * @return bool
     */
    function actionDeleteNote($id){
        if(!Doctor::isDoctor()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        Doctor::deleteNote($id);

        self::actionIndex();

        return true;
    }

    /**
     * Редактирование записи о посещении пациента.
     *
     * @param $id
     * @return bool
     */
    function actionEditNote($id){
        if(!Doctor::isDoctor()){
            require_once(ROOT . '/views/permission_denied.php');
            return true;
        }

        $result = false;
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $date = $_POST['date'];
            $status = $_POST['status'];
            $notice = $_POST['notice'];

            $result = Doctor::updateNote($id, $status, $date, $notice);
        }

        $note = array();
        $note = Doctor::getNote($id);

        require_once(ROOT . '/views/doctor/note_edit.php');
        return true;
    }
}