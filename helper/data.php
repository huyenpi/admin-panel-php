<?php

function show_array($data) {
    if (is_array($data)) {
        echo "<pre>";
        print_r($data);
        echo "<pre>";
    }
}

function get_result() {
    global $result;

    if (isset($result['success'])) {
        $str_alert = "<div class='toast toast-success'>"
                . "<b>{$result['success']}</b>"
                . "</div>";
        return $str_alert;
    }
    if (isset($result['fail'])) {
        $str_alert = "<div class='toast toast-error'>"
                . "<b>{$result['fail']}</b>"
                . "</div>";
        ;
        return $str_alert;
    }
    if (isset($_GET['result']) && $_GET['result'] == 'success') {
        $str_alert = "<div class='toast toast-success'>"
                . "<b>{$_GET['alert']}</b>"
                . "</div>";
        ;
        return $str_alert;
    }
    if (isset($_GET['result']) && $_GET['result'] == 'fail') {
        $str_alert = "<div class='toast toast-error'>"
                . "<b>{$_GET['alert']}</b>"
                . "</div>";
        ;
        return $str_alert;
    }
}
