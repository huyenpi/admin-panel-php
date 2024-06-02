<?php

function get_page_info($page_id) {
    $page_info = db_fetch_row("SELECT * FROM `tbl_pages` WHERE `page_id` = $page_id");
    return $page_info;
}

function delete_page($str_id) {
    return db_update("`tbl_pages`", array("status" => 'trash'), "`page_id` IN ($str_id)");
}

function update_page($str_id, $data) {
    return db_update("`tbl_pages`", $data, "`page_id` IN ($str_id)");
}

function add_page($data) {
    return db_insert("`tbl_pages`", $data);
}

function get_total_page() {
    return db_num_rows("SELECT * FROM `tbl_pages`");
}

function get_num_page($where = "") {
    if (!empty($where))
        $where = "WHERE " . $where;
    return db_num_rows("SELECT * FROM `tbl_pages` {$where}");
}

function get_total($where = "") {
    if (!empty($where)) {
        $where = "WHERE " . $where;
    }
    $result = db_num_rows("SELECT * FROM `tbl_pages` {$where}");
    return $result;
}

function get_list_page_per_page($start, $num_per_page, $where) {
    if (!empty($where))
        $where = "WHERE " . $where;
    $query_string = "SELECT * FROM `tbl_pages` $where ORDER BY page_id DESC LIMIT {$start},{$num_per_page}";
    $list_page = array();
    $list_page = db_fetch_array($query_string);
    if (!empty($list_page)) {
        foreach ($list_page as &$page) {
            $page['url_edit'] = "?mod=page&act=edit&id={$page['page_id']}";
            $page['url_delete'] = "?mod=page&act=delete&id={$page['page_id']}";
            $page['fullname_user'] = get_info_user($page['user_id'], 'fullname');
        }
    }
    return $list_page;
}

?>