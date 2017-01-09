<?php
/**
 * Created by PhpStorm.
 * User: sokol_000
 * Date: 04.12.2016
 * Time: 11:48
 */

return array(
    'user/activation/([a-zA-Z0-9]+)' => 'user/activation/$1',
    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    //'cabinet/edit/login' => 'cabinet/editLogin',
    'cabinet/edit/name' => 'cabinet/editName',
    'cabinet/edit/password' => 'cabinet/editPassword',
    'cabinet/edit/email' => 'cabinet/editEmail',
    'cabinet/activation/([a-zA-Z0-9]+)/([a-zA-Z0-9]+)' => 'user/activation/$1/$2',
    'cabinet' => 'cabinet/index',
    'patient/addvisiting/([0-9]+)' => 'patient/addvisiting/$1',
    'patient/timetable' => 'patient/timetable',
    'patient/doctors' => 'patient/doctors',
    'patient' => 'patient/index',
    'doctor/note/delete/([0-9]+)' => 'doctor/deleteNote/$1',
    'doctor/note/edit/([0-9]+)' => 'doctor/editNote/$1',
    'doctor' => 'doctor/index',
    'admin/visits' => 'admin/showVisits',
    'admin/users' => 'admin/showUsers',
    'admin/user/([0-9]+)' => 'admin/manageUser/$1',
    'admin/user/block/([0-9]+)' => 'admin/blockUser/$1',
    'admin/user/unblock/([0-9]+)' => 'admin/unblockUser/$1',
    'admin/user/editmail/([0-9]+)' => 'admin/editUserMail/$1',
    'admin/user/editname/([0-9]+)' => 'admin/editUserName/$1',
    'admin' => 'admin/index',

    'index.php' => 'cabinet/index',
    '' => 'cabinet/index',
);