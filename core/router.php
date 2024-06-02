<?php

//if (isset($_COOKIE['is_login'])) {
//    $_SESSION['is_login'] = $_COOKIE['is_login'];
//    $_SESSION['username'] = $_COOKIE['username'];
//}
$request_path = MODULESPATH . DIRECTORY_SEPARATOR . get_module() . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . get_controller() . 'Controller.php';
if (file_exists($request_path)) {
    require $request_path;
} else {
    echo "Không tìm thấy:$request_path ";
}

$action_name = get_action() . 'Action';

call_function(array('construct', $action_name));

if (!is_login() && !in_array(get_action(), ['login', 'recoverPass', 'mailToReset'])) {

    redirect_to("?mod=user&act=login");
}
