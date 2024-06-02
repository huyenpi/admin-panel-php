<?php

function is_login() {
    if (isset($_SESSION['is_login']))
        return true;
    return false;
}

function show_gender($gender) {
    $list_gender = array(
        'male' => 'Nam',
        'female' => 'Nữ'
    );
    return $list_gender[$gender];
}

function user_login() {
    if (!empty($_SESSION['username']))
        return $_SESSION['username'];
}


?>

