<?php

function is_username($username)
{
    $patern = "/^[a-z0-9_-]{3,16}$/";
    if (!preg_match($patern, $username, $matchs))
        return false;
    return true;
}

function is_password($password)
{
    $patern = "/^([A-Z]){1}([\w_\.!@#$%^&*()+]){5,31}$/";
    if (!preg_match($patern, $password, $matchs))
        return false;
    return true;
}

function is_email($mail)
{
    $patern = "/^[A-Za-z0-9_.]{2,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/";
    if (!preg_match($patern, $mail, $matchs))
        return false;
    return true;
}

function is_phone($phone)
{
    $patern = "/^(09|08|03|01[2|6|8|9])+([0-9]{8})$/";
    if (!preg_match($patern, $phone, $matchs))
        return false;
    return true;
}

function set_value($label_field)
{
    global $$label_field;
    if (!empty($$label_field))
        return $$label_field;
    return null;
}
function get_value($label_field)
{
    global $$label_field;
    if (!empty($$label_field))
        return $$label_field;
    return null;
}

function form_error($label_field)
{
    global $error;
    if (!empty($error["{$label_field}"]))
        return "<p class='error'>{$error[$label_field]}</p>";
}

?>