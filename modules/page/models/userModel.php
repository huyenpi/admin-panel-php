<?php

function get_user_id_login($username) {
    $user = db_fetch_row("SELECT * FROM `tbl_users` WHERE `username` = '$username'");
    if (!empty($user)) {
        return $user["user_id"];
    }
}

function get_info_user($id, $field) {
    $user = db_fetch_row("SELECT * FROM `tbl_users` WHERE `user_id` = $id");
    if (!empty($user)) {
        return $user["{$field}"];
    }
}

function add_user($table, $data) {
    return db_insert($table, $data);
}

function get_list_user_per_page($start, $num_per_page, $where) {
    if (!empty($where))
        $where = "WHERE " . $where;
    $query_string = "SELECT * FROM `tbl_users` $where LIMIT {$start},{$num_per_page}";
    $list_user = array();
    $list_user = db_fetch_array($query_string);
    if (!empty($list_user)) {
        foreach ($list_user as &$user) {
            $user['url_edit'] = "?mod=user&controller=team&act=edit&id={$user['user_id']}";
            $user['url_delete'] = "?mod=user&controller=team&act=delete&id={$user['user_id']}";
        }
    }
    return $list_user;
}

function update_user_login($username, $data) {
    return db_update("`tbl_users`", $data, "`username` = '{$username}'");
}

function delete_user($str_id) {
    return db_update("`tbl_users`", array('status' => 'deleted'), "`user_id` IN ({$str_id})");
}

function update_user($id, $data) {
    return db_update("`tbl_users`", $data, "`user_id` = '{$id}'");
}

function is_user_exists($username, $password) {
    $query_string = "SELECT COUNT(*) AS num FROM `tbl_users` WHERE `username` = '{$username}' AND `password` = md5('{$password}')";
    $result = db_fetch_row($query_string);
    return $result['num'];
}

function is_current_password($username, $current_password) {
    $query_string = "SELECT COUNT(*) AS num FROM `tbl_users` WHERE `username` = '{$username}' AND `password` = '{$current_password}'";
    $result = db_fetch_row($query_string);
    return $result['num'];
}

function is_current_password_by_id($id, $current_password) {
    $query_string = "SELECT COUNT(*) AS num FROM `tbl_users` WHERE `user_id` = '{$id}' AND `password` = '{$current_password}'";
    $result = db_fetch_row($query_string);
    return $result['num'];
}

function is_username_exists($username) {
    $query_string = "SELECT COUNT(*) AS num FROM `tbl_users` WHERE `username` = '{$username}'";
    $result = db_fetch_row($query_string);
    return $result['num'];
}

function is_email_exists($email) {
    $query_string = "SELECT COUNT(*) AS num FROM `tbl_users` WHERE `email` = '{$email}'";
    $result = db_fetch_row($query_string);
    return $result['num'];
}

function get_list_users() {
    $result = db_fetch_array("SELECT * FROM `tbl_users`");
    return $result;
}

function get_total_member($where = "") {
    if (!empty($where)) {
        $where = "WHERE " . $where;
    }
    $result = db_num_rows("SELECT * FROM `tbl_users` {$where}");
    return $result;
}

function get_user_by_id($id) {
    $item = db_fetch_row("SELECT * FROM `tbl_users` WHERE `user_id` = {$id}");
    return $item;
}

function get_user_by_email($email) {
    $query_string = "SELECT * FROM `tbl_users` WHERE `email` = '{$email}'";
    $user = db_fetch_row($query_string);
    return $user;
}

function get_user_by_username($username) {
    $query_string = "SELECT * FROM `tbl_users` WHERE `username` = '{$username}'";
    $user = db_fetch_row($query_string);
    return $user;
}

function user_info($field) {
    if (isset($_SESSION['is_login'])) {
        $query_string = "SELECT * FROM `tbl_users` WHERE `username` = '{$_SESSION['username']}'";
        $user = db_fetch_row($query_string);
        if (array_key_exists($field, $user)) {
            return $user[$field];
        }
        return false;
    }
}

function active_user($active_token) {
    if (db_update('tbl_users', array('is_active' => 1), "`active_token` = '{$active_token}' AND `is_active` = '0'")) {
        $link_login = base_url() . "?mod=user&act=login";
        echo "Kích hoạt tài khoản thành công. <a href={$link_login}>Đăng nhập</a>";
    } else {
        echo "Mã kích hoạt không tồn tại hoặc đã hết hiệu lực.";
    };
    //kiểm tra token có tồn tại hay không
    //nếu không tồn tại báo mã kích hoạt không tồn tại hoặc đã hết hiệu lực
    //có tồn tại is_active = 0  đổi thành 1 và set active_token = null
}

function save_reset_token($email, $reset_token, $reset_time) {
    return db_update("`tbl_users`", array("`reset_token`" => $reset_token, "`reset_time`" => $reset_time), "`email` = '{$email}'");
}

function is_reset_token_exists($reset_token) {
    $query_string = "SELECT * FROM `tbl_users` WHERE `reset_token` = '{$reset_token}'";
    return db_num_rows($query_string);
}

function update_pass($new_password, $reset_token) {
    return db_update("tbl_users", array("password" => $new_password), "`reset_token` = '$reset_token'");
}

function trash_account_db($current_time) {
    return db_delete("`tbl_users`", "({$current_time} - `reg_time`) >= 86400 AND `is_active` = '0'");
}

?>
